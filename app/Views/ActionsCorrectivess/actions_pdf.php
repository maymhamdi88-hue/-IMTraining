<!--
================================================
VIEW: Template PDF Actions Correctives (actions_pdf.php)
================================================
Rôle: Générer un PDF professionnel des actions correctives
- Format A4 Paysage
- Tous les attributs visibles
- Style professionnel avec CSS inline
================================================
-->

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Actions Correctives</title>
    
    <style>
        /* Style général */
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 7pt;
            margin: 0;
            padding: 15px;
        }
        
        /* En-tête */
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 3px solid #16a085;
            padding-bottom: 10px;
        }
        
        .header h1 {
            color: #16a085;
            margin: 0;
            font-size: 20pt;
        }
        
        .header p {
            color: #666;
            margin: 5px 0;
            font-size: 8pt;
        }
        
        /* Tableau */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        
        /* En-tête tableau */
        thead th {
            background-color: #16a085;
            color: white;
            padding: 5px 3px;
            text-align: left;
            font-size: 6pt;
            border: 1px solid #138d75;
        }
        
        /* Cellules */
        tbody td {
            padding: 4px 3px;
            border: 1px solid #ddd;
            font-size: 6pt;
            vertical-align: top;
        }
        
        /* Lignes alternées */
        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        /* Badge */
        .badge {
            display: inline-block;
            padding: 2px 4px;
            border-radius: 3px;
            color: white;
            font-size: 6pt;
            font-weight: bold;
        }
        
        .badge-success { background-color: #27ae60; }
        .badge-warning { background-color: #f39c12; }
        .badge-secondary { background-color: #95a5a6; }
        
        /* Pied de page */
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
        <h1>🔧 Liste des Actions Correctives</h1>
        <p>Document généré le <?= $date_export ?></p>
        <p>Nombre total d'actions: <strong><?= count($actions) ?></strong></p>
    </div>

    <!-- ======================================== -->
    <!-- TABLEAU -->
    <!-- ======================================== -->
    <table>
        <thead>
            <tr>
                <th style="width: 3%;">#</th>
                <th style="width: 13%;">Causes (Suivi)</th>
                <th style="width: 15%;">Action Corrective</th>
                <th style="width: 10%;">Responsable Action</th>
                <th style="width: 8%;">Date Prévue</th>
                <th style="width: 8%;">Date Réalisation</th>
                <th style="width: 8%;">Date Vérification</th>
                <th style="width: 8%;">Décision</th>
                <th style="width: 12%;">Responsable Vérif.</th>
            </tr>
        </thead>
        
        <tbody>
            <?php if (!empty($actions)): ?>
                <?php $num = 1; ?>
                <?php foreach ($actions as $a): ?>
                    <tr>
                        <!-- # -->
                        <td><?= $num++ ?></td>
                        
                        <!-- Causes (relation avec Suivi) -->
                        <td><?= esc($causesMap[$a['id_suivi']] ?? '—') ?></td>
                        
                        <!-- Action corrective -->
                        <td><?= esc($a['action_corrective']) ?></td>
                        
                        <!-- Responsable action -->
                        <td><?= esc($a['responsable_action']) ?></td>
                        
                        <!-- Date prévue -->
                        <td>
                            <?php 
                            if ($a['date_prevue']) {
                                echo date('d/m/Y', strtotime($a['date_prevue']));
                            } else {
                                echo '—';
                            }
                            ?>
                        </td>
                        
                        <!-- Date réalisation -->
                        <td>
                            <?php 
                            if ($a['date_realisation']) {
                                echo date('d/m/Y', strtotime($a['date_realisation']));
                            } else {
                                echo '—';
                            }
                            ?>
                        </td>
                        
                        <!-- Date vérification -->
                        <td>
                            <?php 
                            if ($a['date_verification']) {
                                echo date('d/m/Y', strtotime($a['date_verification']));
                            } else {
                                echo '—';
                            }
                            ?>
                        </td>
                        
                        <!-- Décision -->
                        <td style="text-align: center;">
                            <?php if ($a['decision'] == 'cloture'): ?>
                                <span class="badge badge-success">✔ Clôturé</span>
                            <?php elseif ($a['decision'] == 'non_cloture'): ?>
                                <span class="badge badge-warning">⏳ Non clôturé</span>
                            <?php else: ?>
                                <span class="badge badge-secondary">—</span>
                            <?php endif; ?>
                        </td>
                        
                        <!-- Responsable vérification -->
                        <td><?= esc($a['responsable_verification'] ?? '—') ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="9" style="text-align: center;">
                        <em>Aucune action corrective enregistrée</em>
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