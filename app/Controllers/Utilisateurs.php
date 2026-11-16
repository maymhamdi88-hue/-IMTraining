<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UtilisateurModel;

class Utilisateurs extends BaseController
{
    protected $utilisateurModel;

    public function __construct()
    {
        $this->utilisateurModel = new UtilisateurModel();
    }

    public function index()
    {
        return view('utilisateurs/index', [
            'title'      => 'Gestion des utilisateurs',
            'utilisateur' => $this->utilisateurModel->getUtilisateursActifs(),
        ]);
    }

    public function store()
    {
        $mdp = $this->request->getPost('mot_de_passe');

        if (empty($mdp) || strlen($mdp) < 6) {
            return redirect()->back()->withInput()
                ->with('error', 'Le mot de passe est obligatoire (minimum 6 caractères).');
        }

        $data = [
            'prenom'          => $this->request->getPost('prenom') ?? '',
            'nom_utilisateur' => $this->request->getPost('nom_utilisateur'),
            'email'           => $this->request->getPost('email')  ?: null,
            'mot_de_passe'    => $mdp, // le Model hash dans creerUtilisateur()
            'role'            => $this->request->getPost('role') ?? 'user',
            'statut'          => 1,
        ];

        try {
            if ($this->utilisateurModel->creerUtilisateur($data)) {
                return redirect()->to(site_url('utilisateurs'))
                    ->with('success', 'Utilisateur ajouté avec succès.');
            }
            $errors = $this->utilisateurModel->errors();
            $msg = !empty($errors) ? implode('<br>', $errors) : "Erreur lors de l'ajout.";
            return redirect()->back()->withInput()->with('error', $msg);

        } catch (\Throwable $e) {
            return redirect()->back()->withInput()
                ->with('error', 'Erreur : ' . $e->getMessage());
        }
    }

    public function modifier_utilisateur($id)
    {
        $utilisateur = $this->utilisateurModel->getUtilisateur($id);

        if (!$utilisateur) {
            return redirect()->to(site_url('utilisateurs'))
                ->with('error', 'Utilisateur introuvable.');
        }

        return view('utilisateurs/index', [
            'title'            => 'Gestion des utilisateurs',
            'utilisateur'      => $this->utilisateurModel->getUtilisateursActifs(),
            'utilisateur_edit' => $utilisateur,
        ]);
    }

    public function update($id)
    {
        // Récupérer données actuelles
        $actuel = $this->utilisateurModel->getUtilisateur($id);
        if (!$actuel) {
            return redirect()->to(site_url('utilisateurs'))
                ->with('error', 'Utilisateur introuvable.');
        }

        $nomPost   = $this->request->getPost('nom_utilisateur');
        $emailPost = $this->request->getPost('email') ?: null;

        // Validation uniquement pour les champs qui ont changé
        $rules = []; $messages = [];

        if ($nomPost !== $actuel['nom_utilisateur']) {
            $rules['nom_utilisateur']    = "required|min_length[3]|max_length[32]|is_unique[utilisateur.nom_utilisateur,id,{$id}]";
            $messages['nom_utilisateur'] = [
                'required'  => "Le nom d'utilisateur est obligatoire.",
                'is_unique' => "Ce nom d'utilisateur est déjà utilisé.",
            ];
        }

        if ($emailPost !== ($actuel['email'] ?? null)) {
            $rules['email']    = "permit_empty|valid_email|is_unique[utilisateur.email,id,{$id}]";
            $messages['email'] = [
                'valid_email' => 'Email invalide.',
                'is_unique'   => 'Cet email est déjà utilisé.',
            ];
        }

        if (!empty($rules) && !$this->validate($rules, $messages)) {
            return redirect()->back()->withInput()
                ->with('error', implode('<br>', $this->validator->getErrors()));
        }

        // ── Construire uniquement les champs modifiés ──
        $data = ['date_modification' => date('Y-m-d H:i:s')];

        $prenom = $this->request->getPost('prenom') ?? '';
        if ($prenom !== ($actuel['prenom'] ?? '')) {
            $data['prenom'] = $prenom;
        }

        if ($nomPost !== $actuel['nom_utilisateur']) {
            $data['nom_utilisateur'] = $nomPost;
        }

        if ($emailPost !== ($actuel['email'] ?? null)) {
            $data['email'] = $emailPost;
        }

        $role = $this->request->getPost('role') ?? 'user';
        if ($role !== $actuel['role']) {
            $data['role'] = $role;
        }

        // Mot de passe : seulement si rempli
        $mdp = trim($this->request->getPost('mot_de_passe') ?? '');
        if (!empty($mdp)) {
            if (strlen($mdp) < 6) {
                return redirect()->back()->withInput()
                    ->with('error', 'Le mot de passe doit contenir au moins 6 caractères.');
            }
            $data['mot_de_passe'] = password_hash($mdp, PASSWORD_DEFAULT);
        }

        // Rien n'a changé ?
        if (count($data) === 1) {
            return redirect()->to(site_url('utilisateurs'))
                ->with('success', 'Aucune modification détectée.');
        }

        try {
            $this->utilisateurModel->update($id, $data);
            return redirect()->to(site_url('utilisateurs'))
                ->with('success', 'Utilisateur modifié avec succès.');

        } catch (\Throwable $e) {
            return redirect()->back()->withInput()
                ->with('error', 'Erreur : ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        if ((int)$id === (int)session()->get('id')) {
            return redirect()->back()
                ->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }

        if (!$this->utilisateurModel->getUtilisateur($id)) {
            return redirect()->back()
                ->with('error', 'Utilisateur introuvable.');
        }

        try {
            $this->utilisateurModel->softDelete($id);
            return redirect()->to(site_url('utilisateurs'))
                ->with('success', 'Utilisateur supprimé avec succès.');

        } catch (\Throwable $e) {
            return redirect()->back()
                ->with('error', 'Erreur : ' . $e->getMessage());
        }
    }
}