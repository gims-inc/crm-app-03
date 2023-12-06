<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'national_id',
        'first_name',
        'last_name',
        'other_name',
        'address',
        'primary_phone_number',
        'Secondary_phone_number',
        'first_contact_name',
        'first_contact_number',
        'second_contact_name',
        'second_contact_number',
        'email',
        'longitude',
        'latitude',
        'town',
        'village',
        'staff_id',
        'id_image'
    ];

    // protected $hidden = [
    //     'national_id',
    // ];

    protected $casts = [
        // 'phone_number' => 'array',
        // 'first_contact' => 'array', 
        // 'second_contact' => 'array',
    ];

    public function customerNote(): HasMany
    {
        return $this->hasMany(CustomerNote::class);
    }

    public function flagRln(): HasMany
    {
        return $this->hasMany(CustomerFlag::class);
    }
    
    // Delete acountNumber fk()
    
    public function account(): HasMany
    {
        return $this->hasMany(Account::class);
    }

    public static function getCustomerById($customerId)
    {
        return self::select(
            'id',
            'national_id',
            'first_name',
            'last_name',
            'other_name',
            'address',
            'primary_phone_number',
            'primary_phone_number',
            'first_contact_name',
            'first_contact_number',
            'second_contact_name',
            'second_contact_number',
            'email',
            'longitude',
            'latitude',
            'town',
            'village',
            'staff_id',
            'id_image'
        )->where('id', $customerId)->first();
    }
}


