@extends('layouts.Supplychain-master')

@section('content')
    <div class="container py-5 animate-fade-in">
        <div class="header-mono mb-5 text-center pb-3">
            <h2 class="fw-bold text-dark m-0">ASSET_PRODUCT_PROFILE</h2>
            <small class="text-muted text-uppercase fw-bold" style="letter-spacing: 2px;">Centralized Specification
                View</small>
        </div>

        <div class="row justify-content-center mb-5">
            <div class="col-lg-6">
                <div class="mono-card shadow-sm p-4 text-center border">
                    <div class="avatar-preview mx-auto mb-4" style="width: 280px; height: 280px;">
                        <img src="{{ asset('uploads/products/' . $product->image) }}"
                            class="img-fluid rounded-4 shadow-sm border">
                    </div>

                    <h3 class="fw-bold text-dark mb-1">{{ $product->name }}</h3>
                    <div class="mono-field mb-4">
                        <span class="badge bg-light text-dark border px-3 py-2 rounded-pill">
                            SERIAL_NUMBER: {{ $product->serial_number }}
                        </span>
                    </div>

                    <div class="d-flex justify-content-center gap-3 pt-3 border-top">
                        <div class="text-center">
                            <small class="text-muted d-block uppercase fw-bold" style="font-size: 10px;">Total Stock</small>
                            <span class="fs-5 fw-bold text-primary">{{ $product->quantity }} Units</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="mono-card shadow-sm p-4 p-xl-5 border">
                    <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
                        <h5 class="fw-bold text-dark m-0">ASSOCIATED_COMPONENTS</h5>
                        <span class="badge rounded-pill bg-dark text-white px-3">{{ $product->spareParts->count() }}
                            ITEMS</span>
                    </div>
                    <div class="table-responsive">
                        <table class="table custom-show-table align-middle">
                            <thead>
                                <tr>
                                    <th style="width: 10%;">Spare Part</th>
                                    <th style="width: 30%;">Name</th>
                                    <th class="text-center" style="width: 15%;">Quantity</th>
                                    <th class="text-center" style="width: 25%;">the condition</th>
                                    <th class="text-center" style="width: 20%;">unit price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($product->spareParts as $part)
                                    <tr>
                                        <td>
                                            <div class="part-thumb-table">
                                                <img src="{{ $part->image ? asset('uploads/parts/' . $part->image) : asset('assets/no-image.png') }}"
                                                    class="rounded border shadow-sm">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="fw-bold text-dark fs-6">{{ $part->name }}</div>
                                        </td>
                                        <td class="text-center">
                                            <span class="qty-badge-simple">{{ $part->quantity }} pcs</span>
                                        </td>
                                        <td class="text-center">
                                            {{-- منطق تغيير الحالة بناءً على الكمية --}}
                                            @if ($part->quantity >= 7)
                                                <span class="badge-status status-available">
                                                    <i class="fas fa-check-circle me-1"></i> Available
                                                </span>
                                            @elseif($part->quantity <= 6 && $part->quantity > 0)
                                                <span class="badge-status status-limited">
                                                    <i class="fas fa-exclamation-triangle me-1"></i> Limited
                                                </span>
                                            @elseif ($part->quantity == 0)
                                                <span class="badge-status status-unavailable">
                                                    <i class="fas fa-times-circle me-1"></i> Unavailable
                                                </span>

                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <span
                                                class="fw-bold text-success fs-6">${{ number_format($part->price, 2) }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5">
                                            <i class="fas fa-box-open fa-3x opacity-25 mb-3 d-block"></i>
                                            <p class="text-muted fw-bold">No components linked to this asset yet.</p>
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

    <style>
        body {
            background-color: #fbfbfb;
        }

        .mono-card {
            background: #ffffff;
            border-radius: 20px;
            transition: 0.3s;
        }

        /* Image Styling */
        .avatar-preview img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            background: #fff;
        }

        /* Table Specific Styling */
        .custom-show-table thead th {
            background-color: #f8fafc;
            color: #64748b;
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            padding: 15px;
            border-top: none;
            border-bottom: 2px solid #edf2f7;
        }

        .custom-show-table tbody td {
            padding: 16px 15px;
            border-bottom: 1px solid #f1f5f9;
        }

        .part-thumb-table img {
            width: 60px;
            height: 60px;
            object-fit: contain;
            background: #fff;
            padding: 4px;
        }

        .qty-badge-simple {
            background: #f1f5f9;
            color: #1e293b;
            padding: 6px 14px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 13px;
        }

        /* Animations */
        .animate-fade-in {
            animation: fadeIn 0.6s ease-out;
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

        .header-mono {
            border-bottom: 2px solid #eee;
        }

        .uppercase {
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* تنسيق شارات الحالة (Status Badges) */
        .badge-status {
            padding: 6px 12px;
            border-radius: 50px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            display: inline-flex;
            align-items: center;
        }

        /* حالة متوفر - أخضر */
        .status-available {
            background-color: #ecfdf5;
            color: #059669;
            border: 1px solid #10b981;
        }

        /* حالة محدود - برتقالي */
        .status-limited {
            background-color: #fffbeb;
            color: #d97706;
            border: 1px solid #f59e0b;
        }

        /* حالة غير متوفر - أحمر */
        .status-unavailable {
            background-color: #fef2f2;
            color: #dc2626;
            border: 1px solid #ef4444;
        }
    </style>
@endsection
