<?php
// ================================================
// LIBRARY: Pdf.php
// ================================================
// Rôle: Wrapper pour utiliser Dompdf dans CodeIgniter
// Permet de générer des PDF facilement
// ================================================

namespace App\Libraries;

// Import de la bibliothèque Dompdf installée via Composer
// Le fichier vendor/autoload.php charge automatiquement toutes les dépendances
require_once ROOTPATH . 'vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

/**
 * Classe Pdf
 * Encapsule Dompdf pour faciliter son utilisation dans CodeIgniter
 */
class Pdf
{
    protected $dompdf;
    
    /**
     * Constructeur - Initialise Dompdf avec options de configuration
     */
    public function __construct()
    {
        // Configuration des options Dompdf
        $options = new Options();
        
        // Active le parser HTML5 (support des balises modernes)
        $options->set('isHtml5ParserEnabled', true);
        
        // Permet de charger des ressources externes (images, CSS...)
        $options->set('isRemoteEnabled', true);
        
        // Police par défaut (DejaVu Sans supporte bien l'UTF-8)
        $options->set('defaultFont', 'DejaVu Sans');
        
        // Création de l'instance Dompdf avec les options
        $this->dompdf = new Dompdf($options);
    }
    
    /**
     * Charger le contenu HTML à convertir en PDF
     * @param string $html - Code HTML complet
     */
    public function loadHtml($html)
    {
        $this->dompdf->loadHtml($html);
    }
    
    /**
     * Définir le format et l'orientation du PDF
     * @param string $size - Format du papier (A4, A3, Letter, Legal...)
     * @param string $orientation - Orientation: 'portrait' (vertical) ou 'landscape' (horizontal)
     */
    public function setPaper($size = 'A4', $orientation = 'portrait')
    {
        $this->dompdf->setPaper($size, $orientation);
    }
    
    /**
     * Générer le PDF à partir du HTML chargé
     * Cette méthode doit être appelée avant stream() ou output()
     */
    public function render()
    {
        $this->dompdf->render();
    }
    
    /**
     * Envoyer le PDF au navigateur (téléchargement ou affichage)
     * @param string $filename - Nom du fichier PDF
     * @param array $options - ['Attachment' => true] pour forcer le téléchargement
     *                         ['Attachment' => false] pour afficher dans le navigateur
     * @return void
     */
    public function stream($filename = 'document.pdf', $options = [])
    {
        return $this->dompdf->stream($filename, $options);
    }
    
    /**
     * Récupérer le contenu PDF en chaîne binaire
     * Utile si vous voulez sauvegarder le PDF dans un fichier
     * @return string - Contenu binaire du PDF
     */
    public function output()
    {
        return $this->dompdf->output();
    }
}