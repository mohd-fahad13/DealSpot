<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    protected $fillable = [
        'owner_id',
        'business_name',
        'email',
        'phone',
        'description',
        'logo_url',
        'category_id',
        'is_verified',
    ];

    public function owner()
    {
        return $this->belongsTo(BusinessOwner::class, 'owner_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function discounts()
    {
        return $this->hasMany(Discount::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function locations()
    {
        return $this->belongsToMany(BusinessLocation::class, 'business_locations');
    }
}
