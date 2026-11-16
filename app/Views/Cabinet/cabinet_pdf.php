<!--
================================================
VIEW: Template PDF Clients Cabinet (cabinet_pdf.php)
================================================
Rôle: Générer un PDF professionnel des clients cabinet
- Format A4 Paysage (Landscape)
- Style professionnel avec CSS inline
================================================
-->

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Clients Cabinet</title>
    
    <!-- Styles CSS inline (obligatoire pour PDF) -->
    <style>
        /* Style général du document */
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 9pt;
            margin: 0;
            padding: 20px;
        }
        
        /* En-tête du document */
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #337ab7;
            padding-bottom: 15px;
        }
        
        .header h1 {
            color: #337ab7;
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
            background-color: #337ab7;
            color: white;
            padding: 8px 4px;
            text-align: left;
            font-size: 8pt;
            border: 1px solid #2e6da4;
        }
        
        /* Cellules du tableau */
        tbody td {
            padding: 6px 4px;
            border: 1px solid #ddd;
            font-size: 7pt;
            vertical-align: top;
        }
        
        /* Lignes alternées */
        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
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
        <h1>🏢 Liste des Clients Cabinet</h1>
        <p>Document généré le <?= $date_export ?></p>
        <p>Nombre total de clients: <strong><?= count($clients) ?></strong></p>
    </div>

    <!-- ======================================== -->
    <!-- TABLEAU DES DONNÉES -->
    <!-- ======================================== -->
    <table>
        <!-- En-tête -->
        <thead>
            <tr>
                <th style="width: 4%;">#</th>
                <th style="width: 14%;">Nom société</th>
                <th style="width: 10%;">Matricule</th>
                <th style="width: 10%;">Secteur</th>
                <th style="width: 12%;">Activité</th>
                <th style="width: 10%;">Responsable</th>
                <th style="width: 15%;">Adresse</th>
                <th style="width: 10%;">Téléphone</th>
                <th style="width: 15%;">Email société</th>
                <th style="width: 10%;">Mobile</th>              
                <th style="width: 10%;">Fax</th>                   
                <th style="width: 10%;">Site Web</th>              
                <th style="width: 10%;">Personne Contactée</th>    
                <th style="width: 15%;">Email Contact</th>     
            </tr>
        </thead>
        
        <!-- Corps du tableau -->
        <tbody>
            <?php if (!empty($clients)): ?>
                <?php $num = 1; ?>
                <?php foreach ($clients as $c): ?>
                    <tr>
                        <!-- Numéro -->
                        <td><?= $num++ ?></td>
                        
                        <!-- Nom société -->
                        <td><strong><?= esc($c['nom_societe']) ?></strong></td>
                        
                        <!-- Matricule -->
                        <td><?= esc($c['matricule_fiscal']) ?></td>
                        
                        <!-- Secteur -->
                        <td><?= esc($c['secteur'] ?? '—') ?></td>
                        
                        <!-- Activité -->
                        <td><?= esc($c['activite'] ?? '—') ?></td>
                        
                        <!-- Responsable -->
                        <td><?= esc($c['responsable']) ?></td>
                        
                        <!-- Adresse (limitée à 50 caractères) -->
                        <td>
                            <?php 
                            $adresse = esc($c['adresse'] ?? '—');
                            if (strlen($adresse) > 50) {
                                echo substr($adresse, 0, 50) . '...';
                            } else {
                                echo $adresse;
                            }
                            ?>
                        </td>
                        
                        <!-- Téléphone -->
                        <td><?= esc($c['telephone'] ?? '—') ?></td>
                        
                        <!-- Email -->
                        <td><?= esc($c['email']) ?></td>
                        <!-- Mobile -->
                        <td><?= esc($c['mob_tel'] ?? '—') ?></td>

                        <!-- Fax -->
                        <td><?= esc($c['fax'] ?? '—') ?></td>

                        <!-- Site Web-->
                        <td><?= esc($c['site_web'] ?? '—') ?></td>

                        <!-- Personne Contactée-->
                        <td><?= esc($c['personne_contactee'] ?? '—') ?></td>

                        <!-- Email Contact-->
                        <td><?= esc($c['email_contact'] ?? '—') ?></td>

                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="9" style="text-align: center;">
                        <em>Aucun client cabinet enregistré</em>
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
