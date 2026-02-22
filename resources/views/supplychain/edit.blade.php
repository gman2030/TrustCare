@extends('layouts.Supplychain-master')
<link rel="stylesheet" href="{{ asset('css/edit.css') }}">
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
                    {{-- القسم الأيسر: معلومات المنتج الأساسية --}}
                    <div class="col-lg-5">
                        <div class="mono-card shadow-sm border-0">
                            <div class="card-body p-4 p-xl-5">
                                <h5 class="fw-bold text-dark mb-4 text-center">General Information</h5>

                                <form action="{{ route('supply.update', $product->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

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
                                        <button type="submit" class="btn-mono-light px-5">Save Changes</button>
                                        <button type="button" class="btn-mono-light px-5"
                                            onclick="toggleSpareParts()">Manage Spare Parts</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- القسم الأيمن: إدارة قطع الغيار --}}
                    <div class="col-lg-7" id="sparePartsSection" style="display: none;">
                        <div class="mono-card shadow-sm border-0 h-100 animate-fade-in">
                            <div class="card-body p-4 p-xl-5">
                                <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
                                    <h2 class="fw-bold text-dark m-0">
                                        <i class="fas fa-tools me-2 opacity-50"></i>Spare Parts
                                    </h2>
                                </div>

                                {{-- 1. فورم إضافة قطعة غيار جديدة --}}
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
                                                    style="width: 110px; height: 110px; border: 2px dashed #3e04eb; cursor: pointer; display: flex; align-items: center; justify-content: center; position: relative; overflow: hidden; background: #f9f9f9;">
                                                    <img id="part-preview-img" src="#"
                                                        style="display:none; max-width: 100%; max-height: 100%; object-fit: contain;">
                                                    <span id="plus-icon" style="font-size: 2rem; color: #1a1af3;">+</span>
                                                </label>
                                            </div>
                                            <p class="text-muted small mt-2">Upload Part Image</p>
                                        </div>

                                        <div class="col-12">
                                            <div class="mono-field">
                                                <label class="form-label small fw-bold text-uppercase">Component
                                                    Name</label>
                                                <input type="text" name="part_name" placeholder="e.g. Engine Valve"
                                                    required>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mono-field">
                                                <label class="form-label small fw-bold text-uppercase">Quantity</label>
                                                <input type="number" name="quantity" value="0" min="0"
                                                    required>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mono-field">
                                                <label class="form-label small fw-bold text-uppercase">Price (Unit)</label>
                                                <input type="number" name="price" step="0.01" value="0.00"
                                                    min="0" required>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="col-12 text-center mt-4">
                                            <button type="submit" class="btn-mono-light w-100 py-3 shadow-sm">
                                                <i class="fas fa-plus-circle me-2"></i>ADD_TO_INVENTORY
                                            </button>
                                        </div>
                                    </div>
                                </form>
                                <br>
                                <div class="parts-list-mono border-top mt-5 pt-4">
                                    <h2 class="fw-bold mb-3 text-muted text-uppercase">Existing Components</h2>
                                    <br>
                                    <form action="{{ route('spare-parts.bulkUpdate') }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="table-responsive">
                                            <table class="table custom-show-table align-middle">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 15%;">Spare Part</th>
                                                        <th style="width: 15%;">Name</th>
                                                        <th class="text-center" style="width: 15%;">Quantity</th>
                                                        <th class="text-center" style="width: 15%;">Unit Price (DZ)</th>
                                                        <th class="text-center" style="width: 15%;">The Condition</th>
                                                        <th class="text-center">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($product->spareParts as $part)
                                                        <tr>
                                                            <td>
                                                                <div class="text-center">
                                                                    <img src="{{ $part->image ? asset('uploads/parts/' . $part->image) : asset('assets/no-image.png') }}"
                                                                        style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;"
                                                                        alt="Part Image">
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="fw-bold text-dark fs-6">{{ $part->name }}
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <input type="number"
                                                                    name="existing_parts[{{ $part->id }}][quantity]"
                                                                    value="{{ $part->quantity }}"
                                                                    class="form-control text-center shadow-sm mx-auto"
                                                                    style="width: 80px;">
                                                            </td>
                                                            <td>
                                                                <input type="number" step="0.01"
                                                                    name="existing_parts[{{ $part->id }}][price]"
                                                                    value="{{ $part->price }}"
                                                                    class="form-control text-center mx-auto"
                                                                    style="width: 100px;">
                                                            </td>
                                                            <td class="text-center">
                                                                @if ($part->quantity >= 7)
                                                                    <span
                                                                        class="badge-status text-success border border-success px-3 py-1 rounded-pill"
                                                                        style="font-size: 11px; background: #e8f5e9;"><i
                                                                            class="fas fa-check-circle me-1"></i>Available</span>
                                                                @elseif($part->quantity <= 6 && $part->quantity > 0)
                                                                    <span
                                                                        class="badge-status text-warning border border-warning px-3 py-1 rounded-pill"
                                                                        style="font-size: 11px; background: #fff8e1;"><i
                                                                            class="fas fa-exclamation-triangle me-1"></i>Limited</span>
                                                                @else
                                                                    <span
                                                                        class="badge-status text-danger border border-danger px-3 py-1 rounded-pill"
                                                                        style="font-size: 11px; background: #ffebee;"><i
                                                                            class="fas fa-times-circle me-1"></i>Unavailable</span>
                                                                @endif
                                                            </td>
                                                            <td class="text-end">
                                                                <button type="button" class="btn text-danger"
                                                                    onclick="deletePart({{ $part->id }})">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="6" class="text-center py-5">
                                                                <i
                                                                    class="fas fa-box-open fa-3x opacity-25 mb-3 d-block text-muted"></i>
                                                                <p class="text-muted fw-bold">No components linked yet.</p>
                                                            </td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                            <br>
                                            <br>
                                        </div>
                                        @if ($product->spareParts->count() > 0)
                                            <button type="submit" class="btn-mono-light w-100 mt-4">Update Inventory
                                                Only</button>
                                        @endif
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <form id="global-delete-form" method="POST" style="display:none;">
        @csrf
        @method('DELETE')
    </form>
    <script>
        /* الـ Java Script الخاص بك كما هو دون أي تغيير */
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
                    const img = document.getElementById('part-preview-img');
                    const icon = document.getElementById('plus-icon');
                    img.src = e.target.result;
                    img.style.display = 'block';
                    icon.style.display = 'none';
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function deletePart(id) {
            if (confirm('Are you sure?')) {
                let form = document.getElementById('global-delete-form');
                form.action = '/spare-parts/' + id; // المسار التقليدي للحذف
                form.submit();
            }
        }
    </script>
@endsection
