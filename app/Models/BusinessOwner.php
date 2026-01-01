<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Casts\Attribute;


class BusinessOwner extends Authenticatable
// {
//     use Notifiable;

//     protected $fillable = [
//         'name',
//         'email',
//         'phone',
//         'password',
//     ];

//     protected $hidden = [
//         'password',
//         'remember_token',
//     ];

//     public function businesses()
//     {
//         return $this->hasMany(Business::class, 'owner_id');
//     }
// }
{
    use Notifiable;
    protected $table = 'business_owners';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Automatically hash password whenever set
     */
    // protected function casts(): array
    // {
    //     return [
    //         'password' => 'hashed',
    //     ]; 
    // }

    protected function password(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => bcrypt($value)
        );
    }

    public function businesses()
    {
        return $this->hasMany(Business::class, 'owner_id');
    }
}

