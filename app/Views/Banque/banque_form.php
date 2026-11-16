<!--
================================================
VIEW: Formulaire Banque (banque_form.php)
================================================
-->

<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<!-- MESSAGES -->
<?php if(session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <strong>✅ Succès</strong><hr><?= session()->getFlashdata('success') ?>
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
    </div>
<?php endif; ?>

<?php if(session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show">
        <strong>❌ Erreur</strong><hr><?= session()->getFlashdata('error') ?>
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
    </div>
<?php endif; ?>

<!-- FORMULAIRE -->
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="white-box">
            <h3 class="box-title m-b-30 text-center">
                <?= isset($operation) ? '✏️ Modifier une Opération' : '➕ Ajouter une Opération' ?>
            </h3>

            <div class="text-right m-b-20">
                <a href="<?= base_url('Banque/banque_list') ?>" class="btn btn-secondary">
                    <i class="fa fa-arrow-left"></i> Retour à la liste
                </a>
            </div>

            <form method="post"
                  action="<?= isset($operation)
                      ? base_url('Banque/banque_update/' . $operation['id_banque'])
                      : base_url('Banque/banque_store') ?>">

                <?= csrf_field() ?>

                <div class="row">

                    <!-- COLONNE GAUCHE -->
                    <div class="col-md-6">

                        <!-- Date opération -->
                        <div class="form-group">
                            <label>Date d'opération: <span class="text-danger">*</span></label>
                            <input type="date" name="date_operation" class="form-control" required
                                   value="<?= old('date_operation', $operation['date_operation'] ?? date('Y-m-d')) ?>">
                        </div>

                        <!-- Type opération -->
                        <div class="form-group">
                            <label>Type d'opération: <span class="text-danger">*</span></label>
                            <select name="type_operation" id="type_operation" class="form-control" required>
                                <option value="">-- Choisir --</option>
                                <option value="credit"
                                    <?= old('type_operation', $operation['type_operation'] ?? '') === 'credit' ? 'selected' : '' ?>>
                                    ✅ Crédit (Entrée)
                                </option>
                                <option value="debit"
                                    <?= old('type_operation', $operation['type_operation'] ?? '') === 'debit' ? 'selected' : '' ?>>
                                    🔴 Débit (Sortie)
                                </option>
                            </select>
                        </div>

                        <!-- Montant -->
                        <div class="form-group">
                            <label>Montant (DT): <span class="text-danger">*</span></label>
                            <input type="number" name="montant" id="montant" class="form-control" required
                                   step="0.001" min="0.001"
                                   placeholder="Ex: 500.000"
                                   value="<?= old('montant', $operation['montant'] ?? '') ?>">
                        </div>

                        <!-- Libellé -->
                        <div class="form-group">
                            <label>Libellé:</label>
                            <input type="text" name="libelle" class="form-control"
                                   placeholder="Ex: Virement client, Loyer..."
                                   value="<?= old('libelle', $operation['libelle'] ?? '') ?>">
                        </div>

                        <!-- Désignation précise -->
                        <div class="form-group">
                            <label>Désignation précise:</label>
                            <textarea name="designation_precise" class="form-control" rows="3"
                                      placeholder="Détails de l'opération..."><?= old('designation_precise', $operation['designation_precise'] ?? '') ?></textarea>
                        </div>

                    </div>

                    <!-- COLONNE DROITE -->
                    <div class="col-md-6">

                        <!-- ===================================== -->
                        <!-- SOLDE INITIALE — Readonly automatique -->
                        <!-- ===================================== -->
                        <div class="form-group">
                            <label>
                                💰 Solde Initial (DT):
                                <small class="text-muted">(dernier solde enregistré)</small>
                            </label>
                            <input type="text"
                                   id="solde_initiale_display"
                                   class="form-control"
                                   style="background-color:#eef4ff; font-weight:bold; color:#337ab7; font-size:16px; cursor:not-allowed;"
                                   value="<?= number_format(
                                       isset($operation) ? (float)$operation['solde_initiale'] : (float)$solde_initiale,
                                       3, ',', ' '
                                   ) ?> DT"
                                   readonly>
                            <!-- Valeur numérique cachée pour le calcul JS -->
                            <input type="hidden" id="solde_initiale_val"
                                   value="<?= isset($operation) ? (float)$operation['solde_initiale'] : (float)$solde_initiale ?>">
                        </div>

                        <!-- ===================================== -->
                        <!-- SOLDE FINALE — Calculé auto en JS    -->
                        <!-- ===================================== -->
                        <div class="form-group">
                            <label>
                                📊 Solde Final (DT):
                                <small class="text-muted">(calculé automatiquement)</small>
                            </label>
                            <input type="text"
                                   id="solde_finale_display"
                                   class="form-control"
                                   style="font-weight:bold; font-size:16px; cursor:not-allowed;"
                                   placeholder="Remplir montant et type..."
                                   readonly>
                        </div>

                        <!-- ===================================== -->
                        <!-- RÉSUMÉ VISUEL du calcul              -->
                        <!-- ===================================== -->
                        <div id="resume_operation" class="alert" style="display:none; margin-top:10px; font-size:14px;">
                            <strong id="resume_text"></strong>
                        </div>

                    </div>
                </div>

                <!-- BOUTON SUBMIT -->
                <div class="text-center m-t-30">
                    <button type="submit" class="btn btn-danger btn-lg px-5">
                        <i class="fa fa-save"></i>
                        <?= isset($operation) ? 'Modifier' : 'Ajouter' ?>
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<!-- ============================================ -->
<!-- JAVASCRIPT — Calcul automatique solde finale -->
<!-- ============================================ -->
<script>
    var soldeInitiale = parseFloat(document.getElementById('solde_initiale_val').value) || 0;
    var montantInput  = document.getElementById('montant');
    var typeSelect    = document.getElementById('type_operation');
    var soldeDisplay  = document.getElementById('solde_finale_display');
    var resumeBox     = document.getElementById('resume_operation');
    var resumeText    = document.getElementById('resume_text');

    function formatNum(num) {
        // Format: 1 234,567 DT
        return num.toFixed(3)
                  .replace('.', ',')
                  .replace(/\B(?=(\d{3})+(?!\d))/g, ' ');
    }

    function calculerSolde() {
        var montant = parseFloat(montantInput.value) || 0;
        var type    = typeSelect.value;

        if (montant <= 0 || type === '') {
            soldeDisplay.value = '';
            soldeDisplay.placeholder = 'Remplir montant et type...';
            soldeDisplay.style.color = '#999';
            resumeBox.style.display = 'none';
            return;
        }

        var soldeFin;

        if (type === 'credit') {
            soldeFin = soldeInitiale + montant;
            soldeDisplay.style.color      = '#27ae60';
            resumeBox.className           = 'alert alert-success';
            resumeText.innerHTML          =
                '✅ ' + formatNum(soldeInitiale) + ' DT' +
                ' &nbsp;+&nbsp; ' + formatNum(montant) + ' DT' +
                ' &nbsp;=&nbsp; <u>' + formatNum(soldeFin) + ' DT</u>';
        } else {
            soldeFin = soldeInitiale - montant;
            if (soldeFin < 0) {
                soldeDisplay.style.color = '#e74c3c';
                resumeBox.className      = 'alert alert-danger';
            } else {
                soldeDisplay.style.color = '#e67e22';
                resumeBox.className      = 'alert alert-warning';
            }
            resumeText.innerHTML =
                '🔴 ' + formatNum(soldeInitiale) + ' DT' +
                ' &nbsp;-&nbsp; ' + formatNum(montant) + ' DT' +
                ' &nbsp;=&nbsp; <u>' + formatNum(soldeFin) + ' DT</u>';
        }

        soldeDisplay.value          = formatNum(soldeFin) + ' DT';
        resumeBox.style.display     = 'block';
    }

    montantInput.addEventListener('input',  calculerSolde);
    typeSelect.addEventListener('change',   calculerSolde);

    // Calculer au chargement (cas modification)
    window.addEventListener('load', calculerSolde);
</script>

<?= $this->endSection() ?>