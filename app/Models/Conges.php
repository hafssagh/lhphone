<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conges extends Model
{
    use HasFactory;

    protected $table = 'conge';
    
    public $fillable = [
        "date_debut", "date_fin", "statut" , "user_id"
    ];

    public function users(){
        return $this->belongsTo(User::class, "user_id", "id");
    }
}
