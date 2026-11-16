<!--
================================================
VIEW: Template PDF Formateurs (formateurs_pdf.php)
================================================
Rôle: Générer un PDF professionnel des formateurs
- Format A4 Paysage
- Tous les attributs visibles
- Style professionnel avec CSS inline
================================================
-->

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Formateurs</title>
    
    <style>
        /* Style général */
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 8pt;
            margin: 0;
            padding: 15px;
        }
        
        /* En-tête */
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 3px solid #d9534f;
            padding-bottom: 10px;
        }
        
        .header h1 {
            color: #d9534f;
            margin: 0;
            font-size: 20pt;
        }
        
        .header p {
            color: #666;
            margin: 5px 0;
            font-size: 8pt;
        }
        
        /* Tableau */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        
        /* En-tête tableau */
        thead th {
            background-color: #d9534f;
            color: white;
            padding: 6px 3px;
            text-align: left;
            font-size: 7pt;
            border: 1px solid #c9302c;
        }
        
        /* Cellules */
        tbody td {
            padding: 5px 3px;
            border: 1px solid #ddd;
            font-size: 7pt;
            vertical-align: top;
        }
        
        /* Lignes alternées */
        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        /* Badge */
        .badge {
            display: inline-block;
            padding: 2px 5px;
            border-radius: 3px;
            color: white;
            font-size: 6pt;
            font-weight: bold;
        }
        
        .badge-success { background-color: #5cb85c; }
        .badge-danger { background-color: #d9534f; }
        .badge-info { background-color: #5bc0de; }
        
        /* Pied de page */
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 7pt;
            color: #999;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <!-- ======================================== -->
    <!-- EN-TÊTE -->
    <!-- ======================================== -->
    <div class="header">
        <h1>👥 Liste des Formateurs</h1>
        <p>Document généré le <?= $date_export ?></p>
        <p>Nombre total de formateurs: <strong><?= count($formateurs) ?></strong></p>
    </div>

    <!-- ======================================== -->
    <!-- TABLEAU -->
    <!-- ======================================== -->
    <table>
        <thead>
            <tr>
                <th style="width: 3%;">#</th>
                <th style="width: 10%;">Nom & Prénom</th>
                <th style="width: 7%;">Date Nais.</th>
                <th style="width: 10%;">Adresse</th>
                <th style="width: 7%;">Téléphone</th>
                <th style="width: 10%;">Email</th>
                <th style="width: 8%;">Diplôme</th>
                <th style="width: 8%;">Domaine</th>
                <th style="width: 6%;">Type</th>
                <th style="width: 6%;">Autor.</th>
                <th style="width: 6%;">Type Autor.</th>
                <th style="width: 7%;">Honoraire</th>
                <th style="width: 8%;">RIB</th>
                <th style="width: 8%;">Banque</th>
                <th style="width: 10%;">Remarque</th>
            </tr>
        </thead>
        
        <tbody>
            <?php if (!empty($formateurs)): ?>
                <?php $num = 1; ?>
                <?php foreach ($formateurs as $f): ?>
                    <tr>
                        <!-- # -->
                        <td><?= $num++ ?></td>
                        
                        <!-- Nom & Prénom -->
                        <td><?= esc($f['nom_prenom']) ?></td>
                        
                        <!-- Date naissance -->
                        <td>
                            <?php 
                            if ($f['date_naissance']) {
                                echo date('d/m/Y', strtotime($f['date_naissance']));
                            } else {
                                echo '—';
                            }
                            ?>
                        </td>
                        
                        <!-- Adresse -->
                        <td><?= esc($f['adresse'] ?? '—') ?></td>
                        
                        <!-- Téléphone -->
                        <td><?= esc($f['telephone'] ?? '—') ?></td>
                        
                        <!-- Email -->
                        <td><?= esc($f['email'] ?? '—') ?></td>
                        
                        <!-- Diplôme -->
                        <td><?= esc($f['diplome'] ?? '—') ?></td>
                        
                        <!-- Domaine -->
                        <td><?= esc($f['domaine_competence'] ?? '—') ?></td>
                        
                        <!-- Type -->
                        <td>
                            <span class="badge badge-info">
                                <?= strtoupper(esc($f['type_formateur'] ?? '—')) ?>
                            </span>
                        </td>
                        
                        <!-- Autorisation -->
                        <td>
                            <?php
                            $badge_class = 'badge-success';
                            if ($f['autorisation'] == 'sans') {
                                $badge_class = 'badge-danger';
                            }
                            ?>
                            <span class="badge <?= $badge_class ?>">
                                <?= ucfirst(esc($f['autorisation'] ?? '—')) ?>
                            </span>
                        </td>
                        
                        <!-- Type autorisation -->
                        <td><?= esc($f['type_autorisation'] ?? '—') ?></td>
                        
                        <!-- Honoraire -->
                        <td style="text-align: right;">
                            <?= number_format($f['honoraire'], 3) ?> DT
                        </td>
                        
                        <!-- RIB -->
                        <td><?= esc($f['rib'] ?? '—') ?></td>
                        
                        <!-- Banque -->
                        <td><?= esc($f['banque'] ?? '—') ?></td>
                        
                        <!-- Remarque -->
                        <td><?= esc($f['remarque'] ?? '—') ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="15" style="text-align: center;">
                        <em>Aucun formateur enregistré</em>
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