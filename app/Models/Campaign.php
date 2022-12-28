<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Item;
use App\Models\User;
use App\Models\Comment;

class Campaign extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'status', 'dispatch_date', 'delivery_date'];
    
    public function items() {
        return $this->belongsToMany(Item::class)->withTimestamps()->withPivot('count');
    }

    public function users() {
        return $this->belongsToMany(User::class)->withTimestamps()->withPivot('score');;
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }
}
