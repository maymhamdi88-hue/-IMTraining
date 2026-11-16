<!--
================================================
VIEW: Template PDF Formateurs Potentiels
================================================
Rôle: Générer un PDF professionnel
- Format A4 Paysage
- Tous les attributs visibles
================================================
-->

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Formateurs Potentiels</title>
    
    <style>
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 8pt;
            margin: 0;
            padding: 15px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 3px solid #5bc0de;
            padding-bottom: 10px;
        }
        
        .header h1 {
            color: #5bc0de;
            margin: 0;
            font-size: 20pt;
        }
        
        .header p {
            color: #666;
            margin: 5px 0;
            font-size: 8pt;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        
        thead th {
            background-color: #5bc0de;
            color: white;
            padding: 6px 3px;
            text-align: left;
            font-size: 7pt;
            border: 1px solid #46b8da;
        }
        
        tbody td {
            padding: 5px 3px;
            border: 1px solid #ddd;
            font-size: 7pt;
            vertical-align: top;
        }
        
        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
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
        <h1>🌟 Liste des Formateurs Potentiels</h1>
        <p>Document généré le <?= $date_export ?></p>
        <p>Nombre total: <strong><?= count($formateur_potentiel) ?></strong></p>
    </div>

    <!-- ======================================== -->
    <!-- TABLEAU -->
    <!-- ======================================== -->
    <table>
        <thead>
            <tr>
                <th style="width: 3%;">#</th>
                <th style="width: 12%;">Nom & Prénom</th>
                <th style="width: 8%;">Date Nais.</th>
                <th style="width: 12%;">Adresse</th>
                <th style="width: 8%;">Téléphone</th>
                <th style="width: 12%;">Email</th>
                <th style="width: 10%;">Diplôme</th>
                <th style="width: 10%;">Domaine</th>
                <th style="width: 8%;">Type</th>
                <th style="width: 7%;">Autor.</th>
                <th style="width: 8%;">Type Autor.</th>
                <th style="width: 8%;">Honoraire</th>
                <th style="width: 10%;">Remarque</th>
            </tr>
        </thead>
        
        <tbody>
            <?php if (!empty($formateur_potentiel)): ?>
                <?php $num = 1; ?>
                <?php foreach ($formateur_potentiel as $f): ?>
                    <tr>
                        <td><?= $num++ ?></td>
                        <td><?= esc($f['nom_prenom']) ?></td>
                        <td>
                            <?php 
                            if ($f['date_naissance']) {
                                echo date('d/m/Y', strtotime($f['date_naissance']));
                            } else {
                                echo '—';
                            }
                            ?>
                        </td>
                        <td><?= esc($f['adresse'] ?? '—') ?></td>
                        <td><?= esc($f['telephone'] ?? '—') ?></td>
                        <td><?= esc($f['email'] ?? '—') ?></td>
                        <td><?= esc($f['diplome'] ?? '—') ?></td>
                        <td><?= esc($f['domaine_competence'] ?? '—') ?></td>
                        <td>
                            <span class="badge badge-info">
                                <?= strtoupper(esc($f['type_formateur_potentiel'] ?? '—')) ?>
                            </span>
                        </td>
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
                        <td><?= esc($f['type_autorisation'] ?? '—') ?></td>
                        <td style="text-align: right;">
                            <?= number_format($f['honoraire'], 3) ?> DT
                        </td>
                        <td><?= esc($f['remarque'] ?? '—') ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="12" style="text-align: center;">
                        <em>Aucun formateur potentiel enregistré</em>
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