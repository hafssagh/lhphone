<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManagerRelance extends Model
{
    use HasFactory;

    protected $table = 'relance_manager';
    
    public $fillable = [
        "company", "nameClient", "email", "numClient" , "user_id",
        "date_envoie",  "numDevie",  "object",  
    ];

    public function users(){
        return $this->belongsTo(User::class, "user_id", "id");
    }
}
