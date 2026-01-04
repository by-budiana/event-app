<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Event;
use App\Models\Payment;

class Order extends Model
{
    protected $fillable = [
        'event_id',
        'tanggal_order',
        'total_harga',
        'status_pembayaran',
        'metode_pembayaran',
        'email_pemesan',
        'nomor_telepon'
    ];


    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function payments()
    {
        return $this->hasOne(Payment::class);
    }
}


