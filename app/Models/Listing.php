<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'price', 'type', 'bedroom', 'bathroom'];

    public function portals()
    {
        return $this->belongsToMany(Portal::class);
    }
    public function bedroomData()
    {
        return $this->belongsTo(Bed::class, 'bedroom');
    }

    public function bathroomData()
    {
        return $this->belongsTo(Bath::class, 'bathroom');
    }
}
