<!--
================================================
VIEW: Formulaire Actions Correctives (actions_form.php)
================================================
Rôle: Formulaire pour ajouter ou modifier une action corrective
- Mode Ajout: $action_edit = null
- Mode Modification: $action_edit contient les données
- 8 champs au total + relation avec Suivi
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
                <?= isset($action_edit) ? '✏️ Modifier Action Corrective' : '➕ Ajouter Action Corrective' ?>
            </h3>
            
            <!-- Bouton retour -->
            <div class="text-right m-b-20">
                <a href="<?= site_url('ActionsCorrectivess/actions_list') ?>" class="btn btn-secondary">
                    <i class="fa fa-arrow-left"></i> Retour à la liste
                </a>
            </div>

            <!-- Formulaire -->
            <!-- Action dynamique selon le mode -->
            <form method="post" 
                  action="<?= isset($action_edit) 
                      ? site_url('ActionsCorrectivess/update_action/' . $action_edit['id_action']) 
                      : site_url('ActionsCorrectivess/ajouter_action') ?>">
                
                <?= csrf_field() ?>

                <!-- ======================================== -->
                <!-- COLONNE GAUCHE -->
                <!-- ======================================== -->
                <div class="row">
                    <div class="col-md-6">
                        
                        <!-- Causes (relation avec Suivi) - obligatoire -->
                        <div class="form-group">
                            <label class="control-label">Causes (Suivi Non-Conformité): <span class="text-danger">*</span></label>
                            <select name="id_suivi" class="form-control" required>
                                <option value="">Choisir un suivi</option>
                                <?php foreach ($suivis as $s): ?>
                                    <option value="<?= $s['id_suivi'] ?>"
                                        <?= (isset($action_edit) && $action_edit['id_suivi'] == $s['id_suivi']) ? 'selected' : '' ?>>
                                        <?= esc($s['causes_probables']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Action corrective (obligatoire) -->
                        <div class="form-group">
                            <label class="control-label">Action corrective: <span class="text-danger">*</span></label>
                            <textarea name="action_corrective" 
                                      class="form-control" 
                                      required 
                                      rows="4"
                                      placeholder="Décrire l'action corrective à mettre en place"><?= esc($action_edit['action_corrective'] ?? '') ?></textarea>
                        </div>

                        <!-- Responsable action (obligatoire) -->
                        <div class="form-group">
                            <label class="control-label">Responsable action: <span class="text-danger">*</span></label>
                            <input type="text" 
                                   name="responsable_action" 
                                   class="form-control" 
                                   required
                                   placeholder="Nom du responsable"
                                   value="<?= esc($action_edit['responsable_action'] ?? '') ?>">
                        </div>

                        <!-- Date prévue (obligatoire) -->
                        <div class="form-group">
                            <label class="control-label">Date prévue: <span class="text-danger">*</span></label>
                            <input type="date" 
                                   name="date_prevue" 
                                   class="form-control" 
                                   required
                                   value="<?= esc($action_edit['date_prevue'] ?? '') ?>">
                        </div>
                    </div>

                    <!-- ======================================== -->
                    <!-- COLONNE DROITE -->
                    <!-- ======================================== -->
                    <div class="col-md-6">

                        <!-- Date réalisation -->
                        <div class="form-group">
                            <label class="control-label">Date réalisation:</label>
                            <input type="date" 
                                   name="date_realisation" 
                                   class="form-control"
                                   value="<?= esc($action_edit['date_realisation'] ?? '') ?>">
                        </div>

                        <!-- Date vérification -->
                        <div class="form-group">
                            <label class="control-label">Date vérification:</label>
                            <input type="date" 
                                   name="date_verification" 
                                   class="form-control"
                                   value="<?= esc($action_edit['date_verification'] ?? '') ?>">
                        </div>

                        <!-- Décision -->
                        <div class="form-group">
                            <label class="control-label">Décision:</label>
                            <select name="decision" class="form-control">
                                <option value="">Choisir</option>
                                <option value="non_cloture" 
                                    <?= (isset($action_edit) && $action_edit['decision'] == 'non_cloture') ? 'selected' : '' ?>>
                                    Non clôturé
                                </option>
                                <option value="cloture" 
                                    <?= (isset($action_edit) && $action_edit['decision'] == 'cloture') ? 'selected' : '' ?>>
                                    Clôturé
                                </option>
                            </select>
                        </div>

                        <!-- Responsable vérification -->
                        <div class="form-group">
                            <label class="control-label">Responsable vérification:</label>
                            <input type="text" 
                                   name="responsable_verification" 
                                   class="form-control"
                                   placeholder="Nom du responsable de vérification"
                                   value="<?= esc($action_edit['responsable_verification'] ?? '') ?>">
                        </div>
                    </div>
                </div>

                <!-- ======================================== -->
                <!-- BOUTON SUBMIT -->
                <!-- ======================================== -->
                <div class="text-center m-t-30">
                    <button type="submit" class="btn btn-danger btn-lg px-5">
                        <i class="fa fa-save"></i> 
                        <?= isset($action_edit) ? 'Modifier' : 'Ajouter' ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>