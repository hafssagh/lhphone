<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Absence;
use Illuminate\Console\Command;

class DailyFunction extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Artisan command to send daily function';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        /* return Command::SUCCESS; */
        $users = User::all();
        $currentMonth = Carbon::now()->format('Y-m');
        foreach ($users as $user) {
            $totalAbsenceDays = Absence::where('user_id', $user->id)
                ->whereRaw("DATE_FORMAT(date, '%Y-%m') = ?", [$currentMonth])
                ->sum('abs_hours');
            $workHours = calculerHeuresTravail();
            $user->work_hours = $workHours - $totalAbsenceDays;
            $workHoursMonth = calculerHeuresTravailParMois();
            $salary_perHour = $user->base_salary / $workHoursMonth;
            $salary = $salary_perHour * $user->work_hours;
            $user->salary = round($salary, 0, PHP_ROUND_HALF_UP);

            $user->save();
        }

        echo 'updated ' . date('Y-m-d');
    }
}
