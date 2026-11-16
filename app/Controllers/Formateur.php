<?php

namespace App\Controllers;

use App\Models\FormateurModel;

class Formateur extends BaseController
{
    protected $formateurModel;

    public function __construct()
    {
        $this->formateurModel = new FormateurModel();
    }

    // ----------------------------------
    // LIST - Afficher la liste
    // Route: GET /Formateur/formateurs_list
    // ----------------------------------
    public function formateurs_list()
    {
        $data = [
            'formateurs' => $this->formateurModel->findAll(),
            'title'   => 'Formateurs',
        ];

        return view('Formateur/formateurs_list', $data);
    }

    // ----------------------------------
    // CREATE FORM - Formulaire d'ajout
    // Route: GET /Formateur/ajouter_form
    // ----------------------------------
    public function ajouter_form()
    {
        return view('Formateur/formateurs_form',[
            'title'   => 'Formateurs',
        ]);
    }

    // ----------------------------------
    // CREATE - Traitement ajout
    // Route: POST /Formateur/ajouter
    // ----------------------------------
    public function ajouter()
    {
        $rules = [
            'nom_prenom'     => 'required|max_length[150]',
            'type_formateur' => 'required|in_list[prive,public]',
            'autorisation'   => 'required|in_list[avec,sans]',
            'honoraire'      => 'required|numeric',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                             ->withInput()
                             ->with('error', implode('<br>', $this->validator->getErrors()));
        }

        $data = [
            'nom_prenom'         => $this->request->getPost('nom_prenom'),
            'date_naissance'     => $this->request->getPost('date_naissance')    ?: null,
            'adresse'            => $this->request->getPost('adresse'),
            'telephone'          => $this->request->getPost('telephone'),
            'email'              => $this->request->getPost('email'),
            'diplome'            => $this->request->getPost('diplome'),
            'domaine_competence' => $this->request->getPost('domaine_competence'),
            'type_formateur'     => $this->request->getPost('type_formateur'),
            'autorisation'       => $this->request->getPost('autorisation'),
            'type_autorisation'  => $this->request->getPost('type_autorisation') ?: null,
            'honoraire'          => $this->request->getPost('honoraire'),
            'rib'                => $this->request->getPost('rib'),
            'banque'             => $this->request->getPost('banque'),
            'remarque'           => $this->request->getPost('remarque'),
        ];

        $this->formateurModel->insert($data);

        return redirect()->to(site_url('Formateur/formateurs_list'))
                         ->with('success', 'Formateur ajouté avec succès !');
    }

    // ----------------------------------
    // EDIT FORM - Formulaire modification
    // Route: GET /Formateur/edit/{id}
    // ----------------------------------
    public function edit($id = null)
    {
        $formateur = $this->formateurModel->find($id);

        if (!$formateur) {
            return redirect()->to(site_url('Formateur/formateurs_list'))
                             ->with('error', 'Formateur introuvable.');
        }

        return view('Formateur/formateurs_form', [
            'title'   => 'Formateurs',
            'formateur_edit' => $formateur,
        ]);
    }

    // ----------------------------------
    // UPDATE - Traitement modification
    // Route: POST /Formateur/update/{id}
    // ----------------------------------
    public function update($id = null)
    {
        $formateur = $this->formateurModel->find($id);

        if (!$formateur) {
            return redirect()->to(site_url('Formateur/formateurs_list'))
                             ->with('error', 'Formateur introuvable.');
        }

        $rules = [
            'nom_prenom'     => 'required|max_length[150]',
            'type_formateur' => 'required|in_list[prive,public]',
            'autorisation'   => 'required|in_list[avec,sans]',
            'honoraire'      => 'required|numeric',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                             ->withInput()
                             ->with('error', implode('<br>', $this->validator->getErrors()));
        }

        $data = [
            'nom_prenom'         => $this->request->getPost('nom_prenom'),
            'date_naissance'     => $this->request->getPost('date_naissance')    ?: null,
            'adresse'            => $this->request->getPost('adresse'),
            'telephone'          => $this->request->getPost('telephone'),
            'email'              => $this->request->getPost('email'),
            'diplome'            => $this->request->getPost('diplome'),
            'domaine_competence' => $this->request->getPost('domaine_competence'),
            'type_formateur'     => $this->request->getPost('type_formateur'),
            'autorisation'       => $this->request->getPost('autorisation'),
            'type_autorisation'  => $this->request->getPost('type_autorisation') ?: null,
            'honoraire'          => $this->request->getPost('honoraire'),
            'rib'                => $this->request->getPost('rib'),
            'banque'             => $this->request->getPost('banque'),
            'remarque'           => $this->request->getPost('remarque'),
        ];

        $this->formateurModel->update($id, $data);

        return redirect()->to(site_url('Formateur/formateurs_list'))
                         ->with('success', 'Formateur modifié avec succès !');
    }

    // ----------------------------------
    // DELETE - Supprimer un formateur
    // Route: GET /Formateur/supprimer/{id}
    // ----------------------------------
    public function supprimer($id = null)
    {
        $formateur = $this->formateurModel->find($id);

        if (!$formateur) {
            return redirect()->to(site_url('Formateur/formateurs_list'))
                             ->with('error', 'Formateur introuvable.');
        }

        $this->formateurModel->delete($id);

        return redirect()->to(site_url('Formateur/formateurs_list'))
                         ->with('success', 'Formateur supprimé avec succès !');
    }

    // ----------------------------------
    // EXPORT PDF
    // Route: GET /Formateur/export_pdf
    // ----------------------------------
    public function export_pdf()
    {
        $dompdf = new \Dompdf\Dompdf();
        $dompdf->setPaper('A4', 'landscape');

        $html = view('Formateur/formateurs_pdf', [
            'formateurs'  => $this->formateurModel->findAll(),
            'date_export' => date('d/m/Y à H:i'),
        ]);

        $dompdf->loadHtml($html);
        $dompdf->render();
        $dompdf->stream('formateurs_' . date('Ymd') . '.pdf', ['Attachment' => true]);
    }
}