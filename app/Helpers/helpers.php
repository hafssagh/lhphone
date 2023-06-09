<?php

use Carbon\Carbon;
use App\Models\Sale;
use App\Models\User;
use App\Models\Absence;

define("PAGEDEVIS", "devisEnCours");
define("PAGELIST", "liste");
define("PAGECREATEFORM", "create");
define("PAGEEDITFORM", "edit");
define("PAGEROLE", "role");
define("PAGEPOPOSWEEK", "proposWeek");
define("PAGEPOPOSMONTH", "proposMonth");

define("DEFAULTPASSWORD", "password");

function CalculChallenge()
{
    $weekDates = fetchWeekDates();
    $users = User::all();

    foreach ($users as $user) {
        $sales = Sale::where('user_id', $user->id)
            ->whereIn('date_confirm', $weekDates)
            ->where('state', '1')
            ->get();

        if ($sales->isNotEmpty()) {
            $totalQuantity = $sales->sum('quantity');
            if ($totalQuantity >= 300) {
                $challenge = max(min(floor($totalQuantity / 100) * 100 - 100, 900), 200);
                $user->challenge = $challenge;
            } else {
                $user->challenge = 0;
            }
        } else {
            $user->challenge = 0;
        }

        $user->save();
    }
}


function CalculPrime()
{
    $monthDates = fetchMonthDates();
    $users = User::all();

    foreach ($users as $user) {
        $sales = Sale::where('user_id', $user->id)
            ->whereIn('date_confirm', $monthDates)
            ->where('state', '1')
            ->get();

        if ($sales->isNotEmpty()) {
            $totalQuantity = $sales->sum('quantity');

            $increments = [
                1000 => 1500,
                1400 => 2500,
                1800 => 3500,
                2200 => 4500,
                2600 => 5500,
                3000 => 6500,
                3400 => 7500,
            ];

            $user->prime = 0; // Set the initial value of prime

            foreach ($increments as $quantityThreshold => $challengeValue) {
                if ($totalQuantity >= $quantityThreshold) {
                    $user->prime = $challengeValue;
                } else {
                    break;
                }
            }
        } else {
            $user->prime = 0;
        }

        $user->save();
    }
}

function fetchMonthDates()
{
    $monthDates = [];

    $currentDate = Carbon::now()->startOfMonth();
    $lastDayOfMonth = Carbon::now()->endOfMonth();

    while ($currentDate <= $lastDayOfMonth) {
        $monthDates[] = $currentDate->toDateString();
        $currentDate->addDay();
    }

    return $monthDates;
}

function fetchWeekDates()
{
    $weekDates = [];

    $currentDate = Carbon::now()->startOfWeek();
    for ($i = 0; $i < 7; $i++) {
        $weekDates[] = $currentDate->toDate();
        $currentDate->addDay();
    }

    return $weekDates;
}

function fetchMonthWeeks()
{
    $monthWeeks = [];
    
    $currentDate = Carbon::now()->startOfMonth();
    $endOfMonth = Carbon::now()->endOfMonth();

    while ($currentDate <= $endOfMonth) {
        $weekStart = $currentDate->copy()->startOfWeek();
        $weekEnd = $currentDate->copy()->endOfWeek();

        $monthWeeks[] = [
            'start' => $weekStart->toDate(),
            'end' => $weekEnd->toDate(),
        ];

        $currentDate->addWeek();
    }

    return $monthWeeks;
}

function workHours()
{
    $users = User::all();
    $currentMonth = Carbon::now()->format('Y-m');
    foreach ($users as $user) {
        $totalAbsenceDays = Absence::where('user_id', $user->id)
            ->whereRaw("DATE_FORMAT(date, '%Y-%m') = ?", [$currentMonth])
            ->sum('abs_hours');
        $workHours = calculerHeuresTravail();
        $user->work_hours = $workHours - $totalAbsenceDays;
        $user->save();
    }
}


function AbsSalary()
{
    $users = User::all();
    foreach ($users as $user) {
        $workHoursMonth =  calculerHeuresTravailParMois();
        $salary_perHour = $user->base_salary /  $workHoursMonth;
        $salary = $salary_perHour * $user->work_hours;
        $user->salary =  round($salary, 0, PHP_ROUND_HALF_UP);
        $user->save();
    }
}

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
        if ($day->isWeekday()) {
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
        if ($day->isWeekday()) {
            // Add 8 working hours for weekdays (Monday to Friday)
            $totalHours += 8;
        }
    }

    return $totalHours;
}


function userName()
{
    return auth()->user()->last_name . ' ' . auth()->user()->first_name;
}

function userPicture()
{
    return auth()->user()->photo;
}

function setMenuActive($route)
{
    $routeActuel = request()->route()->getName();

    if ($routeActuel === $route) {
        return "active";
    }
    return "";
}

function getRolesName()
{
    $rolesName = "";
    $i = 0;
    foreach (auth()->user()->roles as $role) {
        $rolesName .= $role->name;
        //
        if ($i < sizeof(auth()->user()->roles) - 1) {
            $rolesName .= ",";
        }

        $i++;
    }
    return $rolesName;
}
