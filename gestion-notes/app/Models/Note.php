<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'title', 'content', 'category_id', 'image_path'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}