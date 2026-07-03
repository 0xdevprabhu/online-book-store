<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    /**
     * mass assignable மூலம் டேட்டாபேஸில் நேரடியாகச் சேமிக்க அனுமதிக்கப்படும் காலம்கள்.
     */
    protected $fillable = [
        'category_id',
        'title',
        'author',
        'description',
        'price',
        'is_available'
    ];

    /**
     * டேட்டா வகைகளை மாற்றுதல் (Casting).
     * புக் கையிருப்பில் உள்ளதா என்பதை boolean (true/false) ஆக மாற்றுகிறது.
     */
    protected $casts = [
        'is_available' => 'boolean',
        'price' => 'decimal:2'
    ];

    /**
     * ரிலேஷன்ஷிப்: இந்த புத்தகம் ஒரு குறிப்பிட்ட பிரிவைச் சேர்ந்தது (Belongs To).
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}