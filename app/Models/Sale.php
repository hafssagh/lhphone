<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;
    
    public $fillable = [
        "quantity", "state", "date_sal" , "date_confirm" ,
        "name_client", "mail_client", "phone_client",
        "remark","user_id",
        "un","deux","trois","cinq","dix","hublots",
        "pommeaux","mousseurs","reglette","tube","spot"
    ];

    public function users(){
        return $this->belongsTo(User::class, "user_id", "id");
    }

}
