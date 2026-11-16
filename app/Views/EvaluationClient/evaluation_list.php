<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<?php if(session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <strong>✅</strong> <?= session()->getFlashdata('success') ?>
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
    </div>
<?php endif; ?>
<?php if(session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show">
        <strong>❌</strong> <?= session()->getFlashdata('error') ?>
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
    </div>
<?php endif; ?>

<div class="row">
  <div class="col-md-12">
    <div class="white-box">
      <h3 class="box-title">📊 Liste des Évaluations Clients</h3>
      <div class="text-right m-b-20">
        <a href="<?= site_url('EvaluationClient/ajouter_evaluation_form') ?>" class="btn btn-success">
          <i class="fa fa-plus"></i> Ajouter une Évaluation
        </a>
        <a href="<?= site_url('EvaluationClient/export_evaluations_pdf') ?>" class="btn btn-danger" target="_blank">
          <i class="fa fa-file-pdf-o"></i> Exporter en PDF
        </a>
      </div>

      <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover" style="min-width:2000px; font-size:12px;">
          <thead>
            <tr>
              <th rowspan="2" class="bg-secondary text-white" style="vertical-align:middle;">#</th>
              <th colspan="2" class="text-center bg-primary text-white">GÉNÉRAL</th>
              <th colspan="6" class="text-center text-white" style="background:#f0ad4e;">FINANCIER</th>
              <th colspan="4" class="text-center text-white" style="background:#5bc0de;">COMMERCIAL</th>
              <th colspan="4" class="text-center text-white" style="background:#d9534f;">RELATIONNEL</th>
              <th colspan="5" class="text-center text-white" style="background:#5cb85c;">STRATÉGIQUE</th>
              <th rowspan="2" class="bg-secondary text-white" style="vertical-align:middle;">Actions</th>
            </tr>
            <tr>
              <th>Client</th>
              <th>Ancienneté</th>
              <th>Solvabilité</th>
              <th>Respect éch.</th>
              <th>Délai paie.</th>
              <th>Litiges</th>
              <th>Budget</th>
              <th>Commentaire</th>
              <th>Nb form.</th>
              <th>Nb thèmes</th>
              <th>Récurrence</th>
              <th>Potentiel</th>
              <th>Qualité comm.</th>
              <th>Clarté</th>
              <th>Respect eng.</th>
              <th>Collab.</th>
              <th>Innov.</th>
              <th>Partenariat</th>
              <th>Strat.</th>
              <th>Priorité</th>
              <th>Décision</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($evaluations)): ?>
              <?php $num = 1; ?>
              <?php foreach ($evaluations as $e): ?>
                <tr>
                  <td><?= $num++ ?></td>
                  <td><strong><?= esc($clientsMap[$e['id_client']] ?? '—') ?></strong></td>
                  <td><?= esc($e['anciennete_relation'] ?? '—') ?></td>

                  <?php
                  // Helper badge inline
                  $badge = function($val, $map) {
                      $class = $map[$val] ?? 'secondary';
                      return '<span class="badge badge-'.$class.'">'.esc($val ?: '—').'</span>';
                  };
                  $qualBadge = ['Excellent'=>'success','Bon'=>'info','Moyen'=>'warning','Mauvais'=>'danger'];
                  $niveauBadge = ['Eleve'=>'danger','Moyen'=>'warning','Faible'=>'info'];
                  $budgetBadge = ['Tres_eleve'=>'success','Eleve'=>'info','Moyen'=>'warning','Faible'=>'secondary'];
                  $decisionBadge = ['Developper'=>'success','Maintenir'=>'info','Surveiller'=>'warning','Limiter'=>'danger'];
                  ?>

                  <td><?= $badge($e['solvabilite'] ?? '', $qualBadge) ?></td>
                  <td><?= $badge($e['respect_echeances'] ?? '', $qualBadge) ?></td>
                  <td><?= esc($e['delai_paiement'] ?? '—') ?></td>
                  <td><?= esc($e['litiges_paiement'] ?? '—') ?></td>
                  <td><?= $badge($e['budget_annuel'] ?? '', $budgetBadge) ?></td>
                  <td><?php $c = esc($e['commentaire_financier'] ?? '—'); echo strlen($c)>25 ? substr($c,0,25).'...' : $c; ?></td>

                  <td class="text-center"><?= esc($e['nb_formations'] ?? '—') ?></td>
                  <td class="text-center"><?= esc($e['nb_themes'] ?? '—') ?></td>
                  <td><?= esc($e['recurrence'] ?? '—') ?></td>
                  <td><?= $badge($e['potentiel_nouvelles_formations'] ?? '', ['Eleve'=>'success','Moyen'=>'warning','Faible'=>'secondary']) ?></td>

                  <td><?= $badge($e['qualite_communication'] ?? '', $qualBadge) ?></td>
                  <td><?= $badge($e['clarte_demandes'] ?? '', $qualBadge) ?></td>
                  <td><?= $badge($e['respect_engagements'] ?? '', $qualBadge) ?></td>
                  <td><?= $badge($e['facilite_collaboration'] ?? '', $qualBadge) ?></td>

                  <td><?= esc($e['ouverture_innovations'] ?? '—') ?></td>
                  <td><?= esc($e['partenariat_long_terme'] ?? '—') ?></td>
                  <td><span class="badge badge-<?= $e['client_strategique'] ? 'success' : 'secondary' ?>"><?= $e['client_strategique'] ? 'Oui' : 'Non' ?></span></td>
                  <td><?= $badge($e['niveau_priorite'] ?? '', $niveauBadge) ?></td>
                  <td><?= $badge($e['decision_interne'] ?? '', $decisionBadge) ?></td>

                  <td class="text-center" style="white-space:nowrap;">
                    <a href="<?= site_url('EvaluationClient/modifier_evaluation/' . $e['id_evaluation']) ?>"
                       class="btn btn-warning btn-sm" title="Modifier"><i class="fa fa-edit"></i></a>
                    <a href="<?= site_url('EvaluationClient/supprimer_evaluation/' . $e['id_evaluation']) ?>"
                       class="btn btn-danger btn-sm"
                       onclick="return confirm('⚠️ Supprimer cette évaluation ?')"
                       title="Supprimer"><i class="fa fa-trash"></i></a>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr><td colspan="23" class="text-center"><em>Aucune évaluation enregistrée</em></td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>