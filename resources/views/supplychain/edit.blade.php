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
                                <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
                                    <h5 class="fw-bold text-dark m-0">
                                        <i class="fas fa-tools me-2 opacity-50"></i>Spare Parts
                                    </h5>
                                    <button type="button" class="btn-close-mono" onclick="toggleSpareParts()"
                                        aria-label="Close">×</button>
                                </div>

                                <form action="{{ route('spare-parts.store') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">

                                    <div class="row g-4">
                                        <div class="col-12 text-center mb-2">
                                            <div class="image-drop-mono mx-auto shadow-sm"
                                                style="width: 110px; height: 110px; position: relative;">
                                                <input type="file" name="part_image" id="part-upload" hidden
                                                    onchange="previewPart(this)">
                                                <label for="part-upload"
                                                    style="width: 150px; height: 150px; border: 2px dashed #ccc; cursor: pointer; display: flex; align-items: center; justify-content: center; position: relative; overflow: hidden; background: #f9f9f9;">
                                                    <img id="part-preview-img" src="#"
                                                        style="display:none; max-width: 100%; max-height: 100%; object-fit: contain;">

                                                    <span id="plus-icon" style="font-size: 2rem; color: #999;">+</span>
                                                </label>

                                                <input type="file" name="part_image" id="part-upload" hidden
                                                    onchange="previewPart(this)">
                                            </div>
                                            <p class="text-muted small mt-2">Upload Part Image</p>
                                        </div>

                                        <div class="col-12">
                                            <div class="mono-field">
                                                <label class="form-label small fw-bold text-uppercase">Component
                                                    Name</label>
                                                <input type="text" name="part_name" class="form-control"
                                                    placeholder="e.g. Engine Valve" required>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mono-field">
                                                <label class="form-label small fw-bold text-uppercase">Quantity</label>
                                                <input type="number" name="quantity" class="form-control" value="0"
                                                    min="0" required>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mono-field">
                                                <label class="form-label small fw-bold text-uppercase">Price (Unit)</label>
                                                <div class="input-group">
                                                    <input type="number" name="price" step="0.01"
                                                        class="form-control" value="0.00" min="0" required>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="col-12 text-center mt-4">
                                            <button type="submit" class="btn-mono-dark w-100 py-3 shadow-sm">
                                                <i class="fas fa-plus-circle me-2"></i>ADD_TO_INVENTORY
                                            </button>
                                        </div>
                                    </div>
                                </form>
                                <br>
                                <div class="parts-list-mono border-top mt-5 pt-4">
                                    <h2 class="fw-bold mb-3  text-muted text-uppercase">Existing Components</h2>
                                    <br>
                                    <div class="parts-scroll-area" style="max-height: 350px; overflow-y: auto;">

                                    </div>
                                    <div class="parts-list-mono border-top mt-5 pt-4">
                                        <h6 class="fw-bold mb-3 small text-muted text-uppercase">Existing Components</h6>

                                        <div class="table-responsive">
                                            <table class="table custom-show-table align-middle">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 15%;">Spare Part</th>
                                                        <th style="width: 15%;">Name</th>
                                                        <th class="text-center" style="width: 15%;">Quantity</th>
                                                        <th class="text-center" style="width: 15%;">The Condition</th>
                                                        <th class="text-center" style="width: 15%;">Unit Price</th>
                                                        <th class="text-center"></th>
                                                        {{-- حقل زر الحذف --}}
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($product->spareParts as $part)
                                                        <tr>
                                                            <td>
                                                                <div>
                                                                    <img src="{{ $part->image ? asset('uploads/parts/' . $part->image) : asset('assets/no-image.png') }}"
                                                                        style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;">
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="fw-bold text-dark fs-6">
                                                                    {{ $part->name }}
                                                                </div>
                                                            </td>
                                                            <td class="text-center">
                                                                <span
                                                                    class="qty-badge-simple p-2 rounded bg-light border fw-bold small"
                                                                    style="width: 20%;">
                                                                    {{ $part->quantity }} pcs
                                                                </span>
                                                            </td>
                                                            <td class="text-center">
                                                                @if ($part->quantity >= 7)
                                                                    <span
                                                                        class="badge-status status-available text-success border border-success px-3 py-1 rounded-pill"
                                                                        style="font-size: 11px; background: #e8f5e9;">
                                                                        <i class="fas fa-check-circle me-1"></i> Available
                                                                    </span>
                                                                @elseif($part->quantity <= 6 && $part->quantity > 0)
                                                                    <span
                                                                        class="badge-status status-limited text-warning border border-warning px-3 py-1 rounded-pill"
                                                                        style="font-size: 11px; background: #fff8e1;">
                                                                        <i class="fas fa-exclamation-triangle me-1"></i>
                                                                        Limited
                                                                    </span>
                                                                @else
                                                                    <span
                                                                        class="badge-status status-unavailable text-danger border border-danger px-3 py-1 rounded-pill"
                                                                        style="font-size: 11px; background: #ffebee;">
                                                                        <i class="fas fa-times-circle me-1"></i>
                                                                        Unavailable
                                                                    </span>
                                                                @endif
                                                            </td>
                                                            <td class="text-center">
                                                                <span class="fw-bold text-dark fs-6" style="width: 20%">
                                                                    ${{ number_format($part->price, 2) }}
                                                                </span>
                                                            </td>
                                                            <td class="text-end">
                                                                <form
                                                                    action="{{ route('spare-parts.destroy', $part->id) }}"
                                                                    method="POST" class="m-0 d-inline">
                                                                    @csrf @method('DELETE')
                                                                    <button type="submit"
                                                                        class="btn btn-link text-danger p-0"
                                                                        onclick="return confirm('Remove this component?')"
                                                                        style="text-decoration: none;">
                                                                        <i class="fas fa-trash-alt"></i>
                                                                    </button>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="6" class="text-center py-5">
                                                                <i
                                                                    class="fas fa-box-open fa-3x opacity-25 mb-3 d-block text-muted"></i>
                                                                <p class="text-muted fw-bold">No components linked to this
                                                                    asset yet.</p>
                                                            </td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
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

        .custom-show-table th,
        .custom-show-table td {
            text-align: center;
            /* توسيط أفقي */
            vertical-align: middle;
            /* توسيط عمودي */
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
            color: #212529 border: none;
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
            color: #212529 border: none;
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

        .image-drop-mono img {
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

        /* تنسيقات إضافية لتحسين مظهر الجدول المخصص */
        .custom-show-table {
            border-collapse: separate;
            border-spacing: 0 10px;
            table-layout: auto;
        }

        .custom-show-table thead th {
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
            padding: 15px 10px;
            font-size: 12px;
            color: #6c757d;
            text-transform: uppercase;
        }

        .custom-show-table tbody tr {
            transition: all 0.2s;
        }

        .custom-show-table tbody tr:hover {
            background-color: #fdfdfd;
            transform: scale(1.002);
        }

        .badge-status {
            display: inline-flex;
            align-items: center;
            font-weight: 600;
        }

        .qty-badge-simple {
            color: #495057;
            display: inline-block;
            min-width: 70px;
        }

        .custom-show-table td:last-child,
        .custom-show-table th:last-child {
            /* يضمن أن عمود الحذف يلتصق بنهاية الجدول */
            padding-right: 15px;
            text-align: right;
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
                var reader = new FileReader();
                reader.onload = function(e) {
                    // إظهار الصورة وتكبيرها لتملأ المساحة المتاحة دون قص
                    const img = document.getElementById('part-preview-img');
                    const icon = document.getElementById('plus-icon');

                    img.src = e.target.result;
                    img.style.display = 'block'; // إظهار الصورة
                    icon.style.display = 'none'; // إخفاء علامة الزائد لكي لا تشوه الصورة
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection
