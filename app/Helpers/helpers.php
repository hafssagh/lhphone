<?php

use Carbon\Carbon;

define("PAGELIST", "liste");
define("PAGECREATEFORM", "create");
define("PAGEEDITFORM", "edit");
define("PAGEROLE", "role");

define("DEFAULTPASSWORD" ,"password");

function calculerHeuresTravailParMois()
{
       // Get the current month and year
       $currentMonth = Carbon::now()->month;
       $currentYear = Carbon::now()->year;

       // Get the first and last day of the month
       $firstDayOfMonth = Carbon::createFromDate($currentYear, $currentMonth, 1);
       $lastDayOfMonth = Carbon::createFromDate($currentYear, $currentMonth)->endOfMonth();

       // Calculate the total working hours for the month
       $totalHours = 0;

       for ($day = $firstDayOfMonth; $day <= $lastDayOfMonth; $day->addDay()) {
           // Check if the day is a Sunday (dayOfWeek = 0) or a weekday (dayOfWeek between 1 and 5)
           if ($day->isSunday()) {
               // Add 4 working hours for Sundays
               $totalHours += 4;
           } elseif ($day->isWeekday()) {
               // Add 8 working hours for weekdays (Monday to Friday)
               $totalHours += 8;
           }
       }

       return $totalHours;
   
}

function calculerHeuresTravail()
{
      // Get the current month and year
    $currentMonth = Carbon::now()->month;
    $currentYear = Carbon::now()->year;

    // Get the first and last day of the month
    $firstDayOfMonth = Carbon::createFromDate($currentYear, $currentMonth, 1);
    $lastDayOfMonth = Carbon::createFromDate($currentYear, $currentMonth)->endOfMonth();

    // Include the current day if it is within the month
    if (Carbon::now()->isSameMonth($lastDayOfMonth)) {
        $lastDayOfMonth = Carbon::now();
    }

    // Calculate the total working hours for the month
    $totalHours = 0;

    for ($day = $firstDayOfMonth; $day <= $lastDayOfMonth; $day->addDay()) {
        // Check if the day is a Sunday (dayOfWeek = 0) or a weekday (dayOfWeek between 1 and 5)
        if ($day->isSunday()) {
            // Add 4 working hours for Sundays
            $totalHours += 4;
        } elseif ($day->isWeekday()) {
            // Add 8 working hours for weekdays (Monday to Friday)
            $totalHours += 8;
        }
    }

    return $totalHours;
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