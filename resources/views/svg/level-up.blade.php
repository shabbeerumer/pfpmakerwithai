<svg viewBox="0 0 400 500" class="w-100 h-auto">
    <defs>
        <linearGradient id="profile-gradient" x1="0%" y1="0%" x2="100%" y2="100%">
            <stop offset="0%" style="stop-color:#F8E7FF"/>
            <stop offset="100%" style="stop-color:#FFFFFF"/>
        </linearGradient>
    </defs>
    
    <!-- Background -->
    <rect x="0" y="0" width="400" height="500" fill="url(#profile-gradient)" rx="24"/>
    
    <!-- Phone Frame -->
    <rect x="70" y="40" width="260" height="420" rx="24" fill="white" class="phone-frame" filter="drop-shadow(0 4px 6px rgba(0,0,0,0.1))"/>
    
    <!-- Status Bar -->
    <g transform="translate(85, 50)">
        <text x="0" y="15" fill="#1F2937" style="font-size: 14px;">9:41</text>
        <g transform="translate(190, 0)">
            <circle cx="0" cy="8" r="3" fill="#34D399"/>
            <circle cx="12" cy="8" r="3" fill="#3B82F6"/>
            <rect x="24" y="5" width="12" height="6" rx="2" fill="#1F2937"/>
        </g>
    </g>

    <!-- Main Profile -->
    <g transform="translate(85, 90)">
        <!-- Profile Image -->
        <circle cx="115" cy="60" r="45" fill="#F3F4F6"/>
        <circle cx="115" cy="60" r="44" fill="white" stroke="#E5E7EB" stroke-width="1"/>
        <circle cx="150" cy="95" r="12" fill="#60A5FA" class="add-button"/>
        <path d="M147 95h6M150 92v6" stroke="white" stroke-width="2" stroke-linecap="round"/>
        
        <!-- Profile Info -->
        <text x="115" y="130" text-anchor="middle" fill="#111827" style="font-size: 16px; font-weight: 500;">Jenny Mckey</text>
        <g transform="translate(85, 145)">
            <text x="30" y="0" text-anchor="middle" fill="#6B7280" style="font-size: 12px;">
                <tspan>📍</tspan> Malaga, Spain
            </text>
        </g>

        <!-- Message Button -->
        <rect x="65" y="170" width="100" height="32" rx="16" fill="#E0E7FF"/>
        <text x="115" y="190" text-anchor="middle" fill="#4F46E5" style="font-size: 13px;">Send Message</text>

        <!-- Chat List -->
        <g transform="translate(0, 220)">
            <!-- Amelie London -->
            <circle cx="30" cy="25" r="25" fill="#F3F4F6"/>
            <text x="70" y="20" fill="#111827" style="font-size: 14px;">Amelie London</text>
            <text x="70" y="38" fill="#6B7280" style="font-size: 12px;">Thu, Nov 23</text>
            <circle cx="200" cy="25" r="15" fill="#F3F4F6"/>

            <!-- Janet Doe -->
            <circle cx="30" cy="85" r="25" fill="#F3F4F6"/>
            <text x="70" y="80" fill="#111827" style="font-size: 14px;">Janet Doe</text>
            <text x="70" y="98" fill="#6B7280" style="font-size: 12px;">Mon, Nov 15</text>
            <circle cx="200" cy="85" r="15" fill="#F3F4F6"/>
        </g>
    </g>

    <!-- Floating Elements -->
    <circle cx="50" cy="150" r="15" fill="#FCD34D"/>
    <circle cx="320" cy="180" r="20" fill="#34D399"/>
    <circle cx="60" cy="350" r="12" fill="#F472B6"/>
    <circle cx="340" cy="320" r="10" fill="#60A5FA"/>
</svg> 