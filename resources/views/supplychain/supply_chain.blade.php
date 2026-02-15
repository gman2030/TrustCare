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
                            <th style="width: 50%;">Product Details</th>
                            <th style="width: 30%;">Serial Number</th>
                            <th style="width:15%; ">Edit</th>
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
                                            <a href="{{ route('supply.show', $product->id) }}"
                                                class="text-decoration-none fw-bold text-dark">
                                                {{ $product->name }}
                                            </a>

                                        </div>
                                    </div>
                                </td>
                                <td><code class="serial-tag">{{ $product->serial_number }}</code></td>
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

        </div>
        <style>
            /* Table Styling */
            .table-card {
                background: #fff;
                border-radius: 24px;
                overflow: hidden;

            }

            .custom-table {
                width: 100% !important;
                /* يجبر الجدول على ملء كامل عرض المربع الأبيض */
                margin: 0;
                /* يزيل أي هوامش تلقائية */
                table-layout: fixed;
                /* يوزع الأعمدة بانتظام بناءً على النسب التي وضعتها */
            }

            .custom-table thead th {
                background-color: #f8f9fc;
                padding: 20px;
                font-size: 11px;
                font-weight: 800;
                color: #8e9aaf;
                text-transform: uppercase;
                border: none;
                text-align: left;
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
                background-color: #1b2d95;
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

            a {
                color: #1b2d95;

                text-decoration: none;

                font-weight: bold;

                transition: 0.3s;
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
