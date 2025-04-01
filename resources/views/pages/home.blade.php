@extends('layouts.app')

@section('title', 'Create Professional Profile Pictures')

@section('content')
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container" style="max-width: 1179px;">
            <div class="row align-items-center">
                <div class="col">
                    <div class="hero-content">
                        <span class="badge bg-primary-subtle text-primary mb-3">AI-POWERED</span>
                        <h1 class="display-4 fw-bold mb-4">
                            Create the perfect
                            <span class="text-gradient">profile picture</span>
                            in seconds
                        </h1>
                        <p class="lead text-secondary mb-4">
                            Transform your photos into professional headshots with our AI tools.
                            Perfect for LinkedIn, social media, or your website.
                        </p>
                        <div class="cta-group d-flex align-items-center gap-3 mb-4">
                            <a href="http://127.0.0.1:8000/remove-background"
                                style="color: #fff; background: #0d6efd; padding: 10px 20px; text-decoration: none; border-radius: 5px;">
                                Try Free Now <i class="fas fa-arrow-right"></i>
                            </a>
                            <span class="text-success">
                                <i class="fas fa-check-circle me-2"></i>
                                No Credit Card Required
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-auto">
                    <div class="hero-image-wrapper position-relative">
                        <div class="hero-decoration"></div>
                        <img src="{{ asset('images/hero/hero-1.webp') }}" alt="AI Profile Picture Enhancement"
                            class="img-fluid rounded-4" style="width: 416px;" loading="lazy"
                            onerror="this.onerror=null; this.src='{{ asset('images/placeholder.svg') }}'">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Trusted By Section -->
    <section class="trusted-by">
        <div class="container">
            <div class="trusted-header text-center mb-4">
                <span class="badge bg-white bg-opacity-25 text-white mb-2">TRUSTED BY 10M+ USERS</span>
                <h2 class="text-white h4 mb-0">Join millions creating professional profile pictures</h2>
            </div>
            <div class="d-flex justify-content-center align-items-center gap-5 flex-wrap">
                <div class="brand-item">
                    <img src="{{ asset('images/brands/google.svg') }}" alt="Google" height="20" loading="lazy">
                </div>
                <div class="brand-item">
                    <img src="{{ asset('images/brands/linkedin.svg') }}" alt="LinkedIn" height="20" loading="lazy">
                </div>
                <div class="brand-item">
                    <img src="{{ asset('images/brands/salesforce.svg') }}" alt="Salesforce" height="20" loading="lazy">
                </div>
                <div class="brand-item">
                    <img src="{{ asset('images/brands/asana.svg') }}" alt="Asana" height="20" loading="lazy">
                </div>
                <div class="brand-item">
                    <img src="{{ asset('images/brands/pwc.svg') }}" alt="PwC" height="20" loading="lazy">
                </div>
                <div class="brand-item">
                    <img src="{{ asset('images/brands/okta.svg') }}" alt="Okta" height="20" loading="lazy">
                </div>
                <div class="brand-item">
                    <img src="{{ asset('images/brands/workday.svg') }}" alt="Workday" height="20" loading="lazy">
                </div>
            </div>
            <div class="trusted-stats row mt-5 text-center">
                <div class="col-md-4">
                    <div class="stat-item text-white">
                        <div class="h2 mb-2">500M+</div>
                        <p class="text-white-50">Profile Pictures Created</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-item text-white">
                        <div class="h2 mb-2">4.9/5</div>
                        <p class="text-white-50">Customer Rating</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-item text-white">
                        <div class="h2 mb-2">99%</div>
                        <p class="text-white-50">Satisfaction Rate</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="feature-section py-5">
        <div class="container" style="max-width: 1274px;">
            <div class="section-header text-center mb-5">
                <span class="badge bg-success-subtle text-success mb-3">FEATURES</span>
                <h2 class="display-5 fw-bold">Everything you need for the perfect profile</h2>
                <p class="lead text-muted mx-auto" style="max-width: 600px;">
                    Professional tools powered by AI to help you create stunning profile pictures
                </p>
            </div>
            <div class="row align-items-center mb-5">
                <div class="col-lg-6">
                    <div class="feature-image-wrapper">
                        <div class="feature-decoration"></div>
                        <img src="{{ asset('images/features/features-item11.webp') }}" alt="Social Profile Interface"
                            class="feature-image" loading="lazy" style="width: 549px;">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="feature-content" style="max-width: 697px;">
                        <span class="badge bg-primary-subtle text-primary mb-3">LEVEL UP</span>
                        <h2 class="display-6 fw-bold mb-4">Level up your online presence</h2>
                        <p class="lead text-muted mb-4">
                            A profile picture is how others see you online and it can have a very significant impact, as it
                            creates a first impression of you. Create a profile picture that broadcasts your style,
                            confidence
                            and approachability, making it easier to connect for networking or job opportunities.
                        </p>
                        <div class="feature-benefits">
                            <div class="benefit-item">
                                <i class="fas fa-check-circle text-success"></i>
                                <span>Professional appearance</span>
                            </div>
                            <div class="benefit-item">
                                <i class="fas fa-check-circle text-success"></i>
                                <span>Increased engagement</span>
                            </div>
                            <div class="benefit-item">
                                <i class="fas fa-check-circle text-success"></i>
                                <span>Better networking</span>
                            </div>
                        </div>
                        <div class="stat-highlight">
                            <span class="stat-number text-success">36x</span>
                            <span class="stat-text">Get 36x times more interactions</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row align-items-center mb-5">
                <div class="col-lg-6 order-lg-2">
                    <div class="feature-image-wrapper">
                        <img src="{{ asset('images/features/features-item21.webp') }}" alt="LinkedIn Profile Interface"
                            class="feature-image" loading="lazy" style="width: 549px;">
                    </div>
                </div>
                <div class="col-lg-6 order-lg-1">
                    <h2 class="display-6 fw-bold mb-4">Build strong personal brand</h2>
                    <p class="lead text-muted mb-4">
                        Build and grow your personal brand to new heights with a perfect profile picture. Boost your
                        engagement and leads, as a professional-looking profile picture is the key to building connections
                        and getting more attention.
                    </p>
                    <div class="stat-highlight">
                        <span class="stat-number text-success">146%</span>
                        <span class="stat-text">Get 146% more engagement and drive more leads</span>
                    </div>
                </div>
            </div>

            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="feature-image-wrapper">
                        <img src="{{ asset('images/hero/hero-1.webp') }}" alt="Profile Picture Variations"
                            class="feature-image" loading="lazy" style="width: 549px;">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="feature-content" style="max-width: 697px;">
                        <h2 class="display-6 fw-bold mb-4">Personalize to perfection</h2>
                        <p class="lead text-muted">
                            Fine-tune every little detail of your profile picture to perfection with a vast selection of
                            tools.
                            Experiment with AI, filters, backgrounds and templates to find your ideal look.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- AI Portrait Editor Section -->
    <section class="ai-portrait-editor py-5">
        <div class="container" style="max-width: 1140px;">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="editor-content">
                        <h2 class="display-5 fw-bold mb-4">
                            AI Portrait<br>Editor
                        </h2>
                        <p class="lead text-muted mb-4">
                            Transform your photos into polished portraits with AI-powered background removal and enhancement
                            tools
                        </p>
                        <div class="features-list mb-4">
                            <div class="feature-item">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                <span>Background Removal</span>
                            </div>
                            <div class="feature-item">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                <span>Background Replacement</span>
                            </div>
                            <div class="feature-item">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                <span>AI Portrait Enhancer</span>
                            </div>
                            <div class="feature-item">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                <span>Professional Templates</span>
                            </div>
                        </div>
                        <a href="#" class="btn btn-success btn-lg px-4 py-3 rounded-pill">
                            Try PFPMaker Now
                        </a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="editor-preview">
                        <img src="{{ asset('images/features/features-item-img-nbg.webp') }}"
                            alt="AI Portrait Editor Interface" class="img-fluid" style="width: 549px;" loading="lazy">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How to Use Section -->
    <section class="how-to-use py-5">
        <div class="container text-center">
            <div class="section-header text-center mb-5">
                <span class="badge bg-primary-subtle text-primary mb-3">EASY TO USE</span>
                <h2 class="display-5 fw-bold mb-3">Create perfect profile pictures in minutes</h2>
                <p class="text-muted mb-5">
                    With PFPMaker you can create a professional profile picture for any media,<br>
                    be it LinkedIn, CV, Resume, Instagram or any Messenger in a few clicks
                </p>
            </div>

            <div class="usage-tabs mb-5">
                <div class="nav nav-pills nav-custom justify-content-center mb-4" id="usage-tabs" role="tablist">
                    <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#social-media">
                        <i class="fas fa-share-nodes me-2"></i>
                        Social Media
                    </button>
                    <button class="nav-link" data-bs-toggle="pill" data-bs-target="#teams">
                        <i class="fas fa-users me-2"></i>
                        Teams
                    </button>
                    <button class="nav-link" data-bs-toggle="pill" data-bs-target="#business-cards">
                        <i class="fas fa-id-card me-2"></i>
                        Business Cards
                    </button>
                    <button class="nav-link" data-bs-toggle="pill" data-bs-target="#cv-resume">
                        <i class="fas fa-file-alt me-2"></i>
                        CV / Resume
                    </button>
                    <button class="nav-link" data-bs-toggle="pill" data-bs-target="#email-signature">
                        <i class="fas fa-envelope me-2"></i>
                        Email Signature
                    </button>
                </div>

                <div class="tab-content">
                    <!-- Social Media Tab -->
                    <div class="tab-pane fade show active" id="social-media">
                        <div class="usage-preview position-relative">
                            <div class="preview-decoration"></div>
                            <div class="row align-items-center g-4">
                                <!-- Zoom Preview -->
                                <div class="col-md-4 mx-auto">
                                    <div class="preview-card">
                                        <img src="{{ asset('images/variants-slide-2.webp') }}" alt="Social Media Preview"
                                            class="img-fluid rounded-4" loading="lazy">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Teams Tab -->
                    <div class="tab-pane fade" id="teams">
                        <div class="usage-preview position-relative">
                            <div class="preview-decoration"></div>
                            <div class="row align-items-center g-4">
                                <div class="col-md-8 mx-auto">
                                    <div class="preview-card">
                                        <img src="{{ asset('images/variants-slide-1.webp') }}"
                                            alt="Team Profile Pictures" class="img-fluid rounded-4" loading="lazy">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Business Cards Tab -->
                    <div class="tab-pane fade" id="business-cards">
                        <div class="usage-preview position-relative">
                            <div class="preview-decoration"></div>
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <div class="preview-card">
                                        <img src="{{ asset('images/usage/variants-slide-3.webp') }}" alt="Business Card"
                                            class="img-fluid rounded-4">
                                        <div class="preview-overlay">
                                            <span class="badge bg-white text-primary">Professional</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- CV/Resume Tab -->
                    <div class="tab-pane fade" id="cv-resume">
                        <div class="usage-preview position-relative">
                            <div class="preview-decoration"></div>
                            <div class="row align-items-center">
                                <div class="col-md-8 mx-auto">
                                    <div class="preview-card">
                                        <img src="{{ asset('images/usage/variants-slide-4.webp') }}" alt="CV Preview"
                                            class="img-fluid rounded-4">
                                        <div class="preview-overlay">
                                            <span class="badge bg-white text-primary">CV Ready</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Email Signature Tab -->
                    <div class="tab-pane fade" id="email-signature">
                        <div class="usage-preview position-relative">
                            <div class="preview-decoration"></div>
                            <div class="row align-items-center">
                                <div class="col-md-6 mx-auto">
                                    <div class="preview-card">
                                        <img src="{{ asset('images/usage/variants-slide-5.webp') }}"
                                            alt="Email Signature" class="img-fluid rounded-4">
                                        <div class="preview-overlay">
                                            <span class="badge bg-white text-primary">Email Ready</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="usage-features mt-5">
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="usage-feature-card">
                            <div class="feature-icon">
                                <i class="fas fa-wand-magic-sparkles text-primary"></i>
                            </div>
                            <h4>One-Click Enhancement</h4>
                            <p>Instantly enhance your photos with AI-powered tools</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="usage-feature-card">
                            <div class="feature-icon">
                                <i class="fas fa-crop text-primary"></i>
                            </div>
                            <h4>Smart Cropping</h4>
                            <p>Perfect dimensions for every platform</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="usage-feature-card">
                            <div class="feature-icon">
                                <i class="fas fa-share text-primary"></i>
                            </div>
                            <h4>Easy Sharing</h4>
                            <p>Direct sharing to your favorite platforms</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats py-5">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-4">
                    <div class="stat-item">
                        <h3>500M+</h3>
                        <p>Profile Pictures</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-item">
                        <h3>10M+</h3>
                        <p>Users</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-item">
                        <h3>4.7</h3>
                        <p>Rating</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="testimonials py-5 bg-light">
        <div class="container">
            <div class="section-header text-center mb-5">
                <span class="badge bg-warning-subtle text-warning mb-3">TESTIMONIALS</span>
                <h2 class="display-5 fw-bold">Loved by professionals worldwide</h2>
                <p class="lead text-muted mx-auto" style="max-width: 600px;">
                    See what our users have to say about their experience with PFPMaker
                </p>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-4">
                    <div class="testimonial-card bg-white p-5 rounded-4 shadow-sm">
                        <div class="testimonial-profile mb-4">
                            <img src="{{ asset('images/testimonials/avatar-2.webp') }}" alt="Kevin Bello"
                                class="rounded-circle mb-3" width="60">
                            <h5 class="mb-1">Kevin Bello</h5>
                            <p class="text-muted small">Marketing Director at Google</p>
                        </div>
                        <div class="rating mb-4">
                            @for ($i = 0; $i < 5; $i++)
                                <i class="fas fa-star text-warning"></i>
                            @endfor
                        </div>
                        <p class="testimonial-text mb-4">
                            The value was very good for the amount charged. I walked away with many usable images for my
                            project for a very reasonable price. In addition, the customer service was fantastic. I was
                            hoping to have a few edits made to a particular image. I reached out over chat and had final
                            revisions turned around in less than 24 hours. Wow!
                        </p>
                        <div class="testimonial-platform mt-4">
                            <img src="{{ asset('images/brands/google.svg') }}" alt="Google" height="20">
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="testimonial-card bg-white p-5 rounded-4 shadow-sm">
                        <div class="testimonial-profile mb-4">
                            <img src="{{ asset('images/testimonials/michelle.webp') }}" alt="Sarah Chen"
                                class="rounded-circle mb-3" width="60">
                            <h5 class="mb-1">Sarah Chen</h5>
                            <p class="text-muted small">Product Designer at LinkedIn</p>
                        </div>
                        <div class="rating mb-4">
                            @for ($i = 0; $i < 5; $i++)
                                <i class="fas fa-star text-warning"></i>
                            @endfor
                        </div>
                        <p class="testimonial-text mb-4">
                            The AI enhancement feature is incredible! My profile pictures look so much more professional
                            now.
                        </p>
                        <div class="testimonial-platform mt-4">
                            <img src="{{ asset('images/brands/linkedin.svg') }}" alt="LinkedIn" height="20">
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="testimonial-card bg-white p-5 rounded-4 shadow-sm">
                        <div class="testimonial-profile mb-4">
                            <img src="{{ asset('images/testimonials/mario.webp') }}" alt="Michael Torres"
                                class="rounded-circle mb-3" width="60">
                            <h5 class="mb-1">Michael Torres</h5>
                            <p class="text-muted small">Freelance Photographer</p>
                        </div>
                        <div class="rating mb-4">mario.webp
                            @for ($i = 0; $i < 5; $i++)
                                <i class="fas fa-star text-warning"></i>
                            @endfor
                        </div>
                        <p class="testimonial-text mb-4">
                            The background removal tool is a game-changer. Clean, professional results every time.
                        </p>
                        <div class="testimonial-platform mt-4">
                            <span class="badge bg-success">Verified User</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center mt-5">
                <a href="#" class="btn btn-outline-primary">
                    Read More Reviews
                    <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="faq py-5">
        <div class="container">
            <div class="section-header text-center mb-5">
                <span class="badge bg-info-subtle text-info mb-3">FAQ</span>
                <h2 class="display-5 fw-bold">Questions? Look here</h2>
                <p class="lead text-muted mx-auto" style="max-width: 600px;">
                    Everything you need to know about PFPMaker and our AI-powered tools
                </p>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="accordion custom-accordion" id="faqAccordion">
                        <div class="accordion-item mb-3">
                            <h3 class="accordion-header">
                                <button class="accordion-button custom-accordion-button" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#faq1">
                                    <i class="fas fa-magic me-3 text-primary"></i>
                                    Can the background be removed more precisely?
                                </button>
                            </h3>
                            <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <div class="faq-content">
                                        Yes, our AI-powered background removal tool provides precise and accurate results.
                                        <div class="faq-features mt-3">
                                            <div class="feature-tag">
                                                <i class="fas fa-check-circle text-success"></i>
                                                <span>AI-powered precision</span>
                                            </div>
                                            <div class="feature-tag">
                                                <i class="fas fa-check-circle text-success"></i>
                                                <span>Edge detection</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item mb-3">
                            <h3 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#faq2">
                                    Where can generated profile pics be used?
                                </button>
                            </h3>
                            <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Generated profile pictures can be used on any social media platform, professional
                                    networking sites, or business materials.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item mb-3">
                            <h3 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#faq3">
                                    How the generated profile pics can be used?
                                </button>
                            </h3>
                            <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    You can use the generated profile pictures for personal or professional use on any
                                    platform.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item mb-3">
                            <h3 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#faq4">
                                    What happens with my photo after upload?
                                </button>
                            </h3>
                            <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Your photos are processed securely and deleted after processing. We don't store any
                                    personal data.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item mb-3">
                            <h3 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#faq5">
                                    What photo formats are supported?
                                </button>
                            </h3>
                            <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    We support all common image formats including JPG, PNG, WEBP, and HEIC.
                                </div>
                            </div>
                        </div>
                        <!-- Add more FAQ items -->
                    </div>
                    <div class="text-center mt-5">
                        <p class="text-muted mb-4">Still have questions? We're here to help!</p>
                        <a href="#" class="btn btn-outline-primary">
                            Contact Support
                            <i class="fas fa-headset ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Blog Section -->
    <section class="blog py-5 bg-light">
        <div class="container">
            <div class="section-header text-center mb-5">
                <span class="badge bg-success-subtle text-success mb-3">RESOURCES</span>
                <h2 class="display-5 fw-bold">Learn from our experts</h2>
                <p class="lead text-muted mx-auto" style="max-width: 600px;">
                    Discover tips, tricks, and best practices for creating the perfect profile picture
                </p>
            </div>

            <div class="row g-4">
                <div class="col-md-4">
                    <div class="blog-card h-100">
                        <div class="card-image-wrapper">
                            <img src="{{ asset('images/blog/blog_0.webp') }}" class="card-img-top"
                                alt="Remove Background" loading="lazy">
                            <div class="card-overlay">
                                <a href="#" class="btn btn-light btn-sm">Read Article</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <span class="badge bg-primary-subtle text-primary mb-2">TUTORIAL</span>
                            <h5 class="card-title">How to remove background from a profile picture?</h5>
                            <p class="card-text text-muted">Learn how to use our AI-powered background removal tool to
                                create professional headshots.</p>
                        </div>
                        <div class="card-footer bg-transparent border-0">
                            <div class="d-flex align-items-center">
                                <span class="text-muted small">
                                    <i class="far fa-clock me-1"></i> 5 min read
                                </span>
                                <span class="ms-auto">
                                    <i class="far fa-bookmark text-primary"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="blog-card h-100">
                        <div class="card-image-wrapper">
                            <img src="{{ asset('images/blog/blog_1.webp') }}" class="card-img-top" alt="Perfect Selfie"
                                loading="lazy">
                            <div class="card-overlay">
                                <a href="#" class="btn btn-light btn-sm">Read Article</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <span class="badge bg-primary-subtle text-primary mb-2">TUTORIAL</span>
                            <h5 class="card-title">How to take the perfect selfie</h5>
                            <p class="card-text text-muted">Learn how to capture the perfect selfie for your profile
                                picture.</p>
                        </div>
                        <div class="card-footer bg-transparent border-0">
                            <div class="d-flex align-items-center">
                                <span class="text-muted small">
                                    <i class="far fa-clock me-1"></i> 5 min read
                                </span>
                                <span class="ms-auto">
                                    <i class="far fa-bookmark text-primary"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="blog-card h-100">
                        <div class="card-image-wrapper">
                            <img src="{{ asset('images/blog/blog_2.webp') }}" class="card-img-top"
                                alt="LinkedIn Profile" loading="lazy">
                            <div class="card-overlay">
                                <a href="#" class="btn btn-light btn-sm">Read Article</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <span class="badge bg-primary-subtle text-primary mb-2">TUTORIAL</span>
                            <h5 class="card-title">7 Steps for creating a perfect LinkedIn Profile</h5>
                            <p class="card-text text-muted">Learn how to create a professional LinkedIn profile with these
                                7 easy steps.</p>
                        </div>
                        <div class="card-footer bg-transparent border-0">
                            <div class="d-flex align-items-center">
                                <span class="text-muted small">
                                    <i class="far fa-clock me-1"></i> 5 min read
                                </span>
                                <span class="ms-auto">
                                    <i class="far fa-bookmark text-primary"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center mt-5">
                <a href="#" class="btn btn-outline-primary">
                    View All Articles
                    <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </section>

    @push('scripts')
        <!-- No JavaScript needed for navigation -->
    @endpush
@endsection
