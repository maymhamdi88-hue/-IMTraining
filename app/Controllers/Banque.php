<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BanqueModel;

class Banque extends BaseController
{
    protected $banqueModel;

    public function __construct()
    {
        $this->banqueModel = new BanqueModel();
    }

   
   
    private function getDernierSolde(): float
    {
        $derniere = $this->banqueModel
            ->orderBy('id_banque', 'DESC')
            ->first();

        return $derniere ? (float)$derniere['solde_finale'] : 0.0;
    }

    // =========================================================
    // LISTE
    // URL: base_url() . "Banque/banque_list"
    // =========================================================
    public function banque_list()
    {
        $data = [
            'title'       => 'Journal de Banque',
            'operations'  => $this->banqueModel->orderBy('id_banque', 'ASC')->findAll(),
            'solde_actuel' => $this->getDernierSolde(),
        ];

        return view('Banque/banque_list', $data);
    }

    // =========================================================
    // FORMULAIRE AJOUT
    // URL: base_url() . "Banque/banque_ajouter_form"
    // =========================================================
    public function banque_ajouter_form()
    {
        $data = [
            'title'          => 'Ajouter une Opération',
            'solde_initiale' => $this->getDernierSolde(),
        ];

        return view('Banque/banque_form', $data);
    }

    // =========================================================
    // STORE (POST) — Calcul automatique du solde
    // URL: base_url() . "Banque/banque_store"
    // =========================================================
    public function banque_store()
    {
        $rules = [
            'date_operation' => 'required|valid_date',
            'type_operation' => 'required|in_list[credit,debit]',
            'montant'        => 'required|decimal|greater_than[0]',
        ];

        if (!$this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', implode('<br>', $this->validator->getErrors()));
        }

        $solde_initiale = $this->getDernierSolde();
        $type           = $this->request->getPost('type_operation');
        $montant        = (float)$this->request->getPost('montant');

        // Calcul automatique du solde finale
        if ($type === 'credit') {
            $solde_finale = $solde_initiale + $montant;
        } else {
            $solde_finale = $solde_initiale - $montant;
        }

        // Récupérer mois et année depuis date_operation
        $date   = $this->request->getPost('date_operation');
        $mois   = $this->getMoisFr(date('n', strtotime($date)));
        $annee  = date('Y', strtotime($date));

        $this->banqueModel->insert([
            'solde_initiale'     => $solde_initiale,
            'date_operation'     => $date,
            'type_operation'     => $type,
            'montant'            => $montant,
            'solde_finale'       => $solde_finale,
            'libelle'            => $this->request->getPost('libelle'),
            'designation_precise'=> $this->request->getPost('designation_precise'),
            'mois'               => $mois,
            'annee'              => $annee,
        ]);

        return redirect()
            ->to(base_url('Banque/banque_list'))
            ->with('success', 'Opération enregistrée avec succès. Solde: ' . number_format($solde_finale, 3) . ' DT');
    }

    // =========================================================
    // FORMULAIRE MODIFICATION
    // URL: base_url() . "Banque/banque_modifier_form/{id}"
    // ⚠️ ATTENTION: modifier recalcule tous les soldes après
    // =========================================================
    public function banque_modifier_form($id)
    {
        $operation = $this->banqueModel->find($id);

        if (!$operation) {
            return redirect()
                ->to(base_url('Banque/banque_list'))
                ->with('error', 'Opération introuvable.');
        }

        $data = [
            'title'     => 'Modifier une Opération',
            'operation' => $operation,
        ];

        return view('Banque/banque_form', $data);
    }

    // =========================================================

    public function banque_update($id)
    {
        if (!$this->banqueModel->find($id)) {
            return redirect()
                ->to(base_url('Banque/banque_list'))
                ->with('error', 'Opération introuvable.');
        }

        $rules = [
            'date_operation' => 'required|valid_date',
            'type_operation' => 'required|in_list[credit,debit]',
            'montant'        => 'required|decimal|greater_than[0]',
        ];

        if (!$this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', implode('<br>', $this->validator->getErrors()));
        }

        $date  = $this->request->getPost('date_operation');
        $mois  = $this->getMoisFr(date('n', strtotime($date)));
        $annee = date('Y', strtotime($date));

        // Mettre à jour l'opération (sans changer les soldes encore)
        $this->banqueModel->update($id, [
            'date_operation'     => $date,
            'type_operation'     => $this->request->getPost('type_operation'),
            'montant'            => (float)$this->request->getPost('montant'),
            'libelle'            => $this->request->getPost('libelle'),
            'designation_precise'=> $this->request->getPost('designation_precise'),
            'mois'               => $mois,
            'annee'              => $annee,
        ]);

        // Recalculer TOUS les soldes dans l'ordre
        $this->recalculerTousSoldes();

        return redirect()
            ->to(base_url('Banque/banque_list'))
            ->with('success', 'Opération modifiée. Soldes recalculés.');
    }

    // =========================================================
    // DELETE — Recalcul de tous les soldes après suppression
    // URL: base_url() . "Banque/banque_supprimer/{id}"
    // =========================================================
    public function banque_supprimer($id)
    {
        if (!$this->banqueModel->find($id)) {
            return redirect()
                ->to(base_url('Banque/banque_list'))
                ->with('error', 'Opération introuvable.');
        }

        $this->banqueModel->delete($id);

        // Recalculer TOUS les soldes dans l'ordre
        $this->recalculerTousSoldes();

        return redirect()
            ->to(base_url('Banque/banque_list'))
            ->with('success', 'Opération supprimée. Soldes recalculés.');
    }

    // =========================================================
    // EXPORT PDF
    // URL: base_url() . "Banque/banque_export_pdf"
    // =========================================================
    public function banque_export_pdf()
    {
        $data = [
            'operations'  => $this->banqueModel->orderBy('id_banque', 'ASC')->findAll(),
            'solde_actuel' => $this->getDernierSolde(),
            'date_export' => date('d/m/Y H:i'),
        ];

        $html = view('Banque/banque_pdf', $data);

        $options = new \Dompdf\Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new \Dompdf\Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        $dompdf->stream('banque_' . date('Ymd') . '.pdf', ['Attachment' => true]);
        exit;
    }

    // =========================================================
    // HELPER PRIVÉ — Recalculer tous les soldes en cascade
    // Appelé après update ou delete
    // =========================================================
    private function recalculerTousSoldes(): void
    {
        $operations = $this->banqueModel->orderBy('id_banque', 'ASC')->findAll();
        $solde = 0.0;

        foreach ($operations as $op) {
            $solde_initiale = $solde;

            if ($op['type_operation'] === 'credit') {
                $solde_finale = $solde_initiale + (float)$op['montant'];
            } else {
                $solde_finale = $solde_initiale - (float)$op['montant'];
            }

            $this->banqueModel->update($op['id_banque'], [
                'solde_initiale' => $solde_initiale,
                'solde_finale'   => $solde_finale,
            ]);

            $solde = $solde_finale;
        }
    }

    // =========================================================
    // HELPER PRIVÉ — Numéro du mois → nom en français
    // =========================================================
    private function getMoisFr(int $num): string
    {
        $mois = [
            1  => 'janvier',  2  => 'fevrier',   3  => 'mars',
            4  => 'avril',    5  => 'mai',        6  => 'juin',
            7  => 'juillet',  8  => 'aout',       9  => 'septembre',
            10 => 'octobre',  11 => 'novembre',   12 => 'decembre',
        ];
        return $mois[$num] ?? 'janvier';
    }
}