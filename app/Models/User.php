<?php

namespace App\Models;
use App\Models\service;
use App\Models\pet;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'username', 'name', 'email', 'profilepicture','contactnumber'];
    protected $primaryKey = 'id'; // Specifying 'id' as the primary key
    public $incrementing = false; // Disabling auto-incrementing for the primary key
    protected $keyType = 'string';
    
    public function vendor()
    {
        return $this->hasOne(Vendor::class);
    }
    public function services()
    {
        return $this->hasMany(Service::class, 'userid');
    }

    public function pets()
    {
        return $this->hasMany(Pet::class, 'petowner');
    }

    // Add relationship for pet posts created by the user
    public function petPosts()
    {
        return $this->hasMany(PetPost::class, 'userid');
    }

    // Add relationship for service requests made by the user
    // public function serviceRequests()
    // {
    //     return $this->hasMany(Request::class, 'userid');
    // }
}
