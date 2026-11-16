<?php
namespace App\Controllers;

use App\Models\EvaluationClientModel;
use App\Models\ClientCabinetModel;

class EvaluationClient extends BaseController
{
    protected $evaluationModel;
    protected $clientModel;

    public function __construct()
    {
        $this->evaluationModel = new EvaluationClientModel();
        $this->clientModel     = new ClientCabinetModel();
    }

    private function getClientsMap(): array
    {
        $map = [];
        foreach ($this->clientModel->findAll() as $c) {
            $map[$c['id_client']] = $c['nom_societe'];
        }
        return $map;
    }

    private function getPostData(): array
    {
        return [
            'id_client'                     => $this->request->getPost('id_client'),
            'anciennete_relation'            => $this->request->getPost('anciennete_relation'),
            'solvabilite'                    => $this->request->getPost('solvabilite'),
            'respect_echeances'              => $this->request->getPost('respect_echeances'),
            'delai_paiement'                 => $this->request->getPost('delai_paiement'),
            'litiges_paiement'               => $this->request->getPost('litiges_paiement'),
            'commentaire_financier'          => $this->request->getPost('commentaire_financier'),
            'nb_formations'                  => $this->request->getPost('nb_formations'),
            'nb_themes'                      => $this->request->getPost('nb_themes'),
            'budget_annuel'                  => $this->request->getPost('budget_annuel'),
            'recurrence'                     => $this->request->getPost('recurrence'),
            'qualite_communication'          => $this->request->getPost('qualite_communication'),
            'clarte_demandes'                => $this->request->getPost('clarte_demandes'),
            'respect_engagements'            => $this->request->getPost('respect_engagements'),
            'facilite_collaboration'         => $this->request->getPost('facilite_collaboration'),
            'potentiel_nouvelles_formations' => $this->request->getPost('potentiel_nouvelles_formations'),
            'ouverture_innovations'          => $this->request->getPost('ouverture_innovations'),
            'partenariat_long_terme'         => $this->request->getPost('partenariat_long_terme'),
            'client_strategique'             => $this->request->getPost('client_strategique') ? 1 : 0,
            'niveau_priorite'                => $this->request->getPost('niveau_priorite'),
            'decision_interne'               => $this->request->getPost('decision_interne'),
        ];
    }

    private function getRules(): array
    {
        return [
            'id_client'                     => 'required|integer',
            'anciennete_relation'            => 'required',
            'solvabilite'                    => 'required',
            'respect_echeances'              => 'required',
            'delai_paiement'                 => 'required',
            'litiges_paiement'               => 'required',
            'nb_formations'                  => 'required',
            'nb_themes'                      => 'required',
            'budget_annuel'                  => 'required',
            'recurrence'                     => 'required',
            'qualite_communication'          => 'required',
            'clarte_demandes'                => 'required',
            'respect_engagements'            => 'required',
            'facilite_collaboration'         => 'required',
            'potentiel_nouvelles_formations' => 'required',
            'ouverture_innovations'          => 'required',
            'partenariat_long_terme'         => 'required',
            'niveau_priorite'                => 'required',
            'decision_interne'               => 'required',
        ];
    }

    // ================================================
    // LIST
    // ================================================
    public function evaluation_list()
    {
        return view('EvaluationClient/evaluation_list', [
            'title'       => 'Évaluations Clients',
            'evaluations' => $this->evaluationModel->orderBy('id_evaluation', 'DESC')->findAll(),
            'clientsMap'  => $this->getClientsMap(),
        ]);
    }

    // ================================================
    // CREATE FORM
    // ================================================
    public function ajouter_evaluation_form()
    {
        return view('EvaluationClient/evaluation_form', [
            'title'   => 'Évaluations Clients',
            'clients' => $this->clientModel->orderBy('nom_societe', 'ASC')->findAll(),
        ]);
    }

    // ================================================
    // CREATE
    // ================================================
    public function ajouter_evaluation()
    {
        if (!$this->validate($this->getRules())) {
            return redirect()->back()
                             ->withInput()
                             ->with('errors', $this->validator->getErrors());
        }

        $data  = $this->getPostData();
        $newId = $this->evaluationModel->insert($data, true);

        if ($newId) {
            return redirect()->to(site_url('EvaluationClient/evaluation_list'))
                             ->with('success', '✅ Évaluation ajoutée avec succès !');
        }

        $err = $this->evaluationModel->db->error();
        return redirect()->back()
                         ->withInput()
                         ->with('error', '❌ Erreur lors de l\'ajout : ' . ($err['message'] ?? 'inconnue'));
    }

    // ================================================
    // EDIT FORM
    // ================================================
    public function modifier_evaluation($id = null)
    {
        $evaluation = $this->evaluationModel->find($id);

        if (!$evaluation) {
            return redirect()->to(site_url('EvaluationClient/evaluation_list'))
                             ->with('error', '❌ Évaluation introuvable.');
        }

        return view('EvaluationClient/evaluation_form', [
            'title'      => 'Évaluations Clients',
            'evaluation' => $evaluation,
            'clients'    => $this->clientModel->orderBy('nom_societe', 'ASC')->findAll(),
        ]);
    }

    // ================================================
    // UPDATE
    // ================================================
    public function update_evaluation($id = null)
    {
        $evaluation = $this->evaluationModel->find($id);

        if (!$evaluation) {
            return redirect()->to(site_url('EvaluationClient/evaluation_list'))
                             ->with('error', '❌ Évaluation introuvable.');
        }

        if (!$this->validate($this->getRules())) {
            return redirect()->back()
                             ->withInput()
                             ->with('errors', $this->validator->getErrors());
        }

        $data    = $this->getPostData();
        $updated = $this->evaluationModel->update($id, $data);

        if ($updated) {
            return redirect()->to(site_url('EvaluationClient/evaluation_list'))
                             ->with('success', '✅ Évaluation modifiée avec succès !');
        }

        $err = $this->evaluationModel->db->error();
        return redirect()->back()
                         ->withInput()
                         ->with('error', '❌ Erreur lors de la modification : ' . ($err['message'] ?? 'inconnue'));
    }

    // ================================================
    // DELETE
    // ================================================
    public function supprimer_evaluation($id = null)
    {
        $evaluation = $this->evaluationModel->find($id);

        if (!$evaluation) {
            return redirect()->to(site_url('EvaluationClient/evaluation_list'))
                             ->with('error', '❌ Évaluation introuvable.');
        }

        if ($this->evaluationModel->delete($id)) {
            return redirect()->to(site_url('EvaluationClient/evaluation_list'))
                             ->with('success', '✅ Évaluation supprimée avec succès !');
        }

        return redirect()->to(site_url('EvaluationClient/evaluation_list'))
                         ->with('error', '❌ Erreur lors de la suppression.');
    }

    // ================================================
    // EXPORT PDF
    // ================================================
    public function export_evaluations_pdf()
    {
        $html = view('EvaluationClient/evaluation_pdf', [
            'evaluations' => $this->evaluationModel->orderBy('id_evaluation', 'DESC')->findAll(),
            'clientsMap'  => $this->getClientsMap(),
            'date_export' => date('d/m/Y à H:i'),
        ]);

        $options = new \Dompdf\Options();
        $options->set('defaultFont', 'DejaVu Sans');

        $dompdf = new \Dompdf\Dompdf($options);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->loadHtml($html);
        $dompdf->render();

        $dompdf->stream('evaluations_' . date('Ymd') . '.pdf', ['Attachment' => true]);
    }
}