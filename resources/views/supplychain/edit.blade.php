@extends('layouts.Supplychain-master')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-xl-11">
                <div class="header-mono mb-5 d-flex justify-content-between align-items-center pb-3">
                    <div>
                        <h2 class="fw-bold text-dark m-0">Asset Configuration</h2>
                        <small class="text-muted">Manage product details and components</small>
                    </div>
                </div>
                <br>
                <div class="row g-4 justify-content-center">
                    <div class="col-lg-5">
                        <div class="mono-card shadow-sm border-0">
                            <div class="card-body p-4 p-xl-5">
                                <h5 class="fw-bold text-dark mb-4 text-center">General Information</h5>

                                <form action="{{ route('supply.update', $product->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf @method('PUT')

                                    <div class="avatar-upload mb-4">
                                        <div class="avatar-preview mx-auto">
                                            <img id="main-img" src="{{ asset('uploads/products/' . $product->image) }}">
                                            <label for="main-upload" class="upload-badge-mono">
                                                <i class="fas fa-camera"></i>
                                                <input type="file" name="image" id="main-upload" hidden
                                                    onchange="previewMain(this)">
                                            </label>
                                        </div>
                                    </div>

                                    <div class="mono-field mb-3">
                                        <label>Serial Number</label>
                                        <input type="text" name="serial_number" value="{{ $product->serial_number }}"
                                            placeholder="S/N-00000">
                                    </div>

                                    <div class="mono-field mb-5">
                                        <label>Product Label</label>
                                        <input type="text" name="name" value="{{ $product->name }}"
                                            placeholder="Asset Name">
                                    </div>
                                    <br>

                                    <div class="d-flex flex-column align-items-center gap-3">
                                        <button type="submit" class="btn-mono-dark px-5">
                                            Save Changes
                                        </button>
                                        <button type="button" class="btn-mono-light px-5" onclick="toggleSpareParts()">
                                            Manage Spare Parts
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-7" id="sparePartsSection" style="display: none;">
                        <div class="mono-card shadow-sm border-0 h-100 animate-fade-in">
                            <div class="card-body p-4 p-xl-5">
                                <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-2">
                                    <h5 class="fw-bold text-dark m-0">Spare Parts</h5>
                                    <button type="button" class="btn-close-mono" onclick="toggleSpareParts()">×</button>
                                </div>

                                <form action="{{ route('spare-parts.store') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">

                                    <div class="row g-3 mb-4 justify-content-center">
                                        <div class="col-12">
                                            <div class="part-upload-box mx-auto">
                                                <input type="file" name="part_image" id="part-upload" hidden required
                                                    onchange="previewPart(this)">
                                                <label for="part-upload" class="image-drop-mono">
                                                    <div id="plus-icon-container">
                                                        <span class="plus-symbol">+</span>
                                                        <p class="small text-muted m-0">Add Photo</p>
                                                    </div>
                                                    <img id="part-preview-img" src="#" alt="Preview"
                                                        style="display:none;">
                                                </label>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="col-12">
                                            <div class="mono-field">
                                                <label>Component Name</label>
                                                <input type="text" name="part_name" placeholder="Enter component name..."
                                                    required>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="col-12 d-flex justify-content-center mt-4">
                                            <button type="submit" class="btn-mono-dark">Add Component</button>
                                        </div>
                                    </div>
                                </form>

                                <div class="parts-list-mono border-top pt-4">
                                    @forelse($product->spareParts as $part)
                                        <div
                                            class="mono-part-item d-flex align-items-center justify-content-between p-2 mb-2 border-bottom">
                                            <div class="d-flex align-items-center">
                                                <img src="{{ asset('uploads/parts/' . $part->image) }}"
                                                    class="rounded me-3 border" width="45" height="45"
                                                    style="object-fit: cover;">
                                                <span class="fw-bold text-dark small">{{ $part->name }}</span>
                                            </div>
                                            <form action="{{ route('spare-parts.destroy', $part->id) }}" method="POST">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn-del-mono"
                                                    onclick="return confirm('Remove?')">Remove</button>
                                            </form>
                                        </div>
                                    @empty
                                        <p class="text-muted text-center small py-3">No components found.</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Mono Design Theme */
        body {
            background-color: #f8f9fa;
            color: #212529;
            font-family: 'Segoe UI', sans-serif;
        }

        .header-mono {
            border-bottom: 2px solid #eee;
        }

        .mono-card {
            background: #ffffff;
            border: 1px solid #e9ecef !important;
        }

        /* Inputs */
        .mono-field label {
            font-size: 13px;
            font-weight: 800;
            color: black;
            text-transform: uppercase;
            margin-bottom: 5px;
            display: block;
        }

        .mono-field input {
            width: 100%;
            padding: 12px;
            border: 1px solid #dee2e6;
            border-radius: 10px;
            background: #fdfdfd;
            font-size: 14px;
        }

        .mono-field input:focus {
            outline: none;
            border-color: #1b2d95;
            background: #fff;
        }

        /* Buttons */
        .btn-mono-dark {
            background: fff;
            color: #212529
            border: none;
            padding: 12px 30px;
            border-radius: 10px;
            font-weight: 600;
            transition: 0.3s;
        }

        .btn-mono-dark:hover {
            background: #0a0067;
             color: #fff
        }

        .btn-mono-light {
            background: fff;
            color: #212529
            border: none;
            padding: 12px 30px;
            border-radius: 10px;
            font-weight: 600;
            transition: 0.3s;
        }

        .btn-mono-light:hover {
            background: #1b2d95;
             color: #fff
        }

        /* Part Upload Box (The Large Square with Plus) */
        .image-drop-mono {
            width: 10%;
            height: 100px;
            background: #f8f9fa;
            border: 2px dashed #dee2e6;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            transition: 0.3s;
        }
        .image-drop-mono img{
            object-fit: cover;
        }

        .image-drop-mono:hover {
            border-color: #1b2d95;
            background: #fff;
        }

        .plus-symbol {
            font-size: 40px;
            color: #dee2e6;
            display: block;
            line-height: 1;
        }

        #part-preview-img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            position: absolute;
            background: white;
        }

        /* Avatar */
        .avatar-preview {
            width: 110px;
            height: 110px;
            position: relative;
        }

        .avatar-preview img {
            width: 100%;
            height: 100%;
            border-radius: 25px;
            object-fit: cover;
            border: 1px solid #eee;
        }

        .upload-badge-mono {
            position: absolute;
            bottom: -5px;
            right: -5px;
            background: #212529;
            color: #fff;
            width: 30px;
            height: 30px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        /* Utils */
        .btn-exit-mono {
            text-decoration: none;
            color: #6c757d;
            font-weight: 600;
            border: 1px solid #dee2e6;
            padding: 8px 20px;
            border-radius: 8px;
            font-size: 13px;
        }

        .btn-close-mono {
            background: none;
            border: none;
            font-size: 20px;
            font-weight: bold;
        }

        .btn-del-mono {
            background: none;
            border: none;
            color: #dc3545;
            font-size: 12px;
            font-weight: 600;
        }

        .animate-fade-in {
            animation: fadeIn 0.4s;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

    <script>
        function toggleSpareParts() {
            const section = document.getElementById('sparePartsSection');
            section.style.display = (section.style.display === "none") ? "block" : "none";
        }

        function previewMain(input) {
            if (input.files && input.files[0]) {
                let reader = new FileReader();
                reader.onload = e => document.getElementById('main-img').src = e.target.result;
                reader.readAsDataURL(input.files[0]);
            }
        }

        function previewPart(input) {
            if (input.files && input.files[0]) {
                let reader = new FileReader();
                let preview = document.getElementById('part-preview-img');
                let icon = document.getElementById('plus-icon-container');
                reader.onload = e => {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                    icon.style.display = 'none';
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection
