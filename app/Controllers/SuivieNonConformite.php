<?php
/*
================================================
CONTROLLER: SuivieNonConformite
================================================
Gère toutes les opérations CRUD des suivis non-conformité
+ Export PDF via Dompdf
================================================
*/
namespace App\Controllers;

use App\Models\SuiviNonConformiteModel;

class SuivieNonConformite extends BaseController
{
    protected $suiviModel;

    public function __construct()
    {
        $this->suiviModel = new SuiviNonConformiteModel();
    }

    // ================================================
    // LIST
    // Route: GET /SuivieNonConformite/suivi_list
    // View:  SuivieNonConformite/suivi_list.php
    // ================================================
    public function suivi_list()
    {
        return view('SuivieNonConformite/suivi_list', [
            'title'  => 'Suivis Non-Conformité',
            'suivis' => $this->suiviModel->orderBy('date_constat', 'DESC')->findAll(),
        ]);
    }

    // ================================================
    // CREATE FORM
    // Route: GET /SuivieNonConformite/ajouter_suivi_form
    // View:  SuivieNonConformite/suivi_form.php
    // ================================================
    public function ajouter_suivi_form()
    {
        return view('SuivieNonConformite/suivi_form',[
            'title'  => 'Suivis Non-Conformité',
        ]);
    }

    // ================================================
    // CREATE - Traitement ajout
    // Route: POST /SuivieNonConformite/ajouter_suivi
    // ================================================
    public function ajouter_suivi()
    {
        $rules = [
            'date_constat' => 'required|valid_date',
            'responsable'  => 'required|min_length[2]|max_length[150]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                             ->withInput()
                             ->with('error', implode('<br>', $this->validator->getErrors()));
        }

        $data = [
            'date_constat'        => $this->request->getPost('date_constat'),
            'designation'         => $this->request->getPost('designation'),
            'correction_immediate'=> $this->request->getPost('correction_immediate'),
            'date_realisation'    => $this->request->getPost('date_realisation') ?: null,
            'responsable'         => $this->request->getPost('responsable'),
            'causes_probables'    => $this->request->getPost('causes_probables'),
        ];

        if ($this->suiviModel->insert($data)) {
            return redirect()->to(site_url('SuivieNonConformite/suivi_list'))
                             ->with('success', '✅ Suivi ajouté avec succès !');
        }

        return redirect()->back()
                         ->withInput()
                         ->with('error', '❌ Erreur lors de l\'ajout.');
    }

    // ================================================
    // EDIT FORM
    // Route: GET /SuivieNonConformite/modifier_suivi/{id}
    // View:  SuivieNonConformite/suivi_form.php
    // ================================================
    public function modifier_suivi($id = null)
    {
        $suivi = $this->suiviModel->find($id);

        if (!$suivi) {
            return redirect()->to(site_url('SuivieNonConformite/suivi_list'))
                             ->with('error', '❌ Suivi introuvable.');
        }

        return view('SuivieNonConformite/suivi_form', [
            'title'  => 'Suivis Non-Conformité',
            'suivi_edit' => $suivi,
        ]);
    }

    // ================================================
    // UPDATE - Traitement modification
    // Route: POST /SuivieNonConformite/update_suivi/{id}
    // ================================================
    public function update_suivi($id = null)
    {
        $suivi = $this->suiviModel->find($id);

        if (!$suivi) {
            return redirect()->to(site_url('SuivieNonConformite/suivi_list'))
                             ->with('error', '❌ Suivi introuvable.');
        }

        $rules = [
            'date_constat' => 'required|valid_date',
            'responsable'  => 'required|min_length[2]|max_length[150]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                             ->withInput()
                             ->with('error', implode('<br>', $this->validator->getErrors()));
        }

        $data = [
            'date_constat'        => $this->request->getPost('date_constat'),
            'designation'         => $this->request->getPost('designation'),
            'correction_immediate'=> $this->request->getPost('correction_immediate'),
            'date_realisation'    => $this->request->getPost('date_realisation') ?: null,
            'responsable'         => $this->request->getPost('responsable'),
            'causes_probables'    => $this->request->getPost('causes_probables'),
        ];

        if ($this->suiviModel->update($id, $data)) {
            return redirect()->to(site_url('SuivieNonConformite/suivi_list'))
                             ->with('success', '✅ Suivi modifié avec succès !');
        }

        return redirect()->back()
                         ->withInput()
                         ->with('error', '❌ Erreur lors de la modification.');
    }

    // ================================================
    // DELETE
    // Route: GET /SuivieNonConformite/supprimer_suivi/{id}
    // ================================================
    public function supprimer_suivi($id = null)
    {
        $suivi = $this->suiviModel->find($id);

        if (!$suivi) {
            return redirect()->to(site_url('SuivieNonConformite/suivi_list'))
                             ->with('error', '❌ Suivi introuvable.');
        }

        if ($this->suiviModel->delete($id)) {
            return redirect()->to(site_url('SuivieNonConformite/suivi_list'))
                             ->with('success', '✅ Suivi supprimé avec succès !');
        }

        return redirect()->to(site_url('SuivieNonConformite/suivi_list'))
                         ->with('error', '❌ Erreur lors de la suppression.');
    }

    // ================================================
    // EXPORT PDF
    // Route: GET /SuivieNonConformite/export_suivi_pdf
    // ================================================
    public function export_suivi_pdf()
    {
        $html = view('SuivieNonConformite/suivi_pdf', [
            'suivis'      => $this->suiviModel->orderBy('date_constat', 'DESC')->findAll(),
            'date_export' => date('d/m/Y à H:i'),
        ]);

        $options = new \Dompdf\Options();
        $options->set('defaultFont', 'DejaVu Sans');

        $dompdf = new \Dompdf\Dompdf($options);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->loadHtml($html);
        $dompdf->render();

        $dompdf->stream('suivi_non_conformite_' . date('Ymd') . '.pdf', [
            'Attachment' => true
        ]);
    }
}