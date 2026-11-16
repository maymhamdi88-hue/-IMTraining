<!--
================================================
VIEW: Template PDF Salaires (salaire_pdf.php)
================================================
Rôle: Générer un PDF professionnel des salaires
- Format A4 Paysage (Landscape)
- Style professionnel avec CSS inline
- Totaux calculés en bas du tableau
================================================
-->

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Salaires</title>
    
    <!-- Styles CSS inline (obligatoire pour PDF) -->
    <style>
        /* Style général du document */
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 9pt;
            margin: 0;
            padding: 20px;
        }
        
        /* En-tête du document */
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #5cb85c;
            padding-bottom: 15px;
        }
        
        .header h1 {
            color: #5cb85c;
            margin: 0;
            font-size: 24pt;
        }
        
        .header p {
            color: #666;
            margin: 5px 0;
            font-size: 9pt;
        }
        
        /* Tableau */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        /* En-tête du tableau */
        thead th {
            background-color: #5cb85c;
            color: white;
            padding: 8px 4px;
            text-align: left;
            font-size: 8pt;
            border: 1px solid #4cae4c;
        }
        
        /* Cellules du tableau */
        tbody td {
            padding: 6px 4px;
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
            padding: 2px 6px;
            border-radius: 3px;
            color: white;
            font-size: 6pt;
            font-weight: bold;
        }
        
        .badge-primary { background-color: #337ab7; }
        .badge-success { background-color: #5cb85c; }
        .badge-info { background-color: #5bc0de; }
        
        /* Alignement texte */
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        
        /* Ligne de total */
        tfoot td {
            background-color: #f0f0f0;
            font-weight: bold;
            padding: 8px 4px;
            border: 1px solid #ddd;
            font-size: 8pt;
        }
        
        /* Pied de page */
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
    <!-- ======================================== -->
    <!-- EN-TÊTE DU PDF -->
    <!-- ======================================== -->
    <div class="header">
        <h1>💰 Liste des Salaires</h1>
        <p>Document généré le <?= $date_export ?></p>
        <p>Nombre total de salaires: <strong><?= count($salaires) ?></strong></p>
    </div>

    <!-- ======================================== -->
    <!-- TABLEAU DES DONNÉES -->
    <!-- ======================================== -->
    <table>
        <!-- En-tête -->
        <thead>
            <tr>
                <th style="width: 4%;">#</th>
                <th style="width: 14%;">Employé</th>
                <th style="width: 7%;">Mois</th>
                <th style="width: 6%;">Année</th>
                <th style="width: 10%;">Base</th>
                <th style="width: 8%;">Prime</th>
                <th style="width: 10%;">Brut</th>
                <th style="width: 8%;">Déduction</th>
                <th style="width: 10%;">Net</th>
                <th style="width: 8%;">Mode</th>
                <th style="width: 10%;">Date Paie</th>
                <th style="width: 5%;">Remarque</th>
            </tr>
        </thead>
        
        <!-- Corps du tableau -->
        <tbody>
            <?php if (!empty($salaires)): ?>
                <?php 
                $num = 1;
                // Variables pour calculer les totaux
                $total_base = 0;
                $total_prime = 0;
                $total_brut = 0;
                $total_deduction = 0;
                $total_net = 0;
                ?>
                <?php foreach ($salaires as $s): ?>
                    <?php
                    // Cumul des totaux
                    $total_base += $s['salaire_base'];
                    $total_prime += ($s['prime'] ?? 0);
                    $total_brut += $s['salaire_brut'];
                    $total_deduction += ($s['deduction'] ?? 0);
                    $total_net += $s['salaire_net'];
                    ?>
                    <tr>
                        <!-- Numéro -->
                        <td><?= $num++ ?></td>
                        
                        <!-- Employé -->
                        <td><strong><?= esc($employesMap[$s['id_employe']] ?? '—') ?></strong></td>
                        
                        <!-- Mois -->
                        <td class="text-center">
                            <?php
                            $mois_fr = [
                                1 => 'Jan', 2 => 'Fév', 3 => 'Mar',
                                4 => 'Avr', 5 => 'Mai', 6 => 'Juin',
                                7 => 'Juil', 8 => 'Aoû', 9 => 'Sep',
                                10 => 'Oct', 11 => 'Nov', 12 => 'Déc'
                            ];
                            echo $mois_fr[$s['mois']] ?? $s['mois'];
                            ?>
                        </td>
                        
                        <!-- Année -->
                        <td class="text-center"><?= esc($s['annee']) ?></td>
                        
                        <!-- Salaire base -->
                        <td class="text-right"><?= number_format($s['salaire_base'], 3) ?></td>
                        
                        <!-- Prime -->
                        <td class="text-right"><?= number_format($s['prime'] ?? 0, 3) ?></td>
                        
                        <!-- Salaire brut -->
                        <td class="text-right"><strong><?= number_format($s['salaire_brut'], 3) ?></strong></td>
                        
                        <!-- Déduction -->
                        <td class="text-right"><?= number_format($s['deduction'] ?? 0, 3) ?></td>
                        
                        <!-- Salaire net -->
                        <td class="text-right"><strong><?= number_format($s['salaire_net'], 3) ?></strong></td>
                        
                        <!-- Mode avec badge -->
                        <td>
                            <?php
                            $mode_badge = 'badge-primary';
                            if ($s['mode_paiement'] == 'cash') {
                                $mode_badge = 'badge-success';
                            } elseif ($s['mode_paiement'] == 'cheque') {
                                $mode_badge = 'badge-info';
                            }
                            ?>
                            <span class="badge <?= $mode_badge ?>">
                                <?= ucfirst(esc($s['mode_paiement'])) ?>
                            </span>
                        </td>
                        
                        <!-- Date paiement -->
                        <td class="text-center">
                            <?php 
                            if ($s['date_paiement']) {
                                echo date('d/m/Y', strtotime($s['date_paiement']));
                            } else {
                                echo '—';
                            }
                            ?>
                        </td>
                        
                        <!-- Remarque (limitée à 20 caractères) -->
                        <td>
                            <?php 
                            $remarque = esc($s['remarque'] ?? '—');
                            if (strlen($remarque) > 20) {
                                echo substr($remarque, 0, 20) . '...';
                            } else {
                                echo $remarque;
                            }
                            ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="12" style="text-align: center;">
                        <em>Aucun salaire enregistré</em>
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
        
        <!-- ======================================== -->
        <!-- PIED DU TABLEAU - TOTAUX -->
        <!-- ======================================== -->
        <?php if (!empty($salaires)): ?>
        <tfoot>
            <tr>
                <td colspan="4" class="text-right">TOTAUX:</td>
                <td class="text-right"><?= number_format($total_base, 3) ?> DT</td>
                <td class="text-right"><?= number_format($total_prime, 3) ?> DT</td>
                <td class="text-right"><?= number_format($total_brut, 3) ?> DT</td>
                <td class="text-right"><?= number_format($total_deduction, 3) ?> DT</td>
                <td class="text-right"><?= number_format($total_net, 3) ?> DT</td>
                <td colspan="3"></td>
            </tr>
        </tfoot>
        <?php endif; ?>
    </table>

    <!-- ======================================== -->
    <!-- PIED DE PAGE -->
    <!-- ======================================== -->
    <div class="footer">
        <p>© <?= date('Y') ?> - Votre Organisation - Tous droits réservés</p>
        <p>Document généré automatiquement - Confidentiel</p>
    </div>
</body>
</html>
