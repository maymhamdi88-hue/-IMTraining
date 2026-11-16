<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Evaluations Formateurs</title>
    <style>
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 9pt;
            margin: 0;
            padding: 15px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 3px solid #337ab7;
            padding-bottom: 12px;
        }
        .header h1 {
            color: #337ab7;
            margin: 0 0 5px 0;
            font-size: 18pt;
        }
        .header p {
            color: #666;
            margin: 3px 0;
            font-size: 8pt;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        thead th {
            background-color: #337ab7;
            color: white;
            padding: 7px 4px;
            text-align: center;
            font-size: 7pt;
            border: 1px solid #2a6496;
        }
        tbody td {
            padding: 5px 4px;
            border: 1px solid #ddd;
            font-size: 7pt;
            vertical-align: middle;
            text-align: center;
        }
        tbody td.text-left {
            text-align: left;
        }
        tbody tr:nth-child(even) {
            background-color: #f5f5f5;
        }
        .score {
            font-weight: bold;
            font-size: 9pt;
            color: #d9534f;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 7.5pt;
            color: #999;
            border-top: 1px solid #ddd;
            padding-top: 8px;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>Evaluations des Formateurs</h1>
        <p>Document genere le : <strong><?= $date_export ?></strong></p>
        <p>Nombre total d'evaluations : <strong><?= count($evaluations) ?></strong></p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width:3%;">#</th>
                <th style="width:12%;">Formateur</th>
                <th style="width:12%;">Activite</th>
                <th style="width:10%;">Client</th>
                <th style="width:7%;">Date</th>
                <th style="width:7%;">Pedagogie</th>
                <th style="width:7%;">Maitrise</th>
                <th style="width:7%;">Soft skills</th>
                <th style="width:7%;">Collaboration</th>
                <th style="width:7%;">Dossier</th>
                <th style="width:7%;">Flexibilite</th>
                <th style="width:7%;">Score</th>
                <th style="width:12%;">Remarque</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($evaluations)): ?>
                <?php $num = 1; ?>
                <?php foreach ($evaluations as $e): ?>
                    <tr>
                        <td><?= $num++ ?></td>
                        <td class="text-left"><?= esc($formateursMap[$e['id_formateur']] ?? '-') ?></td>
                        <td class="text-left"><?= esc($activitesMap[$e['id_activite']] ?? '-') ?></td>
                        <td class="text-left"><?= esc($clientsMap[$e['id_client']] ?? '-') ?></td>
                        <td><?= !empty($e['date_evaluation']) ? date('d/m/Y', strtotime($e['date_evaluation'])) : '-' ?></td>
                        <td><?= esc($e['pedagogie_methodes'] ?? '-') ?></td>
                        <td><?= esc($e['maitrise_technique'] ?? '-') ?></td>
                        <td><?= esc($e['posture_soft_skills'] ?? '-') ?></td>
                        <td><?= esc($e['facilite_collaboration'] ?? '-') ?></td>
                        <td><?= esc($e['dossier_administratif_ponctualite'] ?? '-') ?></td>
                        <td><?= esc($e['flexibilite_delais_paiement'] ?? '-') ?></td>
                        <td><span class="score"><?= esc($e['score_global']) ?></span></td>
                        <td class="text-left">
                            <?php
                                $r = $e['remarque'] ?? '';
                                echo $r ? esc(mb_substr($r, 0, 80)) . (mb_strlen($r) > 80 ? '...' : '') : '-';
                            ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="13" style="text-align:center; padding:20px;">
                        <em>Aucune evaluation enregistree</em>
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="footer">
        <p>&copy; <?= date('Y') ?> - Votre Organisation - Tous droits reserves</p>
        <p>Document genere automatiquement</p>
    </div>

</body>
</html>