<?php

namespace App\Exports;

use App\Models\Sale;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class SalesExport implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $user = Auth::user();
        $manager = $user->last_name;
    
        $sales = Sale::select('user_id', 'name_client', 'mail_client', 'phone_client', 'date_sal',
            'state', 'date_confirm', 'quantity', 'commentaire', 'remark')
            ->orderBy('date_sal', 'desc');
    
        if ($manager == 'ELMOURABIT' || $manager == 'By') {
            $sales->whereHas('users', fn ($q) => $q->where('group', 1));
        } elseif ($manager == 'Essaid') {
            $sales->whereHas('users', fn ($q) => $q->where('group', 2));
        }else{
            $sales;
        }

        return $sales->get();
    }
    

    public function map($sales): array
    {
        $stateLabel = '';

        if ($sales->state == 2) {
            $stateLabel = 'Cmd confirmée';
        } elseif ($sales->state == 3) {
            $stateLabel = 'Devis envoyé';
        } elseif ($sales->state == 1) {
            $stateLabel = 'Devis signé'; 
        } elseif ($sales->state == -1) {
            $stateLabel = 'Devis refusé';
        }elseif ($sales->state == 4) {
            $stateLabel = 'Devis à corriger';
        }elseif ($sales->state == 5) {
            $stateLabel = 'En attente de livraison';
        }elseif ($sales->state == 6) {
            $stateLabel = 'Livré';
        }elseif ($sales->state == 7) {
            $stateLabel = 'AH envoyé';
        }elseif ($sales->state == 8) {
            $stateLabel = 'AH signé';
        }

        
        return [
            $sales->users->last_name .' '. $sales->users->first_name ,
            $sales->name_client,
            $sales->mail_client,
            $sales->phone_client,
            $sales->date_sal,
            $stateLabel,
            $sales->date_confirm,
            $sales->quantity,
            $sales->commentaire,
            $sales->remark,
        ];
    }


    public function headings(): array
    {

        return [
            'Agent',
            'Société',
            'Adresse Mail',
            'No',
            'Date envoie',
            'Statut',
            'Date confirmation',
            'Quantité',
            'Commentaire',
            'Remarque',
        ];
    }
}
