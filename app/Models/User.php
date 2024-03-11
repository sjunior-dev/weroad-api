<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    protected $table = 'users';
    public const CREATED_AT = 'createdAt';
    public const UPDATED_AT = 'updatedAt';

    protected $fillable = [
        'name',
        'email',
        'password',
        'roles',
    ];

    protected $hidden = [
        'password',
        'rememberToken',
    ];


    protected $casts = [
        'emaiVerifiedAt' => 'datetime',
        'password' => 'hashed',
        'roles' => 'array',
    ];

    public function generateToken()
    {
        $this->apiToken = str_random(60);
        $this->save();

        return $this->apiToken;
    }

    protected static function boot() {
        parent::boot();

        static::creating(function ($user) {
            $user['uuid'] = Str::uuid();
            $user['roles'] ??= ['admin'];
        });
    }
}
