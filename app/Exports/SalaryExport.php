<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SalaryExport implements FromCollection, WithMapping, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return User::select('last_name', 'first_name', 'base_salary', 'salary', 'company')
            ->orderBy('company','desc')
            ->whereNot('last_name', 'EL MESSIOUI')
            ->get();
    }

    public function map($user): array
    {
        return [
            $user->last_name . ' ' . $user->first_name,
            $user->base_salary . ' ' . "DH",
            $user->salary . ' ' . "DH",
            $user->company,
        ];
    }


    public function headings(): array
    {

        return [
            'Nom complet',
            'Salaire de base',
            'Salaire',
            'Société',
        ];
    }
}
