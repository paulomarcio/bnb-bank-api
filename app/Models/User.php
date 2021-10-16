<?php

namespace App\Models;

use App\Enum\RoleEnum;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class User extends Model implements AuthenticatableContract
{
    use Authenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'role_id', 'username', 'name', 'email', 'password'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'role_id', 'created_at', 'updated_at'
    ];

    protected $appends = ['is_admin', 'token'];

    public function account()
    {
        return $this->hasOne(Account::class);
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function getIsAdminAttribute()
    {
        return $this->attributes['role_id'] === RoleEnum::ADMIN;
    }

    public function getTokenAttribute()
    {
        return $this->attributes['password'];
    }
}
