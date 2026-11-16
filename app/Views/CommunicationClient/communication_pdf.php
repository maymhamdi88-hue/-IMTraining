<!--
================================================
VIEW: Template PDF Communications (communication_pdf.php)
================================================
Rôle: Générer un PDF avec TOUS les attributs
================================================
-->

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Historique des Communications</title>
    
    <!-- Styles CSS inline (obligatoire pour PDF) -->
    <style>
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 9pt;
            margin: 0;
            padding: 20px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #5bc0de;
            padding-bottom: 15px;
        }
        
        .header h1 {
            color: #5bc0de;
            margin: 0;
            font-size: 24pt;
        }
        
        .header p {
            color: #666;
            margin: 5px 0;
            font-size: 9pt;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        thead th {
            background-color: #5bc0de;
            color: white;
            padding: 8px 4px;
            text-align: left;
            font-size: 8pt;
            border: 1px solid #46b8da;
        }
        
        tbody td {
            padding: 6px 4px;
            border: 1px solid #ddd;
            font-size: 7pt;
            vertical-align: top;
        }
        
        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        .badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 3px;
            color: white;
            font-size: 6pt;
            font-weight: bold;
        }
        
        .badge-success { background-color: #5cb85c; }
        .badge-info { background-color: #5bc0de; }
        .badge-warning { background-color: #f0ad4e; }
        .badge-danger { background-color: #d9534f; }
        .badge-primary { background-color: #337ab7; }
        .badge-secondary { background-color: #6c757d; }
        
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
    <!-- EN-TÊTE DU PDF -->
    <div class="header">
        <h1>💬 Historique des Communications Clients</h1>
        <p>Document généré le <?= $date_export ?></p>
        <p>Nombre total de communications: <strong><?= count($communications) ?></strong></p>
    </div>

    <!-- TABLEAU DES DONNÉES (TOUS LES ATTRIBUTS) -->
    <table>
        <thead>
            <tr>
                <th style="width: 4%;">#</th>
                <th style="width: 16%;">Client</th>
                <th style="width: 12%;">Responsable</th>
                <th style="width: 14%;">Objet</th>
                <th style="width: 10%;">Moyen</th>
                <th style="width: 8%;">Avis</th>
                <th style="width: 24%;">Commentaire</th>
                <th style="width: 12%;">Date</th>
            </tr>
        </thead>
        
        <tbody>
            <?php if (!empty($communications)): ?>
                <?php $num = 1; ?>
                <?php foreach ($communications as $c): ?>
                    <tr>
                        <td><?= $num++ ?></td>
                        
                        <td><strong><?= esc($clientsMap[$c['id_client']] ?? '—') ?></strong></td>
                        
                        <td><?= esc($usersMap[$c['id_responsable']] ?? '—') ?></td>
                        
                        <td><?= esc($c['domaine'] ?? '—') ?></td>
                        
                        <td>
                            <?php
                            $moyen_badge = 'badge-primary';
                            if ($c['moyen_communication'] == 'appel') {
                                $moyen_badge = 'badge-success';
                            } elseif ($c['moyen_communication'] == 'email') {
                                $moyen_badge = 'badge-info';
                            } elseif ($c['moyen_communication'] == 'reunion') {
                                $moyen_badge = 'badge-warning';
                            }
                            ?>
                            <span class="badge <?= $moyen_badge ?>">
                                <?= ucfirst(esc($c['moyen_communication'])) ?>
                            </span>
                        </td>
                        
                        <td>
                            <?php
                            $avis_badge = 'badge-secondary';
                            if ($c['avis'] == 'positif') {
                                $avis_badge = 'badge-success';
                            } elseif ($c['avis'] == 'negatif') {
                                $avis_badge = 'badge-danger';
                            } elseif ($c['avis'] == 'neutre') {
                                $avis_badge = 'badge-warning';
                            }
                            ?>
                            <span class="badge <?= $avis_badge ?>">
                                <?= ucfirst(esc($c['avis'] ?? 'N/A')) ?>
                            </span>
                        </td>
                        
                        <td>
                            <?php 
                            $commentaire = esc($c['commentaire'] ?? '—');
                            if (strlen($commentaire) > 60) {
                                echo substr($commentaire, 0, 60) . '...';
                            } else {
                                echo $commentaire;
                            }
                            ?>
                        </td>
                        
                        <td>
                            <?php 
                            if ($c['date_communication']) {
                                echo date('d/m/Y', strtotime($c['date_communication']));
                            } else {
                                echo '—';
                            }
                            ?>
                        </td>
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

    <!-- PIED DE PAGE -->
    <div class="footer">
        <p>© <?= date('Y') ?> - Votre Organisation - Tous droits réservés</p>
        <p>Document généré automatiquement</p>
    </div>
</body>
</html>