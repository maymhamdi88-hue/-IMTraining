<!--
================================================
VIEW: Formulaire Charges & Dépenses (charges_form.php)
Compatible avec ChargeDepense controller
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

<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="white-box">
            <h3 class="box-title m-b-30 text-center">
                <?= isset($charge) ? '✏️ Modifier une Charge' : '➕ Ajouter une Charge' ?>
            </h3>

            <div class="text-right m-b-20">
                <a href="<?= base_url('ChargeDepense/charges_list') ?>" class="btn btn-secondary">
                    <i class="fa fa-arrow-left"></i> Retour à la liste
                </a>
            </div>

            <form method="post"
                  action="<?= isset($charge)
                      ? base_url('ChargeDepense/charges_update/' . $charge['id_charge'])
                      : base_url('ChargeDepense/charges_store') ?>">

                <?= csrf_field() ?>

                <div class="row">
                    <!-- COLONNE GAUCHE -->
                    <div class="col-md-6">

                        <!-- Type charge -->
                        <div class="form-group">
                            <label>Type charge:</label>
                            <input type="text" name="type_charge" class="form-control"
                                   placeholder="Ex: Fournitures, Loyer, STEG..."
                                   value="<?= esc($charge['type_charge'] ?? '') ?>">
                        </div>

                        <!-- Fournisseur -->
                        <div class="form-group">
                            <label>Fournisseur:</label>
                            <input type="text" name="fournisseur" class="form-control"
                                   placeholder="Nom du fournisseur"
                                   value="<?= esc($charge['fournisseur'] ?? '') ?>">
                        </div>

                        <!-- Désignation -->
                        <div class="form-group">
                            <label>Désignation:</label>
                            <textarea name="designation" class="form-control" rows="3"
                                      placeholder="Désignation détaillée..."><?= esc($charge['designation'] ?? '') ?></textarea>
                        </div>

                        <!-- Banque/Poste -->
                        <div class="form-group">
                            <label>Banque/Poste:</label>
                            <input type="text" name="banque_poste" class="form-control"
                                   placeholder="Banque ou poste"
                                   value="<?= esc($charge['banque_poste'] ?? '') ?>">
                        </div>

                        <!-- Employé -->
                        <div class="form-group">
                            <label>Employé:</label>
                            <select name="id_employe" class="form-control">
                                <option value="">Choisir</option>
                                <?php foreach ($employes as $e): ?>
                                    <option value="<?= $e['id_employe'] ?>"
                                        <?= isset($charge) && $charge['id_employe'] == $e['id_employe'] ? 'selected' : '' ?>>
                                        <?= esc($e['nom'] . ' ' . $e['prenom']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Date charge -->
                        <div class="form-group">
                            <label>Date charge:</label>
                            <input type="date" name="date_charge" class="form-control"
                                   value="<?= esc($charge['date_charge'] ?? '') ?>">
                        </div>

                        <!-- Montant Net -->
                        <div class="form-group">
                            <label>Montant Net:</label>
                            <input type="number" step="0.001" name="montant_net" class="form-control"
                                   placeholder="0.000"
                                   value="<?= esc($charge['montant_net'] ?? '') ?>">
                        </div>

                    </div>

                    <!-- COLONNE DROITE -->
                    <div class="col-md-6">

                        <!-- Mode de paiement -->
                        <div class="form-group">
                            <label>Mode de paiement:</label>
                            <select name="mode_paiement" class="form-control">
                                <option value="">Choisir</option>
                                <option value="virement" <?= isset($charge) && $charge['mode_paiement'] == 'virement' ? 'selected' : '' ?>>Virement</option>
                                <option value="cash"     <?= isset($charge) && $charge['mode_paiement'] == 'cash'     ? 'selected' : '' ?>>Cash</option>
                                <option value="cheque"   <?= isset($charge) && $charge['mode_paiement'] == 'cheque'   ? 'selected' : '' ?>>Chèque</option>
                            </select>
                        </div>

                        <!-- Montant HTVA -->
                        <div class="form-group">
                            <label>Montant HTVA:</label>
                            <input type="number" step="0.001" name="montant_htva" id="montant_htva"
                                   class="form-control" placeholder="0.000"
                                   value="<?= esc($charge['montant_htva'] ?? '') ?>">
                        </div>

                        <!-- Montant TVA -->
                        <div class="form-group">
                            <label>Montant TVA:</label>
                            <input type="number" step="0.001" name="montant_tva" id="montant_tva"
                                   class="form-control" placeholder="0.000"
                                   value="<?= esc($charge['montant_tva'] ?? '') ?>">
                        </div>

                        <!-- Montant TTC (auto-calculé) -->
                        <div class="form-group">
                            <label>Montant TTC: <small class="text-muted">(HTVA + TVA)</small></label>
                            <input type="number" step="0.001" name="montant_ttc" id="montant_ttc"
                                   class="form-control" readonly
                                   style="background-color:#e9ecef; font-weight:bold;"
                                   value="<?= esc($charge['montant_ttc'] ?? '') ?>">
                        </div>

                        <!-- Remarque -->
                        <div class="form-group">
                            <label>Remarque:</label>
                            <textarea name="remarque" class="form-control" rows="3"
                                      placeholder="Remarques..."><?= esc($charge['remarque'] ?? '') ?></textarea>
                        </div>

                    </div>
                </div>

                <!-- BOUTON SUBMIT -->
                <div class="text-center m-t-30">
                    <button type="submit" class="btn btn-danger btn-lg px-5">
                        <i class="fa fa-save"></i>
                        <?= isset($charge) ? 'Modifier' : 'Ajouter' ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- SCRIPT CALCUL TTC = HTVA + TVA -->
<script>
    function calculerTTC() {
        var htva = parseFloat(document.getElementById("montant_htva").value) || 0;
        var tva  = parseFloat(document.getElementById("montant_tva").value)  || 0;
        document.getElementById("montant_ttc").value = (htva + tva).toFixed(3);
    }

    document.getElementById("montant_htva").addEventListener("input", calculerTTC);
    document.getElementById("montant_tva").addEventListener("input",  calculerTTC);

    window.addEventListener("load", calculerTTC);
</script>

<?= $this->endSection() ?>