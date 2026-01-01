<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'icon_url'
    ];

    public function businesses()
    {
        return $this->hasMany(Business::class);
    }

    public function discountCategories()
    {
        return $this->hasMany(DiscountCategory::class);
    }
}
