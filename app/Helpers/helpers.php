<?php

use Carbon\Carbon;
use App\Models\Sale;
use App\Models\User;
use App\Models\Avance;

use App\Models\Absence;
use App\Models\Suspension;
use App\Models\Resignation;
use App\Exports\PrimeExport;
use App\Exports\SalaryExport;
use App\Exports\ChallengeExport;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


define("PAGEDEVIS", "devisEnCours");
define("PAGELIST", "liste");
define("PAGECREATEFORM", "create");
define("PAGECREATEFORM2", "create2");
define("PAGEEDITFORM", "edit");
define("PAGEROLE", "role");
define("PAGEPOPOSALL", "proposAll");

define("DEFAULTPASSWORD", "password");

function exportChallenge()
{
    $today = date('Y-m-d');
    $dayOfWeek = date('N');

    if ($dayOfWeek !== 7) {
        return;
    }

    $file = 'C:/Users/hp/Desktop/salary.xlsx';

    $spreadsheet = new Spreadsheet();
    if (file_exists($file)) {
        $spreadsheet = IOFactory::load($file);
    }

    $export = new ChallengeExport;
    $sheet = $spreadsheet->getSheet(2);

    $highestRow = $sheet->getHighestRow();
    $nextRow = $highestRow + 1;

    $data = $export->collection();

    $sheet->setCellValue('A' . $nextRow, '');
    $nextRow++;
    $sheet->setCellValue('A' . $nextRow, '');
    $nextRow++;

    $moisEnFrancais = [
        1 => 'janvier',
        2 => 'février',
        3 => 'mars',
        4 => 'avril',
        5 => 'mai',
        6 => 'juin',
        7 => 'juillet',
        8 => 'août',
        9 => 'septembre',
        10 => 'octobre',
        11 => 'novembre',
        12 => 'décembre',
    ];
    $mois = $moisEnFrancais[date('n')];

    $annee = date('Y');

    $today = new DateTime();
    $weekOfMonth = ceil(($today->format('j') - 1) / 7) + 1;

    $style = [
        'font' => [
            'bold' => true,
            'size' => 13,
            'color' => ['rgb' => 'blue'],
        ],
        'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        ],

    ];
    $cellStart = 'A' . $nextRow;
    $cellEnd = 'E' . $nextRow;

    $sheet->setCellValue('A' . $nextRow, "Les challenges de la  $weekOfMonth ème semaine : $mois  $annee");
    switch ($weekOfMonth) {
        case 1:
            echo "st";
            break;
        case 2:
            echo "nd";
            break;
        case 3:
            echo "rd";
            break;
        case 4:
        case 5:
            echo "th";
            break;
        default:
            echo "th";
            break;
    }

    $sheet->mergeCells($cellStart . ':' . $cellEnd);
    $sheet->getStyle($cellStart)->applyFromArray($style);
    $nextRow++;
    $sheet->setCellValue('A' . $nextRow, '');
    $nextRow++;

    // Add the headings
    $headings = $export->headings();
    $sheet->fromArray([$headings], null, 'A' . $nextRow);
    $sheet->getStyle('A' . $nextRow . ':' . 'K' . $nextRow)->applyFromArray([
        'font' => [
            'bold' => true,
        ],
    ]);


    $sumEspece = User::where('type_virement', 'espece')->sum('challenge');
    $sumVirement = User::where('type_virement', 'virement')->sum('challenge');

    $sheet->setCellValue('G' . $nextRow, "Somme Salaire (Espèce) : $sumEspece DH");
    $sheet->getStyle('G' . $nextRow)->getFont()->setBold(true); // Make the text bold
    $nextRow++;

    $sheet->setCellValue('G' . $nextRow, "Somme Salaire (Virement) : $sumVirement DH");
    $sheet->getStyle('G' . $nextRow)->getFont()->setBold(true); // Make the text bold

    foreach ($data as $row) {
        $rowData = $export->map($row);

        $sheet->fromArray($rowData, null, 'A' . $nextRow);
        $nextRow++;
    }

    $writer = new Xlsx($spreadsheet);
    $writer->save($file);

    return response()->download($file)->deleteFileAfterSend(false);
}

function exportPrime()
{
    $today = date('Y-m-d');
    $lastDayOfMonth = date('Y-m-t');

    if ($today !== $lastDayOfMonth) {
        return;
    }

    $file = 'C:/Users/hp/Desktop/salary.xlsx';

    $spreadsheet = new Spreadsheet();
    if (file_exists($file)) {
        $spreadsheet = IOFactory::load($file);
    }

    $export = new PrimeExport;
    $sheet = $spreadsheet->getSheet(1);

    $highestRow = $sheet->getHighestRow();
    $nextRow = $highestRow + 1;

    $data = $export->collection();

    $sheet->setCellValue('A' . $nextRow, '');
    $nextRow++;
    $sheet->setCellValue('A' . $nextRow, '');
    $nextRow++;

    $moisEnFrancais = [
        1 => 'janvier',
        2 => 'février',
        3 => 'mars',
        4 => 'avril',
        5 => 'mai',
        6 => 'juin',
        7 => 'juillet',
        8 => 'août',
        9 => 'septembre',
        10 => 'octobre',
        11 => 'novembre',
        12 => 'décembre',
    ];

    $mois = $moisEnFrancais[date('n')];
    $annee = date('Y');
    $style = [
        'font' => [
            'bold' => true,
            'size' => 13,
            'color' => ['rgb' => 'blue'],
        ],
        'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        ],

    ];
    $cellStart = 'A' . $nextRow;
    $cellEnd = 'E' . $nextRow;

    $sheet->setCellValue('A' . $nextRow, "Les primes du mois de : $mois  $annee");
    $sheet->mergeCells($cellStart . ':' . $cellEnd);
    $sheet->getStyle($cellStart)->applyFromArray($style);
    $nextRow++;
    $sheet->setCellValue('A' . $nextRow, '');
    $nextRow++;

    // Add the headings
    $headings = $export->headings();
    $sheet->fromArray([$headings], null, 'A' . $nextRow);
    $sheet->getStyle('A' . $nextRow . ':' . 'E' . $nextRow)->applyFromArray([
        'font' => [
            'bold' => true,
        ],
    ]);

    $sumEspece = User::where('type_virement', 'espece')->sum('prime');
    $sumVirement = User::where('type_virement', 'virement')->sum('prime');

    $sheet->setCellValue('G' . $nextRow, "Somme Salaire (Espèce) : $sumEspece DH");
    $sheet->getStyle('G' . $nextRow)->getFont()->setBold(true); // Make the text bold
    $nextRow++;

    $sheet->setCellValue('G' . $nextRow, "Somme Salaire (Virement) : $sumVirement DH");
    $sheet->getStyle('G' . $nextRow)->getFont()->setBold(true); // Make the text bold

    foreach ($data as $row) {
        $rowData = $export->map($row);

        $sheet->fromArray($rowData, null, 'A' . $nextRow);
        $nextRow++;
    }

    $writer = new Xlsx($spreadsheet);
    $writer->save($file);

    return response()->download($file)->deleteFileAfterSend(false);
}

function exportSalary()
{
    $today = date('Y-m-d');
    $lastDayOfMonth = date('Y-m-t');

    if ($today !== $lastDayOfMonth) {
        return;
    }

    $file = 'C:/Users/hp/Desktop/salary.xlsx';

    $spreadsheet = new Spreadsheet();
    if (file_exists($file)) {
        $spreadsheet = IOFactory::load($file);
    }

    $export = new SalaryExport;
    $sheet = $spreadsheet->getSheet(0);

    $highestRow = $sheet->getHighestRow();
    $nextRow = $highestRow + 1;

    $data = $export->collection();

    $sheet->setCellValue('A' . $nextRow, '');
    $nextRow++;
    $sheet->setCellValue('A' . $nextRow, '');
    $nextRow++;

    $moisEnFrancais = [
        1 => 'janvier',
        2 => 'février',
        3 => 'mars',
        4 => 'avril',
        5 => 'mai',
        6 => 'juin',
        7 => 'juillet',
        8 => 'août',
        9 => 'septembre',
        10 => 'octobre',
        11 => 'novembre',
        12 => 'décembre',
    ];

    $mois = $moisEnFrancais[date('n')];
    $annee = date('Y');
    $style = [
        'font' => [
            'bold' => true,
            'size' => 13,
            'color' => ['rgb' => 'blue'],
        ],
        'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        ],

    ];
    $cellStart = 'A' . $nextRow;
    $cellEnd = 'E' . $nextRow;

    $sheet->setCellValue('A' . $nextRow, "Les salaires du mois de : $mois  $annee");
    $sheet->mergeCells($cellStart . ':' . $cellEnd);
    $sheet->getStyle($cellStart)->applyFromArray($style);
    $nextRow++;
    $sheet->setCellValue('A' . $nextRow, '');
    $nextRow++;

    // Add the headings
    $headings = $export->headings();
    $sheet->fromArray([$headings], null, 'A' . $nextRow);
    $sheet->getStyle('A' . $nextRow . ':' . 'F' . $nextRow)->applyFromArray([
        'font' => [
            'bold' => true,
        ],
    ]);

    $sumEspece = User::where('type_virement', 'espece')->sum('salary');
    $sumVirement = User::where('type_virement', 'virement')->sum('salary');

    $sheet->setCellValue('H' . $nextRow, "Somme Salaire (Espèce) : $sumEspece DH");
    $sheet->getStyle('H' . $nextRow)->getFont()->setBold(true); // Make the text bold
    $nextRow++;

    $sheet->setCellValue('H' . $nextRow, "Somme Salaire (Virement) : $sumVirement DH");
    $sheet->getStyle('H' . $nextRow)->getFont()->setBold(true); // Make the text bold



    foreach ($data as $row) {
        $rowData = $export->map($row);

        $sheet->fromArray($rowData, null, 'A' . $nextRow);
        $nextRow++;
    }

    $writer = new Xlsx($spreadsheet);
    $writer->save($file);

    return response()->download($file)->deleteFileAfterSend(false);
}

function CalculChallenge()
{
    $weekDates = fetchWeekDates();
    $users = User::all();

    foreach ($users as $user) {
        $sales = Sale::where('user_id', $user->id)
            ->whereIn('date_confirm', $weekDates)
            ->whereIn('state', [1, 5, 6, 7, 8])
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
            ->whereIn('state', [1, 5, 6, 7, 8])
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
                3800 => 8500,
                4200 => 9000,
                4600 => 10000,
            ];

            $user->prime = 0; 

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
        $weekDates[$i] = $currentDate->toDateString();
        $currentDate->addDay();
    }

    return $weekDates;
}

function fetchWeekDatesWithoutWeekend()
{
    $weekDates = [];

    $currentDate = Carbon::now()->startOfWeek();
    for ($i = 0; $i < 5; $i++) {
        $weekDates[$i] = $currentDate->toDateString();
        $currentDate->addDay();
    }

    return $weekDates;
}

function fetchNextWeekDatesWithoutWeekend()
{
    $weekDates = [];
    $currentDate = Carbon::now()->startOfWeek()->addWeek(); 

    for ($i = 0; $i < 5; $i++) {
        if ($currentDate->isWeekend()) {
            $currentDate->addDay();
        }

        $weekDates[$i] = $currentDate->toDateString();
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
    $currentDate = Carbon::now();
    $currentMonth = $currentDate->format('Y-m');

    foreach ($users as $user) {
        $totalAbsenceDays = Absence::where('user_id', $user->id)
            ->whereRaw("DATE_FORMAT(date, '%Y-%m') = ?", [$currentMonth])
            ->whereRaw("abs_hours > ?", [0])
            ->sum('abs_hours');

        $suspension = Suspension::where('user_id', $user->id)
            ->where(function ($query) use ($currentMonth) {
                $query->whereRaw("DATE_FORMAT(date_debut, '%Y-%m') = ?", [$currentMonth])
                    ->orWhereRaw("DATE_FORMAT(date_fin, '%Y-%m') = ?", [$currentMonth]);
            })
            ->first();

        $resignation = Resignation::where('user_id', $user->id)
            ->whereRaw("DATE_FORMAT(date, '%Y-%m') = ?", [$currentMonth])
            ->first();

        if ($suspension) {
            $dateStart = Carbon::parse($suspension->date_debut);
            $dateEnd = Carbon::parse($suspension->date_fin);

            $numberOfHours = 0;
            $date = $currentDate->copy();

            while ($date->format('Y-m') === $currentMonth && $date->gte($dateStart)) {
                if (!$date->isWeekend() && $date->lte($dateEnd)) {
                    $numberOfHours += 8;
                }
                $date->subDay();
            }
        } else {
            $numberOfHours = 0;
        }

        if ($resignation) {
            $resignationDate = Carbon::parse($resignation->date);

            // Add 8 hours for each day equal or after the resignation date (excluding weekends)
            $date = $currentDate->copy();
            while ($date->format('Y-m') === $currentMonth && $date->gte($resignationDate)) {
                if (!$date->isWeekend()) {
                    $numberOfHours += 8;
                }
                $date->subDay();
            }  
        }

        $workHours = calculerHeuresTravail();
        $user->work_hours = $workHours - $totalAbsenceDays - $numberOfHours;
        $user->save();
    }
}


function AbsSalary()
{
    $users = User::all();
    $currentDate = Carbon::now();
    $currentMonth = $currentDate->format('Y-m');

    foreach ($users as $user) {
        $avance = Avance::where('user_id', $user->id)
            ->whereRaw("DATE_FORMAT(created_at, '%Y-%m') = ?", [$currentMonth])
            ->sum('advance');

        $workHoursMonth =  calculerHeuresTravailParMois();
        $salary_perHour = $user->base_salary /  $workHoursMonth;
        $salary = $salary_perHour * $user->work_hours;
        $user->salary =  round($salary, 0, PHP_ROUND_HALF_UP) - $avance;
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
