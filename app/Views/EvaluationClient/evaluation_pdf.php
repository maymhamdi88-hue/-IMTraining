<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Évaluations Clients</title>
<style>
  body{font-family:'DejaVu Sans',Arial,sans-serif;font-size:7pt;margin:0;padding:15px;}
  .header{text-align:center;margin-bottom:20px;border-bottom:3px solid #5cb85c;padding-bottom:10px;}
  .header h1{color:#5cb85c;margin:0;font-size:18pt;}
  .header p{color:#666;margin:3px 0;font-size:8pt;}
  table{width:100%;border-collapse:collapse;margin-top:15px;}
  thead th{padding:5px 2px;text-align:center;font-size:6pt;border:1px solid #ddd;color:white;font-weight:bold;}
  .sg{background-color:#337ab7;}
  .sf{background-color:#f0ad4e;}
  .sc{background-color:#5bc0de;}
  .sr{background-color:#d9534f;}
  .ss{background-color:#5cb85c;}
  thead th.sub{background-color:#f5f5f5;color:#333;font-size:6pt;padding:3px 2px;}
  tbody td{padding:4px 2px;border:1px solid #ddd;font-size:6pt;vertical-align:top;}
  tbody tr:nth-child(even){background-color:#f9f9f9;}
  .b{display:inline-block;padding:2px 4px;border-radius:2px;color:white;font-size:5pt;font-weight:bold;}
  .b-success{background-color:#5cb85c;}
  .b-info{background-color:#5bc0de;}
  .b-warning{background-color:#f0ad4e;color:#333;}
  .b-danger{background-color:#d9534f;}
  .b-secondary{background-color:#6c757d;}
  .footer{margin-top:20px;text-align:center;font-size:6pt;color:#999;border-top:1px solid #ddd;padding-top:8px;}
</style>
</head>
<body>
<div class="header">
  <h1>📊 Évaluations Clients</h1>
  <p>Généré le <?= $date_export ?> — Total: <strong><?= count($evaluations) ?></strong> évaluations</p>
</div>

<?php
$qb = function($val, $map) {
    $class = $map[$val] ?? 'secondary';
    return '<span class="b b-'.$class.'">'.htmlspecialchars($val ?: '—').'</span>';
};
$qualMap = ['Excellent'=>'success','Bon'=>'info','Moyen'=>'warning','Mauvais'=>'danger'];
$niveauMap = ['Eleve'=>'danger','Moyen'=>'warning','Faible'=>'info'];
$budgetMap = ['Tres_eleve'=>'success','Eleve'=>'info','Moyen'=>'warning','Faible'=>'secondary'];
$decisionMap = ['Developper'=>'success','Maintenir'=>'info','Surveiller'=>'warning','Limiter'=>'danger'];
?>

<table>
  <thead>
    <tr>
      <th rowspan="2" style="vertical-align:middle;background:#666;width:2%;">#</th>
      <th colspan="2" class="sg">GÉNÉRAL</th>
      <th colspan="6" class="sf">FINANCIER</th>
      <th colspan="4" class="sc">COMMERCIAL</th>
      <th colspan="4" class="sr">RELATIONNEL</th>
      <th colspan="5" class="ss">STRATÉGIQUE</th>
    </tr>
    <tr>
      <th class="sub">Client</th><th class="sub">Ancienneté</th>
      <th class="sub">Solvabilité</th><th class="sub">Respect éch.</th>
      <th class="sub">Délai</th><th class="sub">Litiges</th>
      <th class="sub">Budget</th><th class="sub">Commentaire</th>
      <th class="sub">Nb form.</th><th class="sub">Nb thèmes</th>
      <th class="sub">Récurrence</th><th class="sub">Potentiel</th>
      <th class="sub">Qualité</th><th class="sub">Clarté</th>
      <th class="sub">Eng.</th><th class="sub">Collab.</th>
      <th class="sub">Innov.</th><th class="sub">Partenariat</th>
      <th class="sub">Strat.</th><th class="sub">Priorité</th><th class="sub">Décision</th>
    </tr>
  </thead>
  <tbody>
    <?php if (!empty($evaluations)): ?>
      <?php $num = 1; foreach ($evaluations as $e): ?>
        <tr>
          <td style="text-align:center;"><?= $num++ ?></td>
          <td><strong><?= htmlspecialchars($clientsMap[$e['id_client']] ?? '—') ?></strong></td>
          <td><?= htmlspecialchars($e['anciennete_relation'] ?? '—') ?></td>
          <td><?= $qb($e['solvabilite'] ?? '', $qualMap) ?></td>
          <td><?= $qb($e['respect_echeances'] ?? '', $qualMap) ?></td>
          <td><?= htmlspecialchars($e['delai_paiement'] ?? '—') ?></td>
          <td><?= htmlspecialchars($e['litiges_paiement'] ?? '—') ?></td>
          <td><?= $qb($e['budget_annuel'] ?? '', $budgetMap) ?></td>
          <td><?php $c=htmlspecialchars($e['commentaire_financier']??'—'); echo strlen($c)>20?substr($c,0,20).'...':$c; ?></td>
          <td style="text-align:center;"><?= htmlspecialchars($e['nb_formations'] ?? '—') ?></td>
          <td style="text-align:center;"><?= htmlspecialchars($e['nb_themes'] ?? '—') ?></td>
          <td><?= htmlspecialchars($e['recurrence'] ?? '—') ?></td>
          <td><?= $qb($e['potentiel_nouvelles_formations'] ?? '', ['Eleve'=>'success','Moyen'=>'warning','Faible'=>'secondary']) ?></td>
          <td><?= $qb($e['qualite_communication'] ?? '', $qualMap) ?></td>
          <td><?= $qb($e['clarte_demandes'] ?? '', $qualMap) ?></td>
          <td><?= $qb($e['respect_engagements'] ?? '', $qualMap) ?></td>
          <td><?= $qb($e['facilite_collaboration'] ?? '', $qualMap) ?></td>
          <td><?= htmlspecialchars($e['ouverture_innovations'] ?? '—') ?></td>
          <td><?= htmlspecialchars($e['partenariat_long_terme'] ?? '—') ?></td>
          <td><span class="b b-<?= $e['client_strategique']?'success':'secondary' ?>"><?= $e['client_strategique']?'Oui':'Non' ?></span></td>
          <td><?= $qb($e['niveau_priorite'] ?? '', $niveauMap) ?></td>
          <td><?= $qb($e['decision_interne'] ?? '', $decisionMap) ?></td>
        </tr>
      <?php endforeach; ?>
    <?php else: ?>
      <tr><td colspan="22" style="text-align:center;"><em>Aucune évaluation</em></td></tr>
    <?php endif; ?>
  </tbody>
</table>

<div class="footer">
  <p>© <?= date('Y') ?> - Document généré automatiquement - Confidentiel</p>
</div>
</body>
</html>