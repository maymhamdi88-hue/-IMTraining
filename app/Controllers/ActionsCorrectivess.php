<?php
/*
Gère toutes les opérations CRUD des actions correctives
+ Export PDF via Dompdf
+ Relation avec SuiviNonConformite (causesMap)

*/
namespace App\Controllers;

use App\Models\ActionCorrectiveModel;
use App\Models\SuiviNonConformiteModel;

class ActionsCorrectivess extends BaseController
{
    protected $actionModel;
    protected $suiviModel;

    public function __construct()
    {
        $this->actionModel = new ActionCorrectiveModel();
        $this->suiviModel  = new SuiviNonConformiteModel();
    }

    // ================================================
    // MÉTHODE PRIVÉE: Map [id_suivi => 'causes_probables']
    // ================================================
    private function getCausesMap(): array
    {
        $causesMap = [];
        foreach ($this->suiviModel->findAll() as $s) {
            $causesMap[$s['id_suivi']] = $s['causes_probables'];
        }
        return $causesMap;
    }

    // ================================================
    // LIST
    // Route: GET /ActionsCorrectivess/actions_list
    // View:  ActionsCorrectivess/actions_list.php
    // ================================================
    public function actions_list()
    {
        return view('ActionsCorrectivess/actions_list', [
            'title'     => 'Actions Correctives',
            'actions'   => $this->actionModel->orderBy('date_prevue', 'DESC')->findAll(),
            'causesMap' => $this->getCausesMap(),
        ]);
    }

    // ================================================
    // CREATE FORM
    // Route: GET /ActionsCorrectivess/ajouter_action_form
    // View:  ActionsCorrectivess/actions_form.php
    // ================================================
    public function ajouter_action_form()
    {
        return view('ActionsCorrectivess/actions_form', [
            'title'     => 'Actions Correctives',
            'suivis' => $this->suiviModel->findAll(),
        ]);
    }

    // ================================================
    // CREATE - Traitement ajout
    // Route: POST /ActionsCorrectivess/ajouter_action
    // ================================================
    public function ajouter_action()
    {
        $rules = [
            'id_suivi'          => 'required|integer',
            'action_corrective' => 'required',
            'responsable_action'=> 'required|min_length[2]|max_length[150]',
            'date_prevue'       => 'required|valid_date',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                             ->withInput()
                             ->with('error', implode('<br>', $this->validator->getErrors()));
        }

        $data = [
            'id_suivi'                => $this->request->getPost('id_suivi'),
            'action_corrective'       => $this->request->getPost('action_corrective'),
            'responsable_action'      => $this->request->getPost('responsable_action'),
            'date_prevue'             => $this->request->getPost('date_prevue'),
            'date_realisation'        => $this->request->getPost('date_realisation')   ?: null,
            'date_verification'       => $this->request->getPost('date_verification')  ?: null,
            'decision'                => $this->request->getPost('decision')            ?: null,
            'responsable_verification'=> $this->request->getPost('responsable_verification'),
        ];

        if ($this->actionModel->insert($data)) {
            return redirect()->to(site_url('ActionsCorrectivess/actions_list'))
                             ->with('success', '✅ Action corrective ajoutée avec succès !');
        }

        return redirect()->back()
                         ->withInput()
                         ->with('error', '❌ Erreur lors de l\'ajout.');
    }

    // ================================================
    // EDIT FORM
    // Route: GET /ActionsCorrectivess/modifier_action/{id}
    // View:  ActionsCorrectivess/actions_form.php
    // ================================================
    public function modifier_action($id = null)
    {
        $action = $this->actionModel->find($id);

        if (!$action) {
            return redirect()->to(site_url('ActionsCorrectivess/actions_list'))
                             ->with('error', '❌ Action introuvable.');
        }

        return view('ActionsCorrectivess/actions_form', [
            'title'     => 'Actions Correctives',
            'action_edit' => $action,
            'suivis'      => $this->suiviModel->findAll(),
        ]);
    }

    // ================================================
    // UPDATE - Traitement modification
    // Route: POST /ActionsCorrectivess/update_action/{id}
    // ================================================
    public function update_action($id = null)
    {
        $action = $this->actionModel->find($id);

        if (!$action) {
            return redirect()->to(site_url('ActionsCorrectivess/actions_list'))
                             ->with('error', '❌ Action introuvable.');
        }

        $rules = [
            'id_suivi'          => 'required|integer',
            'action_corrective' => 'required',
            'responsable_action'=> 'required|min_length[2]|max_length[150]',
            'date_prevue'       => 'required|valid_date',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                             ->withInput()
                             ->with('error', implode('<br>', $this->validator->getErrors()));
        }

        $data = [
            'id_suivi'                => $this->request->getPost('id_suivi'),
            'action_corrective'       => $this->request->getPost('action_corrective'),
            'responsable_action'      => $this->request->getPost('responsable_action'),
            'date_prevue'             => $this->request->getPost('date_prevue'),
            'date_realisation'        => $this->request->getPost('date_realisation')   ?: null,
            'date_verification'       => $this->request->getPost('date_verification')  ?: null,
            'decision'                => $this->request->getPost('decision')            ?: null,
            'responsable_verification'=> $this->request->getPost('responsable_verification'),
        ];

        if ($this->actionModel->update($id, $data)) {
            return redirect()->to(site_url('ActionsCorrectivess/actions_list'))
                             ->with('success', '✅ Action corrective modifiée avec succès !');
        }

        return redirect()->back()
                         ->withInput()
                         ->with('error', '❌ Erreur lors de la modification.');
    }

    // ================================================
    // DELETE
    // Route: GET /ActionsCorrectivess/supprimer_action/{id}
    // ================================================
    public function supprimer_action($id = null)
    {
        $action = $this->actionModel->find($id);

        if (!$action) {
            return redirect()->to(site_url('ActionsCorrectivess/actions_list'))
                             ->with('error', '❌ Action introuvable.');
        }

        if ($this->actionModel->delete($id)) {
            return redirect()->to(site_url('ActionsCorrectivess/actions_list'))
                             ->with('success', '✅ Action corrective supprimée avec succès !');
        }

        return redirect()->to(site_url('ActionsCorrectivess/actions_list'))
                         ->with('error', '❌ Erreur lors de la suppression.');
    }

    // ================================================
    // EXPORT PDF
    // Route: GET /ActionsCorrectivess/export_actions_pdf
    // ================================================
    public function export_actions_pdf()
    {
        $html = view('ActionsCorrectivess/actions_pdf', [
            'actions'     => $this->actionModel->orderBy('date_prevue', 'DESC')->findAll(),
            'causesMap'   => $this->getCausesMap(),
            'date_export' => date('d/m/Y à H:i'),
        ]);

        $options = new \Dompdf\Options();
        $options->set('defaultFont', 'DejaVu Sans');

        $dompdf = new \Dompdf\Dompdf($options);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->loadHtml($html);
        $dompdf->render();

        $dompdf->stream('actions_correctives_' . date('Ymd') . '.pdf', [
            'Attachment' => true
        ]);
    }
}