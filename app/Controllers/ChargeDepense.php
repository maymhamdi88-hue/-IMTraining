<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ChargeDepenseModel;
use App\Models\EmployeModel;

class ChargeDepense extends BaseController
{
    protected $chargeModel;
    protected $employeModel;

    public function __construct()
    {
        $this->chargeModel  = new ChargeDepenseModel();
        $this->employeModel = new EmployeModel();
    }

    private function getEmployesMap(): array
    {
        $employes = $this->employeModel->findAll();
        $map = [];
        foreach ($employes as $e) {
            $map[$e['id_employe']] = $e['nom'] . ' ' . $e['prenom'];
        }
        return $map;
    }

    // =========================================================
    // LISTE
    // URL: base_url() . "ChargeDepense/charges_list"
    // =========================================================
    public function charges_list()
    {
        $data = [
            'title'       => 'Charges & Dépenses',
            'rows'        => $this->chargeModel->orderBy('date_charge', 'DESC')->findAll(),
            'employesMap' => $this->getEmployesMap(),
        ];
        return view('ChargeDepense/charges_list', $data);
    }

    // =========================================================
    // FORMULAIRE AJOUT
    // URL: base_url() . "ChargeDepense/charges_ajouter_form"
    // =========================================================
    public function charges_ajouter_form()
    {
        $data = [
            'title'       => 'Charges & Dépenses',
            'employes' => $this->employeModel->findAll(),
        ];
        return view('ChargeDepense/charges_form', $data);
    }

    // =========================================================
    // STORE (POST)
    // URL: base_url() . "ChargeDepense/charges_store"
    // =========================================================
    public function charges_store()
    {
        $post = $this->request->getPost();

        // Nettoyage mode_paiement
        $mode = $post['mode_paiement'] ?? '';
        if (!in_array($mode, ['cash', 'virement', 'cheque'])) {
            $mode = null;
        }

        $this->chargeModel->insert([
            'type_charge'   => $post['type_charge']   ?: null,
            'date_charge'   => $post['date_charge']   ?: null,
            'fournisseur'   => $post['fournisseur']   ?: null,
            'banque_poste'  => $post['banque_poste']  ?: null,
            'mode_paiement' => $mode,
            'designation'   => $post['designation']   ?: null,
            'montant_htva'  => !empty($post['montant_htva'])  ? (float)$post['montant_htva']  : null,
            'montant_tva'   => !empty($post['montant_tva'])   ? (float)$post['montant_tva']   : null,
            'montant_ttc'   => !empty($post['montant_ttc'])   ? (float)$post['montant_ttc']   : null,
            'montant_net'   => !empty($post['montant_net'])   ? (float)$post['montant_net']   : null,
            'id_employe'    => !empty($post['id_employe'])    ? (int)$post['id_employe']      : null,
            'remarque'      => $post['remarque']      ?: null,
        ]);

        return redirect()->to(base_url('ChargeDepense/charges_list'))
            ->with('success', 'Charge ajoutée avec succès.');
    }

    // =========================================================
    // FORMULAIRE MODIFICATION
    // URL: base_url() . "ChargeDepense/charges_modifier_form/{id}"
    // =========================================================
    public function charges_modifier_form($id)
    {
        $charge = $this->chargeModel->find($id);

        if (!$charge) {
            return redirect()->to(base_url('ChargeDepense/charges_list'))
                ->with('error', 'Charge introuvable.');
        }

        $data = [
            'title'       => 'Charges & Dépenses',
            'charge'   => $charge,
            'employes' => $this->employeModel->findAll(),
        ];
        return view('ChargeDepense/charges_form', $data);
    }

    // =========================================================
    // UPDATE (POST)
    // URL: base_url() . "ChargeDepense/charges_update/{id}"
    // =========================================================
    public function charges_update($id)
    {
        if (!$this->chargeModel->find($id)) {
            return redirect()->to(base_url('ChargeDepense/charges_list'))
                ->with('error', 'Charge introuvable.');
        }

        $post = $this->request->getPost();

        $mode = $post['mode_paiement'] ?? '';
        if (!in_array($mode, ['cash', 'virement', 'cheque'])) {
            $mode = null;
        }

        $this->chargeModel->update($id, [
            'type_charge'   => $post['type_charge']   ?: null,
            'date_charge'   => $post['date_charge']   ?: null,
            'fournisseur'   => $post['fournisseur']   ?: null,
            'banque_poste'  => $post['banque_poste']  ?: null,
            'mode_paiement' => $mode,
            'designation'   => $post['designation']   ?: null,
            'montant_htva'  => !empty($post['montant_htva'])  ? (float)$post['montant_htva']  : null,
            'montant_tva'   => !empty($post['montant_tva'])   ? (float)$post['montant_tva']   : null,
            'montant_ttc'   => !empty($post['montant_ttc'])   ? (float)$post['montant_ttc']   : null,
            'montant_net'   => !empty($post['montant_net'])   ? (float)$post['montant_net']   : null,
            'id_employe'    => !empty($post['id_employe'])    ? (int)$post['id_employe']      : null,
            'remarque'      => $post['remarque']      ?: null,
        ]);

        return redirect()->to(base_url('ChargeDepense/charges_list'))
            ->with('success', 'Charge modifiée avec succès.');
    }

    // =========================================================
    // DELETE
    // URL: base_url() . "ChargeDepense/charges_supprimer/{id}"
    // =========================================================
    public function charges_supprimer($id)
    {
        if (!$this->chargeModel->find($id)) {
            return redirect()->to(base_url('ChargeDepense/charges_list'))
                ->with('error', 'Charge introuvable.');
        }

        $this->chargeModel->delete($id);

        return redirect()->to(base_url('ChargeDepense/charges_list'))
            ->with('success', 'Charge supprimée avec succès.');
    }

    // =========================================================
    // EXPORT PDF
    // URL: base_url() . "ChargeDepense/charges_export_pdf"
    // =========================================================
    public function charges_export_pdf()
    {
        $data = [
            'charges'     => $this->chargeModel->orderBy('date_charge', 'DESC')->findAll(),
            'employesMap' => $this->getEmployesMap(),
            'date_export' => date('d/m/Y H:i'),
        ];

        $html = view('ChargeDepense/charges_pdf', $data);

        $options = new \Dompdf\Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new \Dompdf\Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        $dompdf->stream('charges_' . date('Ymd') . '.pdf', ['Attachment' => true]);
        exit;
    }
}