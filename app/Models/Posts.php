<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    use HasFactory;

    protected $guarded = [];

//    protected $fillable = [
//        'title',
//        'image',
//        'description',
//        'amount',
//    ];


    protected $table = 'posts';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function document()
    {
        return $this->hasMany(document::class)->orderBy('created_at','DESC');
    }

    public function images()
    {
        return $this->hasMany(Images::class)->orderBy('created_at','DESC');
    }
}
