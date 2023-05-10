<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name','lastt_name','email','password',
        'id_card','phone', 'birthday','date_contract','type_contract',
        'duration_contract','base_salary','salary','photo',
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
    ];

    public function roles(){
        return $this->belongsToMany(Role::class, "user_role", "user_id", "role_id");
    }

    public function hasRole($role){
        return $this->roles()->where("name", $role)->first() !== null;
    }

    public function hasAnyRoles($roles){
        return $this->roles()->whereIn("name", $roles)->first() !== null;
    }

    public function getAllRoleNameAttribute(){
        return $this->roles->implode("name",' | ');
    }
}
