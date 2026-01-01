<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Businesses extends Model
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
        'status',
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
        return $this->hasMany(Discount::class, 'business_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function locations()
    {
        return $this->hasMany(BusinessLocation::class, 'business_id');
    }

}
