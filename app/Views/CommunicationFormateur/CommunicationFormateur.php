<?php
/*
================================================
CONTROLLER: CommunicationFormateur
================================================
Gère toutes les opérations CRUD des communications
+ Export PDF via Dompdf
================================================
*/
namespace App\Controllers;

use App\Models\CommunicationModel;
use App\Models\FormateurModel;
use App\Models\UtilisateurModel; // ← adapte selon ton model utilisateur

class CommunicationFormateur extends BaseController
{
    // ================================================
    // Propriétés: instances des models
    // ================================================
    protected $commModel;
    protected $formateurModel;
    protected $userModel;

    // ================================================
    // Constructeur: initialisation des models
    // ================================================
    public function __construct()
    {
        $this->commModel      = new CommunicationModel();
        $this->formateurModel = new FormateurModel();
        $this->userModel      = new UtilisateurModel(); // ← adapte si nom différent
    }

    // ================================================
    // MÉTHODE PRIVÉE: construction des Maps [id => nom]
    // ================================================
    private function getMaps(): array
    {
        // formateursMap[id_formateur] = 'Nom Prénom'
        $formateursMap = [];
        foreach ($this->formateurModel->findAll() as $f) {
            $formateursMap[$f['id_formateur']] = $f['nom_prenom'];
        }

        // usersMap[id] = 'Nom Utilisateur'
        $usersMap = [];
        foreach ($this->userModel->findAll() as $u) {
            $usersMap[$u['id']] = $u['nom_utilisateur'];
        }

        return compact('formateursMap', 'usersMap');
    }

    // ================================================
    // LIST - Afficher toutes les communications
    // Route: GET /CommunicationFormateur/communication_list
    // View:  CommunicationFormateur/communication_list.php
    // ================================================
    public function communication_list()
    {
        $maps = $this->getMaps();

        return view('CommunicationFormateur/communication_list', [
            'communications' => $this->commModel->orderBy('date_communication', 'DESC')->findAll(),
            'formateursMap'  => $maps['formateursMap'],
            'usersMap'       => $maps['usersMap'],
        ]);
    }

    // ================================================
    // CREATE FORM - Formulaire ajout (vide)
    // Route: GET /CommunicationFormateur/ajouter_form
    // View:  CommunicationFormateur/communication_form.php
    // ================================================
    public function ajouter_form()
    {
        return view('CommunicationFormateur/communication_form', [
            'formateurs'  => $this->formateurModel->findAll(),
            'utilisateurs' => $this->userModel->findAll(),
        ]);
    }

    // ================================================
    // CREATE - Traitement ajout
    // Route: POST /CommunicationFormateur/ajouter
    // ================================================
    public function ajouter()
    {
        $rules = [
            'id_formateur'       => 'required|integer',
            'id_responsable'     => 'required|integer',
            'moyen_communication'=> 'required|in_list[appel,email,reunion]',
            'date_communication' => 'required|valid_date',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                             ->withInput()
                             ->with('error', implode('<br>', $this->validator->getErrors()));
        }

        $data = [
            'id_formateur'        => $this->request->getPost('id_formateur'),
            'id_responsable'      => $this->request->getPost('id_responsable'),
            'domaine'             => $this->request->getPost('domaine'),
            'moyen_communication' => $this->request->getPost('moyen_communication'),
            'avis'                => $this->request->getPost('avis') ?: null,
            'commentaire'         => $this->request->getPost('commentaire'),
            'date_communication'  => $this->request->getPost('date_communication'),
        ];

        if ($this->commModel->insert($data)) {
            return redirect()->to(site_url('CommunicationFormateur/communication_list'))
                             ->with('success', '✅ Communication ajoutée avec succès !');
        }

        return redirect()->back()
                         ->withInput()
                         ->with('error', '❌ Erreur lors de l\'ajout.');
    }

    // ================================================
    // EDIT FORM - Formulaire modification (pré-rempli)
    // Route: GET /CommunicationFormateur/edit_form/{id}
    // View:  CommunicationFormateur/communication_form.php
    // ================================================
    public function edit_form($id = null)
    {
        $communication = $this->commModel->find($id);

        if (!$communication) {
            return redirect()->to(site_url('CommunicationFormateur/communication_list'))
                             ->with('error', '❌ Communication introuvable.');
        }

        return view('CommunicationFormateur/communication_form', [
            'communication_edit' => $communication, // ← clé utilisée dans la view
            'formateurs'         => $this->formateurModel->findAll(),
            'utilisateurs'       => $this->userModel->findAll(),
        ]);
    }

    // ================================================
    // UPDATE - Traitement modification
    // Route: POST /CommunicationFormateur/update/{id}
    // ================================================
    public function update($id = null)
    {
        $communication = $this->commModel->find($id);

        if (!$communication) {
            return redirect()->to(site_url('CommunicationFormateur/communication_list'))
                             ->with('error', '❌ Communication introuvable.');
        }

        $rules = [
            'id_formateur'        => 'required|integer',
            'id_responsable'      => 'required|integer',
            'moyen_communication' => 'required|in_list[appel,email,reunion]',
            'date_communication'  => 'required|valid_date',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                             ->withInput()
                             ->with('error', implode('<br>', $this->validator->getErrors()));
        }

        $data = [
            'id_formateur'        => $this->request->getPost('id_formateur'),
            'id_responsable'      => $this->request->getPost('id_responsable'),
            'domaine'             => $this->request->getPost('domaine'),
            'moyen_communication' => $this->request->getPost('moyen_communication'),
            'avis'                => $this->request->getPost('avis') ?: null,
            'commentaire'         => $this->request->getPost('commentaire'),
            'date_communication'  => $this->request->getPost('date_communication'),
        ];

        if ($this->commModel->update($id, $data)) {
            return redirect()->to(site_url('CommunicationFormateur/communication_list'))
                             ->with('success', '✅ Communication modifiée avec succès !');
        }

        return redirect()->back()
                         ->withInput()
                         ->with('error', '❌ Erreur lors de la modification.');
    }

    // ================================================
    // DELETE - Supprimer une communication
    // Route: GET /CommunicationFormateur/supprimer/{id}
    // ================================================
    public function supprimer($id = null)
    {
        $communication = $this->commModel->find($id);

        if (!$communication) {
            return redirect()->to(site_url('CommunicationFormateur/communication_list'))
                             ->with('error', '❌ Communication introuvable.');
        }

        if ($this->commModel->delete($id)) {
            return redirect()->to(site_url('CommunicationFormateur/communication_list'))
                             ->with('success', '✅ Communication supprimée avec succès !');
        }

        return redirect()->to(site_url('CommunicationFormateur/communication_list'))
                         ->with('error', '❌ Erreur lors de la suppression.');
    }

    // ================================================
    // EXPORT PDF
    // Route: GET /CommunicationFormateur/export_pdf
    // View:  CommunicationFormateur/communication_pdf.php
    // ================================================
    public function export_pdf()
    {
        $maps = $this->getMaps();

        $html = view('CommunicationFormateur/communication_pdf', [
            'communications' => $this->commModel->orderBy('date_communication', 'DESC')->findAll(),
            'formateursMap'  => $maps['formateursMap'],
            'usersMap'       => $maps['usersMap'],
            'date_export'    => date('d/m/Y à H:i'),
        ]);

        $options = new \Dompdf\Options();
        $options->set('defaultFont', 'DejaVu Sans');

        $dompdf = new \Dompdf\Dompdf($options);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->loadHtml($html);
        $dompdf->render();

        $dompdf->stream('communications_' . date('Ymd') . '.pdf', [
            'Attachment' => true
        ]);
    }
}