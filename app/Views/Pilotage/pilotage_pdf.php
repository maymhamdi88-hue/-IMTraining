<!--
================================================
VIEW: Template PDF Pilotage COMPLET
================================================
✅ Tous les 14 attributs affichés
================================================
-->

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Objectifs & Résultats</title>
    
    <style>
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 6pt;
            margin: 0;
            padding: 15px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 3px solid #3498db;
            padding-bottom: 10px;
        }
        
        .header h1 {
            color: #3498db;
            margin: 0;
            font-size: 18pt;
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
            background-color: #3498db;
            color: white;
            padding: 5px 2px;
            text-align: left;
            font-size: 5.5pt;
            border: 1px solid #2980b9;
        }
        
        tbody td {
            padding: 4px 2px;
            border: 1px solid #ddd;
            font-size: 5.5pt;
            vertical-align: top;
        }
        
        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        .badge {
            display: inline-block;
            padding: 2px 4px;
            border-radius: 3px;
            color: white;
            font-size: 5pt;
            font-weight: bold;
        }
        
        .badge-success { background-color: #27ae60; }
        .badge-info { background-color: #3498db; }
        .badge-secondary { background-color: #95a5a6; }
        
        .result-cell {
            background-color: #d4edda;
            font-weight: bold;
        }
        
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
    <!-- EN-TÊTE -->
    <div class="header">
        <h1>📊 Liste des Objectifs & Résultats</h1>
        <p>Document généré le <?= $date_export ?></p>
        <p>Nombre total d'enregistrements: <strong><?= count($pilotages) ?></strong></p>
    </div>

    <!-- TABLEAU -->
    <table>
        <thead>
            <tr>
                <th style="width: 2%;">#</th>
                <th style="width: 3%;">Année</th>
                <th style="width: 10%;">Processus</th>
                <th style="width: 12%;">Objectif</th>
                <th style="width: 10%;">Indicateur</th>
                <th style="width: 9%;">Mode Calcul</th>
                <th style="width: 9%;">Résultat</th>
                <th style="width: 6%;">Fréquence</th>
                <th style="width: 4%;">Cible N</th>
                <th style="width: 5%;">Résult. N</th>
                <th style="width: 4%;">Cible N+1</th>
                <th style="width: 5%;">Résult. N+1</th>
                <th style="width: 5%;">Visa</th>
                <th style="width: 11%;">Remarque</th>
            </tr>
        </thead>
        
        <tbody>
            <?php if (!empty($pilotages)): ?>
                <?php $num = 1; ?>
                <?php foreach ($pilotages as $p): ?>
                    <tr>
                        <!-- # -->
                        <td style="text-align: center;"><?= $num++ ?></td>
                        
                        <!-- Année -->
                        <td style="text-align: center;"><strong><?= esc($p['annee']) ?></strong></td>
                        
                        <!-- Processus -->
                        <td><?= esc($p['processus']) ?></td>
                        
                        <!-- Objectif -->
                        <td>
                            <?php 
                            $objectif = esc($p['objectif'] ?? '—');
                            echo strlen($objectif) > 80 ? substr($objectif, 0, 80) . '...' : $objectif;
                            ?>
                        </td>
                        
                        <!-- Indicateur -->
                        <td>
                            <?php 
                            $indicateur = esc($p['indicateur'] ?? '—');
                            echo strlen($indicateur) > 70 ? substr($indicateur, 0, 70) . '...' : $indicateur;
                            ?>
                        </td>
                        
                        <!-- Mode de calcul -->
                        <td>
                            <?php 
                            $mode = esc($p['mode_calcul'] ?? '—');
                            echo strlen($mode) > 60 ? substr($mode, 0, 60) . '...' : $mode;
                            ?>
                        </td>
                        
                        <!-- Résultat -->
                        <td>
                            <?php 
                            $resultat = esc($p['resultat'] ?? '—');
                            echo strlen($resultat) > 60 ? substr($resultat, 0, 60) . '...' : $resultat;
                            ?>
                        </td>
                        
                        <!-- Fréquence de suivi -->
                        <td style="text-align: center;">
                            <span class="badge badge-info">
                                <?php
                                $freq = esc($p['frequence_suivi'] ?? '—');
                                // Abréviations pour gagner de la place
                                if ($freq == 'Mensuelle') echo 'M';
                                elseif ($freq == 'Trimestrielle') echo 'T';
                                elseif ($freq == 'Semestrielle') echo 'S';
                                elseif ($freq == 'Annuelle') echo 'A';
                                else echo $freq;
                                ?>
                            </span>
                        </td>
                        
                        <!-- Cible année N -->
                        <td style="text-align: center;">
                            <?= $p['cible_annee_n'] ? number_format($p['cible_annee_n'], 2, ',', ' ') : '—' ?>
                        </td>
                        
                        <!-- Résultat année N -->
                        <td style="text-align: center;" class="result-cell">
                            <?= $p['resultat_annee_n'] ? number_format($p['resultat_annee_n'], 2, ',', ' ') : '—' ?>
                        </td>
                        
                        <!-- Cible année N+1 -->
                        <td style="text-align: center;">
                            <?= $p['cible_annee_n1'] ? number_format($p['cible_annee_n1'], 2, ',', ' ') : '—' ?>
                        </td>
                        
                        <!-- ✅ Résultat année N+1 (AJOUTÉ) -->
                        <td style="text-align: center;" class="result-cell">
                            <?= $p['resultat_annee_n1'] ? number_format($p['resultat_annee_n1'], 2, ',', ' ') : '—' ?>
                        </td>
                        
                        <!-- Visa direction -->
                        <td style="text-align: center;">
                            <?php if ($p['visa_direction']): ?>
                                <span class="badge badge-success">✔</span>
                            <?php else: ?>
                                <span class="badge badge-secondary">—</span>
                            <?php endif; ?>
                        </td>
                        
                        <!-- Remarque -->
                        <td>
                            <?php 
                            $remarque = esc($p['remarque'] ?? '—');
                            echo strlen($remarque) > 70 ? substr($remarque, 0, 70) . '...' : $remarque;
                            ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="14" style="text-align: center;">
                        <em>Aucun pilotage enregistré</em>
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