<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

use Illuminate\Database\Eloquent\SoftDeletes;

class UserType extends Model
{
    use HasFactory,HasUuids, SoftDeletes;

    protected $fillable = [
        'usertypename'
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}