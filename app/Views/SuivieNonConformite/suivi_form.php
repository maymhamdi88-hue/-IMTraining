<!--
================================================
VIEW: Formulaire Suivi Non-Conformité (suivi_form.php)
================================================
Rôle: Formulaire pour ajouter ou modifier un suivi
- Mode Ajout: $suivi_edit = null
- Mode Modification: $suivi_edit contient les données
- 6 champs au total
================================================
-->

<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<!-- ======================================== -->
<!-- MESSAGES DE NOTIFICATION -->
<!-- ======================================== -->

<?php if(session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <p><strong>✅ Succès</strong></p>
        <hr>
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="close" data-dismiss="alert">
            <span>&times;</span>
        </button>
    </div>
<?php endif; ?>

<?php if(session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <p><strong>❌ Erreur</strong></p>
        <hr>
        <?= session()->getFlashdata('error') ?>
        <button type="button" class="close" data-dismiss="alert">
            <span>&times;</span>
        </button>
    </div>
<?php endif; ?>

<!-- ======================================== -->
<!-- FORMULAIRE -->
<!-- ======================================== -->

<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="white-box">
            <!-- Titre dynamique -->
            <h3 class="box-title m-b-30 text-center">
                <?= isset($suivi_edit) ? '✏️ Modifier Suivi Non-Conformité' : '➕ Ajouter Suivi Non-Conformité' ?>
            </h3>
            
            <!-- Bouton retour -->
            <div class="text-right m-b-20">
                <a href="<?= site_url('SuivieNonConformite/suivi_list') ?>" class="btn btn-secondary">
                    <i class="fa fa-arrow-left"></i> Retour à la liste
                </a>
            </div>

            <!-- Formulaire -->
            <!-- Action dynamique selon le mode -->
            <form method="post" 
                  action="<?= isset($suivi_edit) 
                      ? site_url('SuivieNonConformite/update_suivi/' . $suivi_edit['id_suivi']) 
                      : site_url('SuivieNonConformite/ajouter_suivi') ?>">
                
                <?= csrf_field() ?>

                <!-- ======================================== -->
                <!-- COLONNE GAUCHE -->
                <!-- ======================================== -->
                <div class="row">
                    <div class="col-md-6">
                        
                        <!-- Date constat (obligatoire) -->
                        <div class="form-group">
                            <label class="control-label">Date de constat: <span class="text-danger">*</span></label>
                            <input type="date" 
                                   name="date_constat" 
                                   class="form-control" 
                                   required
                                   value="<?= esc($suivi_edit['date_constat'] ?? '') ?>">
                        </div>

                        <!-- Désignation -->
                        <div class="form-group">
                            <label class="control-label">Désignation:</label>
                            <textarea name="designation" 
                                      class="form-control" 
                                      rows="4"
                                      placeholder="Description de la non-conformité"><?= esc($suivi_edit['designation'] ?? '') ?></textarea>
                        </div>

                        <!-- Correction immédiate -->
                        <div class="form-group">
                            <label class="control-label">Correction immédiate:</label>
                            <textarea name="correction_immediate" 
                                      class="form-control" 
                                      rows="4"
                                      placeholder="Action corrective immédiate prise"><?= esc($suivi_edit['correction_immediate'] ?? '') ?></textarea>
                        </div>
                    </div>

                    <!-- ======================================== -->
                    <!-- COLONNE DROITE -->
                    <!-- ======================================== -->
                    <div class="col-md-6">

                        <!-- Date réalisation -->
                        <div class="form-group">
                            <label class="control-label">Date de réalisation:</label>
                            <input type="date" 
                                   name="date_realisation" 
                                   class="form-control"
                                   value="<?= esc($suivi_edit['date_realisation'] ?? '') ?>">
                        </div>

                        <!-- Responsable (obligatoire) -->
                        <div class="form-group">
                            <label class="control-label">Responsable: <span class="text-danger">*</span></label>
                            <input type="text" 
                                   name="responsable" 
                                   class="form-control" 
                                   required
                                   placeholder="Nom du responsable"
                                   value="<?= esc($suivi_edit['responsable'] ?? '') ?>">
                        </div>

                        <!-- Causes probables -->
                        <div class="form-group">
                            <label class="control-label">Causes probables:</label>
                            <textarea name="causes_probables" 
                                      class="form-control" 
                                      rows="4"
                                      placeholder="Analyse des causes"><?= esc($suivi_edit['causes_probables'] ?? '') ?></textarea>
                        </div>
                    </div>
                </div>

                <!-- ======================================== -->
                <!-- BOUTON SUBMIT -->
                <!-- ======================================== -->
                <div class="text-center m-t-30">
                    <button type="submit" class="btn btn-danger btn-lg px-5">
                        <i class="fa fa-save"></i> 
                        <?= isset($suivi_edit) ? 'Modifier' : 'Ajouter' ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>