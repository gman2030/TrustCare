<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SparePartOrder extends Model
{
    protected $fillable = ['worker_id', 'product_id', 'items', 'status'];

    // ربط الطلب بالعامل
    public function worker()
    {
        return $this->belongsTo(User::class, 'worker_id');
    }

    // ربط الطلب بالمنتج (الآلة)
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    protected $casts = [
        'items' => 'array',
    ];
}
