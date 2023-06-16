<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ChallengeExport implements FromCollection, WithMapping, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return User::select('last_name', 'first_name', 'challenge', 'type_virement' ,'rib', 'company')
            ->orderBy('company','desc')
            ->whereNot('challenge', '0')
            ->get();
    }

    public function map($user): array
    {
        return [
            $user->last_name . ' ' . $user->first_name,
            $user->challenge . ' ' . "DH",
            $user->type_virement,
            $user->rib,
            $user->company,
        ];
    }


    public function headings(): array
    {

        return [
            'Nom complet',
            'Challenge',
            'Mode de paiement',
            'Rib',
            'Société',
        ];
    }
}
