<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    protected $fillable = [
        'business_id',
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
        'view_count',
    ];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'discount_categories');
    }
}

