<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    public function index()
    {
        // Sample profile images from Unsplash
        $sampleImages = [
            'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150&h=150&fit=crop',
            'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=150&h=150&fit=crop',
            'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=150&h=150&fit=crop',
            'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=150&h=150&fit=crop',
            'https://images.unsplash.com/photo-1517841905240-472988babdf9?w=150&h=150&fit=crop',
            'https://images.unsplash.com/photo-1539571696357-5a69c17a67c6?w=150&h=150&fit=crop',
            'https://images.unsplash.com/photo-1524504388940-b1c1722653e1?w=150&h=150&fit=crop',
            'https://images.unsplash.com/photo-1507019403270-cca502add9f8?w=150&h=150&fit=crop',
            'https://images.unsplash.com/photo-1531746020798-e6953c6e8e04?w=150&h=150&fit=crop',
        ];

        // Create feature images
        $featureImages = [
            'level-up' => view('svg.level-up', compact('sampleImages'))->render(),
            'linkedin-profile' => view('svg.linkedin-profile')->render(),
            'profile-variations' => view('svg.profile-variations', compact('sampleImages'))->render(),
        ];

        return view('pages.home', compact('sampleImages', 'featureImages'));
    }
} 