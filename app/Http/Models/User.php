<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password', 'active'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password'
    ];

    /**
     * Get the user's full name
     *
     * @return string
     */
    public function getFullName()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * Get the names of user roles
     *
     * @return array
     */
    public function getRoleNames()
    {
        return array_map(function ($role) {
            return $role['name'];
        }, $this->roles->toArray());
    }

    /**
     * Get the names of the permissions the user has
     *
     * @return array
     */
    public function getPermissionsNames()
    {
        return array_map(function ($permission) {
            return $permission['name'];
        }, $this->getAllPermissions()->toArray());
    }

    /**
     * Mutator for password attribute
     *
     * @param $password
     */
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }
}
