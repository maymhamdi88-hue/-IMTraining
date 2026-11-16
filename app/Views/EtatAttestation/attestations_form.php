<!--
================================================
VIEW: Formulaire Attestations (attestations_form.php)
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
                <?= isset($attestation) ? '✏️ Modifier une Attestation' : '➕ Ajouter une Attestation' ?>
            </h3>
            
            <div class="text-right m-b-20">
                <a href="<?= site_url('EtatAttestation/attestations_list') ?>" class="btn btn-secondary">
                    <i class="fa fa-arrow-left"></i> Retour à la liste
                </a>
            </div>

            <form method="post" 
                  action="<?= isset($attestation) 
                      ? site_url('EtatAttestation/attestations_update/' . $attestation['id_attestation']) 
                      : site_url('EtatAttestation/attestations_store') ?>">
                
                <?= csrf_field() ?>

                <div class="row">
                    <!-- COLONNE GAUCHE -->
                    <div class="col-md-6">
                        
                        <!-- Client -->
                        <div class="form-group">
                            <label>Client: <span class="text-danger">*</span></label>
                            <select name="id_client" class="form-control" required>
                                <option value="">Choisir</option>
                                <?php foreach ($clients as $c): ?>
                                    <option value="<?= $c['id_client'] ?>"
                                        <?= isset($attestation) && $attestation['id_client']==$c['id_client'] ? 'selected' : '' ?>>
                                        <?= esc($c['nom_societe']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Mode -->
                        <div class="form-group">
                            <label>Mode:</label>
                            <input type="text" name="mode" class="form-control" 
                                   placeholder="Ex: Présentiel, Distanciel..."
                                   value="<?= $attestation['mode'] ?? '' ?>">
                        </div>

                        <!-- Numéro d'action -->
                        <div class="form-group">
                            <label>Numéro d'action:</label>
                            <input type="text" name="num_action" class="form-control" 
                                   placeholder="Ex: ACT-2024-001"
                                   value="<?= $attestation['num_action'] ?? '' ?>">
                        </div>

                        <!-- Thème -->
                        <div class="form-group">
                            <label>Thème:</label>
                            <input type="text" name="theme" class="form-control" 
                                   placeholder="Thème de la formation"
                                   value="<?= $attestation['theme'] ?? '' ?>">
                        </div>
                    </div>

                    <!-- COLONNE DROITE -->
                    <div class="col-md-6">
                        
                        <!-- Date préparation -->
                        <div class="form-group">
                            <label>Date préparation:</label>
                            <input type="date" name="date_preparation" class="form-control" 
                                   value="<?= $attestation['date_preparation'] ?? '' ?>">
                        </div>

                        <!-- Date tirage -->
                        <div class="form-group">
                            <label>Date tirage:</label>
                            <input type="date" name="date_tirage" class="form-control" 
                                   value="<?= $attestation['date_tirage'] ?? '' ?>">
                        </div>

                        <!-- Date remise -->
                        <div class="form-group">
                            <label>Date remise:</label>
                            <input type="date" name="date_remise" class="form-control" 
                                   value="<?= $attestation['date_remise'] ?? '' ?>">
                        </div>
                    </div>
                </div>

                <!-- BOUTON SUBMIT -->
                <div class="text-center m-t-30">
                    <button type="submit" class="btn btn-danger btn-lg px-5">
                        <i class="fa fa-save"></i> 
                        <?= isset($attestation) ? 'Modifier' : 'Ajouter' ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>