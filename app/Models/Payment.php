<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Account;

class Payment extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

//    - Amount
//    - Timestamp
//    - TokenNumber
//    - Other payment-related attributes

    protected $fillable = [
        'amount',
        'transaction_time',
        'transaction_id',
        'account_number',
        'phone_number',
        'name',
        'meta',
        'msg',
        'token_value',
        'balance',
        'units'
    ];

    protected $casts = [
        'meta' => 'array',
    ];

    public function account():BelongsTo
    {
        return $this->belongsTo(Account::class,'account_number');
    }
}
