@extends('layouts.worker-master')

@section('page-title', 'Exit Voucher')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;900&display=swap" rel="stylesheet">

<style>
    .exit-pass {
        max-width: 500px;
        margin: 20px auto;
        background: white;
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        border-top: 10px solid #1b2d95;
        position: relative;
        overflow: hidden;
    }

    .pass-header {
        background: #f8fafc;
        padding: 30px;
        text-align: center;
        border-bottom: 2px dashed #e2e8f0;
    }

    .qr-placeholder {
        width: 120px;
        height: 120px;
        background: #fff;
        border: 1px solid #ddd;
        margin: 0 auto 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
    }

    .pass-body {
        padding: 30px;
        font-family: 'Cairo', sans-serif;
        direction: rtl;
    }

    .info-group {
        display: flex;
        justify-content: space-between;
        margin-bottom: 15px;
        border-bottom: 1px solid #f1f5f9;
        padding-bottom: 8px;
    }

    .info-group .label {
        color: #64748b;
        font-weight: 600;
    }

    .info-group .value {
        color: #1e293b;
        font-weight: 800;
    }

    .parts-box {
        background: #fff7ed;
        border: 1px solid #fed7aa;
        border-radius: 12px;
        padding: 15px;
        margin-top: 20px;
        font-family: 'Cairo', sans-serif;
        direction: rtl;
    }

    .parts-box h6 {
        color: #c2410c;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .parts-box ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .parts-box ul li {
        padding: 3px 0;
        color: #1e293b;
    }

    .btn-claim {
        background: #1b2d95;
        color: white;
        width: 100%;
        padding: 15px;
        border: none;
        font-weight: 700;
        font-size: 1.1rem;
        transition: 0.3s;
        font-family: 'Cairo', sans-serif;
        cursor: pointer;
    }

    .btn-claim:hover {
        background: #142170;
        transform: translateY(-1px);
    }

    /* طابع الموافقة */
    .approved-stamp {
        position: absolute;
        top: 85px;
        left: 20px;
        transform: rotate(-15deg);
        border: 3px solid #10b981;
        color: #10b981;
        padding: 5px 15px;
        font-weight: 900;
        border-radius: 8px;
        text-transform: uppercase;
        opacity: 0.8;
        font-family: 'Cairo', sans-serif;
        font-size: 14px;
        pointer-events: none;
    }

    .pass-note {
        text-align: center;
        color: #94a3b8;
        font-size: 13px;
        margin-top: 16px;
        font-family: 'Cairo', sans-serif;
    }

</style>

<div class="exit-pass">
    <div class="approved-stamp">تمت الموافقة</div>

    <div class="pass-header">
        <h4 style="font-weight: 700; margin-bottom: 4px; font-family: 'Cairo', sans-serif;">ظرف خروج قطع غيار</h4>
        <small style="color: #94a3b8;">رقم تسلسل الجهاز: #{{ $order->product->serial_number }}</small>
    </div>

    <div class="pass-body">
        <div class="info-group">
            <span class="label">اسم الفني:</span>
            <span class="value">{{ Auth::user()->name }}</span>
        </div>
        <div class="info-group">
            <span class="label">رقم الطلب:</span>
            <span class="value">Job #{{ $order->id }}</span>
        </div>
        <div class="info-group">
            <span class="label">تاريخ الإصدار:</span>
            <span class="value">{{ $order->updated_at->format('Y-m-d H:i') }}</span>
        </div>

        <div class="parts-box">
            <h6>القطع المصرح بها للجهاز ({{ $order->product->name }}):</h6>
            <ul style="list-style: none; padding: 0;">
                @php
                    $items = is_array($order->items) ? $order->items : json_decode($order->items);
                @endphp

                @foreach($items as $item)
                    <li style="display: flex; align-items: center; gap: 10px; margin-bottom: 8px; background: #f8fafc; padding: 5px; border-radius: 5px;">
                        <img src="{{ asset('uploads/parts/' . ($item->image ?? $item['image'])) }}"
                             style="width: 30px; height: 30px; object-fit: cover; border-radius: 4px;">

                        <span>• {{ $item->name ?? $item['name'] }}</span>
                        <span style="margin-right: auto; font-weight: bold; color: #1b2d95;">
                            x{{ $item->quantity ?? $item['quantity'] }}
                        </span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <form action="{{ route('worker.confirm.exit') }}" method="POST">
        @csrf
        <input type="hidden" name="order_id" value="{{ $order->id }}">

        <button type="submit" class="btn-claim" style="width: 100%; cursor: pointer;">
            تأكيد استلام القطع من المخزن
        </button>
    </form>
</div>
<p class="pass-note">* يرجى إظهار هذه الصفحة لمسؤول المخزن عند الاستلام.</p>

@endsection
