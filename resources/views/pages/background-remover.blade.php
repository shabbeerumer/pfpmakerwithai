@extends('layouts.app')

@section('title', 'Remove Background from Images - PFPMaker')

@section('styles')
    <style>
        .background-option {
            cursor: pointer;
            border: 2px solid transparent;
            border-radius: 8px;
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .background-option:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .background-option.selected {
            border-color: #0d6efd;
        }

        .background-preview {
            width: 100%;
            height: 120px;
            border-radius: 8px;
            background-size: cover;
            background-position: center;
            position: relative;
            overflow: hidden;
        }

        .background-preview img {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        /* Transparent background pattern */
        .transparent-bg {
            background-image: linear-gradient(45deg, #f0f0f0 25%, transparent 25%),
                linear-gradient(-45deg, #f0f0f0 25%, transparent 25%),
                linear-gradient(45deg, transparent 75%, #f0f0f0 75%),
                linear-gradient(-45deg, transparent 75%, #f0f0f0 75%);
            background-size: 20px 20px;
            background-position: 0 0, 0 10px, 10px -10px, -10px 0px;
        }

        /* Gradient backgrounds */
        .gradient-sunset {
            background: linear-gradient(45deg, #ff512f, #dd2476);
        }

        .gradient-ocean {
            background: linear-gradient(45deg, #2193b0, #6dd5ed);
        }

        .gradient-purple {
            background: linear-gradient(45deg, #8e2de2, #4a00e0);
        }

        .gradient-emerald {
            background: linear-gradient(45deg, #0BAB64, #3BB78F);
        }

        .gradient-golden {
            background: linear-gradient(45deg, #FFD700, #FFA500);
        }

        .gradient-rose {
            background: linear-gradient(45deg, #ee9ca7, #ffdde1);
        }

        .gradient-midnight {
            background: linear-gradient(45deg, #232526, #414345);
        }

        .gradient-royal {
            background: linear-gradient(45deg, #141E30, #243B55);
        }
    </style>
@endsection

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <h1 class="display-4 fw-bold mb-4">Remove Background from Images</h1>
                <p class="lead text-muted mb-5">Upload your image and our AI will automatically remove the background in
                    seconds.</p>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="upload-area bg-white rounded-4 shadow-sm p-5 mb-4">
                    <form id="uploadForm" class="text-center">
                        <input type="file" id="file-input" class="d-none" accept="image/*">
                        <div id="dropZone" class="border-2 border-dashed rounded-4 p-5 mb-4 position-relative">
                            <div class="upload-content">
                                <i class="fas fa-cloud-upload-alt fa-3x text-primary mb-3"></i>
                                <h3 class="h5 mb-3">Drag and drop your image here</h3>
                                <p class="text-muted mb-3">or</p>
                                <button type="button" id="uploadButton" class="btn btn-primary px-4 py-2">
                                    Choose File
                                </button>
                                <p class="small text-muted mt-3 mb-0">
                                    Supported formats: PNG, JPEG, JPG<br>
                                    Maximum file size: 5MB
                                </p>
                            </div>
                            <div id="uploadProgress" class="progress mt-3 d-none">
                                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div id="image-preview" class="d-none">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="card h-100">
                                <div class="card-header bg-white py-3">
                                    <h5 class="mb-0">Original Image</h5>
                                </div>
                                <div class="card-body p-3">
                                    <img id="originalImage" class="img-fluid rounded" alt="Original Image">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="card h-100">
                                <div class="card-header bg-white py-3">
                                    <h5 class="mb-0">Result</h5>
                                </div>
                                <div class="card-body p-3">
                                    <img id="processedImage" class="img-fluid rounded" alt="Processed Image">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Background Options Section -->
                    <div id="backgroundOptions" class="mt-4 d-none">
                        <h3 class="h4 text-center mb-4">Choose a Background</h3>
                        <div class="row g-4">
                            <div class="col-6 col-md-3">
                                <div class="background-option" data-bg="transparent">
                                    <div class="background-preview transparent-bg">
                                        <!-- Image will be inserted here by JavaScript -->
                                    </div>
                                    <p class="small text-center mt-2 mb-0">Transparent</p>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="background-option" data-bg="solid-white">
                                    <div class="background-preview bg-white border"></div>
                                    <p class="small text-center mt-2 mb-0">White</p>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="background-option" data-bg="gradient-blue">
                                    <div class="background-preview"
                                        style="background-image: linear-gradient(45deg, #1a73e8, #8ab4f8)"></div>
                                    <p class="small text-center mt-2 mb-0">Blue Sky</p>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="background-option" data-bg="gradient-sunset">
                                    <div class="background-preview gradient-sunset"></div>
                                    <p class="small text-center mt-2 mb-0">Sunset</p>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="background-option" data-bg="gradient-ocean">
                                    <div class="background-preview gradient-ocean"></div>
                                    <p class="small text-center mt-2 mb-0">Ocean</p>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="background-option" data-bg="gradient-purple">
                                    <div class="background-preview gradient-purple"></div>
                                    <p class="small text-center mt-2 mb-0">Royal Purple</p>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="background-option" data-bg="gradient-emerald">
                                    <div class="background-preview gradient-emerald"></div>
                                    <p class="small text-center mt-2 mb-0">Emerald</p>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="background-option" data-bg="gradient-golden">
                                    <div class="background-preview gradient-golden"></div>
                                    <p class="small text-center mt-2 mb-0">Golden</p>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="background-option" data-bg="gradient-rose">
                                    <div class="background-preview gradient-rose"></div>
                                    <p class="small text-center mt-2 mb-0">Rose</p>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="background-option" data-bg="gradient-midnight">
                                    <div class="background-preview gradient-midnight"></div>
                                    <p class="small text-center mt-2 mb-0">Midnight</p>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="background-option" data-bg="gradient-royal">
                                    <div class="background-preview gradient-royal"></div>
                                    <p class="small text-center mt-2 mb-0">Royal Blue</p>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="background-option" data-bg="office">
                                    <div class="background-preview"
                                        style="background-image: url('{{ asset('images/backgrounds/office.jpg') }}')">
                                    </div>
                                    <p class="small text-center mt-2 mb-0">Office</p>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="background-option" data-bg="studio">
                                    <div class="background-preview"
                                        style="background-image: url('{{ asset('images/backgrounds/studio.jpg') }}')">
                                    </div>
                                    <p class="small text-center mt-2 mb-0">Studio</p>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="background-option" data-bg="nature">
                                    <div class="background-preview"
                                        style="background-image: url('{{ asset('images/backgrounds/nature.jpg') }}')">
                                    </div>
                                    <p class="small text-center mt-2 mb-0">Nature</p>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="background-option" data-bg="city">
                                    <div class="background-preview"
                                        style="background-image: url('{{ asset('images/backgrounds/city.jpg') }}')"></div>
                                    <p class="small text-center mt-2 mb-0">City</p>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="background-option" data-bg="custom-bg">
                                    <div
                                        class="background-preview bg-light d-flex align-items-center justify-content-center">
                                        <i class="fas fa-upload text-muted"></i>
                                    </div>
                                    <p class="small text-center mt-2 mb-0">Custom Background</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <button id="downloadButton" class="btn btn-success btn-lg px-4 me-2">
                            <i class="fas fa-download me-2"></i>Download
                        </button>
                        <button id="tryAgainButton" class="btn btn-outline-primary btn-lg px-4">
                            <i class="fas fa-redo me-2"></i>Try Another Image
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Initialize when DOM is loaded
        document.addEventListener('DOMContentLoaded', () => {
            // Initialize tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });
        });
    </script>
@endsection
