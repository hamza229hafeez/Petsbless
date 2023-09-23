<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    use HasFactory;
    protected $fillable = ['petowner', 'pettype', 'petbreed', 'petsize', 'petgender','dateofbirth'];
 
    public function owner()
    {
        return $this->belongsTo(User::class, 'petowner');
    }
    public function photos()
    {
        return $this->hasMany(PetPhoto::class, 'petid');
    }

    
}
