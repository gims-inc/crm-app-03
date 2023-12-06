<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;


class Package extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'package_name',
        'description',
        'daily_payment',
        'total_amount',
        'staff_id'
    ];
    
    public function user():BelongsTo
    {
        return  $this->belongsTo(User::class,'staff_id');
    }

    // public function packageRln():HasMany
    // {
    //     return $this->hasMany(User::class);
    // }
}
