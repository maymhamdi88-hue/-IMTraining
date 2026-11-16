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
<?php if(session()->getFlashdata('errors')): ?>
    <div class="alert alert-danger alert-dismissible fade show">
        <strong>❌ Champs obligatoires manquants:</strong><hr>
        <ul class="mb-0">
            <?php foreach(session()->getFlashdata('errors') as $msg): ?>
                <li><?= esc($msg) ?></li>
            <?php endforeach; ?>
        </ul>
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
    </div>
<?php endif; ?>

<?php
// Helper pour selected sur les selects
function sel($evaluation, $field, $val) {
    return (isset($evaluation) && ($evaluation[$field] ?? '') == $val) ? 'selected' : '';
}
?>

<div class="row">
  <div class="col-md-10 col-md-offset-1">
    <div class="white-box">
      <h3 class="box-title m-b-30 text-center">
        <?= isset($evaluation) ? '✏️ Modifier une Évaluation Client' : '➕ Ajouter une Évaluation Client' ?>
      </h3>
      <div class="text-right m-b-20">
        <a href="<?= site_url('EvaluationClient/evaluation_list') ?>" class="btn btn-secondary">
          <i class="fa fa-arrow-left"></i> Retour à la liste
        </a>
      </div>

      <form method="post" action="<?= isset($evaluation)
          ? site_url('EvaluationClient/update_evaluation/' . $evaluation['id_evaluation'])
          : site_url('EvaluationClient/ajouter_evaluation') ?>">
        <?= csrf_field() ?>

        <!-- ===== SECTION 1: GÉNÉRAL ===== -->
        <div class="panel panel-primary">
          <div class="panel-heading"><h4 class="panel-title">📋 INFORMATIONS GÉNÉRALES</h4></div>
          <div class="panel-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Client: <span class="text-danger">*</span></label>
                  <select name="id_client" class="form-control" required>
                    <option value="">-- Choisir un client --</option>
                    <?php foreach ($clients as $c): ?>
                      <option value="<?= $c['id_client'] ?>"
                        <?= sel($evaluation ?? null, 'id_client', $c['id_client']) ?>>
                        <?= esc($c['nom_societe']) ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Ancienneté relation: <span class="text-danger">*</span></label>
                  <select name="anciennete_relation" class="form-control" required>
                    <option value="">-- Choisir --</option>
                    <option value="Nouveau"    <?= sel($evaluation ?? null, 'anciennete_relation', 'Nouveau') ?>>Nouveau client</option>
                    <option value="1-2_ans"    <?= sel($evaluation ?? null, 'anciennete_relation', '1-2_ans') ?>>1-2 ans</option>
                    <option value="3-5_ans"    <?= sel($evaluation ?? null, 'anciennete_relation', '3-5_ans') ?>>3-5 ans</option>
                    <option value="plus_5_ans" <?= sel($evaluation ?? null, 'anciennete_relation', 'plus_5_ans') ?>>+5 ans</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- ===== SECTION 2: FINANCIER ===== -->
        <div class="panel panel-warning">
          <div class="panel-heading"><h4 class="panel-title">💰 ASPECT FINANCIER</h4></div>
          <div class="panel-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Solvabilité: <span class="text-danger">*</span></label>
                  <select name="solvabilite" class="form-control" required>
                    <option value="">-- Choisir --</option>
                    <option value="Mauvais"   <?= sel($evaluation ?? null, 'solvabilite', 'Mauvais') ?>>Mauvais</option>
                    <option value="Moyen"     <?= sel($evaluation ?? null, 'solvabilite', 'Moyen') ?>>Moyen</option>
                    <option value="Bon"       <?= sel($evaluation ?? null, 'solvabilite', 'Bon') ?>>Bon</option>
                    <option value="Excellent" <?= sel($evaluation ?? null, 'solvabilite', 'Excellent') ?>>Excellent</option>
                  </select>
                </div>
                <div class="form-group">
                  <label>Respect échéances: <span class="text-danger">*</span></label>
                  <select name="respect_echeances" class="form-control" required>
                    <option value="">-- Choisir --</option>
                    <option value="Mauvais"   <?= sel($evaluation ?? null, 'respect_echeances', 'Mauvais') ?>>Mauvais</option>
                    <option value="Moyen"     <?= sel($evaluation ?? null, 'respect_echeances', 'Moyen') ?>>Moyen</option>
                    <option value="Bon"       <?= sel($evaluation ?? null, 'respect_echeances', 'Bon') ?>>Bon</option>
                    <option value="Excellent" <?= sel($evaluation ?? null, 'respect_echeances', 'Excellent') ?>>Excellent</option>
                  </select>
                </div>
                <div class="form-group">
                  <label>Délai paiement: <span class="text-danger">*</span></label>
                  <select name="delai_paiement" class="form-control" required>
                    <option value="">-- Choisir --</option>
                    <option value="plus_60j"  <?= sel($evaluation ?? null, 'delai_paiement', 'plus_60j') ?>>+60 jours</option>
                    <option value="30_60j"    <?= sel($evaluation ?? null, 'delai_paiement', '30_60j') ?>>30-60 jours</option>
                    <option value="moins_30j" <?= sel($evaluation ?? null, 'delai_paiement', 'moins_30j') ?>>≤30 jours</option>
                    <option value="Comptant"  <?= sel($evaluation ?? null, 'delai_paiement', 'Comptant') ?>>Paiement comptant</option>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Litiges paiement: <span class="text-danger">*</span></label>
                  <select name="litiges_paiement" class="form-control" required>
                    <option value="">-- Choisir --</option>
                    <option value="Frequents"    <?= sel($evaluation ?? null, 'litiges_paiement', 'Frequents') ?>>Fréquents</option>
                    <option value="Occasionnels" <?= sel($evaluation ?? null, 'litiges_paiement', 'Occasionnels') ?>>Occasionnels</option>
                    <option value="Rares"        <?= sel($evaluation ?? null, 'litiges_paiement', 'Rares') ?>>Rares</option>
                    <option value="Aucun"        <?= sel($evaluation ?? null, 'litiges_paiement', 'Aucun') ?>>Aucun</option>
                  </select>
                </div>
                <div class="form-group">
                  <label>Budget annuel estimé: <span class="text-danger">*</span></label>
                  <select name="budget_annuel" class="form-control" required>
                    <option value="">-- Choisir --</option>
                    <option value="Faible"     <?= sel($evaluation ?? null, 'budget_annuel', 'Faible') ?>>Faible</option>
                    <option value="Moyen"      <?= sel($evaluation ?? null, 'budget_annuel', 'Moyen') ?>>Moyen</option>
                    <option value="Eleve"      <?= sel($evaluation ?? null, 'budget_annuel', 'Eleve') ?>>Élevé</option>
                    <option value="Tres_eleve" <?= sel($evaluation ?? null, 'budget_annuel', 'Tres_eleve') ?>>Très élevé</option>
                  </select>
                </div>
                <div class="form-group">
                  <label>Commentaire financier:</label>
                  <textarea name="commentaire_financier" class="form-control" rows="3"
                            placeholder="Notes sur la situation financière..."><?= esc($evaluation['commentaire_financier'] ?? '') ?></textarea>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- ===== SECTION 3: COMMERCIAL ===== -->
        <div class="panel panel-info">
          <div class="panel-heading"><h4 class="panel-title">📈 ASPECT COMMERCIAL</h4></div>
          <div class="panel-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Nombre de formations/an: <span class="text-danger">*</span></label>
                  <select name="nb_formations" class="form-control" required>
                    <option value="">-- Choisir --</option>
                    <option value="1"      <?= sel($evaluation ?? null, 'nb_formations', '1') ?>>1</option>
                    <option value="2_3"    <?= sel($evaluation ?? null, 'nb_formations', '2_3') ?>>2-3</option>
                    <option value="4_6"    <?= sel($evaluation ?? null, 'nb_formations', '4_6') ?>>4-6</option>
                    <option value="plus_6" <?= sel($evaluation ?? null, 'nb_formations', 'plus_6') ?>>+6</option>
                  </select>
                </div>
                <div class="form-group">
                  <label>Nombre de thèmes/an: <span class="text-danger">*</span></label>
                  <select name="nb_themes" class="form-control" required>
                    <option value="">-- Choisir --</option>
                    <option value="1"      <?= sel($evaluation ?? null, 'nb_themes', '1') ?>>1</option>
                    <option value="2_3"    <?= sel($evaluation ?? null, 'nb_themes', '2_3') ?>>2-3</option>
                    <option value="4_5"    <?= sel($evaluation ?? null, 'nb_themes', '4_5') ?>>4-5</option>
                    <option value="plus_5" <?= sel($evaluation ?? null, 'nb_themes', 'plus_5') ?>>+5</option>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Récurrence des besoins: <span class="text-danger">*</span></label>
                  <select name="recurrence" class="form-control" required>
                    <option value="">-- Choisir --</option>
                    <option value="Ponctuel"      <?= sel($evaluation ?? null, 'recurrence', 'Ponctuel') ?>>Ponctuel</option>
                    <option value="Occasionnel"   <?= sel($evaluation ?? null, 'recurrence', 'Occasionnel') ?>>Occasionnel</option>
                    <option value="Regulier"      <?= sel($evaluation ?? null, 'recurrence', 'Regulier') ?>>Régulier</option>
                    <option value="Tres_regulier" <?= sel($evaluation ?? null, 'recurrence', 'Tres_regulier') ?>>Très régulier</option>
                  </select>
                </div>
                <div class="form-group">
                  <label>Potentiel nouvelles formations: <span class="text-danger">*</span></label>
                  <select name="potentiel_nouvelles_formations" class="form-control" required>
                    <option value="">-- Choisir --</option>
                    <option value="Faible" <?= sel($evaluation ?? null, 'potentiel_nouvelles_formations', 'Faible') ?>>Faible</option>
                    <option value="Moyen"  <?= sel($evaluation ?? null, 'potentiel_nouvelles_formations', 'Moyen') ?>>Moyen</option>
                    <option value="Eleve"  <?= sel($evaluation ?? null, 'potentiel_nouvelles_formations', 'Eleve') ?>>Élevé</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- ===== SECTION 4: RELATIONNEL ===== -->
        <div class="panel panel-danger">
          <div class="panel-heading"><h4 class="panel-title">🤝 ASPECT RELATIONNEL</h4></div>
          <div class="panel-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Qualité communication: <span class="text-danger">*</span></label>
                  <select name="qualite_communication" class="form-control" required>
                    <option value="">-- Choisir --</option>
                    <option value="Faible"   <?= sel($evaluation ?? null, 'qualite_communication', 'Faible') ?>>Faible</option>
                    <option value="Moyen"    <?= sel($evaluation ?? null, 'qualite_communication', 'Moyen') ?>>Moyen</option>
                    <option value="Bon"      <?= sel($evaluation ?? null, 'qualite_communication', 'Bon') ?>>Bon</option>
                    <option value="Excellent"<?= sel($evaluation ?? null, 'qualite_communication', 'Excellent') ?>>Excellent</option>
                  </select>
                </div>
                <div class="form-group">
                  <label>Clarté des demandes: <span class="text-danger">*</span></label>
                  <select name="clarte_demandes" class="form-control" required>
                    <option value="">-- Choisir --</option>
                    <option value="Faible"   <?= sel($evaluation ?? null, 'clarte_demandes', 'Faible') ?>>Faible</option>
                    <option value="Moyen"    <?= sel($evaluation ?? null, 'clarte_demandes', 'Moyen') ?>>Moyen</option>
                    <option value="Bon"      <?= sel($evaluation ?? null, 'clarte_demandes', 'Bon') ?>>Bon</option>
                    <option value="Excellent"<?= sel($evaluation ?? null, 'clarte_demandes', 'Excellent') ?>>Excellent</option>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Respect des engagements: <span class="text-danger">*</span></label>
                  <select name="respect_engagements" class="form-control" required>
                    <option value="">-- Choisir --</option>
                    <option value="Faible"   <?= sel($evaluation ?? null, 'respect_engagements', 'Faible') ?>>Faible</option>
                    <option value="Moyen"    <?= sel($evaluation ?? null, 'respect_engagements', 'Moyen') ?>>Moyen</option>
                    <option value="Bon"      <?= sel($evaluation ?? null, 'respect_engagements', 'Bon') ?>>Bon</option>
                    <option value="Excellent"<?= sel($evaluation ?? null, 'respect_engagements', 'Excellent') ?>>Excellent</option>
                  </select>
                </div>
                <div class="form-group">
                  <label>Facilité de collaboration: <span class="text-danger">*</span></label>
                  <select name="facilite_collaboration" class="form-control" required>
                    <option value="">-- Choisir --</option>
                    <option value="Faible"   <?= sel($evaluation ?? null, 'facilite_collaboration', 'Faible') ?>>Faible</option>
                    <option value="Moyen"    <?= sel($evaluation ?? null, 'facilite_collaboration', 'Moyen') ?>>Moyen</option>
                    <option value="Bon"      <?= sel($evaluation ?? null, 'facilite_collaboration', 'Bon') ?>>Bon</option>
                    <option value="Excellent"<?= sel($evaluation ?? null, 'facilite_collaboration', 'Excellent') ?>>Excellent</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- ===== SECTION 5: STRATÉGIQUE ===== -->
        <div class="panel panel-success">
          <div class="panel-heading"><h4 class="panel-title">🎯 ASPECT STRATÉGIQUE</h4></div>
          <div class="panel-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Ouverture aux innovations: <span class="text-danger">*</span></label>
                  <select name="ouverture_innovations" class="form-control" required>
                    <option value="">-- Choisir --</option>
                    <option value="Non" <?= sel($evaluation ?? null, 'ouverture_innovations', 'Non') ?>>Non</option>
                    <option value="Peu" <?= sel($evaluation ?? null, 'ouverture_innovations', 'Peu') ?>>Peu</option>
                    <option value="Oui" <?= sel($evaluation ?? null, 'ouverture_innovations', 'Oui') ?>>Oui</option>
                  </select>
                </div>
                <div class="form-group">
                  <label>Partenariat long terme: <span class="text-danger">*</span></label>
                  <select name="partenariat_long_terme" class="form-control" required>
                    <option value="">-- Choisir --</option>
                    <option value="Non"     <?= sel($evaluation ?? null, 'partenariat_long_terme', 'Non') ?>>Non</option>
                    <option value="Etudier" <?= sel($evaluation ?? null, 'partenariat_long_terme', 'Etudier') ?>>À étudier</option>
                    <option value="Oui"     <?= sel($evaluation ?? null, 'partenariat_long_terme', 'Oui') ?>>Oui</option>
                  </select>
                </div>
                <div class="form-group">
                  <label>Client stratégique:</label><br>
                  <input type="checkbox" name="client_strategique" value="1"
                    <?= (isset($evaluation) && $evaluation['client_strategique'] == 1) ? 'checked' : '' ?>>
                  <label class="m-l-10">Oui, c'est un client stratégique</label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Niveau de priorité: <span class="text-danger">*</span></label>
                  <select name="niveau_priorite" class="form-control" required>
                    <option value="">-- Choisir --</option>
                    <option value="Faible" <?= sel($evaluation ?? null, 'niveau_priorite', 'Faible') ?>>Faible</option>
                    <option value="Moyen"  <?= sel($evaluation ?? null, 'niveau_priorite', 'Moyen') ?>>Moyen</option>
                    <option value="Eleve"  <?= sel($evaluation ?? null, 'niveau_priorite', 'Eleve') ?>>Élevé</option>
                  </select>
                </div>
                <div class="form-group">
                  <label>Décision interne: <span class="text-danger">*</span></label>
                  <select name="decision_interne" class="form-control" required>
                    <option value="">-- Choisir --</option>
                    <option value="Developper" <?= sel($evaluation ?? null, 'decision_interne', 'Developper') ?>>À développer</option>
                    <option value="Maintenir"  <?= sel($evaluation ?? null, 'decision_interne', 'Maintenir') ?>>À maintenir</option>
                    <option value="Surveiller" <?= sel($evaluation ?? null, 'decision_interne', 'Surveiller') ?>>À surveiller</option>
                    <option value="Limiter"    <?= sel($evaluation ?? null, 'decision_interne', 'Limiter') ?>>À limiter / risque</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- BOUTON SUBMIT -->
        <div class="text-center m-t-30">
          <button type="submit" class="btn btn-danger btn-lg px-5">
            <i class="fa fa-save"></i>
            <?= isset($evaluation) ? 'Modifier' : 'Ajouter' ?>
          </button>
        </div>

      </form>
    </div>
  </div>
</div>

<?= $this->endSection() ?>