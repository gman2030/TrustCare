@extends('layouts.Supplychain-master')

@section('page-title', 'Inventory Requests')

@section('content')

<style>
    /* ===== PAGE HEADER ===== */
    .page-header {
        margin-bottom: 28px;
    }

    .page-header h2 {
        color: #1b2d95;
        font-size: 26px;
        font-weight: 700;
        margin: 0 0 4px;
    }

    .page-header p {
        color: #64748b;
        font-size: 14px;
        margin: 0;
    }

    /* ===== ORDER CARD ===== */
    .order-card {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        margin-bottom: 24px;
        overflow: hidden;
        border: 1px solid #e2e8f0;
        transition: box-shadow 0.2s ease;
    }

    .order-card:hover {
        box-shadow: 0 8px 28px rgba(0, 0, 0, 0.09);
    }

    /* Card Top */
    .card-top {
        background: #f8fafc;
        padding: 14px 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #e2e8f0;
    }

    .worker-badge {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        background: #1b2d95;
        color: white;
        padding: 6px 14px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
    }

    .time-label {
        display: flex;
        align-items: center;
        gap: 6px;
        color: #94a3b8;
        font-size: 13px;
    }

    /* Machine Info */
    .machine-info {
        padding: 14px 24px;
        color: #1e293b;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 8px;
        border-bottom: 1px solid #f1f5f9;
    }

    .machine-info strong {
        color: #1b2d95;
    }

    .machine-info .sn {
        color: #94a3b8;
        font-size: 13px;
        margin-left: 6px;
    }

    /* Parts Grid */
    .parts-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
        gap: 12px;
        padding: 20px 24px;
    }

    .part-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px;
        background: #f8fafc;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        transition: border-color 0.2s;
    }

    .part-item:hover {
        border-color: #1b2d95;
    }

    .part-img {
        width: 48px;
        height: 48px;
        border-radius: 8px;
        object-fit: cover;
        border: 1px solid #e2e8f0;
        flex-shrink: 0;
    }

    .part-info .part-name {
        font-size: 14px;
        font-weight: 600;
        color: #1e293b;
    }

    .part-info .part-id {
        font-size: 11px;
        color: #94a3b8;
        margin-top: 2px;
    }

    .qty-indicator {
        margin-left: auto;
        font-weight: 800;
        color: #1b2d95;
        background: #eff6ff;
        padding: 4px 10px;
        border-radius: 8px;
        font-size: 13px;
        border: 1px solid #bfdbfe;
        flex-shrink: 0;
    }

    /* Action Bar */
    .action-bar {
        padding: 14px 24px;
        background: #fdfdfd;
        border-top: 1px solid #f1f5f9;
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 10px;
    }

    .btn-prepare {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #1b2d95;
        color: white;
        border: none;
        padding: 10px 22px;
        border-radius: 10px;
        cursor: pointer;
        font-weight: 700;
        font-size: 14px;
        transition: all 0.25s ease;
    }

    .btn-prepare:hover {
        background: #142170;
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(27, 45, 149, 0.3);
        color: white;
    }

    .badge-prepared {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        background: #dcfce7;
        color: #166534;
        font-size: 13px;
        font-weight: 700;
        padding: 8px 16px;
        border-radius: 10px;
        border: 1px solid #bbf7d0;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 80px 40px;
        background: white;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 20px rgba(0,0,0,0.04);
    }

    .empty-state i {
        font-size: 52px;
        color: #e2e8f0;
        margin-bottom: 18px;
        display: block;
    }

    .empty-state h3 {
        color: #94a3b8;
        font-size: 20px;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .empty-state p {
        color: #cbd5e1;
        font-size: 14px;
        margin: 0;
    }
</style>

<div class="page-header">
    <h2><i class="fas fa-boxes" style="margin-right: 10px;"></i> Inventory Requests</h2>
    <p>Pending parts collection and preparation</p>
</div>

@forelse($orders as $order)
    <div class="order-card">

        {{-- Top --}}
        <div class="card-top">
            <span class="worker-badge">
                <i class="fas fa-user-tag"></i>
                {{ $order->worker->name }}
            </span>
            <span class="time-label">
                <i class="far fa-clock"></i>
                {{ $order->created_at->format('M d, H:i A') }}
            </span>
        </div>

        {{-- Machine --}}
        <div class="machine-info">
            <i class="fas fa-microchip" style="color: #f59e0b;"></i>
            Target Machine: <strong>{{ $order->product->name }}</strong>
            <span class="sn">(S/N: {{ $order->product->serial_number }})</span>
        </div>

        {{-- Parts --}}
        <div class="parts-grid">
            @php $items = is_array($order->items) ? $order->items : json_decode($order->items); @endphp
            @foreach ($items as $item)
                <div class="part-item">
                    <img src="{{ asset('uploads/parts/' . ($item->image ?? $item['image'])) }}" class="part-img">
                    <div class="part-info">
                        <div class="part-name">{{ $item->name ?? $item['name'] }}</div>
                        <div class="part-id">ID: {{ $item->id ?? $item['id'] }}</div>
                    </div>
                    <div class="qty-indicator">x{{ $item->quantity ?? $item['quantity'] }}</div>
                </div>
            @endforeach
        </div>

        {{-- Action --}}
        <div class="action-bar">
            @if ($order->status == 'accepted')
                <form action="{{ route('supply.prepare', $order->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-prepare">
                        <i class="fas fa-check-circle"></i>
                        Mark as Prepared
                    </button>
                </form>
            @elseif($order->status == 'prepared')
                <span class="badge-prepared">
                    <i class="fas fa-box-open"></i>
                    Ready for Pickup — Voucher Active
                </span>
            @endif
        </div>

    </div>
@empty
    <div class="empty-state">
        <i class="fas fa-box-open"></i>
        <h3>Warehouse is clear!</h3>
        <p>No pending requests from the Admin.</p>
    </div>
@endforelse

@endsection
