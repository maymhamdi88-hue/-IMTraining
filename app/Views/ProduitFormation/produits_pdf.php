<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Produits Formation</title>
    <style>
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 6pt;
            margin: 0;
            padding: 10px;
        }
        .header {
            text-align: center;
            margin-bottom: 15px;
            border-bottom: 3px solid #337ab7;
            padding-bottom: 10px;
        }
        .header h1 { color: #337ab7; margin: 0; font-size: 16pt; }
        .header p  { color: #666; margin: 3px 0; font-size: 7pt; }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        thead th {
            background-color: #337ab7;
            color: white;
            padding: 5px 2px;
            text-align: center;
            font-size: 5.5pt;
            border: 1px solid #2e6da4;
        }
        tbody td {
            padding: 4px 2px;
            border: 1px solid #ddd;
            font-size: 5.5pt;
            vertical-align: middle;
        }
        tbody tr:nth-child(even) { background-color: #f9f9f9; }
        .text-right  { text-align: right; }
        .text-center { text-align: center; }
        .net-cell    { background-color: #d4edda; font-weight: bold; color: #27ae60; }
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

    <div class="header">
        <h1>Liste des Produits Formation</h1>
        <p>Document généré le <?= $date_export ?></p>
        <p>Nombre de produits: <strong><?= count($produits) ?></strong></p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width:2%;">#</th>
                <th style="width:6%;">Client</th>
                <th style="width:5%;">Prestation</th>
                <th style="width:5%;">Type</th>
                <th style="width:6%;">Thème</th>
                <th style="width:5%;">Date Prestation</th>
                <th style="width:5%;">Formateur</th>
                <th style="width:4%;">Honoraire</th>
                <th style="width:4%;">Prix Unit.</th>
                <th style="width:3%;">Nb H/J</th>     <!-- ✅ Séparé -->
                <th style="width:3%;">Nb Jours</th>   <!-- ✅ Séparé -->
                <th style="width:3%;">Taux TVA</th>
                <th style="width:3%;">Taux RAS</th>
                <th style="width:4%;">MHTVA</th>
                <th style="width:3%;">TVA</th>
                <th style="width:4%;">MTTC</th>
                <th style="width:3%;">RAS</th>
                <th style="width:4%;">Net</th>
                <th style="width:4%;">N° Action</th>
                <th style="width:4%;">N° Facture</th>
                <th style="width:4%;">Date Fact.</th>
                <th style="width:4%;">Date Réglement</th>
                <th style="width:4%;">Date Rég. Form.</th>
                <th style="width:4%;">Date Certif. RAS</th>
                <th style="width:3%;">Mois Décl.</th>
                <th style="width:3%;">Mode</th>
                <th style="width:5%;">Remarque</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($produits)): ?>
                <?php $num = 1; ?>
                <?php foreach ($produits as $r): ?>
                    <tr>
                        <td class="text-center"><?= $num++ ?></td>
                        <td><strong><?= esc($r['nom_societe'] ?? '—') ?></strong></td>
                        <td><?= esc($r['reference'] ?? '—') ?></td>
                        <td><?= esc($r['type_activite'] ?? '—') ?></td>
                        <td><?= esc($r['theme_domaine'] ?? '—') ?></td>
                        <td class="text-center">
                            <?php if (!empty($r['date_prestation'])): ?>
                                <?= nl2br(esc($r['date_prestation'])) ?>
                            <?php else: ?>—
                            <?php endif; ?>
                        </td>
                        <td><?= esc($r['nom_prenom'] ?? '—') ?></td>
                        <td class="text-right">
                            <?= $r['honoraire'] ? number_format($r['honoraire'], 3, ',', ' ') : '—' ?>
                        </td>
                        <td class="text-right">
                            <?= number_format($r['montant_unitaire'] ?? 0, 3, ',', ' ') ?>
                        </td>

                        <!-- ✅ Nb H/J et Nb Jours séparés -->
                        <td class="text-center">
                            <?= esc($r['nombre_heures_jour'] ?? '—') ?>
                        </td>
                        <td class="text-center">
                            <?= esc($r['nombre_jours'] ?? '—') ?>
                        </td>

                        <td class="text-right"><?= number_format($r['taux_tva'] ?? 0, 2, ',', ' ') ?>%</td>
                        <td class="text-right"><?= number_format($r['taux_ras'] ?? 0, 2, ',', ' ') ?>%</td>
                        <td class="text-right"><?= number_format($r['mhtva'] ?? 0, 3, ',', ' ') ?></td>
                        <td class="text-right"><?= number_format($r['tva'] ?? 0, 3, ',', ' ') ?></td>
                        <td class="text-right"><?= number_format($r['mttc'] ?? 0, 3, ',', ' ') ?></td>
                        <td class="text-right"><?= number_format($r['ras'] ?? 0, 3, ',', ' ') ?></td>
                        <td class="text-right net-cell">
                            <?= number_format($r['montant_net'] ?? 0, 3, ',', ' ') ?>
                        </td>
                        <td><?= esc($r['numero_action'] ?? '—') ?></td>
                        <td><?= esc($r['numero_facture'] ?? '—') ?></td>
                        <td class="text-center">
                            <?= $r['date_facture'] ? date('d/m/Y', strtotime($r['date_facture'])) : '—' ?>
                        </td>
                        <td class="text-center">
                            <?= $r['date_entree'] ? date('d/m/Y', strtotime($r['date_entree'])) : '—' ?>
                        </td>
                        <td class="text-center">
                            <?= $r['date_sortie'] ? date('d/m/Y', strtotime($r['date_sortie'])) : '—' ?>
                        </td>
                        <td class="text-center">
                            <?= $r['date_certificat_ras'] ? date('d/m/Y', strtotime($r['date_certificat_ras'])) : '—' ?>
                        </td>
                        <td><?= esc($r['mois_declaration'] ?? '—') ?></td>
                        <td class="text-center"><?= esc(ucfirst($r['mode_paiement'] ?? '—')) ?></td>
                        <td>
                            <?php
                            $rem = esc($r['remarque'] ?? '—');
                            echo strlen($rem) > 30 ? substr($rem, 0, 30) . '...' : $rem;
                            ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="27" class="text-center">  <!-- ✅ 26+1 = 27 -->
                        <em>Aucun produit enregistré</em>
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="footer">
        <p>© <?= date('Y') ?> - Votre Organisation - Document confidentiel</p>
        <p>Document généré automatiquement</p>
    </div>

</body>
</html>