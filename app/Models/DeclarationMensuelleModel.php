<?php
namespace App\Models;
use CodeIgniter\Model;

class DeclarationMensuelleModel extends Model
{
    protected $table      = 'declaration_mensuelle';
    protected $primaryKey = 'id_declaration';
    protected $allowedFields = [
        'mois','annee',
        'base_salaire','base_comptable','base_formateur','base_loyer','total_base',
        'taux_salaire','taux_comptable','taux_formateur','taux_loyer',
        'rs_salaire','rs_comptable','rs_formateur','rs_loyer','total_retenue',
        'tfp','forprolos',
        'tva_deductible','tva_collectee','report','tva_final','tcl','total_a_payer'
    ];

    public function getAllDeclarations()
    {
        return $this->orderBy('annee DESC, mois DESC')->findAll();
    }

    // Calcul côté serveur — sécurité
    public static function calcTvaDeductible(array $ids): float
    {
        if (empty($ids)) return 0.0;
        $db = \Config\Database::connect();
        return (float) $db->table('charge_depense')
            ->selectSum('montant_ttc')
            ->whereIn('id_charge', $ids)
            ->get()->getRow()->montant_ttc;
    }

    public static function calcTvaCollectee(array $ids): float
    {
        if (empty($ids)) return 0.0;
        $db = \Config\Database::connect();
        return (float) $db->table('produits_formation')
            ->selectSum('mttc')
            ->whereIn('id_produit', $ids)
            ->get()->getRow()->mttc;
    }
}