<svg width="600" height="600" xmlns="http://www.w3.org/2000/svg">
    <defs>
        <linearGradient id="bgGrad" x1="0%" y1="0%" x2="100%" y2="100%">
            <stop offset="0%" style="stop-color:#f3e8ff;stop-opacity:1" />
            <stop offset="100%" style="stop-color:#ffffff;stop-opacity:1" />
        </linearGradient>
    </defs>
    <rect width="100%" height="100%" fill="url(#bgGrad)" rx="20" />

    <!-- 3x3 Grid of Profile Pictures -->
    <g transform="translate(50,50)">
        <!-- Row 1 -->
        <image href="{{ $sampleImages[0] }}" x="0" y="0" width="150" height="150" rx="10" />
        <image href="{{ $sampleImages[1] }}" x="170" y="0" width="150" height="150" rx="10" />
        <image href="{{ $sampleImages[2] }}" x="340" y="0" width="150" height="150" rx="10" />

        <!-- Row 2 -->
        <image href="{{ $sampleImages[3] }}" x="0" y="170" width="150" height="150" rx="10" />
        <image href="{{ $sampleImages[4] }}" x="170" y="170" width="150" height="150" rx="10" />
        <image href="{{ $sampleImages[5] }}" x="340" y="170" width="150" height="150" rx="10" />

        <!-- Row 3 -->
        <image href="{{ $sampleImages[6] }}" x="0" y="340" width="150" height="150" rx="10" />
        <image href="{{ $sampleImages[7] }}" x="170" y="340" width="150" height="150" rx="10" />
        <image href="{{ $sampleImages[8] }}" x="340" y="340" width="150" height="150" rx="10" />
    </g>
</svg>
