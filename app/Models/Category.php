<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug'];

    /**
     * ரிலேஷன்ஷிப்: ஒரு பிரிவின் கீழ் பல புத்தகங்கள் இருக்கலாம் (One-to-Many).
     */
    public function books()
    {
        return $this->hasMany(Book::class);
    }
}