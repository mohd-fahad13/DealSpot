<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'business_id',
        'customer_name',
        'rating',
        'message',
    ];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }
}

