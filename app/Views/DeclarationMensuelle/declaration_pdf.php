<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Déclarations Mensuelles</title>
    <style>
        body     { font-family:'DejaVu Sans', Arial, sans-serif; font-size:6pt; margin:0; padding:10px; }
        .header  { text-align:center; margin-bottom:12px; border-bottom:3px solid #337ab7; padding-bottom:8px; }
        .header h1 { color:#337ab7; margin:0; font-size:14pt; }
        .header p  { color:#666; margin:2px 0; font-size:6.5pt; }

        table    { width:100%; border-collapse:collapse; margin-top:8px; }
        thead th { background:#337ab7; color:#fff; padding:4px 2px; text-align:center;
                   font-size:5pt; border:1px solid #2e6da4; }

        /* Groupes de colonnes en-tête niveau 1 */
        th.grp-base    { background:#17a2b8; }
        th.grp-taux    { background:#ffc107; color:#000; }
        th.grp-rs      { background:#dc3545; }
        th.grp-tfp     { background:#28a745; }
        th.grp-tva     { background:#007bff; }
        th.grp-total   { background:#fd7e14; }

        /* Sous-en-têtes niveau 2 */
        th.sub-base    { background:#bee5eb; color:#000; }
        th.sub-taux    { background:#fff3cd; color:#000; }
        th.sub-rs      { background:#f8d7da; color:#000; }

        tbody td { padding:3px 2px; border:1px solid #ddd; font-size:5pt; vertical-align:middle; }
        tbody tr:nth-child(even) { background:#f9f9f9; }

        .tr  { text-align:right; }
        .tc  { text-align:center; }
        .neg { color:#d9534f; font-weight:bold; }
        .pos { color:#5cb85c; font-weight:bold; }
        .total-cell { background:#fff3cd; font-weight:bold; color:#d9534f; }

        .footer { margin-top:12px; text-align:center; font-size:5.5pt;
                  color:#999; border-top:1px solid #ddd; padding-top:6px; }
    </style>
</head>
<body>

<div class="header">
    <h1>📊 Déclarations Mensuelles</h1>
    <p>Généré le : <strong><?= $date_export ?></strong></p>
    <p>Nombre de déclarations : <strong><?= count($declarations) ?></strong></p>
</div>

<table>
    <thead>
        <!-- LIGNE 1 : groupes -->
        <tr>
            <th rowspan="2" style="width:2%;">#</th>
            <th rowspan="2" style="width:3%;" class="tc">Mois</th>
            <th rowspan="2" style="width:3%;" class="tc">Année</th>

            <th colspan="4" class="grp-base" style="width:16%;">Bases</th>
            <th rowspan="2" class="grp-base" style="width:5%;">Tot. Base</th>

            <th colspan="4" class="grp-taux" style="width:12%;">Taux %</th>

            <th colspan="4" class="grp-rs" style="width:16%;">Retenues (RS)</th>
            <th rowspan="2" class="grp-rs" style="width:5%;">Tot. Ret.</th>

            <th rowspan="2" class="grp-tfp" style="width:4%;">TFP</th>
            <th rowspan="2" class="grp-tfp" style="width:5%;">FORPROLOS</th>

            <th rowspan="2" class="grp-tva" style="width:5%;">TVA Déd.</th>
            <th rowspan="2" class="grp-tva" style="width:5%;">TVA Coll.</th>
            <th rowspan="2" class="grp-tva" style="width:4%;">Report</th>
            <th rowspan="2" class="grp-tva" style="width:5%;">TVA Fin.</th>
            <th rowspan="2" class="grp-tfp" style="width:4%;">TCL</th>

            <th rowspan="2" class="grp-total" style="width:6%;">Total Payer</th>
        </tr>
        <!-- LIGNE 2 : sous-colonnes -->
        <tr>
            <th class="sub-base">Sal.</th>
            <th class="sub-base">Cpt.</th>
            <th class="sub-base">Form.</th>
            <th class="sub-base">Loyer</th>

            <th class="sub-taux">Sal.</th>
            <th class="sub-taux">Cpt.</th>
            <th class="sub-taux">Form.</th>
            <th class="sub-taux">Loyer</th>

            <th class="sub-rs">Sal.</th>
            <th class="sub-rs">Cpt.</th>
            <th class="sub-rs">Form.</th>
            <th class="sub-rs">Loyer</th>
        </tr>
    </thead>
    <tbody>
    <?php if (!empty($declarations)):
        $mois_noms = [
            1=>'Jan', 2=>'Fév', 3=>'Mar', 4=>'Avr',
            5=>'Mai', 6=>'Jun', 7=>'Jul', 8=>'Aoû',
            9=>'Sep', 10=>'Oct', 11=>'Nov', 12=>'Déc'
        ];
        $num = 1;
        foreach ($declarations as $d): ?>
        <tr>
            <td class="tc"><?= $num++ ?></td>
            <td class="tc"><strong><?= $mois_noms[$d['mois']] ?? $d['mois'] ?></strong></td>
            <td class="tc"><?= $d['annee'] ?></td>

            <!-- Bases -->
            <td class="tr"><?= number_format($d['base_salaire'],   3, ',', ' ') ?></td>
            <td class="tr"><?= number_format($d['base_comptable'], 3, ',', ' ') ?></td>
            <td class="tr"><?= number_format($d['base_formateur'], 3, ',', ' ') ?></td>
            <td class="tr"><?= number_format($d['base_loyer'],     3, ',', ' ') ?></td>
            <td class="tr"><strong><?= number_format($d['total_base'], 3, ',', ' ') ?></strong></td>

            <!-- Taux -->
            <td class="tc"><?= number_format($d['taux_salaire'],   2, ',', ' ') ?>%</td>
            <td class="tc"><?= number_format($d['taux_comptable'], 2, ',', ' ') ?>%</td>
            <td class="tc"><?= number_format($d['taux_formateur'], 2, ',', ' ') ?>%</td>
            <td class="tc"><?= number_format($d['taux_loyer'],     2, ',', ' ') ?>%</td>

            <!-- RS -->
            <td class="tr"><?= number_format($d['rs_salaire'],   3, ',', ' ') ?></td>
            <td class="tr"><?= number_format($d['rs_comptable'], 3, ',', ' ') ?></td>
            <td class="tr"><?= number_format($d['rs_formateur'], 3, ',', ' ') ?></td>
            <td class="tr"><?= number_format($d['rs_loyer'],     3, ',', ' ') ?></td>
            <td class="tr"><strong><?= number_format($d['total_retenue'], 3, ',', ' ') ?></strong></td>

            <!-- TFP / FORPROLOS -->
            <td class="tr"><?= number_format($d['tfp'],       3, ',', ' ') ?></td>
            <td class="tr"><?= number_format($d['forprolos'], 3, ',', ' ') ?></td>

            <!-- TVA -->
            <td class="tr"><?= number_format($d['tva_deductible'], 3, ',', ' ') ?></td>
            <td class="tr"><?= number_format($d['tva_collectee'],  3, ',', ' ') ?></td>
            <td class="tr"><?= number_format($d['report'],         3, ',', ' ') ?></td>
            <td class="tr">
                <span class="<?= $d['tva_final'] < 0 ? 'neg' : 'pos' ?>">
                    <?= number_format($d['tva_final'], 3, ',', ' ') ?>
                </span>
            </td>
            <td class="tr"><?= number_format($d['tcl'], 3, ',', ' ') ?></td>

            <!-- Total à payer -->
            <td class="tr total-cell"><?= number_format($d['total_a_payer'], 3, ',', ' ') ?></td>
        </tr>
        <?php endforeach;
    else: ?>
        <tr><td colspan="27" class="tc"><em>Aucune déclaration.</em></td></tr>
    <?php endif; ?>
    </tbody>
</table>

<div class="footer">
    <p>© <?= date('Y') ?> — Document confidentiel — Généré automatiquement</p>
</div>

</body>
</html>