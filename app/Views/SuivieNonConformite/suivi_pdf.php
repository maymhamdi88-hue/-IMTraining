<!--
================================================
VIEW: Template PDF Suivi Non-Conformité (suivi_pdf.php)
================================================
Rôle: Générer un PDF professionnel des suivis
- Format A4 Paysage
- Tous les attributs visibles
- Style professionnel avec CSS inline
================================================
-->

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Suivis Non-Conformité</title>
    
    <style>
        /* Style général */
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 8pt;
            margin: 0;
            padding: 15px;
        }
        
        /* En-tête */
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 3px solid #e67e22;
            padding-bottom: 10px;
        }
        
        .header h1 {
            color: #e67e22;
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
            background-color: #e67e22;
            color: white;
            padding: 6px 4px;
            text-align: left;
            font-size: 7pt;
            border: 1px solid #d35400;
        }
        
        /* Cellules */
        tbody td {
            padding: 5px 4px;
            border: 1px solid #ddd;
            font-size: 7pt;
            vertical-align: top;
        }
        
        /* Lignes alternées */
        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
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
        <h1>⚠️ Liste des Suivis Non-Conformité</h1>
        <p>Document généré le <?= $date_export ?></p>
        <p>Nombre total de suivis: <strong><?= count($suivis) ?></strong></p>
    </div>

    <!-- ======================================== -->
    <!-- TABLEAU -->
    <!-- ======================================== -->
    <table>
        <thead>
            <tr>
                <th style="width: 5%;">#</th>
                <th style="width: 10%;">Date Constat</th>
                <th style="width: 20%;">Désignation</th>
                <th style="width: 20%;">Correction Immédiate</th>
                <th style="width: 10%;">Date Réalisation</th>
                <th style="width: 15%;">Responsable</th>
                <th style="width: 20%;">Causes Probables</th>
            </tr>
        </thead>
        
        <tbody>
            <?php if (!empty($suivis)): ?>
                <?php $num = 1; ?>
                <?php foreach ($suivis as $s): ?>
                    <tr>
                        <!-- # -->
                        <td><?= $num++ ?></td>
                        
                        <!-- Date constat -->
                        <td>
                            <?php 
                            if ($s['date_constat']) {
                                echo date('d/m/Y', strtotime($s['date_constat']));
                            } else {
                                echo '—';
                            }
                            ?>
                        </td>
                        
                        <!-- Désignation -->
                        <td><?= esc($s['designation'] ?? '—') ?></td>
                        
                        <!-- Correction immédiate -->
                        <td><?= esc($s['correction_immediate'] ?? '—') ?></td>
                        
                        <!-- Date réalisation -->
                        <td>
                            <?php 
                            if ($s['date_realisation']) {
                                echo date('d/m/Y', strtotime($s['date_realisation']));
                            } else {
                                echo '—';
                            }
                            ?>
                        </td>
                        
                        <!-- Responsable -->
                        <td><?= esc($s['responsable']) ?></td>
                        
                        <!-- Causes probables -->
                        <td><?= esc($s['causes_probables'] ?? '—') ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" style="text-align: center;">
                        <em>Aucun suivi non-conformité enregistré</em>
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