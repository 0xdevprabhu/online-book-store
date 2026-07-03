<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * mass assignable ஆக இருக்க வேண்டிய காலம்கள்.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * சீரியலைஸ் செய்யும் போது மறைக்கப்பட வேண்டியவை.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * டேட்டா வகைகளை மாற்றுதல் (Casting).
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed', // லாராவெல் 10+ பாஸ்வேர்டை ஆட்டோமேட்டிக்காக ஹாஷ் செய்யும்
    ];
}