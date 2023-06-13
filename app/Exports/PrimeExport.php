<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PrimeExport implements FromCollection, WithMapping, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return User::select('last_name', 'first_name', 'prime', 'company')
            ->orderBy('company','desc')
            ->whereNot('prime', '0')
            ->get();
    }

    public function map($user): array
    {
        return [
            $user->last_name . ' ' . $user->first_name,
            $user->prime . ' ' . "DH",
            $user->company,
        ];
    }


    public function headings(): array
    {

        return [
            'Nom complet',
            'Prime',
            'Société',
        ];
    }
}
