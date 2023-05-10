<?php

function userName(){
    return auth()->user()->name;
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