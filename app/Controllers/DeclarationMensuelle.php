<?php
namespace App\Controllers;
use App\Models\DeclarationMensuelleModel;

class DeclarationMensuelle extends BaseController
{
    protected DeclarationMensuelleModel $model;
    protected string $pageTitle = 'Déclaration Mensuelle';

    public function __construct()
    {
        $this->model = new DeclarationMensuelleModel();
    }

    // GET /declaration
    public function index()
    {
        return view('DeclarationMensuelle/declaration_list', [
            'title' => $this->pageTitle,
            'rows'  => $this->model->getAllDeclarations(),
        ]);
    }

    // GET /declaration/getReport?mois=1&annee=2025
    public function getReport()
    {
        $mois  = (int)$this->request->getGet('mois');
        $annee = (int)$this->request->getGet('annee');

        // Validation : si mois ou annee invalides → retourner 0 sans planter
        if ($mois < 1 || $mois > 12 || $annee < 2000) {
            return $this->response->setJSON([
                'report'  => 0,
                'periode' => '--/----',
                'found'   => false,
            ]);
        }

        $moisPrec  = $mois === 1 ? 12         : $mois - 1;
        $anneePrec = $mois === 1 ? $annee - 1 : $annee;

        $db       = \Config\Database::connect();
        $declPrec = $db->table('declaration_mensuelle')
            ->where('mois',  $moisPrec)
            ->where('annee', $anneePrec)
            ->get()->getRowArray();

        return $this->response->setJSON([
            'report'  => $declPrec ? (float)$declPrec['report'] : 0,
            'periode' => sprintf('%02d/%d', $moisPrec, $anneePrec),
            'found'   => (bool)$declPrec,
        ]);
    }

    // GET /declaration/ajouter
    public function ajouter()
    {
        return $this->showForm();
    }

    // GET /declaration/modifier/1
    public function modifier(int $id)
    {
        $declaration = $this->model->find($id);
        if (!$declaration) {
            session()->setFlashdata('error', 'Déclaration introuvable.');
            return redirect()->to(site_url('declaration'));
        }
        return $this->showForm($id, $declaration);
    }

    private function showForm(int $id = null, array $declaration = null)
    {
        $db = \Config\Database::connect();

        $selCharges  = [];
        $selProduits = [];

        if ($id) {
            $selCharges  = array_column($db->table('declaration_charge')
                ->where('id_declaration', $id)->get()->getResultArray(), 'id_charge');
            $selProduits = array_column($db->table('declaration_produit')
                ->where('id_declaration', $id)->get()->getResultArray(), 'id_produit');
        }

        // ══════════════════════════════════════════════════════
        // REPORT AUTO : basé sur le mois de la déclaration
        // Mode MODIFIER  → fetch depuis BDD (mois/annee connus)
        // Mode AJOUTER   → null au départ, mis à jour via AJAX quand l'user saisit mois/annee
        // ══════════════════════════════════════════════════════
        $reportAuto = null;

        if ($id) {
            // Mode MODIFIER uniquement
            $moisRef   = (int)$declaration['mois'];
            $anneeRef  = (int)$declaration['annee'];
            $moisPrec  = $moisRef === 1 ? 12           : $moisRef - 1;
            $anneePrec = $moisRef === 1 ? $anneeRef - 1 : $anneeRef;

            $declPrec = $db->table('declaration_mensuelle')
                ->where('mois',  $moisPrec)
                ->where('annee', $anneePrec)
                ->get()->getRowArray();

            $reportAuto = [
                'valeur'  => $declPrec ? (float)$declPrec['report'] : 0,
                'periode' => sprintf('%02d/%d', $moisPrec, $anneePrec),
                'zero'    => !$declPrec || ((float)$declPrec['report'] == 0),
            ];
        }
        // Mode AJOUTER : $reportAuto reste null → AJAX fetchReportAuto() prend le relais

        return view('DeclarationMensuelle/declaration_form', [
            'title'        => $this->pageTitle,
            'declaration'  => $declaration,
            'charges'      => $db->table('charge_depense')->orderBy('date_charge', 'DESC')->get()->getResultArray(),
            'produits'     => $db->table('produits_formation')->orderBy('date_facture', 'DESC')->get()->getResultArray(),
            'sel_charges'  => $selCharges,
            'sel_produits' => $selProduits,
            'report_auto'  => $reportAuto,
        ]);
    }

    // POST /declaration/store
    public function store()
    {
        return $this->save();
    }

    // POST /declaration/update/1
    public function update(int $id)
    {
        if (!$this->model->find($id)) {
            session()->setFlashdata('error', 'Déclaration introuvable.');
            return redirect()->to(site_url('declaration'));
        }
        return $this->save($id);
    }

    private function save(int $id = null)
    {
        $post = $this->request->getPost();
        $idCharges  = (array)($post['id_charges']  ?? []);
        $idProduits = (array)($post['id_produits'] ?? []);

        $bS = (float)($post['base_salaire']   ?? 0);
        $bC = (float)($post['base_comptable'] ?? 0);
        $bF = (float)($post['base_formateur'] ?? 0);
        $bL = (float)($post['base_loyer']     ?? 0);

        $tS = (float)($post['taux_salaire']   ?? 0);
        $tC = (float)($post['taux_comptable'] ?? 0);
        $tF = (float)($post['taux_formateur'] ?? 0);
        $tL = (float)($post['taux_loyer']     ?? 0);

        $rsS = (float)($post['rs_salaire'] ?? 0); // MANUEL
        $rsC = $bC * $tC / 100;
        $rsF = $bF * $tF / 100;
        $rsL = $bL * $tL / 100;
        $totalRetenue = $rsS + $rsC + $rsF + $rsL;

        $tfp       = $bS * 0.01;
        $forprolos = $bS * 0.02;

        $tvaD   = DeclarationMensuelleModel::calcTvaDeductible($idCharges);
        $tvaC   = DeclarationMensuelleModel::calcTvaCollectee($idProduits);
        $report = (float)($post['report'] ?? 0); // report courant → sera repris le mois prochain

        // ── Report du mois précédent → entre dans TVA finale du mois courant ──
        $db2       = \Config\Database::connect();
        $mois      = (int)$post['mois'];
        $annee     = (int)$post['annee'];
        $moisPrec  = $mois === 1 ? 12        : $mois - 1;
        $anneePrec = $mois === 1 ? $annee - 1 : $annee;
        $declPrec  = $db2->table('declaration_mensuelle')
                        ->where('mois',  $moisPrec)
                        ->where('annee', $anneePrec)
                        ->get()->getRowArray();
        $reportPrec = $declPrec ? (float)$declPrec['report'] : 0;

        $tvaF  = $tvaC - $tvaD + $reportPrec;
        $tcl   = $tvaC * 0.002;
        $total = $totalRetenue + $tfp + $forprolos + max(0, $tvaF) + $tcl;

        $data = [
            'mois'           => $mois,   'annee'          => $annee,
            'base_salaire'   => $bS,     'base_comptable'  => $bC,
            'base_formateur' => $bF,     'base_loyer'      => $bL,
            'total_base'     => $bS + $bC + $bF + $bL,
            'taux_salaire'   => $tS,     'taux_comptable'  => $tC,
            'taux_formateur' => $tF,     'taux_loyer'      => $tL,
            'rs_salaire'     => $rsS,    'rs_comptable'    => $rsC,
            'rs_formateur'   => $rsF,    'rs_loyer'        => $rsL,
            'total_retenue'  => $totalRetenue,
            'tfp'            => $tfp,    'forprolos'       => $forprolos,
            'tva_deductible' => $tvaD,   'tva_collectee'   => $tvaC,
            'report'         => $report, 'tva_final'       => $tvaF,
            'tcl'            => $tcl,    'total_a_payer'   => $total,
        ];

        try {
            $db = \Config\Database::connect();
            $db->transStart();

            if ($id) {
                $this->model->update($id, $data);
                $db->table('declaration_charge')->where('id_declaration', $id)->delete();
                $db->table('declaration_produit')->where('id_declaration', $id)->delete();
            } else {
                $id = $this->model->insert($data, true);
            }

            foreach ($idCharges  as $c)
                $db->table('declaration_charge')->insert(['id_declaration' => $id, 'id_charge'  => (int)$c]);
            foreach ($idProduits as $p)
                $db->table('declaration_produit')->insert(['id_declaration' => $id, 'id_produit' => (int)$p]);

            $db->transComplete();
            session()->setFlashdata(
                $db->transStatus() ? 'success' : 'error',
                $db->transStatus() ? 'Déclaration enregistrée !' : 'Transaction échouée.'
            );
        } catch (\Throwable $e) {
            session()->setFlashdata('error', $e->getMessage());
        }

        return redirect()->to(site_url('declaration'));
    }

    // GET /declaration/supprimer/1
    public function supprimer(int $id)
    {
        $db = \Config\Database::connect();
        $db->table('declaration_charge')->where('id_declaration', $id)->delete();
        $db->table('declaration_produit')->where('id_declaration', $id)->delete();
        $this->model->delete($id);
        session()->setFlashdata('success', 'Déclaration supprimée.');
        return redirect()->to(site_url('declaration'));
    }

    // GET /declaration/pdf
    public function exportPdf()
    {
        $html = view('DeclarationMensuelle/declaration_pdf', [
            'title'        => $this->pageTitle,
            'declarations' => $this->model->getAllDeclarations(),
            'date_export'  => date('d/m/Y H:i'),
        ]);

        if (class_exists('\Dompdf\Dompdf')) {
            $dompdf = new \Dompdf\Dompdf(['isHtml5ParserEnabled' => true]);
            $dompdf->setPaper('A4', 'landscape');
            $dompdf->loadHtml($html);
            $dompdf->render();
            $dompdf->stream('declarations_' . date('Ymd') . '.pdf', ['Attachment' => false]);
            return;
        }
        return $this->response->setBody($html);
    }
}