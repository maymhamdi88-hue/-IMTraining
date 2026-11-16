<?php

namespace App\Controllers;

use App\Models\UtilisateurModel;

class Auth extends BaseController
{
    protected $utilisateurModel;

    public function __construct()
    {
        $this->utilisateurModel = new UtilisateurModel();
    }

    /**
     * PAGE LOGIN
     */
    public function login()
    {
        // Clear any old session data
        session()->destroy();
        
        // Ken déjà connecté avec session valide, redirect
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/Home/accueil');
        }

        return view('auth/login');
    }

    /**
     * TRAITEMENT LOGIN
     */
    public function attemptLogin()
    {
        $rules = [
            'login' => 'required',
            'mot_de_passe' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Veuillez remplir tous les champs');
        }

        $login = $this->request->getPost('login');
        $motDePasse = $this->request->getPost('mot_de_passe');

        $utilisateur = $this->utilisateurModel->verifierConnexion($login, $motDePasse);

        if (!$utilisateur) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Identifiants incorrects');
        }

        // Créer session
        $sessionData = [
            'id' => $utilisateur['id'],
            'prenom' => $utilisateur['prenom'] ?? '',
            'nom_utilisateur' => $utilisateur['nom_utilisateur'],
            'email' => $utilisateur['email'],
            'role' => $utilisateur['role'],
            'isLoggedIn' => true
        ];

        session()->set($sessionData);

        return redirect()->to('/Home/accueil')
            ->with('success', 'Bienvenue ' . $utilisateur['nom_utilisateur']);
    }

    /**
     * DÉCONNEXION
     */
    public function logout()
    {
        // Destroy all session data
        session()->destroy();
        
        // Clear all cookies
        foreach ($_COOKIE as $key => $value) {
            setcookie($key, '', time() - 3600, '/');
        }
        
        // Remove session cookie
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time() - 3600, '/');
            unset($_COOKIE[session_name()]);
        }
        
        return redirect()->to('/Auth/login')
            ->with('success', 'Déconnexion réussie');
    }

    /**
     * PAGE REGISTER (Optionnelle)
     */
    public function register()
    {
        // Clear any old session data
        session()->destroy();
        
        // Ken déjà connecté, redirect
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/Home/accueil');
        }

        return view('auth/register');
    }

    /**
     * TRAITEMENT REGISTER
     */
    public function attemptRegister()
    {
        $validation = \Config\Services::validation();

        $rules = [
            'nom_utilisateur' => 'required|min_length[3]|max_length[32]|is_unique[utilisateur.nom_utilisateur]',
            'email' => 'permit_empty|valid_email|is_unique[utilisateur.email]',
            'mot_de_passe' => 'required|min_length[6]',
            'confirmer_mot_de_passe' => 'required|matches[mot_de_passe]'
        ];

        $customMessages = [
            'nom_utilisateur' => [
                'required' => 'Le nom d\'utilisateur est obligatoire',
                'min_length' => 'Le nom d\'utilisateur doit contenir au moins 3 caractères',
                'is_unique' => 'Ce nom d\'utilisateur est déjà utilisé'
            ],
            'email' => [
                'valid_email' => 'Veuillez entrer un email valide',
                'is_unique' => 'Cet email est déjà utilisé'
            ],
            'mot_de_passe' => [
                'required' => 'Le mot de passe est obligatoire',
                'min_length' => 'Le mot de passe doit contenir au moins 6 caractères'
            ],
            'confirmer_mot_de_passe' => [
                'required' => 'Veuillez confirmer le mot de passe',
                'matches' => 'Les mots de passe ne correspondent pas'
            ]
        ];

        if (!$this->validate($rules, $customMessages)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $validation->getErrors());
        }

        // Créer utilisateur
        $data = [
            'prenom' => $this->request->getPost('prenom') ?? '',
            'nom_utilisateur' => $this->request->getPost('nom_utilisateur'),
            'email' => $this->request->getPost('email') ?? null,
            'mot_de_passe' => $this->request->getPost('mot_de_passe'),
            'role' => 'user',
            'statut' => 1
        ];

        try {
            if ($this->utilisateurModel->creerUtilisateur($data)) {
                return redirect()->to('/Auth/login')
                    ->with('success', 'Inscription réussie ! Vous pouvez maintenant vous connecter.');
            }
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Erreur lors de l\'inscription: ' . $e->getMessage());
        }

        return redirect()->back()
            ->withInput()
            ->with('error', 'Erreur lors de l\'inscription');
    }
}