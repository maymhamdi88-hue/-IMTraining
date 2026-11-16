<?php

namespace App\Models;

use CodeIgniter\Model;

class UtilisateurModel extends Model
{
    protected $table = 'utilisateur';
    protected $primaryKey = 'id';
    
    protected $allowedFields = [
        'prenom',
        'nom_utilisateur',
        'mot_de_passe',
        'email',
        'statut',
        'role',
        'derniere_connexion',
        'date_modification'
    ];
    
    protected $useTimestamps = false;
    
    protected $validationRules = [
        'nom_utilisateur' => 'required|min_length[3]|max_length[32]|is_unique[utilisateur.nom_utilisateur,id,{id}]',
        'email' => 'permit_empty|valid_email|is_unique[utilisateur.email,id,{id}]',
        'mot_de_passe' => 'required|min_length[6]'
    ];
    
    protected $validationMessages = [
        'nom_utilisateur' => [
            'required' => 'Le nom d\'utilisateur est requis',
            'is_unique' => 'Ce nom d\'utilisateur est déjà utilisé'
        ],
        'email' => [
            'is_unique' => 'Cet email est déjà utilisé'
        ]
    ];

    /**
     * Vérifier les identifiants de connexion
     */
    public function verifierConnexion($login, $motDePasse)
    {
        // Recherche par nom_utilisateur ou email
        $builder = $this->builder();
        $utilisateur = $builder->where('nom_utilisateur', $login)
                              ->orWhere('email', $login)
                              ->where('date_suppression IS NULL')
                              ->get()
                              ->getRowArray();

        if (!$utilisateur) {
            return false;
        }

        // Vérifier le statut
        if ($utilisateur['statut'] != 1) {
            return false;
        }

        // Vérifier le mot de passe
        if (password_verify($motDePasse, $utilisateur['mot_de_passe'])) {
            // Mettre à jour la dernière connexion
            $this->update($utilisateur['id'], [
                'derniere_connexion' => date('Y-m-d H:i:s'),
                'date_modification' => date('Y-m-d H:i:s')
            ]);
            
            return $utilisateur;
        }

        return false;
    }

    /**
     * Créer un nouvel utilisateur
     */
    public function creerUtilisateur($data)
    {
        // Hasher le mot de passe
        if (isset($data['mot_de_passe'])) {
            $data['mot_de_passe'] = password_hash($data['mot_de_passe'], PASSWORD_DEFAULT);
        }

        // Valeurs par défaut
        $data['statut'] = $data['statut'] ?? 1;
        $data['role'] = $data['role'] ?? 'user';

        return $this->insert($data);
    }

    /**
     * Obtenir utilisateur par ID (non supprimé)
     */
    public function getUtilisateur($id)
    {
        return $this->where('id', $id)
                    ->where('date_suppression IS NULL')
                    ->first();
    }

    /**
     * Obtenir tous les utilisateurs actifs (non supprimés)
     */
    public function getUtilisateursActifs()
    {
        return $this->where('statut', 1)
                    ->where('date_suppression IS NULL')
                    ->findAll();
    }

    /**
     * Soft delete - marquer comme supprimé
     */
    public function softDelete($id)
    {
        return $this->update($id, [
            'date_suppression' => date('Y-m-d H:i:s'),
            'date_modification' => date('Y-m-d H:i:s'),
            'statut' => 0
        ]);
    }

    /**
     * Modifier le mot de passe
     */
    public function changerMotDePasse($id, $nouveauMotDePasse)
    {
        return $this->update($id, [
            'mot_de_passe' => password_hash($nouveauMotDePasse, PASSWORD_DEFAULT),
            'date_modification' => date('Y-m-d H:i:s')
        ]);
    }
}