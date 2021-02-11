<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $guarded = [];

    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function getCreatedAtAttribute($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('Y-m-d');
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function isLikePost($user_id)
    {
        $like = $this->likes->where('user_id', $user_id)->first();
        if($like){
            return $like->like ? true : false;
        }
        return false;
    }

    public function isDislikePost($user_id)
    {
        $like = $this->likes->where('user_id', $user_id)->first();
        if($like){
            return !$like->like ? true : false;
        }
        return false;
    }
}
