<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', // Add any other fields you want to allow for mass assignment here
        'introduction',
        'experience',
        'your_enjoy',
        'skills',
        'special_skill',
        'emid',
        'front_picture_url',
        'back_picture_url',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
