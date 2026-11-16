<?php
/*
================================================
CONTROLLER: Salaire
================================================
Gère toutes les opérations CRUD des salaires
+ Export PDF via Dompdf
================================================
*/
namespace App\Controllers;

use App\Models\SalaireModel;
use App\Models\EmployeModel; // ← adapte selon ton model employé

class Salaire extends BaseController
{
    protected $salaireModel;
    protected $employeModel;

    public function __construct()
    {
        $this->salaireModel = new SalaireModel();
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
    // Route: GET /Salaire/salaire_list
    // View:  Salaire/salaire_list.php
    // ================================================
    public function salaire_list()
    {
        return view('Salaire/salaire_list', [
            'title'   => 'Salaire',
            'salaires'    => $this->salaireModel->orderBy('annee', 'DESC')->orderBy('mois', 'DESC')->findAll(),
            'employesMap' => $this->getEmployesMap(),
        ]);
    }

    // ================================================
    // CREATE FORM
    // Route: GET /Salaire/ajouter_form
    // View:  Salaire/salaire_form.php
    // ================================================
    public function ajouter_form()
    {
        return view('Salaire/salaire_form', [
            'title'   => 'Salaire',
            'employes' => $this->employeModel->findAll(),
        ]);
    }

    // ================================================
    // CREATE - Traitement ajout
    // Route: POST /Salaire/ajouter
    // ================================================
    public function ajouter()
    {
        $rules = [
            'id_employe'   => 'required|integer',
            'mois'         => 'required|integer|greater_than[0]|less_than[13]',
            'annee'        => 'required|integer',
            'salaire_base' => 'required|numeric',
            'mode_paiement'=> 'required|in_list[virement,cash,cheque]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                             ->withInput()
                             ->with('error', implode('<br>', $this->validator->getErrors()));
        }

        $data = [
            'id_employe'    => $this->request->getPost('id_employe'),
            'mois'          => $this->request->getPost('mois'),
            'annee'         => $this->request->getPost('annee'),
            'salaire_base'  => $this->request->getPost('salaire_base'),
            'prime'         => $this->request->getPost('prime') ?: 0,
            'salaire_brut'  => $this->request->getPost('salaire_brut'),
            'deduction'     => $this->request->getPost('deduction') ?: 0,
            'salaire_net'   => $this->request->getPost('salaire_net'),
            'mode_paiement' => $this->request->getPost('mode_paiement'),
            'date_paiement' => $this->request->getPost('date_paiement') ?: null,
            'remarque'      => $this->request->getPost('remarque'),
        ];

        if ($this->salaireModel->insert($data)) {
            return redirect()->to(site_url('Salaire/salaire_list'))
                             ->with('success', '✅ Salaire ajouté avec succès !');
        }

        return redirect()->back()
                         ->withInput()
                         ->with('error', '❌ Erreur lors de l\'ajout.');
    }

    // ================================================
    // EDIT FORM
    // Route: GET /Salaire/edit_form/{id}
    // View:  Salaire/salaire_form.php
    // ================================================
    public function edit_form($id = null)
    {
        $salaire = $this->salaireModel->find($id);

        if (!$salaire) {
            return redirect()->to(site_url('Salaire/salaire_list'))
                             ->with('error', '❌ Salaire introuvable.');
        }

        return view('Salaire/salaire_form', [
            'title'   => 'Salaire',
            'salaire'  => $salaire, // ← clé utilisée dans la view
            'employes' => $this->employeModel->findAll(),
        ]);
    }

    // ================================================
    // UPDATE - Traitement modification
    // Route: POST /Salaire/update/{id}
    // ================================================
    public function update($id = null)
    {
        $salaire = $this->salaireModel->find($id);

        if (!$salaire) {
            return redirect()->to(site_url('Salaire/salaire_list'))
                             ->with('error', '❌ Salaire introuvable.');
        }

        $rules = [
            'id_employe'   => 'required|integer',
            'mois'         => 'required|integer|greater_than[0]|less_than[13]',
            'annee'        => 'required|integer',
            'salaire_base' => 'required|numeric',
            'mode_paiement'=> 'required|in_list[virement,cash,cheque]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                             ->withInput()
                             ->with('error', implode('<br>', $this->validator->getErrors()));
        }

        $data = [
            'id_employe'    => $this->request->getPost('id_employe'),
            'mois'          => $this->request->getPost('mois'),
            'annee'         => $this->request->getPost('annee'),
            'salaire_base'  => $this->request->getPost('salaire_base'),
            'prime'         => $this->request->getPost('prime') ?: 0,
            'salaire_brut'  => $this->request->getPost('salaire_brut'),
            'deduction'     => $this->request->getPost('deduction') ?: 0,
            'salaire_net'   => $this->request->getPost('salaire_net'),
            'mode_paiement' => $this->request->getPost('mode_paiement'),
            'date_paiement' => $this->request->getPost('date_paiement') ?: null,
            'remarque'      => $this->request->getPost('remarque'),
        ];

        if ($this->salaireModel->update($id, $data)) {
            return redirect()->to(site_url('Salaire/salaire_list'))
                             ->with('success', '✅ Salaire modifié avec succès !');
        }

        return redirect()->back()
                         ->withInput()
                         ->with('error', '❌ Erreur lors de la modification.');
    }

    // ================================================
    // DELETE
    // Route: GET /Salaire/supprimer/{id}
    // ================================================
    public function supprimer($id = null)
    {
        $salaire = $this->salaireModel->find($id);

        if (!$salaire) {
            return redirect()->to(site_url('Salaire/salaire_list'))
                             ->with('error', '❌ Salaire introuvable.');
        }

        if ($this->salaireModel->delete($id)) {
            return redirect()->to(site_url('Salaire/salaire_list'))
                             ->with('success', '✅ Salaire supprimé avec succès !');
        }

        return redirect()->to(site_url('Salaire/salaire_list'))
                         ->with('error', '❌ Erreur lors de la suppression.');
    }

    // ================================================
    // EXPORT PDF
    // Route: GET /Salaire/export_pdf
    // ================================================
    public function export_pdf()
    {
        $html = view('Salaire/salaire_pdf', [
            'salaires'    => $this->salaireModel->orderBy('annee', 'DESC')->orderBy('mois', 'DESC')->findAll(),
            'employesMap' => $this->getEmployesMap(),
            'date_export' => date('d/m/Y à H:i'),
        ]);

        $options = new \Dompdf\Options();
        $options->set('defaultFont', 'DejaVu Sans');

        $dompdf = new \Dompdf\Dompdf($options);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->loadHtml($html);
        $dompdf->render();

        $dompdf->stream('salaires_' . date('Ymd') . '.pdf', [
            'Attachment' => true
        ]);
    }
}