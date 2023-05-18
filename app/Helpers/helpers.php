<?php

use Carbon\Carbon;

define("PAGELIST", "liste");
define("PAGECREATEFORM", "create");
define("PAGEEDITFORM", "edit");
define("PAGEROLE", "role");

define("DEFAULTPASSWORD" ,"password");

function calculerHeuresTravailParMois()
{
    $moisCourant = Carbon::now()->startOfMonth();
    $heuresTravailParMois = [];

    while ($moisCourant->month == Carbon::now()->month) {
        if (!$moisCourant->isWeekend()) {
            $joursTravailles = $moisCourant->diffInDaysFiltered(function (Carbon $date) {
                return !$date->isWeekend();
            }, Carbon::now()->endOfMonth());

            $heuresTravailParMois= $joursTravailles * 8;

        }
        $moisCourant->addMonth();
    }
    return $heuresTravailParMois;
}

function userName(){
    return auth()->user()->first_name . ' ' . auth()->user()->last_name;
}

function userPicture(){
    return auth()->user()->photo;
}

function setMenuActive($route){
    $routeActuel = request()->route()->getName();

    if($routeActuel === $route ){
        return "active";
    }
    return "";
}

function getRolesName(){
    $rolesName = "";
    $i = 0;
    foreach(auth()->user()->roles as $role){
        $rolesName .= $role->name;
        //
        if($i < sizeof(auth()->user()->roles) - 1 ){
            $rolesName .= ",";
        }

        $i++;
    }
    return $rolesName;
}


?>