<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Avance extends Model
{
    use HasFactory;

    protected $table = 'avances';
    
    public $fillable = [
        "advance", "motif", "user_id"
    ];

    public function users(){
        return $this->belongsTo(User::class, "user_id", "id");
    }
    
}
