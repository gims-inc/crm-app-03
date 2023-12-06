<?php

namespace App\Models;


use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable 
{
    use HasApiTokens, HasFactory, SoftDeletes, Notifiable; // IsFilamentUser;

    protected $keyType = 'string';
    public $incrementing = false;
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
        'phonenumber',
        'usertypename'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'id' => 'string'
    ];


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = (string) Str::uuid();
        });
    }

    // public function canAccessPanel(Panel $panel): bool
    // {
    //     return str_ends_with($this->email, '@caino.africa') && $this->hasVerifiedEmail();
    // }

    public function userType(): BelongsTo
    {
        return $this->belongsTo(UserType::class);
    }

    public static function getUserById($userId)
    {
        return self::select('name', 'email', 'phonenumber','usertypename')->where('id', $userId)->first();
    }

    public static function isSupperUser($userId) // buggy
    {
        $is_super_user = self::select('is_superuser')->where('id', $userId)->first();

        return $is_super_user == true;
    }
}
