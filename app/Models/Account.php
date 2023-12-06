<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\User;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Package;
use App\Models\Payment;

class Account extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'account_number',
        'customer_id',
        'package_id',
        'staff_id',
        'status', //pending,active,inactive,suspended,closed
        'product_id'
    ];

    // create customerId fk()

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'staff_id');
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class,'customer_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class,'product_id');
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class,'package_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class,'account_number');
    }
}
