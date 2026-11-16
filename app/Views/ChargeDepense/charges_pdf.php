<!--
================================================
VIEW: Template PDF Charges (charges_pdf.php)
Nefs colonnes que charges_list.php
Format A4 Paysage
================================================
-->

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Charges & Dépenses</title>
    <style>
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 7pt;
            margin: 0;
            padding: 15px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 3px solid #337ab7;
            padding-bottom: 10px;
        }
        .header h1 { color: #337ab7; margin: 0; font-size: 18pt; }
        .header p  { color: #666; margin: 3px 0; font-size: 8pt; }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        thead th {
            background-color: #337ab7;
            color: white;
            padding: 6px 3px;
            text-align: center;
            font-size: 6.5pt;
            border: 1px solid #2e6da4;
        }
        tbody td {
            padding: 5px 3px;
            border: 1px solid #ddd;
            font-size: 6.5pt;
            vertical-align: middle;
        }
        tbody tr:nth-child(even) { background-color: #f9f9f9; }

        .text-right  { text-align: right; }
        .text-center { text-align: center; }
        .net-cell    { background-color: #f8d7da; font-weight: bold; color: #d9534f; }

        .footer {
            margin-top: 15px;
            text-align: center;
            font-size: 6pt;
            color: #999;
            border-top: 1px solid #ddd;
            padding-top: 8px;
        }
    </style>
</head>
<body>

    <!-- EN-TÊTE -->
    <div class="header">
        <h1>💰 Charges & Dépenses</h1>
        <p>Document généré le <?= $date_export ?></p>
        <p>Nombre de charges: <strong><?= count($charges) ?></strong></p>
    </div>

    <!-- TABLEAU — Nefs colonnes que la liste HTML -->
    <table>
        <thead>
            <tr>
                <th style="width:3%;">#</th>
                <th style="width:9%;">Type Charge</th>
                <th style="width:10%;">Fournisseur</th>
                <th style="width:14%;">Désignation</th>
                <th style="width:9%;">Banque/Poste</th>
                <th style="width:9%;">Employé</th>
                <th style="width:7%;">Date</th>
                <th style="width:8%;">Montant Net</th>
                <th style="width:7%;">Mode Paiement</th>
                <th style="width:7%;">HTVA</th>
                <th style="width:6%;">TVA</th>
                <th style="width:7%;">TTC</th>
                <th style="width:14%;">Remarque</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($charges)): ?>
                <?php $num = 1; ?>
                <?php foreach ($charges as $c): ?>
                    <tr>
                        <td class="text-center"><?= $num++ ?></td>

                        <!-- Type charge -->
                        <td><strong><?= esc($c['type_charge'] ?? '—') ?></strong></td>

                        <!-- Fournisseur -->
                        <td><?= esc($c['fournisseur'] ?? '—') ?></td>

                        <!-- Désignation -->
                        <td>
                            <?php
                            $d = esc($c['designation'] ?? '—');
                            echo strlen($d) > 40 ? substr($d, 0, 40) . '...' : $d;
                            ?>
                        </td>

                        <!-- Banque/Poste -->
                        <td><?= esc($c['banque_poste'] ?? '—') ?></td>

                        <!-- Employé -->
                        <td><?= esc($employesMap[$c['id_employe']] ?? '—') ?></td>

                        <!-- Date -->
                        <td class="text-center">
                            <?= $c['date_charge'] ? date('d/m/Y', strtotime($c['date_charge'])) : '—' ?>
                        </td>

                        <!-- Montant Net -->
                        <td class="text-right net-cell">
                            <?= $c['montant_net'] ? number_format($c['montant_net'], 3, ',', ' ') . ' TND' : '—' ?>
                        </td>

                        <!-- Mode paiement -->
                        <td class="text-center"><?= esc(ucfirst($c['mode_paiement'] ?? '—')) ?></td>

                        <!-- HTVA -->
                        <td class="text-right">
                            <?= $c['montant_htva'] ? number_format($c['montant_htva'], 3, ',', ' ') : '—' ?>
                        </td>

                        <!-- TVA -->
                        <td class="text-right">
                            <?= $c['montant_tva'] ? number_format($c['montant_tva'], 3, ',', ' ') : '—' ?>
                        </td>

                        <!-- TTC -->
                        <td class="text-right">
                            <?= $c['montant_ttc'] ? number_format($c['montant_ttc'], 3, ',', ' ') : '—' ?>
                        </td>

                        <!-- Remarque -->
                        <td>
                            <?php
                            $rem = esc($c['remarque'] ?? '—');
                            echo strlen($rem) > 40 ? substr($rem, 0, 40) . '...' : $rem;
                            ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="13" class="text-center"><em>Aucune charge enregistrée</em></td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- PIED DE PAGE -->
    <div class="footer">
        <p>© <?= date('Y') ?> - Votre Organisation - Document confidentiel</p>
        <p>Document généré automatiquement</p>
    </div>

</body>
</html>