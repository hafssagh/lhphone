<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgentRelance extends Model
{
    use HasFactory;

    protected $table = 'agent_relance';
    
    public $fillable = [
        "company", "nameClient", "emailClient", "numClient" , "user_id", "send"  
    ];

    public function users(){
        return $this->belongsTo(User::class, "user_id", "id");
    }

}
