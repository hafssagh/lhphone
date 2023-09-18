<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prelevement extends Model
{
    use HasFactory;

    protected $table = 'prelevements';
    
    public $fillable = [
        "prelevement", "motif", "user_id"
    ];

    public function users(){
        return $this->belongsTo(User::class, "user_id", "id");
    }
}
