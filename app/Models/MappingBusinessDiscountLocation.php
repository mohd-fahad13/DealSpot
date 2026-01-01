<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MappingBusinessDiscountLocation extends Model
{
    protected $table = 'mapping_business_discount_location';

    protected $fillable = [
        'business_id',
        'discount_id',
        'location_id',
    ];

    public function business()
    {
        return $this->belongsTo(Businesses::class, 'business_id');
    }

    public function discount()
    {
        return $this->belongsTo(Discounts::class, 'discount_id');
    }

    public function location()
    {
        return $this->belongsTo(BusinessLocation::class, 'location_id');
    }
}
