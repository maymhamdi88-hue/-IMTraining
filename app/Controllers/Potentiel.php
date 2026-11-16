<?php
/*
================================================
CONTROLLER: Potentiel
================================================
Gère toutes les opérations CRUD des clients potentiels
+ Export PDF via Dompdf
================================================
*/
namespace App\Controllers;

use App\Models\ClientPotentielModel;

class Potentiel extends BaseController
{
    protected $clientModel;

    public function __construct()
    {
        $this->clientModel = new ClientPotentielModel();
    }

    // ================================================
    // LIST
    // Route: GET /Potentiel/potentiel_list
    // View:  Potentiel/potentiel_list.php
    // ================================================
    public function potentiel_list()
    {
        return view('Potentiel/potentiel_list', [
            'title'   => 'Clients Potentiels',
            'clients' => $this->clientModel->orderBy('nom_societe', 'ASC')->findAll(),
        ]);
    }

    // ================================================
    // CREATE FORM
    // Route: GET /Potentiel/ajouter_potentiel_form
    // View:  Potentiel/potentiel_form.php
    // ================================================
    public function ajouter_potentiel_form()
    {
        return view('Potentiel/potentiel_form',[
            'title'   => 'Clients Potentiels',
        ]);
    }

    // ================================================
    // CREATE - Traitement ajout
    // Route: POST /Potentiel/ajouter_client_potentiel
    // ================================================
    public function ajouter_client_potentiel()
    {
        $rules = [
            'nom_societe'       => 'required|min_length[2]|max_length[150]',
            'activite'          => 'required|min_length[2]|max_length[150]',
            'responsable'       => 'required|min_length[2]|max_length[150]',
            'adresse'           => 'required',
            'email'             => 'required|valid_email',
            'personne_contactee'=> 'required|min_length[2]|max_length[150]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                             ->withInput()
                             ->with('error', implode('<br>', $this->validator->getErrors()));
        }

        $data = [
            'nom_societe'       => $this->request->getPost('nom_societe'),
            'secteur'           => $this->request->getPost('secteur'),
            'activite'          => $this->request->getPost('activite'),
            'responsable'       => $this->request->getPost('responsable'),
            'adresse'           => $this->request->getPost('adresse'),
            'telephone'         => $this->request->getPost('telephone'),
            'mobile'            => $this->request->getPost('mobile'),
            'fax'               => $this->request->getPost('fax'),
            'email'             => $this->request->getPost('email'),
            'site_web'          => $this->request->getPost('site_web'),
            'personne_contactee'=> $this->request->getPost('personne_contactee'),
            'remarque'          => $this->request->getPost('remarque'),
        ];

        if ($this->clientModel->insert($data)) {
            return redirect()->to(site_url('Potentiel/potentiel_list'))
                             ->with('success', '✅ Client potentiel ajouté avec succès !');
        }

        return redirect()->back()
                         ->withInput()
                         ->with('error', '❌ Erreur lors de l\'ajout.');
    }

    // ================================================
    // EDIT FORM
    // Route: GET /Potentiel/modifier_potentiel/{id}
    // View:  Potentiel/potentiel_form.php
    // ================================================
    public function modifier_potentiel($id = null)
    {
        $client = $this->clientModel->find($id);

        if (!$client) {
            return redirect()->to(site_url('Potentiel/potentiel_list'))
                             ->with('error', '❌ Client introuvable.');
        }

        return view('Potentiel/potentiel_form', [
            'title'   => 'Clients Potentiels',
            'client' => $client,
        ]);
    }

    // ================================================
    // UPDATE - Traitement modification
    // Route: POST /Potentiel/update_potentiel/{id}
    // ================================================
    public function update_potentiel($id = null)
    {
        $client = $this->clientModel->find($id);

        if (!$client) {
            return redirect()->to(site_url('Potentiel/potentiel_list'))
                             ->with('error', '❌ Client introuvable.');
        }

        $rules = [
            'nom_societe'       => 'required|min_length[2]|max_length[150]',
            'activite'          => 'required|min_length[2]|max_length[150]',
            'responsable'       => 'required|min_length[2]|max_length[150]',
            'adresse'           => 'required',
            'email'             => 'required|valid_email',
            'personne_contactee'=> 'required|min_length[2]|max_length[150]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                             ->withInput()
                             ->with('error', implode('<br>', $this->validator->getErrors()));
        }

        $data = [
            'nom_societe'       => $this->request->getPost('nom_societe'),
            'secteur'           => $this->request->getPost('secteur'),
            'activite'          => $this->request->getPost('activite'),
            'responsable'       => $this->request->getPost('responsable'),
            'adresse'           => $this->request->getPost('adresse'),
            'telephone'         => $this->request->getPost('telephone'),
            'mobile'            => $this->request->getPost('mobile'),
            'fax'               => $this->request->getPost('fax'),
            'email'             => $this->request->getPost('email'),
            'site_web'          => $this->request->getPost('site_web'),
            'personne_contactee'=> $this->request->getPost('personne_contactee'),
            'remarque'          => $this->request->getPost('remarque'),
        ];

        if ($this->clientModel->update($id, $data)) {
            return redirect()->to(site_url('Potentiel/potentiel_list'))
                             ->with('success', '✅ Client potentiel modifié avec succès !');
        }

        return redirect()->back()
                         ->withInput()
                         ->with('error', '❌ Erreur lors de la modification.');
    }

    // ================================================
    // DELETE
    // Route: GET /Potentiel/supprimer_client_potentiel/{id}
    // ================================================
    public function supprimer_client_potentiel($id = null)
    {
        $client = $this->clientModel->find($id);

        if (!$client) {
            return redirect()->to(site_url('Potentiel/potentiel_list'))
                             ->with('error', '❌ Client introuvable.');
        }

        if ($this->clientModel->delete($id)) {
            return redirect()->to(site_url('Potentiel/potentiel_list'))
                             ->with('success', '✅ Client potentiel supprimé avec succès !');
        }

        return redirect()->to(site_url('Potentiel/potentiel_list'))
                         ->with('error', '❌ Erreur lors de la suppression.');
    }

    // ================================================
    // EXPORT PDF
    // Route: GET /Potentiel/export_potentiels_pdf
    // ================================================
    public function export_potentiels_pdf()
    {
        $html = view('Potentiel/potentiel_pdf', [
            'clients'     => $this->clientModel->orderBy('nom_societe', 'ASC')->findAll(),
            'date_export' => date('d/m/Y à H:i'),
        ]);

        $options = new \Dompdf\Options();
        $options->set('defaultFont', 'DejaVu Sans');

        $dompdf = new \Dompdf\Dompdf($options);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->loadHtml($html);
        $dompdf->render();

        $dompdf->stream('clients_potentiels_' . date('Ymd') . '.pdf', [
            'Attachment' => true
        ]);
    }
}