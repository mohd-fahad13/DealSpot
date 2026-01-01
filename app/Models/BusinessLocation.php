<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessLocation extends Model
{
    protected $fillable = [
        'business_id',
        'branch_name',
        'phone',
        'email',
        'address',
        'country',
        'state',
        'city',
        'postal_code',
        'is_primary'
    ];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }
}
