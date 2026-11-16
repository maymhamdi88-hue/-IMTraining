<!--
================================================
VIEW: Template PDF Banque (banque_pdf.php)
================================================
Format A4 Paysage
================================================
-->

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Journal de Banque</title>
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
            border-bottom: 3px solid #337ab7;
            padding-bottom: 10px;
        }
        .header h1 { color: #337ab7; margin: 0; font-size: 20pt; }
        .header p  { color: #666; margin: 4px 0; font-size: 8pt; }

        .solde-box {
            text-align: right;
            margin-bottom: 10px;
            font-size: 10pt;
            font-weight: bold;
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
            text-align: left;
            font-size: 7pt;
            border: 1px solid #2e6da4;
        }
        tbody td {
            padding: 5px 4px;
            border: 1px solid #ddd;
            font-size: 7pt;
            vertical-align: top;
        }
        tbody tr:nth-child(even) { background-color: #f9f9f9; }

        .credit { color: #27ae60; font-weight: bold; }
        .debit  { color: #e74c3c; font-weight: bold; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }

        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 7pt;
            color: #999;
            border-top: 1px solid #ddd;
            padding-top: 8px;
        }
    </style>
</head>
<body>

    <!-- EN-TÊTE -->
    <div class="header">
        <h1>🏦 Journal de Banque</h1>
        <p>Document généré le <?= $date_export ?></p>
        <p>Nombre d'opérations: <strong><?= count($operations) ?></strong></p>
    </div>

    <!-- SOLDE ACTUEL -->
    <div class="solde-box">
        Solde Actuel : <span style="color: <?= $solde_actuel >= 0 ? '#27ae60' : '#e74c3c' ?>">
            <?= number_format($solde_actuel, 3, ',', ' ') ?> DT
        </span>
    </div>

    <!-- TABLEAU -->
    <table>
        <thead>
            <tr>
                <th style="width:4%;">#</th>
                <th style="width:9%;">Date</th>
                <th style="width:8%;">Mois</th>
                <th style="width:6%;">Année</th>
                <th style="width:7%;">Type</th>
                <th style="width:15%;">Libellé</th>
                <th style="width:20%;">Désignation</th>
                <th style="width:10%;">Solde Initial</th>
                <th style="width:10%;">Montant</th>
                <th style="width:11%;">Solde Final</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($operations)): ?>
                <?php $num = 1; ?>
                <?php foreach ($operations as $op): ?>
                    <tr>
                        <td class="text-center"><?= $num++ ?></td>
                        <td><?= date('d/m/Y', strtotime($op['date_operation'])) ?></td>
                        <td><?= ucfirst(esc($op['mois'] ?? '—')) ?></td>
                        <td class="text-center"><?= esc($op['annee'] ?? '—') ?></td>
                        <td class="text-center <?= $op['type_operation'] === 'credit' ? 'credit' : 'debit' ?>">
                            <?= $op['type_operation'] === 'credit' ? 'Crédit' : 'Débit' ?>
                        </td>
                        <td><?= esc($op['libelle'] ?? '—') ?></td>
                        <td>
                            <?php
                            $desig = esc($op['designation_precise'] ?? '—');
                            echo strlen($desig) > 50 ? substr($desig, 0, 50) . '...' : $desig;
                            ?>
                        </td>
                        <td class="text-right"><?= number_format((float)$op['solde_initiale'], 3, ',', ' ') ?></td>
                        <td class="text-right <?= $op['type_operation'] === 'credit' ? 'credit' : 'debit' ?>">
                            <?= $op['type_operation'] === 'credit' ? '+' : '-' ?>
                            <?= number_format((float)$op['montant'], 3, ',', ' ') ?>
                        </td>
                        <td class="text-right"><strong><?= number_format((float)$op['solde_finale'], 3, ',', ' ') ?></strong></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="10" class="text-center"><em>Aucune opération enregistrée</em></td>
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