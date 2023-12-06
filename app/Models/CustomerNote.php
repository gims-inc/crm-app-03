<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class CustomerNote extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'content',
        'customer_id',
        'userId'
    ];

    public function customeRln():BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

}
