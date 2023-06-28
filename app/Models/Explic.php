<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Explic extends Model
{
    use HasFactory;

    protected $table = 'explic';
    
    public $fillable = [
        "nameClient", "emailClient", "numClient" , "user_id",
        "adresse", "company", 
    ];

    public function users(){
        return $this->belongsTo(User::class, "user_id", "id");
    }
}
