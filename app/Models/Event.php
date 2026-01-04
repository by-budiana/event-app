<?php

namespace App\Models;

use App\Models\Category;
use App\Models\Venue;   
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'title',
        'description',
        'jadwal',
        'harga_tiket',
        'venue_id'
      
        
    ];

    public function venue()
    {
        return $this->belongsTo(Venue::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'event_category', 'event_id', 'category_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }


}
