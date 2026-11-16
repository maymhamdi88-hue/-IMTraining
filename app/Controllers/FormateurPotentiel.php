<?php

namespace App\Controllers;

use App\Models\FormateurPotentielModel;

class FormateurPotentiel extends BaseController
{
    protected $formateurPotentielModel;

    public function __construct()
    {
        $this->formateurPotentielModel = new FormateurPotentielModel();
    }

    public function formateur_potentiel_list()
    {
        $data = [
            'formateur_potentiel' => $this->formateurPotentielModel->findAll(),
            'title'   => 'Formateur Potentiel',
        ];
        return view('FormateurPotentiel/formateur_potentiel_list', $data);
    }

    public function ajouter_form()
    {
        return view('FormateurPotentiel/formateur_potentiel_form',[
            'title'   => 'Formateur Potentiel',
        ]);
    }

    public function ajouter()
    {
        $rules = [
            'nom_prenom'               => 'required|max_length[150]',
            'type_formateur_potentiel' => 'required|in_list[prive,public]',
            'autorisation'             => 'required|in_list[avec,sans]',
            'honoraire'                => 'required|numeric',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                             ->withInput()
                             ->with('error', implode('<br>', $this->validator->getErrors()));
        }

        $data = [
            'nom_prenom'               => $this->request->getPost('nom_prenom'),
            'date_naissance'           => $this->request->getPost('date_naissance') ?: null,
            'adresse'                  => $this->request->getPost('adresse'),
            'telephone'                => $this->request->getPost('telephone'),
            'email'                    => $this->request->getPost('email'),
            'diplome'                  => $this->request->getPost('diplome'),
            'domaine_competence'       => $this->request->getPost('domaine_competence'),
            'type_formateur_potentiel' => $this->request->getPost('type_formateur_potentiel'),
            'autorisation'             => $this->request->getPost('autorisation'),
            'type_autorisation'        => $this->request->getPost('type_autorisation') ?: null,
            'honoraire'                => $this->request->getPost('honoraire'),
            'remarque'                 => $this->request->getPost('remarque'),
        ];

        $this->formateurPotentielModel->insert($data);

        // ✅ Redirige vers la LISTE
        return redirect()->to(site_url('FormateurPotentiel/formateur_potentiel_list'))
                         ->with('success', 'Formateur potentiel ajouté avec succès !');
    }

    public function edit($id = null)
    {
        $fp = $this->formateurPotentielModel->find($id);

        if (!$fp) {
            // ✅ Redirige vers la LISTE
            return redirect()->to(site_url('FormateurPotentiel/formateur_potentiel_list'))
                             ->with('error', 'Formateur potentiel introuvable.');
        }

        return view('FormateurPotentiel/formateur_potentiel_form', [
            'title'   => 'Formateur Potentiel',
            'formateur_potentiel_edit' => $fp,
        ]);
    }

    public function update($id = null)
    {
        $fp = $this->formateurPotentielModel->find($id);

        if (!$fp) {
            // ✅ Redirige vers la LISTE
            return redirect()->to(site_url('FormateurPotentiel/formateur_potentiel_list'))
                             ->with('error', 'Formateur potentiel introuvable.');
        }

        $rules = [
            'nom_prenom'               => 'required|max_length[150]',
            'type_formateur_potentiel' => 'required|in_list[prive,public]',
            'autorisation'             => 'required|in_list[avec,sans]',
            'honoraire'                => 'required|numeric',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                             ->withInput()
                             ->with('error', implode('<br>', $this->validator->getErrors()));
        }

        $data = [
            'nom_prenom'               => $this->request->getPost('nom_prenom'),
            'date_naissance'           => $this->request->getPost('date_naissance') ?: null,
            'adresse'                  => $this->request->getPost('adresse'),
            'telephone'                => $this->request->getPost('telephone'),
            'email'                    => $this->request->getPost('email'),
            'diplome'                  => $this->request->getPost('diplome'),
            'domaine_competence'       => $this->request->getPost('domaine_competence'),
            'type_formateur_potentiel' => $this->request->getPost('type_formateur_potentiel'),
            'autorisation'             => $this->request->getPost('autorisation'),
            'type_autorisation'        => $this->request->getPost('type_autorisation') ?: null,
            'honoraire'                => $this->request->getPost('honoraire'),
            'remarque'                 => $this->request->getPost('remarque'),
        ];

        $this->formateurPotentielModel->update($id, $data);

        // ✅ Redirige vers la LISTE
        return redirect()->to(site_url('FormateurPotentiel/formateur_potentiel_list'))
                         ->with('success', 'Formateur potentiel modifié avec succès !');
    }

    public function supprimer($id = null)
    {
        $fp = $this->formateurPotentielModel->find($id);

        if (!$fp) {
            // ✅ Redirige vers la LISTE
            return redirect()->to(site_url('FormateurPotentiel/formateur_potentiel_list'))
                             ->with('error', 'Formateur potentiel introuvable.');
        }

        $this->formateurPotentielModel->delete($id);

        // ✅ Redirige vers la LISTE
        return redirect()->to(site_url('FormateurPotentiel/formateur_potentiel_list'))
                         ->with('success', 'Formateur potentiel supprimé avec succès !');
    }

    public function export_pdf()
    {
        $dompdf = new \Dompdf\Dompdf();
        $dompdf->setPaper('A4', 'landscape');

        $html = view('FormateurPotentiel/formateur_potentiel_pdf', [
            'formateur_potentiel' => $this->formateurPotentielModel->findAll(),
            'date_export'         => date('d/m/Y à H:i'),
        ]);

        $dompdf->loadHtml($html);
        $dompdf->render();
        $dompdf->stream('formateurs_potentiels_' . date('Ymd') . '.pdf', ['Attachment' => true]);
    }
}