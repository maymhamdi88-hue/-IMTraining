<?php

namespace App\Controllers;

use App\Models\EvaluationFormateurModel;
use App\Models\FormateurModel;
use App\Models\ActiviteModel;
use App\Models\ClientCabinetModel;
use Dompdf\Dompdf;
use Dompdf\Options;

class EvaluationFormateur extends BaseController
{
    protected $evalModel;
    protected $formateurModel;
    protected $activiteModel;
    protected $clientModel;

    public function __construct()
    {
        $this->evalModel      = new EvaluationFormateurModel();
        $this->formateurModel = new FormateurModel();
        $this->activiteModel  = new ActiviteModel();
        $this->clientModel    = new ClientCabinetModel();
    }

    // ── HELPER MAPS ───────────────────────────────────────
    private function getMaps(): array
    {
        $formateursMap = array_column($this->formateurModel->findAll(), 'nom_prenom',  'id_formateur');
        $clientsMap    = array_column($this->clientModel->findAll(),    'nom_societe', 'id_client');

        $activitesMap = [];
        foreach ($this->activiteModel->findAll() as $a) {
            $activitesMap[$a['id_activite']] = $a['type_activite'] . ' - ' . ($a['theme_domaine'] ?? '');
        }

        return compact('formateursMap', 'activitesMap', 'clientsMap');
    }

    // ── LIST ──────────────────────────────────────────────
    public function evaluation_list()
    {
        $maps = $this->getMaps();
        return view('EvaluationFormateur/evaluation_list', [
            'title'         => 'Évaluation formateur',
            'evaluations'   => $this->evalModel->orderBy('date_evaluation', 'DESC')->findAll(),
            'formateursMap' => $maps['formateursMap'],
            'activitesMap'  => $maps['activitesMap'],
            'clientsMap'    => $maps['clientsMap'],
        ]);
    }

    // ── CREATE FORM ───────────────────────────────────────
    public function ajouter_form()
    {
        return view('EvaluationFormateur/evaluation_form', [
            'title'      => 'Évaluation formateur',
            'formateurs' => $this->formateurModel->findAll(),
            'activites'  => $this->activiteModel->findAll(),
            'clients'    => $this->clientModel->findAll(),
        ]);
    }

    // ── CREATE ────────────────────────────────────────────
    public function ajouter()
    {
        $rules = [
            'id_formateur' => 'required|integer',
            'id_activite'  => 'required|integer',
            'score_global' => 'required|numeric',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('error', implode('<br>', $this->validator->getErrors()));
        }

        $this->evalModel->insert($this->_postData());

        return redirect()->to(site_url('EvaluationFormateur/evaluation_list'))
            ->with('success', 'Évaluation ajoutée avec succès !');
    }

    // ── EDIT FORM ─────────────────────────────────────────
    public function edit_form($id = null)
    {
        $evaluation = $this->evalModel->find($id);
        if (!$evaluation) {
            return redirect()->to(site_url('EvaluationFormateur/evaluation_list'))
                ->with('error', 'Évaluation introuvable.');
        }

        return view('EvaluationFormateur/evaluation_form', [
            'title'           => 'Évaluation formateur',
            'evaluation_edit' => $evaluation,
            'formateurs'      => $this->formateurModel->findAll(),
            'activites'       => $this->activiteModel->findAll(),
            'clients'         => $this->clientModel->findAll(),
        ]);
    }

    // ── UPDATE ────────────────────────────────────────────
    public function update($id = null)
    {
        if (!$this->evalModel->find($id)) {
            return redirect()->to(site_url('EvaluationFormateur/evaluation_list'))
                ->with('error', 'Évaluation introuvable.');
        }

        $rules = [
            'id_formateur' => 'required|integer',
            'id_activite'  => 'required|integer',
            'score_global' => 'required|numeric',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('error', implode('<br>', $this->validator->getErrors()));
        }

        // On ne touche pas date_evaluation lors d'un update
        $data = $this->_postData();
        unset($data['date_evaluation']);

        $this->evalModel->update($id, $data);

        return redirect()->to(site_url('EvaluationFormateur/evaluation_list'))
            ->with('success', 'Évaluation modifiée avec succès !');
    }

    // ── DELETE ────────────────────────────────────────────
    public function supprimer($id = null)
    {
        if (!$this->evalModel->find($id)) {
            return redirect()->to(site_url('EvaluationFormateur/evaluation_list'))
                ->with('error', 'Évaluation introuvable.');
        }

        $this->evalModel->delete($id);

        return redirect()->to(site_url('EvaluationFormateur/evaluation_list'))
            ->with('success', 'Évaluation supprimée avec succès !');
    }

    // ── EXPORT PDF ────────────────────────────────────────
    public function export_pdf()
    {
        $maps = $this->getMaps();

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', false);
        $options->set('defaultFont', 'DejaVu Sans');

        $dompdf = new Dompdf($options);
        $dompdf->setPaper('A4', 'landscape');

        $html = view('EvaluationFormateur/evaluation_pdf', [
            'evaluations'   => $this->evalModel->orderBy('date_evaluation', 'DESC')->findAll(),
            'formateursMap' => $maps['formateursMap'],
            'activitesMap'  => $maps['activitesMap'],
            'clientsMap'    => $maps['clientsMap'],
            'date_export'   => date('d/m/Y H:i'),
        ]);

        if (ob_get_length()) ob_end_clean();

        $dompdf->loadHtml($html, 'UTF-8');
        $dompdf->render();
        $dompdf->stream('evaluations_' . date('Ymd') . '.pdf', ['Attachment' => true]);
        exit;
    }

    // ── HELPER POST DATA ──────────────────────────────────
    private function _postData(): array
    {
        return [
            'id_formateur'                      => $this->request->getPost('id_formateur'),
            'id_activite'                       => $this->request->getPost('id_activite'),
            'id_client'                         => $this->request->getPost('id_client') ?: null,
            'date_evaluation'                   => date('Y-m-d'),
            'pedagogie_methodes'                => $this->request->getPost('pedagogie_methodes') ?: null,
            'maitrise_technique'                => $this->request->getPost('maitrise_technique') ?: null,
            'posture_soft_skills'               => $this->request->getPost('posture_soft_skills') ?: null,
            'facilite_collaboration'            => $this->request->getPost('facilite_collaboration') ?: null,
            'dossier_administratif_ponctualite' => $this->request->getPost('dossier_administratif_ponctualite') ?: null,
            'flexibilite_delais_paiement'       => $this->request->getPost('flexibilite_delais_paiement') ?: null,
            'score_global'                      => $this->request->getPost('score_global'),
            'remarque'                          => $this->request->getPost('remarque'),
        ];
    }
}