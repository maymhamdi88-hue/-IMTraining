<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AttestationModel;
use App\Models\ClientCabinetModel;

class EtatAttestation extends BaseController
{
    protected $attestationModel;
    protected $clientModel;

    public function __construct()
    {
        $this->attestationModel = new AttestationModel();
        $this->clientModel      = new ClientCabinetModel();
    }

    // =========================================================
    // HELPER PRIVÉ
    // =========================================================
    private function getClientsMap(): array
    {
        $clients = $this->clientModel->findAll();
        $map = [];
        foreach ($clients as $c) {
            $map[$c['id_client']] = $c['nom_societe'];
        }
        return $map;
    }

    // =========================================================
    // LISTE
    // URL: base_url() . "EtatAttestation/attestations_list"
    // =========================================================
    public function attestations_list()
    {
        $data = [
            'title'    => 'États Attestations',
            'rows'       => $this->attestationModel->findAll(),
            'clientsMap' => $this->getClientsMap(),
        ];

        return view('EtatAttestation/attestations_list', $data);
    }

    // =========================================================
    // FORMULAIRE AJOUT
    // URL: base_url() . "EtatAttestation/attestations_ajouter_form"
    // =========================================================
    public function attestations_ajouter_form()
    {
        $data = [
            'title'    => 'États Attestations',
            'clients' => $this->clientModel->findAll(),
        ];

        return view('EtatAttestation/attestations_form', $data);
    }

    // =========================================================
    // STORE (POST)
    // URL: base_url() . "EtatAttestation/attestations_store"
    // =========================================================
    public function attestations_store()
    {
        if (!$this->validate(['id_client' => 'required|integer'])) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', implode('<br>', $this->validator->getErrors()));
        }

        $this->attestationModel->insert([
            'id_client'        => $this->request->getPost('id_client'),
            'mode'             => $this->request->getPost('mode'),
            'num_action'       => $this->request->getPost('num_action'),
            'theme'            => $this->request->getPost('theme'),
            'date_preparation' => $this->request->getPost('date_preparation') ?: null,
            'date_tirage'      => $this->request->getPost('date_tirage')      ?: null,
            'date_remise'      => $this->request->getPost('date_remise')      ?: null,
        ]);

        return redirect()
            ->to(base_url('EtatAttestation/attestations_list'))
            ->with('success', 'Attestation ajoutée avec succès.');
    }

    // =========================================================
    // FORMULAIRE MODIFICATION
    // URL: base_url() . "EtatAttestation/attestations_modifier_form/{id}"
    // =========================================================
    public function attestations_modifier_form($id)
    {
        $attestation = $this->attestationModel->find($id);

        if (!$attestation) {
            return redirect()
                ->to(base_url('EtatAttestation/attestations_list'))
                ->with('error', 'Attestation introuvable.');
        }

        $data = [
            'title'    => 'États Attestations',
            'attestation' => $attestation,
            'clients'     => $this->clientModel->findAll(),
        ];

        return view('EtatAttestation/attestations_form', $data);
    }

    // =========================================================
    // UPDATE (POST)
    // URL: base_url() . "EtatAttestation/attestations_update/{id}"
    // =========================================================
    public function attestations_update($id)
    {
        if (!$this->attestationModel->find($id)) {
            return redirect()
                ->to(base_url('EtatAttestation/attestations_list'))
                ->with('error', 'Attestation introuvable.');
        }

        if (!$this->validate(['id_client' => 'required|integer'])) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', implode('<br>', $this->validator->getErrors()));
        }

        $this->attestationModel->update($id, [
            'id_client'        => $this->request->getPost('id_client'),
            'mode'             => $this->request->getPost('mode'),
            'num_action'       => $this->request->getPost('num_action'),
            'theme'            => $this->request->getPost('theme'),
            'date_preparation' => $this->request->getPost('date_preparation') ?: null,
            'date_tirage'      => $this->request->getPost('date_tirage')      ?: null,
            'date_remise'      => $this->request->getPost('date_remise')      ?: null,
        ]);

        return redirect()
            ->to(base_url('EtatAttestation/attestations_list'))
            ->with('success', 'Attestation modifiée avec succès.');
    }

    // =========================================================
    // DELETE
    // URL: base_url() . "EtatAttestation/attestations_supprimer/{id}"
    // =========================================================
    public function attestations_supprimer($id)
    {
        if (!$this->attestationModel->find($id)) {
            return redirect()
                ->to(base_url('EtatAttestation/attestations_list'))
                ->with('error', 'Attestation introuvable.');
        }

        $this->attestationModel->delete($id);

        return redirect()
            ->to(base_url('EtatAttestation/attestations_list'))
            ->with('success', 'Attestation supprimée avec succès.');
    }

    // =========================================================
    // EXPORT PDF
    // URL: base_url() . "EtatAttestation/attestations_export_pdf"
    // =========================================================
    public function attestations_export_pdf()
    {
        $data = [
            'attestations' => $this->attestationModel->findAll(),
            'clientsMap'   => $this->getClientsMap(),
            'date_export'  => date('d/m/Y H:i'),
        ];

        $html = view('EtatAttestation/attestations_pdf', $data);

        $options = new \Dompdf\Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new \Dompdf\Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $dompdf->stream('attestations_' . date('Ymd') . '.pdf', ['Attachment' => true]);
        exit;
    }
}