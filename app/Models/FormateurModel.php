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
//Ce Model représente la table 'formateur' dans la base de données
class FormateurModel extends Model
{
    //nom de la table associé à ce Model
    protected $table = 'formateur';
    //clé primaire de la table   
    protected $primaryKey = 'id_formateur'; 
    //champs autorisés pour l'insertion et la mise à jour
    // protége contre l'injection de champs non autorisés (Mass assignment)
    protected $allowedFields = [
        'nom_prenom',
        'date_naissance',
        'adresse',
        'telephone',
        'email',
        'diplome',
        'domaine_competence',
        'type_formateur',
        'autorisation',
        'type_autorisation',
        'honoraire',
        'remarque',
        'rib',
        'banque',
    ];
}
