@extends('layouts.app')

@section('title', 'PFP Editor')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <h1 class="text-center mb-4">Create Your Profile Picture</h1>
            
            <div class="upload-area mb-4">
                <input type="file" id="file-input" class="d-none" accept="image/*">
                <div class="text-center">
                    <i class="fas fa-cloud-upload-alt fa-3x mb-3"></i>
                    <h3>Drag & Drop your photo here</h3>
                    <p class="text-muted">or</p>
                    <button class="btn btn-primary" onclick="document.getElementById('file-input').click()">
                        Choose File
                    </button>
                    <p class="mt-2 text-muted small">Supported formats: JPG, PNG (Max 5MB)</p>
                </div>
            </div>
            
            <div id="image-preview" class="text-center mb-4">
                <!-- Preview will be inserted here -->
            </div>
            
            <div id="editor-tools" class="mt-4" style="display: none;">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Basic Adjustments</h5>
                                <div class="mb-3">
                                    <label for="brightness" class="form-label">Brightness</label>
                                    <input type="range" class="form-range" id="brightness" min="0" max="200" value="100">
                                </div>
                                <div class="mb-3">
                                    <label for="contrast" class="form-label">Contrast</label>
                                    <input type="range" class="form-range" id="contrast" min="0" max="200" value="100">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Actions</h5>
                                <div class="d-grid gap-2">
                                    <button class="btn btn-primary" onclick="imageEditor.saveChanges()">Save Changes</button>
                                    <button class="btn btn-secondary" onclick="imageEditor.resetChanges()">Reset</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/editor.js') }}"></script>
@endsection 