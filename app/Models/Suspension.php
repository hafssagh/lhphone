<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suspension extends Model
{
    use HasFactory;

    protected $table = 'suspension';

    public $fillable = [
        "date_debut","date_fin", "cause" , "user_id"
    ];

    public function users(){
        return $this->belongsTo(User::class, "user_id", "id");
    }
}
