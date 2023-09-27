<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;
    protected $fillable = [
        'service_type',
        'start_date',
        'end_date',
        'service_location',
        'description',
        'pickup_service',
        'user_id',
    ];
    public function pets()
    {
        return $this->belongsToMany(Pet::class, 'pet_for_job', 'job_id', 'pet_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

