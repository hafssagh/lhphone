<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resignation extends Model
{
    use HasFactory;

    public $fillable = [
        "date", "motive", "user_id"
    ];

    public function users(){
        return $this->belongsTo(User::class, "user_id", "id");
    }
  
}
