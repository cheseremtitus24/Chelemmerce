<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class document extends Model
{
    use HasFactory;
    protected $fillable = ['name'];
    protected $table = 'documents';
    public function posts()
    {
        return $this->belongsTo(Posts::class);
    }
}
