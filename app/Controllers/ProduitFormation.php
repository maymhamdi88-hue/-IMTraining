<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProduitFormationModel;
use App\Models\ClientCabinetModel;
use App\Models\ActiviteModel;
use App\Models\FormateurModel;

class ProduitFormation extends BaseController
{
    protected $produitModel;
    protected $clientModel;
    protected $activiteModel;
    protected $formateurModel;

    public function __construct()
    {
        $this->produitModel   = new ProduitFormationModel();
        $this->clientModel    = new ClientCabinetModel();
        $this->activiteModel  = new ActiviteModel();
        $this->formateurModel = new FormateurModel();
    }

    // =========================================================
    // HELPER — JOIN pour récupérer toutes les données liste
    // =========================================================
    private function getRows(): array
    {
        $db = \Config\Database::connect();
        return $db->table('produits_formation p')
            ->select('p.*, 
                      c.nom_societe,
                      a.reference, a.type_activite, a.theme_domaine, a.date_prestation,
                      f.nom_prenom')
            ->join('clients_cabinet c', 'c.id_client = p.id_client', 'left')
            ->join('activites a',       'a.id_activite = p.id_activite', 'left')
            ->join('formateur f',       'f.id_formateur = p.id_formateur', 'left')
            ->orderBy('p.id_produit', 'ASC')
            ->get()->getResultArray();
    }

    // =========================================================
    // LISTE
    // URL: base_url() . "ProduitFormation/produits_list"
    // =========================================================
    public function produits_list()
    {
        $data = [
            'title' => 'Produits Formation',
            'rows'  => $this->getRows(),
        ];
        return view('ProduitFormation/produits_list', $data);
    }

    // =========================================================
    // FORMULAIRE AJOUT
    // URL: base_url() . "ProduitFormation/produits_ajouter_form"
    // =========================================================
    public function produits_ajouter_form()
    {
        $data = [
            'title'      => 'Produits Formation',
            'clients'    => $this->clientModel->findAll(),
            'activites'  => $this->activiteModel->findAll(),
            'formateurs' => $this->formateurModel->findAll(),
        ];
        return view('ProduitFormation/produits_form', $data);
    }

    // =========================================================
    // STORE (POST)
    // URL: base_url() . "ProduitFormation/produits_store"
    // =========================================================
    public function produits_store()
    {
        $rules = [
            'id_client'       => 'required|integer',
            'id_activite'     => 'required|integer',
            'montant_unitaire'=> 'required|decimal',
            'taux_tva'        => 'required|decimal',
            'taux_ras'        => 'required|decimal',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()
                ->with('error', implode('<br>', $this->validator->getErrors()));
        }

        $post = $this->request->getPost();

        $this->produitModel->insert([
            'id_client'           => $post['id_client'],
            'id_activite'         => $post['id_activite'],
            'id_formateur'        => $post['id_formateur']       ?: null,
            'type_activite'       => $post['type_activite']      ?: null,
            'theme_domaine'       => $post['theme_domaine']      ?: null,
            'date_prestation'     => $post['date_prestation']    ?: null,
            'honoraire'           => $post['honoraire']          ?: null,
            'montant_unitaire'    => $post['montant_unitaire'],
            'nombre_heures_jour'  => $post['nombre_heures_jour'] ?: null,
            'nombre_jours'        => $post['nombre_jours']       ?: null,
            'mhtva'               => $post['mhtva']              ?: null,
            'taux_tva'            => $post['taux_tva'],
            'tva'                 => $post['tva']                ?: null,
            'mttc'                => $post['mttc']               ?: null,
            'taux_ras'            => $post['taux_ras'],
            'ras'                 => $post['ras']                ?: null,
            'montant_net'         => $post['montant_net']        ?: null,
            'mode_paiement'       => $post['mode_paiement']      ?: null,
            'numero_action'       => $post['numero_action']      ?: null,
            'numero_facture'      => $post['numero_facture']     ?: null,
            'date_facture'        => $post['date_facture']       ?: null,
            'date_entree'         => $post['date_reglement']     ?: null,
            'date_sortie'         => $post['date_sortie']        ?: null,
            'date_certificat_ras' => $post['date_certificat_ras']?: null,
            'mois_declaration'    => $post['mois_declaration']   ?: null,
            'remarque'            => $post['remarque']           ?: null,
        ]);

        return redirect()->to(base_url('ProduitFormation/produits_list'))
            ->with('success', 'Produit ajouté avec succès.');
    }

    // =========================================================
    // FORMULAIRE MODIFICATION
    // URL: base_url() . "ProduitFormation/produits_modifier_form/{id}"
    // =========================================================
    public function produits_modifier_form($id)
    {
        $produit = $this->produitModel->find($id);

        if (!$produit) {
            return redirect()->to(base_url('ProduitFormation/produits_list'))
                ->with('error', 'Produit introuvable.');
        }

        $data = [
            'title'      => 'Produits Formation',
            'produit'    => $produit,
            'clients'    => $this->clientModel->findAll(),
            'activites'  => $this->activiteModel->findAll(),
            'formateurs' => $this->formateurModel->findAll(),
        ];
        return view('ProduitFormation/produits_form', $data);
    }

    // =========================================================
    // UPDATE (POST)
    // URL: base_url() . "ProduitFormation/produits_update/{id}"
    // =========================================================
    public function produits_update($id)
    {
        if (!$this->produitModel->find($id)) {
            return redirect()->to(base_url('ProduitFormation/produits_list'))
                ->with('error', 'Produit introuvable.');
        }

        $rules = [
            'id_client'       => 'required|integer',
            'id_activite'     => 'required|integer',
            'montant_unitaire'=> 'required|decimal',
            'taux_tva'        => 'required|decimal',
            'taux_ras'        => 'required|decimal',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()
                ->with('error', implode('<br>', $this->validator->getErrors()));
        }

        $post = $this->request->getPost();

        $this->produitModel->update($id, [
            'id_client'           => $post['id_client'],
            'id_activite'         => $post['id_activite'],
            'id_formateur'        => $post['id_formateur']       ?: null,
            'type_activite'       => $post['type_activite']      ?: null,
            'theme_domaine'       => $post['theme_domaine']      ?: null,
            'date_prestation'     => $post['date_prestation']    ?: null,
            'honoraire'           => $post['honoraire']          ?: null,
            'montant_unitaire'    => $post['montant_unitaire'],
            'nombre_heures_jour'  => $post['nombre_heures_jour'] ?: null,
            'nombre_jours'        => $post['nombre_jours']       ?: null,
            'mhtva'               => $post['mhtva']              ?: null,
            'taux_tva'            => $post['taux_tva'],
            'tva'                 => $post['tva']                ?: null,
            'mttc'                => $post['mttc']               ?: null,
            'taux_ras'            => $post['taux_ras'],
            'ras'                 => $post['ras']                ?: null,
            'montant_net'         => $post['montant_net']        ?: null,
            'mode_paiement'       => $post['mode_paiement']      ?: null,
            'numero_action'       => $post['numero_action']      ?: null,
            'numero_facture'      => $post['numero_facture']     ?: null,
            'date_facture'        => $post['date_facture']       ?: null,
            'date_entree'         => $post['date_reglement']     ?: null,
            'date_sortie'         => $post['date_sortie']        ?: null,
            'date_certificat_ras' => $post['date_certificat_ras']?: null,
            'mois_declaration'    => $post['mois_declaration']   ?: null,
            'remarque'            => $post['remarque']           ?: null,
        ]);

        return redirect()->to(base_url('ProduitFormation/produits_list'))
            ->with('success', 'Produit modifié avec succès.');
    }

    // =========================================================
    // DELETE
    // URL: base_url() . "ProduitFormation/produits_supprimer/{id}"
    // =========================================================
    public function produits_supprimer($id)
    {
        if (!$this->produitModel->find($id)) {
            return redirect()->to(base_url('ProduitFormation/produits_list'))
                ->with('error', 'Produit introuvable.');
        }

        $this->produitModel->delete($id);

        return redirect()->to(base_url('ProduitFormation/produits_list'))
            ->with('success', 'Produit supprimé avec succès.');
    }

    // =========================================================
    // EXPORT PDF
    // URL: base_url() . "ProduitFormation/produits_export_pdf"
    // =========================================================
    public function produits_export_pdf()
    {
        $data = [
            'produits'    => $this->getRows(),
            'date_export' => date('d/m/Y H:i'),
        ];

        $html = view('ProduitFormation/produits_pdf', $data);

        $options = new \Dompdf\Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new \Dompdf\Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        $dompdf->stream('produits_formation_' . date('Ymd') . '.pdf', ['Attachment' => true]);
        exit;
    }
}