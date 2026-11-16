<?php

namespace App\Controllers;

use App\Models\CommunicationClientModel;
use App\Models\ClientCabinetModel;
use App\Models\UtilisateurModel;

class CommunicationClient extends BaseController
{
    protected $communicationModel;
    protected $clientModel;
    protected $utilisateurModel;

    public function __construct()
    {
        $this->communicationModel = new CommunicationClientModel();
        $this->clientModel        = new ClientCabinetModel();
        $this->utilisateurModel   = new UtilisateurModel();
    }

    // ================================================
    // MÉTHODE PRIVÉE: Map [id_client => 'nom_societe']
    // ================================================
    private function getClientsMap(): array
    {
        $clientsMap = [];
        foreach ($this->clientModel->findAll() as $c) {
            $clientsMap[$c['id_client']] = $c['nom_societe'];
        }
        return $clientsMap;
    }

    // ================================================
    // MÉTHODE PRIVÉE: Map [id => 'nom_utilisateur']
    // ================================================
    private function getUsersMap(): array
    {
        $usersMap = [];
        foreach ($this->utilisateurModel->getUtilisateursActifs() as $u) {
            $usersMap[$u['id']] = $u['nom_utilisateur'];
        }
        return $usersMap;
    }

    // ================================================
    // LIST
    // ================================================
    public function communication_list()
    {
        return view('CommunicationClient/communication_list', [
            'title'          => 'Communications Clients',
            'communications' => $this->communicationModel->orderBy('date_communication', 'DESC')->findAll(),
            'clientsMap'     => $this->getClientsMap(),
            'usersMap'       => $this->getUsersMap(),
        ]);
    }

    // ================================================
    // CREATE FORM
    // ================================================
    public function ajouter_communication_form()
    {
        return view('CommunicationClient/communication_form', [
            'clients'      => $this->clientModel->orderBy('nom_societe', 'ASC')->findAll(),
            'utilisateurs' => $this->utilisateurModel->getUtilisateursActifs(),
        ]);
    }

    // ================================================
    // CREATE - Traitement ajout
    // ================================================
    public function ajouter_communication()
    {
        $rules = [
            'id_client'           => 'required|integer',
            'id_responsable'      => 'required|integer',
            'date_communication'  => 'required|valid_date',
            'moyen_communication' => 'required|in_list[appel,email,reunion]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                             ->withInput()
                             ->with('error', implode('<br>', $this->validator->getErrors()));
        }

        $data = [
            'id_client'           => $this->request->getPost('id_client'),
            'id_responsable'      => $this->request->getPost('id_responsable'),
            'domaine'             => $this->request->getPost('domaine'),
            'moyen_communication' => $this->request->getPost('moyen_communication'),
            'avis'                => $this->request->getPost('avis') ?: null,
            'commentaire'         => $this->request->getPost('commentaire'),
            'date_communication'  => $this->request->getPost('date_communication'),
        ];

        if ($this->communicationModel->insert($data)) {
            return redirect()->to(site_url('CommunicationClient/communication_list'))
                             ->with('success', '✅ Communication ajoutée avec succès !');
        }

        return redirect()->back()
                         ->withInput()
                         ->with('error', '❌ Erreur lors de l\'ajout.');
    }

    // ================================================
    // EDIT FORM
    // ================================================
    public function modifier_communication($id = null)
    {
        $communication = $this->communicationModel->find($id);

        if (!$communication) {
            return redirect()->to(site_url('CommunicationClient/communication_list'))
                             ->with('error', '❌ Communication introuvable.');
        }

        return view('CommunicationClient/communication_form', [
            'communication' => $communication,
            'clients'       => $this->clientModel->orderBy('nom_societe', 'ASC')->findAll(),
            'utilisateurs'  => $this->utilisateurModel->getUtilisateursActifs(),
        ]);
    }

    // ================================================
    // UPDATE - Traitement modification
    // ================================================
    public function update_communication($id = null)
    {
        $communication = $this->communicationModel->find($id);

        if (!$communication) {
            return redirect()->to(site_url('CommunicationClient/communication_list'))
                             ->with('error', '❌ Communication introuvable.');
        }

        $rules = [
            'id_client'           => 'required|integer',
            'id_responsable'      => 'required|integer',
            'date_communication'  => 'required|valid_date',
            'moyen_communication' => 'required|in_list[appel,email,reunion]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                             ->withInput()
                             ->with('error', implode('<br>', $this->validator->getErrors()));
        }

        $data = [
            'id_client'           => $this->request->getPost('id_client'),
            'id_responsable'      => $this->request->getPost('id_responsable'),
            'domaine'             => $this->request->getPost('domaine'),
            'moyen_communication' => $this->request->getPost('moyen_communication'),
            'avis'                => $this->request->getPost('avis') ?: null,
            'commentaire'         => $this->request->getPost('commentaire'),
            'date_communication'  => $this->request->getPost('date_communication'),
        ];

        if ($this->communicationModel->update($id, $data)) {
            return redirect()->to(site_url('CommunicationClient/communication_list'))
                             ->with('success', '✅ Communication modifiée avec succès !');
        }

        return redirect()->back()
                         ->withInput()
                         ->with('error', '❌ Erreur lors de la modification.');
    }

    // ================================================
    // DELETE
    // ================================================
    public function supprimer_communication($id = null)
    {
        $communication = $this->communicationModel->find($id);

        if (!$communication) {
            return redirect()->to(site_url('CommunicationClient/communication_list'))
                             ->with('error', '❌ Communication introuvable.');
        }

        if ($this->communicationModel->delete($id)) {
            return redirect()->to(site_url('CommunicationClient/communication_list'))
                             ->with('success', '✅ Communication supprimée avec succès !');
        }

        return redirect()->to(site_url('CommunicationClient/communication_list'))
                         ->with('error', '❌ Erreur lors de la suppression.');
    }

    // ================================================
    // EXPORT PDF
    // ================================================
    public function export_communications_pdf()
    {
        $html = view('CommunicationClient/communication_pdf', [
            'communications' => $this->communicationModel->orderBy('date_communication', 'DESC')->findAll(),
            'clientsMap'     => $this->getClientsMap(),
            'usersMap'       => $this->getUsersMap(),
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