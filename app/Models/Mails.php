<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mails extends Model
{
    use HasFactory;

    protected $table = 'mails';
    
    public $fillable = [
        "nameClient", "emailClient", "numClient" , "user_id",
        "adresse", "company", "state" , "remark", "rappel"
    ];

    public function users(){
        return $this->belongsTo(User::class, "user_id", "id");
    }
}
