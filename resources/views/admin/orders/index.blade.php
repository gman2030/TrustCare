@extends('layouts.admin-master')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@section('content')


    <div class="page-title-box">
        <h2><i class="fas fa-tray"></i> Incoming Requests</h2>
    </div>

    @forelse($orders as $order)
        <div class="order-ticket">
            <div class="ticket-header">
                <div class="worker-profile">
                    <div class="avatar-circle">
                        <i class="fas fa-user"></i>
                    </div>
                    <div>
                        <span class="worker-name">{{ $order->worker->name ?? 'Deleted User' }}</span>
                        <span class="time-stamp"><i class="far fa-clock"></i>
                            {{ $order->created_at->diffForHumans() }}</span>
                    </div>
                </div>
                <div class="ticket-id" style="color: var(--text-muted); font-size: 13px;">
                    Order #{{ $order->id }}
                </div>
            </div>

            <div class="machine-info">
                Machine Target: <span>{{ $order->product->name ?? 'Unknown' }}</span>
            </div>

            <div class="items-container">
                <table class="custom-grid-table">
                    <thead>
                        <tr>
                            <th>Part</th>
                            <th>Description</th>
                            <th style="text-align: center;">Required Qty</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $items = is_array($order->items) ? $order->items : json_decode($order->items); @endphp
                        @foreach ($items as $item)
                            <tr>
                                <td style="width: 70px;">
                                    <img src="{{ asset('uploads/parts/' . ($item->image ?? $item['image'])) }}"
                                        class="part-img">
                                </td>
                                <td>
                                    <div class="part-name-text">{{ $item->name ?? $item['name'] }}</div>
                                    <div style="font-size: 11px; color: #a0aec0;">ID: {{ $item->id ?? $item['id'] }}
                                    </div>
                                </td>
                                <td style="text-align: center;">
                                    <span class="qty-box">{{ $item->quantity ?? $item['quantity'] }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <form action="{{ route('admin.orders.accept', $order->id) }}" method="POST">
                @csrf
                <div class="action-bar">
                    <button class="btn-ready">
                        <i class="fas fa-dolly" style="margin-right: 8px;"></i> Mark as Prepared
                    </button>
                </div>
            </form>
        </div>
    @empty
        <div class="empty-state">
            <i class="fas fa-inbox" style="font-size: 50px; margin-bottom: 15px; display: block;"></i>
            <h3>No requests at the moment</h3>
            <p>New orders from workers will appear here.</p>
        </div>
    @endforelse
    @if (Auth::user()->unreadNotifications->count() > 0)
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            Swal.fire({
                title: 'New Requests!',
                text: 'You have {{ Auth::user()->unreadNotifications->count() }} new spare parts requests.',
                icon: 'info',
                confirmButtonText: 'Check Now',
                confirmButtonColor: '#1b2d95'
            });
        </script>
        {{-- مسح الإشعارات بعد رؤيتها --}}
        @php Auth::user()->unreadNotifications->markAsRead(); @endphp
    @endif
@endsection
