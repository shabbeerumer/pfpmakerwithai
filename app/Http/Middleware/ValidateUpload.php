<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ValidateUpload
{
    public function handle(Request $request, Closure $next)
    {
        $request->validate([
            'image' => [
                'required',
                'image',
                'max:5120', // 5MB max
                'mimes:jpeg,png,jpg,webp',
                function ($attribute, $value, $fail) {
                    if (!getimagesize($value)) {
                        $fail('Invalid image file.');
                    }
                    
                    // Check for malicious content
                    $mime = mime_content_type($value->getPathname());
                    if (!in_array($mime, ['image/jpeg', 'image/png', 'image/webp'])) {
                        $fail('Invalid image type.');
                    }
                },
            ]
        ]);

        return $next($request);
    }
} 