#!/usr/bin/env python3
import sys
import os
import traceback
import numpy as np
from PIL import Image
from rembg import remove

def check_dependencies():
    try:
        import numpy
        import PIL
        import rembg
        return True
    except ImportError as e:
        print(f"Error importing dependencies: {str(e)}", file=sys.stderr)
        print("Trying to install required packages...", file=sys.stderr)
        try:
            import pip
            pip.main(['install', 'rembg==2.0.50', 'Pillow==10.0.0', 'numpy'])
            return True
        except Exception as e:
            print(f"Failed to install dependencies: {str(e)}", file=sys.stderr)
            return False

def sharpen_alpha(image, threshold=240):
    try:
        # Convert image to numpy array
        img_array = np.array(image)
        
        # Get alpha channel
        if img_array.shape[-1] == 4:  # Check if image has alpha channel
            alpha = img_array[:, :, 3]
            
            # Apply threshold to alpha channel
            alpha = np.where(alpha > threshold, 255, alpha)
            alpha = np.where(alpha < (255 - threshold), 0, alpha)
            
            # Update alpha channel
            img_array[:, :, 3] = alpha
            
            return Image.fromarray(img_array, 'RGBA')
        else:
            print("Image doesn't have an alpha channel", file=sys.stderr)
            return image
    except Exception as e:
        print(f"Error in sharpen_alpha: {str(e)}", file=sys.stderr)
        return image

def remove_background(input_path, output_path):
    try:
        # Check if input file exists
        if not os.path.exists(input_path):
            print(f"Input file does not exist: {input_path}", file=sys.stderr)
            return False
            
        # Check if output directory exists
        output_dir = os.path.dirname(output_path)
        if not os.path.exists(output_dir):
            os.makedirs(output_dir)
        
        print(f"Processing image: {input_path}", file=sys.stderr)
        
        # Read input image
        input_image = Image.open(input_path)
        
        # Remove background
        print("Removing background...", file=sys.stderr)
        output_image = remove(input_image)
        
        # Apply edge sharpening
        print("Sharpening edges...", file=sys.stderr)
        output_image = sharpen_alpha(output_image)
        
        # Save the output
        print(f"Saving to: {output_path}", file=sys.stderr)
        output_image.save(output_path, 'PNG')
        
        print("Background removal completed successfully!", file=sys.stderr)
        return True
    except Exception as e:
        print(f"Error: {str(e)}", file=sys.stderr)
        print("Traceback:", file=sys.stderr)
        print(traceback.format_exc(), file=sys.stderr)
        return False

if __name__ == "__main__":
    if len(sys.argv) != 3:
        print("Usage: python remove_bg.py input_path output_path", file=sys.stderr)
        sys.exit(1)
        
    input_path = sys.argv[1]
    output_path = sys.argv[2]
    
    # Check dependencies first
    if not check_dependencies():
        sys.exit(1)
    
    success = remove_background(input_path, output_path)
    sys.exit(0 if success else 1) 