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
//Déclaration du Model ChargeDepenseModel
//Ce Model représente la table  dans la base de données
class ChargeDepenseModel extends Model
{
    //nom de la table associé à ce Model
    protected $table = 'charge_depense';
    //clé primaire de la table 
    protected $primaryKey = 'id_charge';
    //champs autorisés pour l'insertion et la mise à jour
    // protége contre l'injection de champs non autorisés (Mass assignment)
    protected $allowedFields = [
        'type_charge',
        'date_charge',
        'fournisseur',
        'banque_poste',
        'mode_paiement',
        'designation',
        'montant_htva',
        'montant_tva',
        'montant_ttc',
        'montant_net',
        'id_employe',
        'remarque'
    ];

   

  
}
