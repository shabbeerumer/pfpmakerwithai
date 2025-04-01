<?php

namespace App\Http\Controllers;

use App\Models\ProfilePicture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;

class ProfilePictureController extends Controller
{
    public function editor()
    {
        return view('editor');
    }

    public function backgroundRemover()
    {
        return view('pages.background-remover');
    }
    
    public function upload(Request $request)
    {
        try {
            $request->validate([
                'image' => 'required|image|max:5120', // 5MB max
            ]);
            
            $image = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            
            // Store original image
            $path = $image->storeAs('public/uploads', $filename);
            
            // Convert backslashes to forward slashes for URLs
            $url = str_replace('\\', '/', Storage::url($path));
            
            return response()->json([
                'success' => true,
                'filename' => $filename,
                'url' => $url
            ]);
        } catch (\Exception $e) {
            Log::error('Upload failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Upload failed'
            ], 500);
        }
    }
    
    public function removeBg(Request $request)
    {
        try {
            $request->validate([
                'image' => 'required|string'
            ]);
            
            // Get the image URL and convert it to a file path
            $imageUrl = $request->input('image');
            Log::info('Processing image URL: ' . $imageUrl);
            
            // Convert URL to storage path
            $path = str_replace('/storage/', '', parse_url($imageUrl, PHP_URL_PATH));
            $imagePath = storage_path('app/public/' . $path);
            
            Log::info('Image path: ' . $imagePath);
            
            if (!file_exists($imagePath)) {
                Log::error('Image file not found at path: ' . $imagePath);
                throw new \Exception('Image file not found');
            }

            // Create processed directory if it doesn't exist
            $processedPath = storage_path('app/public/processed');
            if (!file_exists($processedPath)) {
                mkdir($processedPath, 0755, true);
            }
            
            // Generate output filename
            $filename = 'processed/' . time() . '_' . uniqid() . '_no_bg.png';
            $outputPath = storage_path('app/public/' . $filename);
            
            // Execute the Python script
            $pythonScript = base_path('scripts/remove_bg.py');
            $venvPath = base_path('scripts/venv');
            $requirementsPath = base_path('scripts/requirements.txt');
            
            // Ensure all paths exist
            Log::info('Checking paths:');
            Log::info('Python Script: ' . $pythonScript . ' (Exists: ' . (file_exists($pythonScript) ? 'Yes' : 'No') . ')');
            Log::info('Venv Path: ' . $venvPath . ' (Exists: ' . (file_exists($venvPath) ? 'Yes' : 'No') . ')');
            Log::info('Requirements: ' . $requirementsPath . ' (Exists: ' . (file_exists($requirementsPath) ? 'Yes' : 'No') . ')');
            
            // Use full path for Python interpreter
            $pythonInterpreter = PHP_OS === 'WINNT' 
                ? $venvPath . '\Scripts\python.exe'
                : $venvPath . '/bin/python';
                
            Log::info('Python Interpreter: ' . $pythonInterpreter . ' (Exists: ' . (file_exists($pythonInterpreter) ? 'Yes' : 'No') . ')');
            
            // First, try to install rembg if not already installed
            $installCommand = sprintf('"%s" -m pip install rembg==2.0.50 2>&1', $pythonInterpreter);
            Log::info('Running pip install: ' . $installCommand);
            exec($installCommand, $pipOutput, $pipReturnCode);
            Log::info('Pip install output: ' . implode("\n", $pipOutput));
            
            // Now run the actual script
            $command = sprintf('"%s" "%s" "%s" "%s" 2>&1', 
                $pythonInterpreter,
                $pythonScript, 
                $imagePath, 
                $outputPath
            );
            
            Log::info('Executing command: ' . $command);
            exec($command, $output, $returnCode);
            
            if ($returnCode !== 0) {
                $errorMessage = implode("\n", $output);
                Log::error('Background removal failed: ' . $errorMessage);
                throw new \Exception('Background removal failed: ' . $errorMessage);
            }
            
            $outputUrl = Storage::url($filename);
            Log::info('Generated URL: ' . $outputUrl);
            
            return response()->json([
                'success' => true,
                'message' => 'Background removed successfully',
                'url' => $outputUrl
            ]);
            
        } catch (\Exception $e) {
            Log::error('Background removal failed: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json([
                'success' => false,
                'message' => 'Background removal failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Local background removal fallback using Intervention Image
     */
    private function localBackgroundRemoval($imagePath)
    {
        try {
            // Load the image
            $image = Image::make($imagePath);
            
            // Create a transparent background
            $width = $image->width();
            $height = $image->height();
            $canvas = Image::canvas($width, $height);
            
            // Basic background removal using edge detection and color similarity
            $image->brightness(-10);
            $image->contrast(10);
            
            // Create a mask for the subject
            $mask = clone $image;
            $mask->greyscale();
            $mask->contrast(20);
            $mask->brightness(10);
            
            // Apply the mask to the original image
            $image->mask($mask);
            
            // Copy the processed image onto the transparent canvas
            $canvas->insert($image, 'center');
            
            // Generate unique filename
            $filename = 'processed/' . time() . '_' . uniqid() . '_no_bg.png';
            
            // Save with transparency
            Storage::put('public/' . $filename, $canvas->encode('png'));
            
            $outputUrl = Storage::url($filename);
            Log::info('Generated URL (local processing): ' . $outputUrl);
            
            return response()->json([
                'success' => true,
                'message' => 'Background removed successfully (local processing)',
                'url' => $outputUrl
            ]);
        } catch (\Exception $e) {
            Log::error('Local background removal failed: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json([
                'success' => false,
                'message' => 'Background removal failed: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function applyBackground(Request $request)
    {
        try {
            $request->validate([
                'image' => 'required|string',
                'background' => 'required|string'
            ]);

            // Get the image path
            $imageUrl = $request->input('image');
            $path = str_replace('/storage/', '', parse_url($imageUrl, PHP_URL_PATH));
            $imagePath = storage_path('app/public/' . $path);

            if (!file_exists($imagePath)) {
                throw new \Exception('Image file not found');
            }

            // Load the image using Intervention Image
            $image = Image::make($imagePath);

            // Apply background based on type
            switch ($request->input('background')) {
                case 'transparent':
                    // Keep transparent
                    break;

                case 'solid-white':
                    // Create a white background
                    $canvas = Image::canvas($image->width(), $image->height(), '#ffffff');
                    $canvas->insert($image, 'center');
                    $image = $canvas;
                    break;

                case 'gradient-blue':
                    // Create a blue gradient background
                    $canvas = Image::canvas($image->width(), $image->height());
                    $this->applyGradient($canvas, '#1a73e8', '#8ab4f8');
                    $canvas->insert($image, 'center');
                    $image = $canvas;
                    break;

                case 'gradient-sunset':
                    $canvas = Image::canvas($image->width(), $image->height());
                    $this->applyGradient($canvas, '#ff512f', '#dd2476');
                    $canvas->insert($image, 'center');
                    $image = $canvas;
                    break;

                case 'gradient-ocean':
                    $canvas = Image::canvas($image->width(), $image->height());
                    $this->applyGradient($canvas, '#2193b0', '#6dd5ed');
                    $canvas->insert($image, 'center');
                    $image = $canvas;
                    break;

                case 'gradient-purple':
                    $canvas = Image::canvas($image->width(), $image->height());
                    $this->applyGradient($canvas, '#8e2de2', '#4a00e0');
                    $canvas->insert($image, 'center');
                    $image = $canvas;
                    break;

                case 'gradient-emerald':
                    $canvas = Image::canvas($image->width(), $image->height());
                    $this->applyGradient($canvas, '#0BAB64', '#3BB78F');
                    $canvas->insert($image, 'center');
                    $image = $canvas;
                    break;

                case 'gradient-golden':
                    $canvas = Image::canvas($image->width(), $image->height());
                    $this->applyGradient($canvas, '#FFD700', '#FFA500');
                    $canvas->insert($image, 'center');
                    $image = $canvas;
                    break;

                case 'gradient-rose':
                    $canvas = Image::canvas($image->width(), $image->height());
                    $this->applyGradient($canvas, '#ee9ca7', '#ffdde1');
                    $canvas->insert($image, 'center');
                    $image = $canvas;
                    break;

                case 'gradient-midnight':
                    $canvas = Image::canvas($image->width(), $image->height());
                    $this->applyGradient($canvas, '#232526', '#414345');
                    $canvas->insert($image, 'center');
                    $image = $canvas;
                    break;

                case 'gradient-royal':
                    $canvas = Image::canvas($image->width(), $image->height());
                    $this->applyGradient($canvas, '#141E30', '#243B55');
                    $canvas->insert($image, 'center');
                    $image = $canvas;
                    break;

                default:
                    // For predefined backgrounds (office, studio, nature, city)
                    $bgPath = public_path('images/backgrounds/' . $request->input('background') . '.jpg');
                    if (!file_exists($bgPath)) {
                        throw new \Exception('Background not found');
                    }
                    $background = Image::make($bgPath);
                    $background->fit($image->width(), $image->height());
                    $background->insert($image, 'center');
                    $image = $background;
            }

            // Save the result
            $outputFile = 'processed/' . uniqid() . '_with_bg.png';
            Storage::put('public/' . $outputFile, $image->encode('png'));

            return response()->json([
                'success' => true,
                'message' => 'Background applied successfully',
                'url' => Storage::url($outputFile)
            ]);

        } catch (\Exception $e) {
            Log::error('Background application failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to apply background: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Helper method to apply a gradient background
     */
    private function applyGradient($canvas, $startColor, $endColor)
    {
        $width = $canvas->width();
        $height = $canvas->height();
        
        // Convert hex colors to RGB
        $startRGB = $this->hexToRgb($startColor);
        $endRGB = $this->hexToRgb($endColor);
        
        // Create gradient by drawing lines
        for ($i = 0; $i < $width; $i++) {
            $ratio = $i / $width;
            $r = $startRGB['r'] + ($endRGB['r'] - $startRGB['r']) * $ratio;
            $g = $startRGB['g'] + ($endRGB['g'] - $startRGB['g']) * $ratio;
            $b = $startRGB['b'] + ($endRGB['b'] - $startRGB['b']) * $ratio;
            
            $canvas->line($i, 0, $i, $height, function ($draw) use ($r, $g, $b) {
                $draw->color(sprintf('rgba(%d, %d, %d, 1)', $r, $g, $b));
            });
        }
    }

    /**
     * Helper method to convert hex color to RGB
     */
    private function hexToRgb($hex)
    {
        $hex = ltrim($hex, '#');
        return [
            'r' => hexdec(substr($hex, 0, 2)),
            'g' => hexdec(substr($hex, 2, 2)),
            'b' => hexdec(substr($hex, 4, 2))
        ];
    }

    public function applyCustomBackground(Request $request)
    {
        try {
            $request->validate([
                'image' => 'required|string',
                'background' => 'required|image|max:5120'
            ]);

            // Get the foreground image
            $imageUrl = $request->input('image');
            $path = str_replace('/storage/', '', parse_url($imageUrl, PHP_URL_PATH));
            $imagePath = storage_path('app/public/' . $path);

            if (!file_exists($imagePath)) {
                Log::error('Image file not found at path: ' . $imagePath);
                throw new \Exception('Image file not found');
            }

            // Load both images
            $image = Image::make($imagePath);
            $background = Image::make($request->file('background'));

            // Resize background to match foreground dimensions
            $background->fit($image->width(), $image->height());
            
            // Overlay the foreground on the background
            $background->insert($image, 'center');

            // Save the result
            $outputFile = 'processed/' . uniqid() . '_custom_bg.png';
            Storage::put('public/' . $outputFile, $background->encode('png'));

            return response()->json([
                'success' => true,
                'message' => 'Custom background applied successfully',
                'url' => Storage::url($outputFile)
            ]);

        } catch (\Exception $e) {
            Log::error('Custom background application failed: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json([
                'success' => false,
                'message' => 'Failed to apply custom background: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function enhance(Request $request)
    {
        try {
            $request->validate([
                'image' => 'required|string'
            ]);
            
            // AI enhancement logic here
            // For now, just return success
            return response()->json([
                'success' => true,
                'message' => 'Image enhanced successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Enhancement failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Enhancement failed'
            ], 500);
        }
    }
} 