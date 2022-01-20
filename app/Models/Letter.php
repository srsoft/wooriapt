<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Letter extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function favorite()
    {
//        return $this->belongsTo(Favorite::class, 'id', 'letter_id')->where('user_id','1');
        return $this->belongsTo(Favorite::class, 'id', 'letter_id');
    }

    public function prev()
    {
        //return $this->select('*');
    }
}
