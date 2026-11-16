<!--
================================================
VIEW: Template PDF Employés (employe_pdf.php)
================================================
Rôle: Générer un PDF professionnel des employés
- Format A4 Paysage (Landscape)
- Style professionnel avec CSS inline
================================================
-->

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Employés</title>
    
    <!-- Styles CSS inline (obligatoire pour PDF) -->
    <style>
        /* Style général du document */
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 10pt;
            margin: 0;
            padding: 20px;
        }
        
        /* En-tête du document */
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #d9534f;
            padding-bottom: 15px;
        }
        
        .header h1 {
            color: #d9534f;
            margin: 0;
            font-size: 24pt;
        }
        
        .header p {
            color: #666;
            margin: 5px 0;
            font-size: 9pt;
        }
        
        /* Tableau */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        /* En-tête du tableau */
        thead th {
            background-color: #d9534f;
            color: white;
            padding: 10px 5px;
            text-align: left;
            font-size: 9pt;
            border: 1px solid #c9302c;
        }
        
        /* Cellules du tableau */
        tbody td {
            padding: 8px 5px;
            border: 1px solid #ddd;
            font-size: 8pt;
            vertical-align: top;
        }
        
        /* Lignes alternées */
        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        tbody tr:hover {
            background-color: #f5f5f5;
        }
        
        /* Badge statut */
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            color: white;
            font-size: 7pt;
            font-weight: bold;
        }
        
        .badge-success { background-color: #5cb85c; }
        .badge-danger { background-color: #d9534f; }
        .badge-info { background-color: #5bc0de; }
        
        /* Pied de page */
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 8pt;
            color: #999;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <!-- ======================================== -->
    <!-- EN-TÊTE DU PDF -->
    <!-- ======================================== -->
    <div class="header">
        <h1>👥 Liste des Employés</h1>
        <p>Document généré le <?= $date_export ?></p>
        <p>Nombre total d'employés: <strong><?= count($employes) ?></strong></p>
    </div>

    <!-- ======================================== -->
    <!-- TABLEAU DES DONNÉES -->
    <!-- ======================================== -->
    <table>
        <!-- En-tête -->
        <thead>
            <tr>
                <th style="width: 5%;">#</th>
                <th style="width: 12%;">Nom</th>
                <th style="width: 12%;">Prénom</th>
                <th style="width: 13%;">Poste</th>
                <th style="width: 10%;">Date Embauche</th>
                <th style="width: 10%;">Type Contrat</th>
                <th style="width: 10%;">Salaire</th>
                <th style="width: 15%;">Email</th>
                <th style="width: 8%;">Statut</th>
            </tr>
        </thead>
        
        <!-- Corps du tableau -->
        <tbody>
            <?php if (!empty($employes)): ?>
                <?php $num = 1; ?>
                <?php foreach ($employes as $e): ?>
                    <tr>
                        <!-- Numéro -->
                        <td><?= $num++ ?></td>
                        
                        <!-- Nom -->
                        <td><?= esc($e['nom']) ?></td>
                        
                        <!-- Prénom -->
                        <td><?= esc($e['prenom']) ?></td>
                        
                        <!-- Poste -->
                        <td><?= esc($e['poste']) ?></td>
                        
                        <!-- Date d'embauche -->
                        <td>
                            <?php 
                            if ($e['date_embauche']) {
                                echo date('d/m/Y', strtotime($e['date_embauche']));
                            } else {
                                echo '—';
                            }
                            ?>
                        </td>
                        
                        <!-- Type contrat -->
                        <td>
                            <span class="badge badge-info">
                                <?= strtoupper(esc($e['type_contrat'] ?? '—')) ?>
                            </span>
                        </td>
                        
                        <!-- Salaire -->
                        <td style="text-align: right;">
                            <?= number_format($e['salaire_base'], 3) ?> DT
                        </td>
                        
                        <!-- Email -->
                        <td><?= esc($e['email'] ?? '—') ?></td>
                        
                        <!-- Statut avec badge -->
                        <td>
                            <?php
                            $badge_class = 'badge-success';
                            if ($e['statut'] == 'suspendu') {
                                $badge_class = 'badge-danger';
                            }
                            ?>
                            <span class="badge <?= $badge_class ?>">
                                <?= ucfirst(esc($e['statut'] ?? 'actif')) ?>
                            </span>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="9" style="text-align: center;">
                        <em>Aucun employé enregistré</em>
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- ======================================== -->
    <!-- PIED DE PAGE -->
    <!-- ======================================== -->
    <div class="footer">
        <p>© <?= date('Y') ?> - Votre Organisation - Tous droits réservés</p>
        <p>Document généré automatiquement</p>
    </div>
</body>
</html>
