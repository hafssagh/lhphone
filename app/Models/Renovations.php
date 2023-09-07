<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Renovations extends Model
{
    use HasFactory;

    protected $table = 'renovation';
    
    public $fillable = [
        "state", "dep", "date_prise" , "date_confirm" ,"date_rdv",
        "cr", "prospect", "num_fix" , "num_mobile", "adresse", 
        "commentaire","retour" , "user_id" , "rappel" , "email" 
    ];

    public function users(){
        return $this->belongsTo(User::class, "user_id", "id");
    }
}