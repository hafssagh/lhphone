<?php

namespace App\Exports;

use App\Models\Appoint;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class AppointExport implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
    
        $appoints = Appoint::select('user_id','date_prise', 'prospect',  'dep', 'adresse',
        'num_mobile','num_fix', 'state','date_confirm', 'date_rdv', 'cr', 'commentaire', 'retour')
            ->orderBy('date_prise', 'desc');

        return $appoints->get();
    }
    

    public function map($appoints): array
    {
        $stateLabel = '';

        if ($appoints->state == 0) {
            $stateLabel = 'En attente';
        } elseif ($appoints->state == 1) {
            $stateLabel = 'Confirmé';
        } elseif ($appoints->state == 2) {
            $stateLabel = 'A voir'; 
        } elseif ($appoints->state == 3) {
            $stateLabel = 'NRP'; 
        } elseif ($appoints->state == 4) {
            $stateLabel = 'Injoingnable'; 
        } elseif ($appoints->state == 5) {
            $stateLabel = 'Enregistrement demandé'; 
        } elseif ($appoints->state == 6) {
            $stateLabel = 'Présence couple'; 
        } elseif ($appoints->state == -1) {
            $stateLabel = 'Annulé'; 
        } elseif ($appoints->state == -2) {
            $stateLabel = 'Hors cible'; 
        } elseif ($appoints->state == -3) {
            $stateLabel = 'Mauvaise fois'; 
        } 


        return [
            $appoints->users->last_name .' '. $appoints->users->first_name ,
            $appoints->date_prise,
            $appoints->prospect,
            $appoints->dep,
            $appoints->adresse,
            $appoints->num_mobile,
            $appoints->num_fix,
            $stateLabel,
            $appoints->date_confirm,
            $appoints->date_rdv,
            $appoints->cr,
            $appoints->commentaire,
            $appoints->retour,
        ];
    }


    public function headings(): array
    {

        return [
            'Agent',
            'Date envoie',
            'Prospect',
            'Dep',
            'Adresse',
            'No mobile',
            'No fixe',
            'Statut',
            'Date confirmation',
            'Date RDV',
            'Créneau',
            'Commetaire',
            'Retout',
        ];
    }
}
