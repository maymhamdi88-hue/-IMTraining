<?php

namespace App\Controllers;

use App\Models\ActiviteModel;
use App\Models\FormateurModel;
use App\Models\ClientCabinetModel;
use Dompdf\Dompdf;
use Dompdf\Options;

class Operations extends BaseController
{
    protected $activiteModel;
    protected $formateurModel;
    protected $clientModel;

    public function __construct()
    {
        $this->activiteModel  = new ActiviteModel();
        $this->formateurModel = new FormateurModel();
        $this->clientModel    = new ClientCabinetModel();
    }

    private function getMaps(): array
    {
        $formateurs    = $this->formateurModel->findAll();
        $clients       = $this->clientModel->findAll();
        $formateursMap = array_column($formateurs, 'nom_prenom',  'id_formateur');
        $clientsMap    = array_column($clients,    'nom_societe', 'id_client');

        return [
            'formateurs'    => $formateurs,
            'clients'       => $clients,
            'formateursMap' => $formateursMap,
            'clientsMap'    => $clientsMap,
        ];
    }

    // ── LIST ──────────────────────────────────────────────
    public function prestation_list()
    {
        $data = array_merge($this->getMaps(), [
            'activites' => $this->activiteModel->findAll(),
            'title'     => 'Prestation',
        ]);
        return view('Operations/prestation_list', $data);
    }

    // ── CREATE FORM ───────────────────────────────────────
    public function ajouter_form()
    {
        $data          = $this->getMaps();
        $data['title'] = 'Prestation';
        return view('Operations/prestation_form', $data);
    }

    // ── CREATE ────────────────────────────────────────────
    public function ajouter()
    {
        $rules = [
            'type_activite' => 'required',
            'id_formateur'  => 'required|integer',
            'id_client'     => 'required|integer',
            'theme_domaine' => 'required|max_length[150]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('error', implode('<br>', $this->validator->getErrors()));
        }

        $this->activiteModel->insert($this->_postData());

        return redirect()->to(site_url('Operations/prestation_list'))
            ->with('success', 'Prestation ajoutée avec succès !');
    }

    // ── EDIT FORM ─────────────────────────────────────────
    public function modifier($id = null)
    {
        $activite = $this->activiteModel->find($id);
        if (!$activite) {
            return redirect()->to(site_url('Operations/prestation_list'))
                ->with('error', 'Prestation introuvable.');
        }

        $data             = $this->getMaps();
        $data['title']    = 'Prestation';
        $data['activite'] = $activite;
        return view('Operations/prestation_form', $data);
    }

    // ── UPDATE ────────────────────────────────────────────
    public function update($id = null)
    {
        if (!$this->activiteModel->find($id)) {
            return redirect()->to(site_url('Operations/prestation_list'))
                ->with('error', 'Prestation introuvable.');
        }

        $rules = [
            'type_activite' => 'required',
            'id_formateur'  => 'required|integer',
            'id_client'     => 'required|integer',
            'theme_domaine' => 'required|max_length[150]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('error', implode('<br>', $this->validator->getErrors()));
        }

        $this->activiteModel->update($id, $this->_postData());

        return redirect()->to(site_url('Operations/prestation_list'))
            ->with('success', 'Prestation modifiée avec succès !');
    }

    // ── DELETE ────────────────────────────────────────────
    public function supprimer($id = null)
    {
        if (!$this->activiteModel->find($id)) {
            return redirect()->to(site_url('Operations/prestation_list'))
                ->with('error', 'Prestation introuvable.');
        }

        $this->activiteModel->delete($id);

        return redirect()->to(site_url('Operations/prestation_list'))
            ->with('success', 'Prestation supprimée avec succès !');
    }

    // ── EXPORT PDF ────────────────────────────────────────
    public function export_pdf()
    {
        // Vérification dompdf installé
        if (!class_exists('\Dompdf\Dompdf')) {
            die('dompdf non installé. Lance: composer require dompdf/dompdf');
        }

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', false);
        $options->set('defaultFont', 'DejaVu Sans');

        $dompdf = new Dompdf($options);
        $dompdf->setPaper('A4', 'landscape');

        $maps = $this->getMaps();
        $data = [
            'activites'     => $this->activiteModel->findAll(),
            'formateursMap' => $maps['formateursMap'],
            'clientsMap'    => $maps['clientsMap'],
            'date_export'   => date('d/m/Y H:i'),
        ];

        $html = view('Operations/prestation_pdf', $data);

        // Nettoyer tout output parasite
        if (ob_get_length()) ob_end_clean();

        $dompdf->loadHtml($html, 'UTF-8');
        $dompdf->render();
        $dompdf->stream('prestations_' . date('Ymd') . '.pdf', ['Attachment' => true]);
        exit; // fin export
    }

    // ── HELPER PRIVÉ ─────────────────────────────────────
    private function _postData(): array
    {
        return [
            'type_activite'       => $this->request->getPost('type_activite'),
            'reference'           => $this->request->getPost('reference'),
            'id_formateur'        => $this->request->getPost('id_formateur'),
            'id_client'           => $this->request->getPost('id_client'),
            'theme_domaine'       => $this->request->getPost('theme_domaine'),
            'objectif'            => $this->request->getPost('objectif'),
            'date_debut'          => $this->request->getPost('date_debut') ?: null,
            'date_fin'            => $this->request->getPost('date_fin')   ?: null,
            'date_prestation'     => $this->request->getPost('date_prestation'),
            'lieu'                => $this->request->getPost('lieu'),
            'nombre_participants' => $this->request->getPost('nombre_participants') ?: null,
            'statut'              => $this->request->getPost('statut'),
            'remarque'            => $this->request->getPost('remarque'),
        ];
    }
}