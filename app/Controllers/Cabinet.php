<?php
namespace App\Controllers;

use App\Models\ClientCabinetModel;

class Cabinet extends BaseController
{
    protected $clientModel;

    public function __construct()
    {
        $this->clientModel = new ClientCabinetModel();
    }

    // ================================================
    // LIST
    // ================================================
    public function cabinet_list()
    {
        return view('Cabinet/cabinet_list', [
            'title'   => 'Clients Cabinet',
            'clients' => $this->clientModel->orderBy('nom_societe', 'ASC')->findAll(),
        ]);
    }

    // ================================================
    // CREATE FORM
    // ================================================
    public function ajouter_cabinet_form()
    {
        return view('Cabinet/cabinet_form', [
            'title' => 'Clients Cabinet',
        ]);
    }

    // ================================================
    // CREATE
    // ================================================
    public function ajouter_client_cabinet()
    {
        $rules = [
            'nom_societe'        => 'required|min_length[2]|max_length[150]',
            'matricule_fiscal'   => 'required|max_length[50]',
            'responsable'        => 'required|min_length[2]|max_length[150]',
            'adresse'            => 'required',
            'email'              => 'required|valid_email',
            'personne_contactee' => 'required|min_length[2]|max_length[150]',
            'email_contact'      => 'required|valid_email',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                             ->withInput()
                             ->with('errors', $this->validator->getErrors());
        }

        $matricule    = trim($this->request->getPost('matricule_fiscal'));
        $email        = trim($this->request->getPost('email'));
        $emailContact = trim($this->request->getPost('email_contact'));

        // Vérification unicité matricule_fiscal
        if ($this->clientModel->where('matricule_fiscal', $matricule)->first()) {
            return redirect()->back()
                             ->withInput()
                             ->with('errors', [
                                 'matricule_fiscal' => '❌ Ce matricule fiscal existe déjà.'
                             ]);
        }

        // Vérification unicité email société
        if ($this->clientModel->where('email', $email)->first()) {
            return redirect()->back()
                             ->withInput()
                             ->with('errors', [
                                 'email' => '❌ Cet email société existe déjà.'
                             ]);
        }

        // Vérification unicité email contact
        if ($this->clientModel->where('email_contact', $emailContact)->first()) {
            return redirect()->back()
                             ->withInput()
                             ->with('errors', [
                                 'email_contact' => '❌ Cet email contact existe déjà.'
                             ]);
        }

        $data = [
            'nom_societe'        => $this->request->getPost('nom_societe'),
            'activite'           => $this->request->getPost('activite'),
            'secteur'            => $this->request->getPost('secteur'),
            'matricule_fiscal'   => $matricule,
            'responsable'        => $this->request->getPost('responsable'),
            'adresse'            => $this->request->getPost('adresse'),
            'telephone'          => $this->request->getPost('telephone'),
            'fax'                => $this->request->getPost('fax'),
            'email'              => $email,
            'site_web'           => $this->request->getPost('site_web'),
            'personne_contactee' => $this->request->getPost('personne_contactee'),
            'mob_tel'            => $this->request->getPost('mob_tel'),
            'email_contact'      => $emailContact,
        ];

        // insert(data, true) retourne l'ID inséré ou false
        $newId = $this->clientModel->insert($data, true);

        if ($newId) {
            return redirect()->to(site_url('Cabinet/cabinet_list'))
                             ->with('success', '✅ Client cabinet ajouté avec succès !');
        }

        // Récupère l'erreur exacte
        $dbError = $this->clientModel->db->error();
        $message = '❌ Erreur lors de l\'ajout.';
        if (!empty($dbError['message'])) {
            $message .= ' — ' . $dbError['message'];
        }

        return redirect()->back()
                         ->withInput()
                         ->with('error', $message);
    }

    // ================================================
    // EDIT FORM
    // ================================================
    public function modifier_cabinet($id = null)
    {
        $client = $this->clientModel->find($id);

        if (!$client) {
            return redirect()->to(site_url('Cabinet/cabinet_list'))
                             ->with('error', '❌ Client introuvable.');
        }

        return view('Cabinet/cabinet_form', [
            'title'  => 'Clients Cabinet',
            'client' => $client,
        ]);
    }

    // ================================================
    // UPDATE
    // ================================================
    public function update_cabinet($id = null)
    {
        $client = $this->clientModel->find($id);

        if (!$client) {
            return redirect()->to(site_url('Cabinet/cabinet_list'))
                             ->with('error', '❌ Client introuvable.');
        }

        $rules = [
            'nom_societe'        => 'required|min_length[2]|max_length[150]',
            'matricule_fiscal'   => 'required|max_length[50]',
            'responsable'        => 'required|min_length[2]|max_length[150]',
            'adresse'            => 'required',
            'email'              => 'required|valid_email',
            'personne_contactee' => 'required|min_length[2]|max_length[150]',
            'email_contact'      => 'required|valid_email',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                             ->withInput()
                             ->with('errors', $this->validator->getErrors());
        }

        $matricule    = trim($this->request->getPost('matricule_fiscal'));
        $email        = trim($this->request->getPost('email'));
        $emailContact = trim($this->request->getPost('email_contact'));

        // Vérification unicité matricule — ignore le client courant
        if ($this->clientModel
                 ->where('matricule_fiscal', $matricule)
                 ->where('id_client !=', $id)
                 ->first()) {
            return redirect()->back()
                             ->withInput()
                             ->with('errors', [
                                 'matricule_fiscal' => '❌ Ce matricule fiscal est déjà utilisé par un autre client.'
                             ]);
        }

        // Vérification unicité email société — ignore le client courant
        if ($this->clientModel
                 ->where('email', $email)
                 ->where('id_client !=', $id)
                 ->first()) {
            return redirect()->back()
                             ->withInput()
                             ->with('errors', [
                                 'email' => '❌ Cet email société est déjà utilisé par un autre client.'
                             ]);
        }

        // Vérification unicité email contact — ignore le client courant
        if ($this->clientModel
                 ->where('email_contact', $emailContact)
                 ->where('id_client !=', $id)
                 ->first()) {
            return redirect()->back()
                             ->withInput()
                             ->with('errors', [
                                 'email_contact' => '❌ Cet email contact est déjà utilisé par un autre client.'
                             ]);
        }

        $data = [
            'nom_societe'        => $this->request->getPost('nom_societe'),
            'activite'           => $this->request->getPost('activite'),
            'secteur'            => $this->request->getPost('secteur'),
            'matricule_fiscal'   => $matricule,
            'responsable'        => $this->request->getPost('responsable'),
            'adresse'            => $this->request->getPost('adresse'),
            'telephone'          => $this->request->getPost('telephone'),
            'fax'                => $this->request->getPost('fax'),
            'email'              => $email,
            'site_web'           => $this->request->getPost('site_web'),
            'personne_contactee' => $this->request->getPost('personne_contactee'),
            'mob_tel'            => $this->request->getPost('mob_tel'),
            'email_contact'      => $emailContact,
        ];

        $updated = $this->clientModel->update($id, $data);

        if ($updated) {
            return redirect()->to(site_url('Cabinet/cabinet_list'))
                             ->with('success', '✅ Client cabinet modifié avec succès !');
        }

        // Récupère l'erreur exacte
        $dbError = $this->clientModel->db->error();
        $message = '❌ Erreur lors de la modification.';
        if (!empty($dbError['message'])) {
            $message .= ' — ' . $dbError['message'];
        }

        return redirect()->back()
                         ->withInput()
                         ->with('error', $message);
    }

    // ================================================
    // DELETE
    // ================================================
    public function supprimer_client_cabinet($id = null)
    {
        $client = $this->clientModel->find($id);

        if (!$client) {
            return redirect()->to(site_url('Cabinet/cabinet_list'))
                             ->with('error', '❌ Client introuvable.');
        }

        if ($this->clientModel->delete($id)) {
            return redirect()->to(site_url('Cabinet/cabinet_list'))
                             ->with('success', '✅ Client cabinet supprimé avec succès !');
        }

        return redirect()->to(site_url('Cabinet/cabinet_list'))
                         ->with('error', '❌ Erreur lors de la suppression.');
    }

    // ================================================
    // EXPORT PDF
    // ================================================
    public function export_cabinet_pdf()
    {
        $html = view('Cabinet/cabinet_pdf', [
            'clients'     => $this->clientModel->orderBy('nom_societe', 'ASC')->findAll(),
            'date_export' => date('d/m/Y à H:i'),
        ]);

        $options = new \Dompdf\Options();
        $options->set('defaultFont', 'DejaVu Sans');

        $dompdf = new \Dompdf\Dompdf($options);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->loadHtml($html);
        $dompdf->render();

        $dompdf->stream('clients_cabinet_' . date('Ymd') . '.pdf', [
            'Attachment' => true,
        ]);
    }
}