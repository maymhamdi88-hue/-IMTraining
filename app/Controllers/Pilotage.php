<?php
/*
================================================
CONTROLLER: Pilotage
================================================
✅ CORRIGÉ: Ajout de resultat_annee_n1 dans store/update
================================================
*/
namespace App\Controllers;

use App\Models\ResultatIndicateurAnnuelModel;

class Pilotage extends BaseController
{
    protected $pilotageModel;

    public function __construct()
    {
        $this->pilotageModel = new ResultatIndicateurAnnuelModel();
    }

    // ================================================
    // LIST
    // ================================================
    public function pilotage_list()
    {
        return view('Pilotage/pilotage_list', [
            'title'     => 'Objectifs & Résultats',
            'pilotages' => $this->pilotageModel->orderBy('annee', 'DESC')->findAll(),
        ]);
    }

    // ================================================
    // CREATE FORM
    // ================================================
    public function ajouter_pilotage_form()
    {
        return view('Pilotage/pilotage_form', [
            'title' => 'Ajouter un Pilotage',
        ]);
    }

    // ================================================
    // CREATE - Traitement ajout
    // ================================================
    public function ajouter_pilotage()
    {
        $rules = [
            'annee'          => 'required|integer|greater_than[1999]|less_than[2101]',
            'processus'      => 'required|min_length[2]|max_length[150]',
            'objectif'       => 'required',
            'indicateur'     => 'required',
            'frequence_suivi'=> 'required|in_list[Mensuelle,Trimestrielle,Semestrielle,Annuelle]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('error', implode('<br>', $this->validator->getErrors()));
        }

        // ✅ Tous les champs y compris resultat_annee_n1
        $data = [
            'annee'            => $this->request->getVar('annee'),
            'processus'        => $this->request->getVar('processus'),
            'objectif'         => $this->request->getVar('objectif'),
            'indicateur'       => $this->request->getVar('indicateur'),
            'mode_calcul'      => $this->request->getVar('mode_calcul'),
            'resultat'         => $this->request->getVar('resultat'),
            'frequence_suivi'  => $this->request->getVar('frequence_suivi'),
            'cible_annee_n'    => $this->request->getVar('cible_annee_n')    ?: null,
            'resultat_annee_n' => $this->request->getVar('resultat_annee_n') ?: null,
            'cible_annee_n1'   => $this->request->getVar('cible_annee_n1')   ?: null,
            'resultat_annee_n1'=> $this->request->getVar('resultat_annee_n1')?: null, // ✅ AJOUTÉ
            'visa_direction'   => $this->request->getVar('visa_direction')   ? 1 : 0,
            'remarque'         => $this->request->getVar('remarque'),
        ];

        if ($this->pilotageModel->insert($data)) {
            return redirect()->to(site_url('Pilotage/pilotage_list'))
                ->with('success', '✅ Pilotage ajouté avec succès !');
        }

        return redirect()->back()
            ->withInput()
            ->with('error', '❌ Erreur lors de l\'ajout.');
    }

    // ================================================
    // EDIT FORM
    // ================================================
    public function modifier_pilotage($id = null)
    {
        $pilotage = $this->pilotageModel->find($id);

        if (!$pilotage) {
            return redirect()->to(site_url('Pilotage/pilotage_list'))
                ->with('error', '❌ Pilotage introuvable.');
        }

        return view('Pilotage/pilotage_form', [
            'title'         => 'Modifier un Pilotage',
            'pilotage_edit' => $pilotage,
        ]);
    }

    // ================================================
    // UPDATE - Traitement modification
    // ================================================
    public function update_pilotage($id = null)
    {
        $pilotage = $this->pilotageModel->find($id);

        if (!$pilotage) {
            return redirect()->to(site_url('Pilotage/pilotage_list'))
                ->with('error', '❌ Pilotage introuvable.');
        }

        $rules = [
            'annee'          => 'required|integer|greater_than[1999]|less_than[2101]',
            'processus'      => 'required|min_length[2]|max_length[150]',
            'objectif'       => 'required',
            'indicateur'     => 'required',
            'frequence_suivi'=> 'required|in_list[Mensuelle,Trimestrielle,Semestrielle,Annuelle]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('error', implode('<br>', $this->validator->getErrors()));
        }

        // ✅ Tous les champs y compris resultat_annee_n1
        $data = [
            'annee'            => $this->request->getVar('annee'),
            'processus'        => $this->request->getVar('processus'),
            'objectif'         => $this->request->getVar('objectif'),
            'indicateur'       => $this->request->getVar('indicateur'),
            'mode_calcul'      => $this->request->getVar('mode_calcul'),
            'resultat'         => $this->request->getVar('resultat'),
            'frequence_suivi'  => $this->request->getVar('frequence_suivi'),
            'cible_annee_n'    => $this->request->getVar('cible_annee_n')    ?: null,
            'resultat_annee_n' => $this->request->getVar('resultat_annee_n') ?: null,
            'cible_annee_n1'   => $this->request->getVar('cible_annee_n1')   ?: null,
            'resultat_annee_n1'=> $this->request->getVar('resultat_annee_n1')?: null, // ✅ AJOUTÉ
            'visa_direction'   => $this->request->getVar('visa_direction')   ? 1 : 0,
            'remarque'         => $this->request->getVar('remarque'),
        ];

        if ($this->pilotageModel->update($id, $data)) {
            return redirect()->to(site_url('Pilotage/pilotage_list'))
                ->with('success', '✅ Pilotage modifié avec succès !');
        }

        return redirect()->back()
            ->withInput()
            ->with('error', '❌ Erreur lors de la modification.');
    }

    // ================================================
    // DELETE
    // ================================================
    public function supprimer_pilotage($id = null)
    {
        $pilotage = $this->pilotageModel->find($id);

        if (!$pilotage) {
            return redirect()->to(site_url('Pilotage/pilotage_list'))
                ->with('error', '❌ Pilotage introuvable.');
        }

        if ($this->pilotageModel->delete($id)) {
            return redirect()->to(site_url('Pilotage/pilotage_list'))
                ->with('success', '✅ Pilotage supprimé avec succès !');
        }

        return redirect()->to(site_url('Pilotage/pilotage_list'))
            ->with('error', '❌ Erreur lors de la suppression.');
    }

    // ================================================
    // EXPORT PDF
    // ================================================
    public function export_pilotage_pdf()
    {
        $html = view('Pilotage/pilotage_pdf', [
            'pilotages'   => $this->pilotageModel->orderBy('annee', 'DESC')->findAll(),
            'date_export' => date('d/m/Y à H:i'),
        ]);

        $options = new \Dompdf\Options();
        $options->set('defaultFont', 'DejaVu Sans');

        $dompdf = new \Dompdf\Dompdf($options);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->loadHtml($html);
        $dompdf->render();

        $dompdf->stream('pilotage_' . date('Ymd') . '.pdf', [
            'Attachment' => true
        ]);
    }
}