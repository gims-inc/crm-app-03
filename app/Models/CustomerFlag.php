<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class CustomerFlag extends Model
{
    use HasFactory, HasUuids;

    const OPTION_MAINTENANCE = 'maintenance';
    const OPTION_CUSTOMER_SERVICE = 'customerService';
    const OPTION_OTHERS = 'others';

    public function getCustomerFlag($value)
    {
        switch ($value) {
            case self::OPTION_MAINTENANCE:
                return 'Maintenance';
            case self::OPTION_CUSTOMER_SERVICE:
                return 'Customer Service';
            case self::OPTION_OTHERS:
                return 'Others';
            default:
                return 'Unknown';
        }
    }

    protected $fillable = [
        'flag',
        'customer_id',
        'userId' //staff
    ];

    public function customeFlagRln():BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

}

// $user = new User();
// $user->option = User::OPTION_MAINTENANCE;
// $user->save();

