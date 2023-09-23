<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $fillable = [
        'type',
        'title',
        'listing_summary',
        'description',
        'price',
        'location',
        'country',
        'city',
        'zipcode',
        'street_number',
        'user_id',
        // Add other fields here...
    ];
    public function questions()
    {
        return $this->hasMany(ServiceQuestion::class);
    }

    public function images()
    {
        return $this->hasMany(ServiceImage::class);
    }
}
