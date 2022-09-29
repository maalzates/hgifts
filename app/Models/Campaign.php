<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Item;
use App\Models\User;

class Campaign extends Model
{
    use HasFactory;

    public function items() {
        return $this->belongsToMany(Item::class)->withPivot('count');
    }

    public function users() {
        return $this->belongsToMany(User::class);
    }
}
