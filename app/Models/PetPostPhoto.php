<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PetPostPhoto extends Model
{
    protected $fillable = ['postid', 'photo_url'];
    // Add relationship to the pet post for the photo
    public function petPost()
    {
        return $this->belongsTo(PetPost::class,);
    }
}
