<?php
namespace App\Controllers;

use App\Controllers\BaseController;

class TestPdf extends BaseController
{
    /**
     * Test simple pour vérifier que Dompdf fonctionne
     * URL: http://localhost/ton_projet/public/testpdf
     */
    public function index()
    {
        // Chargement de la library PDF
        $pdf = new \App\Libraries\Pdf();
        
        // HTML simple pour le test
        $html = '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <style>
                body { font-family: DejaVu Sans; }
                h1 { color: #d9534f; text-align: center; }
                p { font-size: 14pt; }
            </style>
        </head>
        <body>
            <h1>✅ Test PDF - CodeIgniter + Dompdf</h1>
            <p>Si vous voyez ce message, l\'installation est réussie! 🎉</p>
            <p>Date de génération: ' . date('d/m/Y H:i:s') . '</p>
        </body>
        </html>
        ';
        
        // Configuration et génération du PDF
        $pdf->loadHtml($html);
        $pdf->setPaper('A4', 'portrait');
        $pdf->render();
        
        // Télécharger le PDF
        $pdf->stream('test_pdf.pdf', ['Attachment' => true]);
    }
}