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
//Déclaration du Model ProduitFormationModel
//Ce Model représente la table  dans la base de données
class ProduitFormationModel extends Model
{
    //nom de la table associé à ce Model
    protected $table = 'produits_formation';
    //clé primaire de la table 
    protected $primaryKey = 'id_produit';
    //champs autorisés pour l'insertion et la mise à jour
    // protége contre l'injection de champs non autorisés (Mass assignment)
    protected $allowedFields = [
        'id_client',
        'id_activite',
        'id_formateur',
        'type_activite',
        'theme_domaine',
        'date_prestation',
        'honoraire',
        'montant_unitaire',
        'nombre_heures_jour',
        'nombre_jours',
        'mhtva',
        'taux_tva',
        'tva',
        'mttc',
        'taux_ras',
        'ras',
        'montant_net',
        'mode_paiement',
        'numero_action',
        'numero_facture',
        'date_facture',
        'date_entree',
        'date_sortie',
        'date_certificat_ras',
        'mois_declaration',
        'remarque'
    ];

   

  
}
