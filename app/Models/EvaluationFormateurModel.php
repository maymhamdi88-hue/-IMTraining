<?php
/*
le Model représente la couche base de données
Il permet de se connecter à la base et de gérer les opération (CRUD)
find(): récupérer un enregistrement 
findAll():  récupérer tous les enregistrement 
insert(): ajouter des données 
update(): modification des données 
delete(): supprimer des données 
*/
// définition de l'espace de noms du Model (App\Models)
namespace App\Models;
//Importation de la classe  Model de codeIgniter
//Elle fournit toutes les méthodes de base (find ,insert ,update , delete)
use CodeIgniter\Model;
//Déclaration du Model FormateurModel
//Ce Model représente la table 'evaluation_formateur' dans la base de données
class EvaluationFormateurModel extends Model
{
    //nom de la table associé à ce Model
    protected $table = 'evaluation_formateur';
    //clé primaire de la table 
    protected $primaryKey = 'id_evaluation';
    //champs autorisés pour l'insertion et la mise à jour
    // protége contre l'injection de champs non autorisés (Mass assignment)
    protected $allowedFields = [
        'id_formateur',
        'id_activite',
        'id_client',
        'date_evaluation',
        'pedagogie_methodes',
        'maitrise_technique',
        'posture_soft_skills',
        'facilite_collaboration',
        'dossier_administratif_ponctualite',
        'flexibilite_delais_paiement',
        'score_global',
        'remarque'
    ];



}
