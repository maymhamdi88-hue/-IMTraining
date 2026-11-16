<?php
/*
================================================
MODEL: ResultatIndicateurAnnuelModel
================================================
✅ CORRIGÉ: Ajout de 'resultat_annee_n1' dans allowedFields
================================================
*/
namespace App\Models;

use CodeIgniter\Model;

class ResultatIndicateurAnnuelModel extends Model
{
    protected $table      = 'resultat_indicateur_annuel';
    protected $primaryKey = 'id_resultat';
    
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    
    // ✅ TOUS les champs de la table (13 champs)
    protected $allowedFields = [
        'annee',
        'processus',
        'objectif',
        'indicateur',
        'mode_calcul',
        'resultat',                // Note: ce champ existe dans form mais pas dans DB structure que tu as montré
        'frequence_suivi',
        'cible_annee_n',
        'resultat_annee_n',
        'cible_annee_n1',
        'resultat_annee_n1',      // ✅ AJOUTÉ (manquant avant!)
        'visa_direction',
        'remarque'
    ];
    
    // ✅ Timestamps automatiques (created_at existe dans DB)
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = ''; // Pas de updated_at dans ta table
    
    // Validation rules
    protected $validationRules = [
        'annee'          => 'required|integer|greater_than[1999]|less_than[2101]',
        'processus'      => 'required|min_length[2]|max_length[150]',
        'objectif'       => 'required',
        'indicateur'     => 'required',
        'frequence_suivi'=> 'required|in_list[Mensuelle,Trimestrielle,Semestrielle,Annuelle]',
    ];
    
    protected $validationMessages = [
        'annee' => [
            'required' => 'L\'année est obligatoire',
            'integer'  => 'L\'année doit être un nombre',
        ],
        'processus' => [
            'required' => 'Le processus est obligatoire',
        ],
    ];
    
    protected $skipValidation = false;
}