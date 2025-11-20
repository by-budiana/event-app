<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
    protected $fillable = [
        'name_venue',
        'deskripsi_venue',
        'alamat_venue',
        'image_venue',
        'kapasitas',
    ];

    public function events()
    {
        return $this->hasMany(Event::class);
    }
}
