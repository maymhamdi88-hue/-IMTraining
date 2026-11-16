<!--
================================================
VIEW: Template PDF Communications Formateurs
================================================
Rôle: Générer un PDF professionnel des communications
- Format A4 Paysage
- Tous les attributs visibles
================================================
-->

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Communications Formateurs</title>
    
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
            border-bottom: 3px solid #5cb85c;
            padding-bottom: 10px;
        }
        
        .header h1 {
            color: #5cb85c;
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
            background-color: #5cb85c;
            color: white;
            padding: 6px 3px;
            text-align: left;
            font-size: 7pt;
            border: 1px solid #4cae4c;
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
        .badge-warning { background-color: #f0ad4e; }
        
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
        <h1>💬 Historique des Communications Formateurs</h1>
        <p>Document généré le <?= $date_export ?></p>
        <p>Nombre total de communications: <strong><?= count($communications) ?></strong></p>
    </div>

    <!-- ======================================== -->
    <!-- TABLEAU -->
    <!-- ======================================== -->
    <table>
        <thead>
            <tr>
                <th style="width: 3%;">#</th>
                <th style="width: 13%;">Formateur</th>
                <th style="width: 12%;">Responsable</th>
                <th style="width: 12%;">Domaine</th>
                <th style="width: 10%;">Moyen</th>
                <th style="width: 8%;">Avis</th>
                <th style="width: 8%;">Date</th>
                <th style="width: 34%;">Commentaire</th>
            </tr>
        </thead>
        
        <tbody>
            <?php if (!empty($communications)): ?>
                <?php $num = 1; ?>
                <?php foreach ($communications as $c): ?>
                    <tr>
                        <!-- # -->
                        <td><?= $num++ ?></td>
                        
                        <!-- Formateur -->
                        <td><?= esc($formateursMap[$c['id_formateur']] ?? '—') ?></td>
                        
                        <!-- Responsable -->
                        <td><?= esc($usersMap[$c['id_responsable']] ?? '—') ?></td>
                        
                        <!-- Domaine -->
                        <td><?= esc($c['domaine'] ?? '—') ?></td>
                        
                        <!-- Moyen de communication -->
                        <td>
                            <?php
                            $badge_class = 'badge-info';
                            if ($c['moyen_communication'] == 'email') {
                                $badge_class = 'badge-info';
                            } elseif ($c['moyen_communication'] == 'reunion') {
                                $badge_class = 'badge-warning';
                            }
                            ?>
                            <span class="badge <?= $badge_class ?>">
                                <?= ucfirst(esc($c['moyen_communication'])) ?>
                            </span>
                        </td>
                        
                        <!-- Avis -->
                        <td>
                            <?php
                            $avis_badge = 'badge-info';
                            if ($c['avis'] == 'positif') {
                                $avis_badge = 'badge-success';
                            } elseif ($c['avis'] == 'negatif') {
                                $avis_badge = 'badge-danger';
                            }
                            ?>
                            <span class="badge <?= $avis_badge ?>">
                                <?= ucfirst(esc($c['avis'] ?? '—')) ?>
                            </span>
                        </td>
                        
                        <!-- Date -->
                        <td>
                            <?php 
                            if ($c['date_communication']) {
                                echo date('d/m/Y', strtotime($c['date_communication']));
                            } else {
                                echo '—';
                            }
                            ?>
                        </td>
                        
                        <!-- Commentaire -->
                        <td><?= esc($c['commentaire'] ?? '—') ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8" style="text-align: center;">
                        <em>Aucune communication enregistrée</em>
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