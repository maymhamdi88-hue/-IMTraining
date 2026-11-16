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
//Déclaration du Model ClientCabinetModel
//Ce Model représente la table 'clients_cabinet' dans la base de données
class ClientCabinetModel extends Model
{
    //nom de la table associé à ce Model
    protected $table = 'clients_cabinet';
    //clé primaire de la table 
    protected $primaryKey = 'id_client';
    //champs autorisés pour l'insertion et la mise à jour
    // protége contre l'injection de champs non autorisés (Mass assignment)
    protected $allowedFields = [
        'nom_societe',
        'activite',
        'secteur',
        'matricule_fiscal',
        'responsable',
        'adresse',
        'telephone',
        'fax',
        'email',
        'site_web',
        'personne_contactee',
        'mob_tel',
        'email_contact'
    ];

    
}
