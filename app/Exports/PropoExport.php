<?php

namespace App\Exports;

use App\Models\Mails;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class PropoExport implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $user = Auth::user();
        $manager = $user->last_name;
    
        $appoints = Mails::select('user_id', 'nameClient', 'company', 'emailClient', 'numClient',
            'adresse', 'state', 'remark', 'remark2', 'created_at')
            ->orderBy('created_at', 'desc');
    
        if ($manager == 'ELMOURABIT' || $manager == 'By') {
            $appoints->whereHas('users', fn ($q) => $q->where('group', 1));
        } elseif ($manager == 'Essaid') {
            $appoints->whereHas('users', fn ($q) => $q->where('group', 2));
        }else{
            $appoints;
        }

        return $appoints->get();
    }
    

    public function map($appoints): array
    {
        $stateLabel = '';
    
        if ($appoints->state == 0) {
            $stateLabel = 'Non traitée';
        } elseif ($appoints->state == 1) {
            $stateLabel = 'Confirmée';
        } elseif ($appoints->state == -1) {
            $stateLabel = 'Hors cible / Pas intéressé'; // Replace with the label for the third condition
        } elseif ($appoints->state == 3) {
            $stateLabel = 'Rappeler'; // Replace with the label for the third condition
        }

        return [
            $appoints->users->last_name .' '. $appoints->users->first_name ,
            $appoints->nameClient,
            $appoints->company,
            $appoints->emailClient,
            $appoints->numClient,
            $appoints->adresse,
            $stateLabel,
            $appoints->created_at,
            $appoints->remark,
            $appoints->remark2,
        ];
    }


    public function headings(): array
    {

        return [
            'Agent',
            'Prospect',
            'Société',
            'Adresse Mail',
            'No',
            'Adresse',
            'Statut',
            'Date envoie',
            'Remarque agent',
            'Remarque manager',
        ];
    }
}
