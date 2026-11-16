<?php
namespace App\Models;
use CodeIgniter\Model;

class EvaluationClientModel extends Model
{
    protected $table      = 'evaluation_client';
    protected $primaryKey = 'id_evaluation';

    protected $allowedFields = [
        'id_client',
        'anciennete_relation',
        'solvabilite',
        'respect_echeances',
        'delai_paiement',
        'litiges_paiement',
        'commentaire_financier',
        'nb_formations',
        'nb_themes',
        'budget_annuel',
        'recurrence',
        'qualite_communication',
        'clarte_demandes',
        'respect_engagements',
        'facilite_collaboration',
        'potentiel_nouvelles_formations',
        'ouverture_innovations',
        'partenariat_long_terme',
        'client_strategique',
        'niveau_priorite',
        'decision_interne',
    ];
}