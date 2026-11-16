<?php
/*
================================================
CONTROLLER: Employes
================================================
Gère toutes les opérations CRUD des employés
+ Export PDF via Dompdf
================================================
*/
namespace App\Controllers;

use App\Models\EmployeModel;

class Employes extends BaseController
{
    protected $employeModel;

    public function __construct()
    {
        $this->employeModel = new EmployeModel();
    }

    // ================================================
    // LIST
    // Route: GET /Employes/employe_list
    // View:  Employes/employe_list.php
    // ================================================
    public function employe_list()
    {
        return view('Employes/employe_list', [
            'title'    => 'Employés',
            'employes' => $this->employeModel->orderBy('nom', 'ASC')->findAll(),
        ]);
    }

    // ================================================
    // CREATE FORM
    // Route: GET /Employes/ajouter_form
    // View:  Employes/employe_form.php
    // ================================================
    public function ajouter_form()
    {
        return view('Employes/employe_form', [
            'title'    => 'Employés',
        ]);
    }

    // ================================================
    // CREATE - Traitement ajout
    // Route: POST /Employes/ajouter_employe
    // ================================================
    public function ajouter_employe()
    {
        $rules = [
            'nom'           => 'required|min_length[2]|max_length[100]',
            'prenom'        => 'required|min_length[2]|max_length[100]',
            'date_embauche' => 'required|valid_date',
            'salaire_base'  => 'required|decimal|greater_than[0]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                             ->withInput()
                             ->with('error', implode('<br>', $this->validator->getErrors()));
        }

        $data = [
            'nom'           => $this->request->getPost('nom'),
            'prenom'        => $this->request->getPost('prenom'),
            'poste'         => $this->request->getPost('poste'),
            'departement'   => $this->request->getPost('departement'),
            'date_embauche' => $this->request->getPost('date_embauche'),
            'type_contrat'  => $this->request->getPost('type_contrat'),
            'salaire_base'  => $this->request->getPost('salaire_base'),
            'email'         => $this->request->getPost('email'),
            'telephone'     => $this->request->getPost('telephone'),
            'statut'        => $this->request->getPost('statut') ?: 'actif',
        ];

        if ($this->employeModel->insert($data)) {
            return redirect()->to(site_url('Employes/employe_list'))
                             ->with('success', '✅ Employé ajouté avec succès !');
        }

        return redirect()->back()
                         ->withInput()
                         ->with('error', '❌ Erreur lors de l\'ajout.');
    }

    // ================================================
    // EDIT FORM
    // Route: GET /Employes/edit/{id}
    // View:  Employes/employe_form.php
    // ================================================
    public function edit($id = null)
    {
        $employe = $this->employeModel->find($id);

        if (!$employe) {
            return redirect()->to(site_url('Employes/employe_list'))
                             ->with('error', '❌ Employé introuvable.');
        }

        return view('Employes/employe_form', [
            'title'    => 'Employés',
            'employe' => $employe,
        ]);
    }

    // ================================================
    // UPDATE - Traitement modification
    // Route: POST /Employes/update/{id}
    // ================================================
    public function update($id = null)
    {
        $employe = $this->employeModel->find($id);

        if (!$employe) {
            return redirect()->to(site_url('Employes/employe_list'))
                             ->with('error', '❌ Employé introuvable.');
        }

        $rules = [
            'nom'           => 'required|min_length[2]|max_length[100]',
            'prenom'        => 'required|min_length[2]|max_length[100]',
            'date_embauche' => 'required|valid_date',
            'salaire_base'  => 'required|decimal|greater_than[0]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                             ->withInput()
                             ->with('error', implode('<br>', $this->validator->getErrors()));
        }

        $data = [
            'nom'           => $this->request->getPost('nom'),
            'prenom'        => $this->request->getPost('prenom'),
            'poste'         => $this->request->getPost('poste'),
            'departement'   => $this->request->getPost('departement'),
            'date_embauche' => $this->request->getPost('date_embauche'),
            'type_contrat'  => $this->request->getPost('type_contrat'),
            'salaire_base'  => $this->request->getPost('salaire_base'),
            'email'         => $this->request->getPost('email'),
            'telephone'     => $this->request->getPost('telephone'),
            'statut'        => $this->request->getPost('statut'),
        ];

        if ($this->employeModel->update($id, $data)) {
            return redirect()->to(site_url('Employes/employe_list'))
                             ->with('success', '✅ Employé modifié avec succès !');
        }

        return redirect()->back()
                         ->withInput()
                         ->with('error', '❌ Erreur lors de la modification.');
    }

    // ================================================
    // DELETE
    // Route: GET /Employes/supprimer/{id}
    // ================================================
    public function supprimer($id = null)
    {
        $employe = $this->employeModel->find($id);

        if (!$employe) {
            return redirect()->to(site_url('Employes/employe_list'))
                             ->with('error', '❌ Employé introuvable.');
        }

        if ($this->employeModel->delete($id)) {
            return redirect()->to(site_url('Employes/employe_list'))
                             ->with('success', '✅ Employé supprimé avec succès !');
        }

        return redirect()->to(site_url('Employes/employe_list'))
                         ->with('error', '❌ Erreur lors de la suppression.');
    }

    // ================================================
    // EXPORT PDF
    // Route: GET /Employes/export_employes_pdf
    // ================================================
    public function export_employes_pdf()
    {
        $html = view('Employes/employe_pdf', [
            'employes'    => $this->employeModel->orderBy('nom', 'ASC')->findAll(),
            'date_export' => date('d/m/Y à H:i'),
        ]);

        $options = new \Dompdf\Options();
        $options->set('defaultFont', 'DejaVu Sans');

        $dompdf = new \Dompdf\Dompdf($options);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->loadHtml($html);
        $dompdf->render();

        $dompdf->stream('employes_' . date('Ymd') . '.pdf', [
            'Attachment' => true
        ]);
    }
}