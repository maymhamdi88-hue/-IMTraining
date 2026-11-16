<?php
/*
================================================
CONTROLLER: Conge
================================================
Gère toutes les opérations CRUD des congés
+ Export PDF via Dompdf
================================================
*/
namespace App\Controllers;

use App\Models\CongeModel;
use App\Models\EmployeModel;

class Conge extends BaseController
{
    protected $congeModel;
    protected $employeModel;

    public function __construct()
    {
        $this->congeModel  = new CongeModel();
        $this->employeModel = new EmployeModel();
    }

    // ================================================
    // MÉTHODE PRIVÉE: Map [id_employe => 'Nom Prénom']
    // ================================================
    private function getEmployesMap(): array
    {
        $employesMap = [];
        foreach ($this->employeModel->findAll() as $e) {
            $employesMap[$e['id_employe']] = $e['nom'] . ' ' . $e['prenom'];
        }
        return $employesMap;
    }

    // ================================================
    // LIST
    // Route: GET /Conge/conge_list
    // View:  Conges/conge_list.php
    // ================================================
    public function conge_list()
    {
        return view('Conges/conge_list', [
            'title'       => 'Congés',
            'conges'      => $this->congeModel->orderBy('date_debut', 'DESC')->findAll(),
            'employesMap' => $this->getEmployesMap(),
        ]);
    }

    // ================================================
    // CREATE FORM
    // Route: GET /Conge/ajouter_form
    // View:  Conges/conge_form.php
    // ================================================
    public function ajouter_form()
    {
        return view('Conges/conge_form', [
            'title'       => 'Congés',
            'employes' => $this->employeModel->findAll(),
        ]);
    }

    // ================================================
    // CREATE - Traitement ajout
    // Route: POST /Conge/ajouter
    // ================================================
    public function ajouter()
    {
        $rules = [
            'id_employe'  => 'required|integer',
            'type_conge'  => 'required|in_list[annuel,maladie,sans_solde]',
            'date_debut'  => 'required|valid_date',
            'nombre_jours'=> 'required|integer|greater_than[0]',
            'statut'      => 'required|in_list[en_attente,accepte,refuse]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                             ->withInput()
                             ->with('error', implode('<br>', $this->validator->getErrors()));
        }

        $data = [
            'id_employe'   => $this->request->getPost('id_employe'),
            'type_conge'   => $this->request->getPost('type_conge'),
            'date_debut'   => $this->request->getPost('date_debut'),
            'date_fin'     => $this->request->getPost('date_fin') ?: null,
            'nombre_jours' => $this->request->getPost('nombre_jours'),
            'statut'       => $this->request->getPost('statut'),
            'motif'        => $this->request->getPost('motif'),
            'date_demande' => $this->request->getPost('date_demande') ?: null,
        ];

        if ($this->congeModel->insert($data)) {
            return redirect()->to(site_url('Conge/conge_list'))
                             ->with('success', '✅ Congé ajouté avec succès !');
        }

        return redirect()->back()
                         ->withInput()
                         ->with('error', '❌ Erreur lors de l\'ajout.');
    }

    // ================================================
    // EDIT FORM
    // Route: GET /Conge/edit_form/{id}
    // View:  Conges/conge_form.php
    // ================================================
    public function edit_form($id = null)
    {
        $conge = $this->congeModel->find($id);

        if (!$conge) {
            return redirect()->to(site_url('Conge/conge_list'))
                             ->with('error', '❌ Congé introuvable.');
        }

        return view('Conges/conge_form', [
            'title'       => 'Congés',
            'conge'    => $conge, // ← clé utilisée dans la view
            'employes' => $this->employeModel->findAll(),
        ]);
    }

    // ================================================
    // UPDATE - Traitement modification
    // Route: POST /Conge/update/{id}
    // ================================================
    public function update($id = null)
    {
        $conge = $this->congeModel->find($id);

        if (!$conge) {
            return redirect()->to(site_url('Conge/conge_list'))
                             ->with('error', '❌ Congé introuvable.');
        }

        $rules = [
            'id_employe'  => 'required|integer',
            'type_conge'  => 'required|in_list[annuel,maladie,sans_solde]',
            'date_debut'  => 'required|valid_date',
            'nombre_jours'=> 'required|integer|greater_than[0]',
            'statut'      => 'required|in_list[en_attente,accepte,refuse]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                             ->withInput()
                             ->with('error', implode('<br>', $this->validator->getErrors()));
        }

        $data = [
            'id_employe'   => $this->request->getPost('id_employe'),
            'type_conge'   => $this->request->getPost('type_conge'),
            'date_debut'   => $this->request->getPost('date_debut'),
            'date_fin'     => $this->request->getPost('date_fin') ?: null,
            'nombre_jours' => $this->request->getPost('nombre_jours'),
            'statut'       => $this->request->getPost('statut'),
            'motif'        => $this->request->getPost('motif'),
            'date_demande' => $this->request->getPost('date_demande') ?: null,
        ];

        if ($this->congeModel->update($id, $data)) {
            return redirect()->to(site_url('Conge/conge_list'))
                             ->with('success', '✅ Congé modifié avec succès !');
        }

        return redirect()->back()
                         ->withInput()
                         ->with('error', '❌ Erreur lors de la modification.');
    }

    // ================================================
    // DELETE
    // Route: GET /Conge/supprimer/{id}
    // ================================================
    public function supprimer($id = null)
    {
        $conge = $this->congeModel->find($id);

        if (!$conge) {
            return redirect()->to(site_url('Conge/conge_list'))
                             ->with('error', '❌ Congé introuvable.');
        }

        if ($this->congeModel->delete($id)) {
            return redirect()->to(site_url('Conge/conge_list'))
                             ->with('success', '✅ Congé supprimé avec succès !');
        }

        return redirect()->to(site_url('Conge/conge_list'))
                         ->with('error', '❌ Erreur lors de la suppression.');
    }

    // ================================================
    // EXPORT PDF
    // Route: GET /Conge/export_pdf
    // ================================================
    public function export_pdf()
    {
        $html = view('Conges/conge_pdf', [
            'conges'      => $this->congeModel->orderBy('date_debut', 'DESC')->findAll(),
            'employesMap' => $this->getEmployesMap(),
            'date_export' => date('d/m/Y à H:i'),
        ]);

        $options = new \Dompdf\Options();
        $options->set('defaultFont', 'DejaVu Sans');

        $dompdf = new \Dompdf\Dompdf($options);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->loadHtml($html);
        $dompdf->render();

        $dompdf->stream('conges_' . date('Ymd') . '.pdf', [
            'Attachment' => true
        ]);
    }
}