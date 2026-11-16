<!--
================================================
VIEW: Template PDF Congés (conge_pdf.php)
================================================
Rôle: Générer un PDF professionnel des congés
- Format A4 Paysage (Landscape)
- Style professionnel avec CSS inline
================================================
-->

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Congés</title>
    
    <!-- Styles CSS inline (obligatoire pour PDF) -->
    <style>
        /* Style général du document */
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 10pt;
            margin: 0;
            padding: 20px;
        }
        
        /* En-tête du document */
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #5bc0de;
            padding-bottom: 15px;
        }
        
        .header h1 {
            color: #5bc0de;
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
            background-color: #5bc0de;
            color: white;
            padding: 10px 5px;
            text-align: left;
            font-size: 9pt;
            border: 1px solid #46b8da;
        }
        
        /* Cellules du tableau */
        tbody td {
            padding: 8px 5px;
            border: 1px solid #ddd;
            font-size: 8pt;
            vertical-align: top;
        }
        
        /* Lignes alternées */
        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        /* Badge */
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            color: white;
            font-size: 7pt;
            font-weight: bold;
        }
        
        .badge-primary { background-color: #337ab7; }
        .badge-success { background-color: #5cb85c; }
        .badge-warning { background-color: #f0ad4e; }
        .badge-danger { background-color: #d9534f; }
        .badge-info { background-color: #5bc0de; }
        .badge-secondary { background-color: #6c757d; }
        
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
        <h1>🏖️ Liste des Congés</h1>
        <p>Document généré le <?= $date_export ?></p>
        <p>Nombre total de congés: <strong><?= count($conges) ?></strong></p>
    </div>

    <!-- ======================================== -->
    <!-- TABLEAU DES DONNÉES -->
    <!-- ======================================== -->
    <table>
        <!-- En-tête -->
        <thead>
            <tr>
                <th style="width: 5%;">#</th>
                <th style="width: 18%;">Employé</th>
                <th style="width: 12%;">Type</th>
                <th style="width: 10%;">Date Début</th>
                <th style="width: 10%;">Date Fin</th>
                <th style="width: 8%;">Nb Jours</th>
                <th style="width: 12%;">Statut</th>
                <th style="width: 15%;">Motif</th>
                <th style="width: 10%;">Date Demande</th>
            </tr>
        </thead>
        
        <!-- Corps du tableau -->
        <tbody>
            <?php if (!empty($conges)): ?>
                <?php $num = 1; ?>
                <?php foreach ($conges as $c): ?>
                    <tr>
                        <!-- Numéro -->
                        <td><?= $num++ ?></td>
                        
                        <!-- Employé -->
                        <td><strong><?= esc($employesMap[$c['id_employe']] ?? '—') ?></strong></td>
                        
                        <!-- Type avec badge -->
                        <td>
                            <?php
                            $type_badge = 'badge-primary';
                            if ($c['type_conge'] == 'maladie') {
                                $type_badge = 'badge-warning';
                            } elseif ($c['type_conge'] == 'sans_solde') {
                                $type_badge = 'badge-secondary';
                            }
                            ?>
                            <span class="badge <?= $type_badge ?>">
                                <?= ucfirst(str_replace('_', ' ', esc($c['type_conge']))) ?>
                            </span>
                        </td>
                        
                        <!-- Date début -->
                        <td>
                            <?php 
                            if ($c['date_debut']) {
                                echo date('d/m/Y', strtotime($c['date_debut']));
                            } else {
                                echo '—';
                            }
                            ?>
                        </td>
                        
                        <!-- Date fin -->
                        <td>
                            <?php 
                            if ($c['date_fin']) {
                                echo date('d/m/Y', strtotime($c['date_fin']));
                            } else {
                                echo '—';
                            }
                            ?>
                        </td>
                        
                        <!-- Nombre de jours -->
                        <td style="text-align: center;">
                            <?= esc($c['nombre_jours']) ?>
                        </td>
                        
                        <!-- Statut avec badge -->
                        <td>
                            <?php
                            $statut_badge = 'badge-info';
                            if ($c['statut'] == 'accepte') {
                                $statut_badge = 'badge-success';
                            } elseif ($c['statut'] == 'refuse') {
                                $statut_badge = 'badge-danger';
                            }
                            ?>
                            <span class="badge <?= $statut_badge ?>">
                                <?= ucfirst(str_replace('_', ' ', esc($c['statut']))) ?>
                            </span>
                        </td>
                        
                        <!-- Motif (limité à 40 caractères) -->
                        <td>
                            <?php 
                            $motif = esc($c['motif'] ?? '—');
                            if (strlen($motif) > 40) {
                                echo substr($motif, 0, 40) . '...';
                            } else {
                                echo $motif;
                            }
                            ?>
                        </td>
                        
                        <!-- Date demande -->
                        <td>
                            <?php 
                            if ($c['date_demande']) {
                                echo date('d/m/Y', strtotime($c['date_demande']));
                            } else {
                                echo '—';
                            }
                            ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="9" style="text-align: center;">
                        <em>Aucun congé enregistré</em>
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
