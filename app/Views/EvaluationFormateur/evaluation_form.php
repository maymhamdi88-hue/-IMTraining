<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<?php if(session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Succès</strong> — <?= session()->getFlashdata('success') ?>
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
    </div>
<?php endif; ?>

<?php if(session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Erreur</strong> — <?= session()->getFlashdata('error') ?>
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
    </div>
<?php endif; ?>

<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="white-box">

            <h3 class="box-title m-b-30 text-center">
                <?= isset($evaluation_edit) ? 'Modifier une Évaluation' : 'Ajouter une Évaluation Formateur' ?>
            </h3>

            <div class="text-right m-b-20">
                <a href="<?= site_url('EvaluationFormateur/evaluation_list') ?>" class="btn btn-secondary">
                    <i class="fa fa-arrow-left"></i> Retour à la liste
                </a>
            </div>

            <form method="post"
                  action="<?= isset($evaluation_edit)
                      ? site_url('EvaluationFormateur/update/' . $evaluation_edit['id_evaluation'])
                      : site_url('EvaluationFormateur/ajouter') ?>">

                <?= csrf_field() ?>

                <div class="row">

                    <!-- ══ COLONNE GAUCHE ══ -->
                    <div class="col-md-6">

                        <!-- Formateur -->
                        <div class="form-group">
                            <label class="control-label">Formateur <span class="text-danger">*</span></label>
                            <select name="id_formateur" class="form-control" required>
                                <option value="">-- Choisir un formateur --</option>
                                <?php foreach ($formateurs as $f): ?>
                                    <option value="<?= $f['id_formateur'] ?>"
                                        <?= (isset($evaluation_edit) && $evaluation_edit['id_formateur'] == $f['id_formateur']) ? 'selected' : '' ?>>
                                        <?= esc($f['nom_prenom']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Activité / Prestation -->
                        <div class="form-group">
                            <label class="control-label">Prestation <span class="text-danger">*</span></label>
                            <select name="id_activite" class="form-control" required>
                                <option value="">-- Choisir une activité --</option>
                                <?php foreach ($activites as $a): ?>
                                    <option value="<?= $a['id_activite'] ?>"
                                        <?= (isset($evaluation_edit) && $evaluation_edit['id_activite'] == $a['id_activite']) ? 'selected' : '' ?>>
                                        <?= esc($a['type_activite'] . ' - ' . ($a['theme_domaine'] ?? '')) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Client -->
                        <div class="form-group">
                            <label class="control-label">Client</label>
                            <select name="id_client" class="form-control">
                                <option value="">-- Choisir un client --</option>
                                <?php foreach ($clients as $c): ?>
                                    <option value="<?= $c['id_client'] ?>"
                                        <?= (isset($evaluation_edit) && $evaluation_edit['id_client'] == $c['id_client']) ? 'selected' : '' ?>>
                                        <?= esc($c['nom_societe']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Pédagogie -->
                        <div class="form-group">
                            <label class="control-label">Pédagogie & Méthodes (0-10)</label>
                            <input type="number" name="pedagogie_methodes" class="form-control score-input"
                                   placeholder="0" min="0" max="10" step="0.1"
                                   value="<?= esc($evaluation_edit['pedagogie_methodes'] ?? '') ?>">
                        </div>

                        <!-- Maîtrise technique -->
                        <div class="form-group">
                            <label class="control-label">Maîtrise technique (0-10)</label>
                            <input type="number" name="maitrise_technique" class="form-control score-input"
                                   placeholder="0" min="0" max="10" step="0.1"
                                   value="<?= esc($evaluation_edit['maitrise_technique'] ?? '') ?>">
                        </div>

                        <!-- Posture & Soft skills -->
                        <div class="form-group">
                            <label class="control-label">Posture & Soft skills (0-10)</label>
                            <input type="number" name="posture_soft_skills" class="form-control score-input"
                                   placeholder="0" min="0" max="10" step="0.1"
                                   value="<?= esc($evaluation_edit['posture_soft_skills'] ?? '') ?>">
                        </div>

                    </div>

                    <!-- ══ COLONNE DROITE ══ -->
                    <div class="col-md-6">

                        <!-- Dossier administratif -->
                        <div class="form-group">
                            <label class="control-label">Dossier administratif & ponctualité (0-10)</label>
                            <input type="number" name="dossier_administratif_ponctualite" class="form-control score-input"
                                   placeholder="0" min="0" max="10" step="0.1"
                                   value="<?= esc($evaluation_edit['dossier_administratif_ponctualite'] ?? '') ?>">
                        </div>

                        <!-- Facilité de collaboration -->
                        <div class="form-group">
                            <label class="control-label">Facilité de collaboration (0-10)</label>
                            <input type="number" name="facilite_collaboration" class="form-control score-input"
                                   placeholder="0" min="0" max="10" step="0.1"
                                   value="<?= esc($evaluation_edit['facilite_collaboration'] ?? '') ?>">
                        </div>

                        <!-- Flexibilité délais paiement -->
                        <div class="form-group">
                            <label class="control-label">Flexibilité des délais de paiement (0-10)</label>
                            <input type="number" name="flexibilite_delais_paiement" class="form-control score-input"
                                   placeholder="0" min="0" max="10" step="0.1"
                                   value="<?= esc($evaluation_edit['flexibilite_delais_paiement'] ?? '') ?>">
                        </div>

                        <!-- Score global (readonly, calculé auto) -->
                        <div class="form-group">
                            <label class="control-label">
                                Score global (calculé automatiquement) <span class="text-danger">*</span>
                            </label>
                            <input type="number" name="score_global" id="score_global"
                                   class="form-control" required readonly
                                   style="background-color:#f0f0f0; font-weight:bold; font-size:16px;"
                                   value="<?= esc($evaluation_edit['score_global'] ?? '') ?>">
                        </div>

                        <!-- Remarque -->
                        <div class="form-group">
                            <label class="control-label">Remarque</label>
                            <textarea name="remarque" class="form-control" rows="4"
                                      placeholder="Commentaires supplémentaires..."><?= esc($evaluation_edit['remarque'] ?? '') ?></textarea>
                        </div>

                    </div>
                </div>

                <!-- BOUTON SUBMIT -->
                <div class="text-center m-t-30">
                    <button type="submit" class="btn btn-danger btn-lg px-5">
                        <i class="fa fa-save"></i>
                        <?= isset($evaluation_edit) ? 'Modifier' : 'Ajouter' ?>
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<!-- CALCUL AUTOMATIQUE DU SCORE -->
<script>
function calcScore() {
    var inputs = document.querySelectorAll('.score-input');
    var total = 0, count = 0;
    inputs.forEach(function(input) {
        var val = parseFloat(input.value);
        if (!isNaN(val)) {
            total += val;
            count++;
        }
    });
    var moyenne = count > 0 ? (total / count) : 0;
    document.getElementById('score_global').value = moyenne.toFixed(3);
}

document.querySelectorAll('.score-input').forEach(function(input) {
    input.addEventListener('input', calcScore);
});

// Calcul au chargement (mode modification)
calcScore();
</script>

<?= $this->endSection() ?>