<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Accueil - Dashboard',
            // Taw ta3mel requêtes lil database bech tjib data réelle
            'formations_count' => 12,
            'clients_count' => 44,
            'intervenants_count' => 8,
            'operations_count' => 28
        ];
        
        return view('accueil', $data);
    }
    
    public function accueil()
    {
        return $this->index();
    }
}