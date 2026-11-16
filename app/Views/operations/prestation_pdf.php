<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Prestations</title>
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
            border-bottom: 3px solid #d9534f;
            padding-bottom: 12px;
        }
        .header h1 {
            color: #d9534f;
            margin: 0 0 5px 0;
            font-size: 20pt;
            letter-spacing: 1px;
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
            background-color: #d9534f;
            color: white;
            padding: 7px 4px;
            text-align: left;
            font-size: 7.5pt;
            border: 1px solid #c9302c;
        }
        tbody td {
            padding: 6px 4px;
            border: 1px solid #ddd;
            font-size: 7pt;
            vertical-align: top;
        }
        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 3px;
            color: white;
            font-size: 6.5pt;
            font-weight: bold;
        }
        .badge-primary   { background-color: #337ab7; }
        .badge-success   { background-color: #5cb85c; }
        .badge-warning   { background-color: #f0ad4e; color: #333; }
        .badge-info      { background-color: #5bc0de; }
        .badge-dark      { background-color: #343a40; }
        .badge-danger    { background-color: #d9534f; }
        .badge-secondary { background-color: #6c757d; }
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 7.5pt;
            color: #999;
            border-top: 1px solid #ddd;
            padding-top: 8px;
        }
        .text-center { text-align: center; }
    </style>
</head>
<body>

    <div class="header">
        <h1>Liste des Prestations</h1>
        <p>Document genere le : <strong><?= $date_export ?></strong></p>
        <p>Nombre total d'activites : <strong><?= count($activites) ?></strong></p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width:3%;">#</th>
                <th style="width:8%;">Type</th>
                <th style="width:7%;">Reference</th>
                <th style="width:10%;">Theme</th>
                <th style="width:10%;">Formateur</th>
                <th style="width:10%;">Client</th>
                <th style="width:8%;">Date Prestation</th>
                <th style="width:7%;">Lieu</th>
                <th style="width:5%;">Participants</th>
                <th style="width:7%;">Statut</th>
                <th style="width:10%;">Remarque</th>
                <th style="width:8%;">Objectif</th>
                <th style="width:7%;">Debut</th>
                <th style="width:7%;">Fin</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($activites)): ?>
                <?php $num = 1; ?>
                <?php foreach ($activites as $a): ?>
                    <tr>

                        <td class="text-center"><?= $num++ ?></td>

                        <!-- Type -->
                        <td>
                            <?php
                                // ⚠️ valeurs base: TFP, Droit de tirage, Contenu, Audit, Consulting
                                $typeBadge = 'badge-secondary';
                                switch ($a['type_activite'] ?? '') {
                                    case 'TFP':             $typeBadge = 'badge-primary'; break;
                                    case 'Droit de tirage': $typeBadge = 'badge-success'; break;
                                    case 'Contenu':         $typeBadge = 'badge-info';    break;
                                    case 'Audit':           $typeBadge = 'badge-warning'; break;
                                    case 'Consulting':      $typeBadge = 'badge-dark';    break;
                                }
                            ?>
                            <span class="badge <?= $typeBadge ?>"><?= esc($a['type_activite'] ?? '-') ?></span>
                        </td>

                        <td><?= esc($a['reference'] ?? '-') ?></td>
                        <td><?= esc($a['theme_domaine'] ?? '-') ?></td>
                        <td><?= esc($formateursMap[$a['id_formateur']] ?? '-') ?></td>
                        <td><?= esc($clientsMap[$a['id_client']] ?? '-') ?></td>

                        <!-- Date Prestation -->
                        <td>
                            <?php
                                $dp = $a['date_prestation'] ?? '';
                                echo $dp ? esc(mb_substr($dp, 0, 80)) . (mb_strlen($dp) > 80 ? '...' : '') : '-';
                            ?>
                        </td>

                        <td><?= esc($a['lieu'] ?? '-') ?></td>
                        <td class="text-center"><?= esc($a['nombre_participants'] ?? '-') ?></td>

                        <!-- Statut -->
                        <td>
                            <?php
                                // ⚠️ valeurs base: planifiee, reporte, en_cours, terminee, annulee
                                $statutBadge  = 'badge-secondary';
                                $statutLabel  = $a['statut'] ?? '-';
                                switch ($a['statut'] ?? '') {
                                    case 'planifiee': $statutBadge = 'badge-info';    $statutLabel = 'Planifie';  break;
                                    case 'reporte':   $statutBadge = 'badge-warning'; $statutLabel = 'Reporte';   break;
                                    case 'en_cours':  $statutBadge = 'badge-primary'; $statutLabel = 'En cours';  break;
                                    case 'terminee':  $statutBadge = 'badge-success'; $statutLabel = 'Termine';   break;
                                    case 'annulee':   $statutBadge = 'badge-danger';  $statutLabel = 'Annule';    break;
                                }
                            ?>
                            <span class="badge <?= $statutBadge ?>"><?= $statutLabel ?></span>
                        </td>

                        <!-- Remarque -->
                        <td>
                            <?php
                                $r = $a['remarque'] ?? '';
                                echo $r ? esc(mb_substr($r, 0, 100)) . (mb_strlen($r) > 100 ? '...' : '') : '-';
                            ?>
                        </td>

                        <!-- Objectif -->
                        <td>
                            <?php
                                $o = $a['objectif'] ?? '';
                                echo $o ? esc(mb_substr($o, 0, 100)) . (mb_strlen($o) > 100 ? '...' : '') : '-';
                            ?>
                        </td>

                        <td class="text-center">
                            <?= !empty($a['date_debut']) ? date('d/m/Y', strtotime($a['date_debut'])) : '-' ?>
                        </td>

                        <td class="text-center">
                            <?= !empty($a['date_fin']) ? date('d/m/Y', strtotime($a['date_fin'])) : '-' ?>
                        </td>

                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="14" class="text-center" style="padding:20px;">
                        <em>Aucune activite enregistree</em>
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