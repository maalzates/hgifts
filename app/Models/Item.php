<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Campaign;

class Item extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'unit_price', 'units_owned'];

    public function campaigns(){
        return $this->belongsToMany(Campaign::class);
    }
    
}
