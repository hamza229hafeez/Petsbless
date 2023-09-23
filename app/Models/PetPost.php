<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class PetPost extends Model
{
    // Add relationship to the user who created the post
    protected $fillable = ['title', 'description', 'userid'];
    public function user()
    {
        return $this->belongsTo(User::class, 'userid');
    }
    public function postPhotos()
    {
        return $this->hasMany(PetPostPhoto::class, 'postid');
    }
}
