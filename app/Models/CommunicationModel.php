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
//Déclaration du Model CommunicationModel
//Ce Model représente la table  dans la base de données
class CommunicationModel extends Model
{
    //nom de la table associé à ce Model
    protected $table = 'communication';
    //clé primaire de la table
    protected $primaryKey = 'id_communication';
    //champs autorisés pour l'insertion et la mise à jour
    // protége contre l'injection de champs non autorisés (Mass assignment)
    protected $allowedFields = [
        'id_formateur',
        'id_responsable',
        'domaine',
        'moyen_communication',
        'avis',
        'commentaire',
        'date_communication'
    ];
}
