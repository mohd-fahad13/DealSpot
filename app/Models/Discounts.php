<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Discounts extends Model
{
    protected $table = 'discounts';

    protected $fillable = [
        'business_id',
        'location_ids',
        'title',
        'description',
        'discount_value',
        'discount_type',
        'terms',
        'start_date',
        'end_date',
        'min_purchase',
        'promo_code',
        'image_url',
        'status',
    ];

    protected $casts = [
        'location_ids' => 'array',
    ];

    public function business()
    {
        return $this->belongsTo(Businesses::class);
    }
    public function businesslocation()
    {
        return $this->belongsTo(BusinessLocation::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'discount_categories');
    }

    // In app/Models/Discount.php
public function validLocations()
{
    return $this->belongsToMany(
        BusinessLocation::class, 
        'mapping_business_discount_location', // Your mapping table
        'discount_id', 
        'location_id'
    );
}
}

