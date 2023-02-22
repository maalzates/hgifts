<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Campaign;
use App\Models\User;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = ['content', 'campaign_id', 'user_id'];

    public function campaign(){
        return $this->belongsTo(Campaign::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
    
}
