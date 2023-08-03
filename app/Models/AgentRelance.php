<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgentRelance extends Model
{
    use HasFactory;

    protected $table = 'relance';
    
    public $fillable = [
        "company", "nameClient", "email", "numClient" , "user_id", "send"  
    ];

    public function users(){
        return $this->belongsTo(User::class, "user_id", "id");
    }

}
