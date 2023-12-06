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
use App\Models\Account;

class Product extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
    'product_name',
    'serial_number', //(unique)
    'batch_number',
    // 'package_id',  //(fk)
    'staff_id',
    'where_at'    //['field','production', 'repairs', 'decomissioned']
    ];

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class,'staff_id');
    }

    public function account():HasOne
    {
        return $this->hasOne(Account::class);
    }

    public function productHistoryRln():HasMany
    {
        return $this->hasMany(ProductHistory::class);
    }

    public static function getProductById($productId)
    {
        return self::select('product_name', 'serial_number', 'where_at')->where('id', $productId)->first();
    }

}
