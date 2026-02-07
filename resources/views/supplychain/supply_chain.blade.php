@extends('layouts.Supplychain-master')

@section('content')
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4 p-2 animate-fade-in">
            <div>
                <h3 class="fw-bold text-dark m-0">Inventory Management</h3>
                <p class="text-muted small">Monitor and manage your products and components</p>
            </div>
        </div>
        <br>
        <div class="table-card shadow-sm border-0 animate-slide-up">
            <div class="table-responsive">
                <table class="table custom-table align-middle m-0">
                    <thead>
                        <tr>
                            <th style="width: 35%;">Product Details</th>
                            <th style="width: 20%;">Serial Number</th>
                            <th style="width: 15%;">Availability</th>
                            <th style="width: 15%; text-align: center;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr class="product-row">
                                <td>
                                    <div class="d-flex align-items-center cursor-pointer group-hover"
                                        onclick="openPartsModal('{{ $product->id }}', '{{ $product->name }}')">
                                        <div class="product-img-box me-3 shadow-sm">
                                            <img src="{{ $product->image ? asset('uploads/products/' . $product->image) : asset('assets/no-image.png') }}"
                                                alt="">
                                        </div>
                                        <div class="product-info">
                                            <h6 class="fw-bold mb-0 text-dark product-title-link">{{ $product->name }}</h6>
                                            <small class="text-muted"><i class="fas fa-microchip me-1"></i>View spare
                                                parts</small>
                                        </div>
                                    </div>
                                </td>
                                <td><code class="serial-tag">{{ $product->serial_number }}</code></td>
                                <td><span class="qty-badge">{{ $product->quantity ?? 0 }}</span></td>
                                <td>
                                    <span
                                        class="status-pill {{ ($product->quantity ?? 0) > 0 ? 'status-in-stock' : 'status-out-stock' }}">
                                        <i
                                            class="fas {{ ($product->quantity ?? 0) > 0 ? 'fa-check-circle' : 'fa-exclamation-triangle' }} me-1"></i>
                                        {{ ($product->quantity ?? 0) > 0 ? 'In Stock' : 'Out of Stock' }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('supply.edit', $product->id) }}" class="btn-action-edit"
                                        title="Edit Product">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="editModal" class="custom-modal">
        <div class="modal-content-premium animate-zoom-in">
            <div class="modal-header-clean">
                <h4 class="fw-bold m-0 text-dark"><i class="fas fa-edit me-2 text-primary"></i>Edit Information</h4>
                <span class="close-modal" onclick="closeEditModal()">&times;</span>
            </div>
            <form id="editForm" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="row">
                    <div class="col-md-5 text-center border-end">
                        <label for="editImageInput" class="edit-img-container mb-3 hover-glow">
                            <img id="editImagePreview" src="" class="img-fluid rounded-4">
                            <div class="edit-overlay"><i class="fas fa-camera mb-1"></i><br>Change Photo</div>
                            <input type="file" name="image" id="editImageInput" hidden accept="image/*"
                                onchange="previewEditImage(this)">
                        </label>
                        <div class="px-3 text-start">
                            <label class="small fw-bold text-muted mb-1 text-uppercase">Product Name</label>
                            <input type="text" name="name" id="editName" class="modern-input-small mb-3"
                                placeholder="Enter name">
                            <label class="small fw-bold text-muted mb-1 text-uppercase">Serial Number</label>
                            <input type="text" name="serial_number" id="editSerial" class="modern-input-small"
                                placeholder="Enter S/N">
                        </div>
                    </div>
                    <div class="col-md-7 ps-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="fw-bold m-0">Spare Parts List</h6>
                            <button type="button" class="btn btn-sm btn-dark rounded-pill px-3"
                                onclick="addSparePartRow()">
                                <i class="fas fa-plus me-1"></i> Add Part
                            </button>
                        </div>
                        <div id="sparePartsContainer" class="custom-scrollbar"
                            style="max-height: 300px; overflow-y: auto; padding-right: 5px;">
                        </div>
                    </div>
                </div>
                <div class="text-end mt-4 border-top pt-3">
                    <button type="button" class="btn btn-light rounded-pill px-4 me-2"
                        onclick="closeEditModal()">Cancel</button>
                    <button type="submit" class="btn btn-dark rounded-pill px-5 shadow">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <div id="partsModal" class="custom-modal">
        <div class="modal-content-premium animate-slide-down" style="max-width: 600px;">
            <div class="modal-header-clean">
                <div>
                    <h4 class="fw-bold m-0" id="partsModalTitle">Product Parts</h4>
                    <p class="text-muted small m-0">Quick inventory adjustment</p>
                </div>
                <span class="close-modal" onclick="closePartsModal()">&times;</span>
            </div>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr class="text-muted small">
                            <th>Part</th>
                            <th>Name</th>
                            <th class="text-center">Stock Adjustment</th>
                        </tr>
                    </thead>
                    <tbody id="partsTableBody">
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <style>
        /* Table Styling */
        .table-card {
            background: #fff;
            border-radius: 24px;
            overflow: hidden;
        }

        .custom-table thead th {
            background-color: #f8f9fc;
            padding: 20px;
            font-size: 11px;
            font-weight: 800;
            color: #8e9aaf;
            text-transform: uppercase;
            border: none;
        }

        .product-row {
            transition: all 0.2s;
            border-bottom: 1px solid #f1f4f8;
        }

        .product-row:hover {
            background-color: #f8fafd;
        }

        .product-row td {
            padding: 16px 20px;
            border: none;
        }

        /* Product UI Elements */
        .product-img-box {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            overflow: hidden;
            background: #eee;
        }

        .product-img-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .product-title-link {
            transition: 0.2s;
            color: #1e293b;
        }

        .product-row:hover .product-title-link {
            color: #3b82f6;
        }

        .serial-tag {
            background: #f1f5f9;
            color: #475569;
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 13px;
        }

        .qty-badge {
            background: #e2e8f0;
            color: #1e293b;
            padding: 6px 14px;
            border-radius: 10px;
            font-weight: 800;
        }

        /* Status Pills */
        .status-pill {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
        }

        .status-in-stock {
            background: #dcfce7;
            color: #15803d;
        }

        .status-out-stock {
            background: #fee2e2;
            color: #b91c1c;
        }

        /* --- NEW PENCIL BUTTON STYLE --- */
        .btn-action-edit {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            border: none;
            background-color: #f1f5f9;
            color: #64748b;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn-action-edit:hover {
            background-color: #000;
            color: #fff;
            transform: translateY(-3px) rotate(-12deg);
            box-shadow: 0 5px 12px rgba(0, 0, 0, 0.15);
        }

        /* Modal & Inputs */
        .custom-modal {
            display: none;
            position: fixed;
            z-index: 1050;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(8px);
        }

        .modal-content-premium {
            background: #fff;
            margin: 3% auto;
            padding: 30px;
            border-radius: 28px;
            width: 90%;
            max-width: 850px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        .edit-img-container {
            width: 160px;
            height: 160px;
            position: relative;
            cursor: pointer;
            border-radius: 22px;
            overflow: hidden;
            display: inline-block;
            border: 2px dashed #e2e8f0;
        }

        .edit-overlay {
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            color: #fff;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: 0.3s;
            font-size: 12px;
        }

        .edit-img-container:hover .edit-overlay {
            opacity: 1;
        }

        .modern-input-small {
            width: 100%;
            padding: 12px 16px;
            background: #f8fafc;
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            transition: 0.3s;
            font-size: 14px;
        }

        .modern-input-small:focus {
            border-color: #000;
            background: #fff;
            outline: none;
        }

        /* Quantity Control */
        .qty-control {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            background: #f1f5f9;
            padding: 4px;
            border-radius: 12px;
            width: fit-content;
            margin: auto;
        }

        .btn-qty {
            border: none;
            background: #fff;
            width: 28px;
            height: 28px;
            border-radius: 8px;
            font-weight: bold;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            transition: 0.2s;
        }

        .btn-qty:hover {
            background: #000;
            color: #fff;
        }

        /* Animations */
        .animate-zoom-in {
            animation: zoomIn 0.3s ease;
        }

        .animate-slide-up {
            animation: slideUp 0.5s ease;
        }

        @keyframes zoomIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

    <script>
        function openEditModal(id, name, serial, imgSrc) {
            document.getElementById('editForm').action = `/supply-chain/update/${id}`;
            document.getElementById('editName').value = name;
            document.getElementById('editSerial').value = serial;
            document.getElementById('editImagePreview').src = imgSrc;
            document.getElementById('editModal').style.display = "block";
        }

        function closeEditModal() {
            document.getElementById('editModal').style.display = "none";
        }

        function openPartsModal(productId, productName) {
            document.getElementById('partsModalTitle').innerText = productName;
            const tableBody = document.getElementById('partsTableBody');

            // Example dynamic content (To be replaced with real AJAX)
            tableBody.innerHTML = `
            <tr>
                <td><img src="https://cdn-icons-png.flaticon.com/512/702/702455.png" width="40"></td>
                <td class="fw-bold">Air Filter</td>
                <td>
                    <div class="qty-control">
                        <button type="button" class="btn-qty" onclick="updateQty(this, -1)">-</button>
                        <span class="px-2">12</span>
                        <button type="button" class="btn-qty" onclick="updateQty(this, 1)">+</button>
                    </div>
                </td>
            </tr>
        `;
            document.getElementById('partsModal').style.display = "block";
        }

        function closePartsModal() {
            document.getElementById('partsModal').style.display = "none";
        }

        function updateQty(btn, change) {
            const span = btn.parentElement.querySelector('span');
            let current = parseInt(span.innerText);
            if (current + change >= 0) span.innerText = current + change;
        }

        function previewEditImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = e => document.getElementById('editImagePreview').src = e.target.result;
                reader.readAsDataURL(input.files[0]);
            }
        }

        function addSparePartRow() {
            const container = document.getElementById('sparePartsContainer');
            const row = `
            <div class="d-flex gap-2 mb-2 animate-zoom-in align-items-center bg-light p-2 rounded-3">
                <input type="text" class="modern-input-small py-1" placeholder="Part Name" style="flex:2">
                <input type="file" class="form-control form-control-sm" style="flex:1">
                <button type="button" class="btn btn-sm text-danger" onclick="this.parentElement.remove()"><i class="fas fa-trash"></i></button>
            </div>`;
            container.insertAdjacentHTML('beforeend', row);
        }

        window.onclick = e => {
            if (e.target.className === 'custom-modal') {
                closeEditModal();
                closePartsModal();
            }
        }
    </script>
@endsection
