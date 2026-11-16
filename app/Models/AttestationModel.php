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
//Déclaration du Model AttestationModel
//Ce Model représente la table  dans la base de données
class AttestationModel extends Model
{
    //nom de la table associé à ce Model
    protected $table = 'etat_attestation';
    //clé primaire de la table
    protected $primaryKey = 'id_attestation';
    //champs autorisés pour l'insertion et la mise à jour
    // protége contre l'injection de champs non autorisés (Mass assignment)
    protected $allowedFields = [
        'id_client',
        'mode',
        'num_action',
        'theme',
        'date_preparation',
        'date_tirage',
        'date_remise'
    ];

    
}
