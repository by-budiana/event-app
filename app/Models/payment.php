<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Order;
class payment extends Model
{
    protected $fillable =[
        'order_id',
        'metode_pembayaran',
        'payment_reference',
        'status',
        'paid_at'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}


