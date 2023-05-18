<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Absence extends Model
{
    use HasFactory;

    public $fillable = [
        "date","work_hours", "justification" , "user_id"
    ];

    public function users(){
        return $this->belongsTo(User::class, "user_id", "id");
    }
}
