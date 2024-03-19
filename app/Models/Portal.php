<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Portal extends Model
{

    public function listings()
    {
        return $this->belongsToMany(Listing::class);
    }
}
