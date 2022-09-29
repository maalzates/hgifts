<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Campaign;

class Item extends Model
{
    use HasFactory;

    public function campaigns(){
        return $this->belongsToMany(Campaign::class);
    }
    
}
