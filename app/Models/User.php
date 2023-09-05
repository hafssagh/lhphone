<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Appoint;
use App\Models\Suspension;
use App\Models\Resignation;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name','last_name','email','password',
        'id_card','phone', 'birthday','date_contract','type_contract','company', 'group',
        'duration_contract','base_salary','salary','abs_hours' ,'photo',
        'type_virement', 'rib','nom_prod'
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

    public function resignations(){
        return $this->hasMany(Resignation::class);
    }

    public function suspensions(){
        return $this->hasMany(Suspension::class);
    }

    public function absences(){
        return $this->hasMany(Absence::class);
    }

    public function sales(){
        return $this->hasMany(Sale::class);
    }

    public function mails(){
        return $this->hasMany(Mails::class);
    }

    public function explics(){
        return $this->hasMany(Explic::class);
    }

    public function mangerRelances(){
        return $this->hasMany(ManagerRelance::class);
    }

    public function agentRelances(){
        return $this->hasMany(AgentRelance::class);
    }

    public function avances(){
        return $this->hasMany(Avance::class);
    }

    public function appoints(){
        return $this->hasMany(Appoint::class);
    }

    public function renovations(){
        return $this->hasMany(Renovations::class);
    }
}
