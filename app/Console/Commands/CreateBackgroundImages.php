<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Intervention\Image\Facades\Image;

class CreateBackgroundImages extends Command
{
    protected $signature = 'backgrounds:create';
    protected $description = 'Create background images for the application';

    public function handle()
    {
        $backgrounds = [
            'office' => ['#1a73e8', 800, 600],
            'studio' => ['#424242', 800, 600],
            'nature' => ['#4caf50', 800, 600],
            'city' => ['#607d8b', 800, 600]
        ];

        foreach ($backgrounds as $name => [$color, $width, $height]) {
            $image = Image::canvas($width, $height);
            
            // Create base color
            $image->rectangle(0, 0, $width, $height, function ($draw) use ($color) {
                $draw->background($color);
            });
            
            // Add pattern using rectangles
            for ($x = 0; $x < $width; $x += 100) {
                for ($y = 0; $y < $height; $y += 100) {
                    $image->rectangle($x, $y, $x + 80, $y + 80, function ($draw) use ($color) {
                        $draw->background(adjustBrightness($color, 20));
                    });
                }
            }

            $image->save(public_path("images/backgrounds/{$name}.jpg"), 90);
            $this->info("Created {$name} background");
        }
    }
}

function adjustBrightness($hex, $steps) {
    // Strip # if present
    $hex = ltrim($hex, '#');
    
    // Convert to RGB
    $r = hexdec(substr($hex, 0, 2));
    $g = hexdec(substr($hex, 2, 2));
    $b = hexdec(substr($hex, 4, 2));
    
    // Adjust brightness
    $r = max(0, min(255, $r + $steps));
    $g = max(0, min(255, $g + $steps));
    $b = max(0, min(255, $b + $steps));
    
    // Convert back to hex
    return sprintf("#%02x%02x%02x", $r, $g, $b);
} 