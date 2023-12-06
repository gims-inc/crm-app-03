<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class ProductHistory extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'product_id', //(Foreign Key to Product table)
        'staff_id', //(Foreign Key to User table)
        'history_desc' //(e.g., "Product added," "Product modified," etc.)
        ];

    public function productRln():BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
