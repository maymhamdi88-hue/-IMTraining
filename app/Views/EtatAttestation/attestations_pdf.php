<!--
================================================
VIEW: Template PDF Attestations (attestations_pdf.php)
================================================
Format A4 Portrait
================================================
-->

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Attestations</title>
    
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
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        thead th {
            background-color: #337ab7;
            color: white;
            padding: 10px 6px;
            text-align: left;
            font-size: 8pt;
            border: 1px solid #2e6da4;
        }
        
        tbody td {
            padding: 8px 6px;
            border: 1px solid #ddd;
            font-size: 8pt;
            vertical-align: top;
        }
        
        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        .text-center {
            text-align: center;
        }
        
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
    <!-- EN-TÊTE -->
    <div class="header">
        <h1>📜 États des Attestations</h1>
        <p>Document généré le <?= $date_export ?></p>
        <p>Nombre d'attestations: <strong><?= count($attestations) ?></strong></p>
    </div>

    <!-- TABLEAU -->
    <table>
        <thead>
            <tr>
                <th style="width: 5%;">#</th>
                <th style="width: 20%;">Client</th>
                <th style="width: 10%;">Mode</th>
                <th style="width: 10%;">N° Action</th>
                <th style="width: 20%;">Thème</th>
                <th style="width: 11%;">Date Préparation</th>
                <th style="width: 11%;">Date Tirage</th>
                <th style="width: 11%;">Date Remise</th>
            </tr>
        </thead>
        
        <tbody>
            <?php if (!empty($attestations)): ?>
                <?php $num = 1; ?>
                <?php foreach ($attestations as $a): ?>
                    <tr>
                        <td><?= $num++ ?></td>
                        <td><strong><?= esc($clientsMap[$a['id_client']] ?? '—') ?></strong></td>
                        <td><?= esc($a['mode'] ?? '—') ?></td>
                        <td><?= esc($a['num_action'] ?? '—') ?></td>
                        <td>
                            <?php 
                            $theme = esc($a['theme'] ?? '—');
                            echo strlen($theme) > 40 ? substr($theme, 0, 40) . '...' : $theme;
                            ?>
                        </td>
                        <td class="text-center">
                            <?= $a['date_preparation'] ? date('d/m/Y', strtotime($a['date_preparation'])) : '—' ?>
                        </td>
                        <td class="text-center">
                            <?= $a['date_tirage'] ? date('d/m/Y', strtotime($a['date_tirage'])) : '—' ?>
                        </td>
                        <td class="text-center">
                            <?= $a['date_remise'] ? date('d/m/Y', strtotime($a['date_remise'])) : '—' ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8" class="text-center">
                        <em>Aucune attestation enregistrée</em>
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