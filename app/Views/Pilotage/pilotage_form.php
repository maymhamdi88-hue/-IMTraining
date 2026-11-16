<!--
================================================
VIEW: Formulaire Pilotage (pilotage_form.php)
================================================
✅ CORRIGÉ: Ajout du champ resultat_annee_n1
================================================
-->

<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<!-- MESSAGES -->
<?php if(session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <p><strong>✅ Succès</strong></p><hr>
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
    </div>
<?php endif; ?>

<?php if(session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <p><strong>❌ Erreur</strong></p><hr>
        <?= session()->getFlashdata('error') ?>
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
    </div>
<?php endif; ?>

<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="white-box">
            <h3 class="box-title m-b-30 text-center">
                <?= isset($pilotage_edit) ? '✏️ Modifier Objectif & Résultat' : '➕ Ajouter Objectif & Résultat' ?>
            </h3>
            
            <div class="text-right m-b-20">
                <a href="<?= site_url('Pilotage/pilotage_list') ?>" class="btn btn-secondary">
                    <i class="fa fa-arrow-left"></i> Retour à la liste
                </a>
            </div>

            <form method="post" 
                  action="<?= isset($pilotage_edit) 
                      ? site_url('Pilotage/update_pilotage/' . $pilotage_edit['id_resultat']) 
                      : site_url('Pilotage/ajouter_pilotage') ?>">
                
                <?= csrf_field() ?>

                <div class="row">
                    <!-- COLONNE GAUCHE -->
                    <div class="col-md-6">
                        
                        <!-- Année -->
                        <div class="form-group">
                            <label class="control-label">Année: <span class="text-danger">*</span></label>
                            <input type="number" 
                                   name="annee" 
                                   class="form-control" 
                                   required 
                                   placeholder="Ex: 2025"
                                   min="2000"
                                   max="2100"
                                   value="<?= esc($pilotage_edit['annee'] ?? '') ?>">
                        </div>

                        <!-- Processus -->
                        <div class="form-group">
                            <label class="control-label">Processus: <span class="text-danger">*</span></label>
                            <input type="text" 
                                   name="processus" 
                                   class="form-control" 
                                   required
                                   placeholder="Ex: Processus de Formation"
                                   value="<?= esc($pilotage_edit['processus'] ?? '') ?>">
                        </div>

                        <!-- Objectif -->
                        <div class="form-group">
                            <label class="control-label">Objectif: <span class="text-danger">*</span></label>
                            <textarea name="objectif" 
                                      class="form-control" 
                                      rows="3"
                                      required
                                      placeholder="Décrire l'objectif"><?= esc($pilotage_edit['objectif'] ?? '') ?></textarea>
                        </div>

                        <!-- Indicateur -->
                        <div class="form-group">
                            <label class="control-label">Indicateur: <span class="text-danger">*</span></label>
                            <textarea name="indicateur" 
                                      class="form-control" 
                                      rows="3"
                                      required
                                      placeholder="Décrire l'indicateur"><?= esc($pilotage_edit['indicateur'] ?? '') ?></textarea>
                        </div>

                        <!-- Mode de calcul -->
                        <div class="form-group">
                            <label class="control-label">Mode de calcul:</label>
                            <textarea name="mode_calcul" 
                                      class="form-control" 
                                      rows="3"
                                      placeholder="Ex: (Nombre X / Total Y) × 100"><?= esc($pilotage_edit['mode_calcul'] ?? '') ?></textarea>
                        </div>

                        <!-- Résultat -->
                        <div class="form-group">
                            <label class="control-label">Résultat:</label>
                            <textarea name="resultat" 
                                      class="form-control" 
                                      rows="3"
                                      placeholder="Décrire le résultat obtenu"><?= esc($pilotage_edit['resultat'] ?? '') ?></textarea>
                        </div>
                    </div>

                    <!-- COLONNE DROITE -->
                    <div class="col-md-6">

                        <!-- Fréquence de suivi -->
                        <div class="form-group">
                            <label class="control-label">Fréquence de suivi: <span class="text-danger">*</span></label>
                            <select name="frequence_suivi" class="form-control" required>
                                <option value="">Sélectionner</option>
                                <option value="Mensuelle" 
                                    <?= (isset($pilotage_edit) && $pilotage_edit['frequence_suivi'] == 'Mensuelle') ? 'selected' : '' ?>>
                                    Mensuelle
                                </option>
                                <option value="Trimestrielle" 
                                    <?= (isset($pilotage_edit) && $pilotage_edit['frequence_suivi'] == 'Trimestrielle') ? 'selected' : '' ?>>
                                    Trimestrielle
                                </option>
                                <option value="Semestrielle" 
                                    <?= (isset($pilotage_edit) && $pilotage_edit['frequence_suivi'] == 'Semestrielle') ? 'selected' : '' ?>>
                                    Semestrielle
                                </option>
                                <option value="Annuelle" 
                                    <?= (isset($pilotage_edit) && $pilotage_edit['frequence_suivi'] == 'Annuelle') ? 'selected' : '' ?>>
                                    Annuelle
                                </option>
                            </select>
                        </div>

                        <!-- Cible année N -->
                        <div class="form-group">
                            <label class="control-label">Cible année N:</label>
                            <input type="number" 
                                   step="0.01" 
                                   name="cible_annee_n" 
                                   class="form-control"
                                   placeholder="Ex: 85.50"
                                   value="<?= esc($pilotage_edit['cible_annee_n'] ?? '') ?>">
                        </div>

                        <!-- Résultat année N -->
                        <div class="form-group">
                            <label class="control-label">Résultat année N:</label>
                            <input type="number" 
                                   step="0.01" 
                                   name="resultat_annee_n" 
                                   class="form-control"
                                   placeholder="Ex: 82.75"
                                   value="<?= esc($pilotage_edit['resultat_annee_n'] ?? '') ?>">
                        </div>

                        <!-- Cible année N+1 -->
                        <div class="form-group">
                            <label class="control-label">Cible année N+1:</label>
                            <input type="number" 
                                   step="0.01" 
                                   name="cible_annee_n1" 
                                   class="form-control"
                                   placeholder="Ex: 90.00"
                                   value="<?= esc($pilotage_edit['cible_annee_n1'] ?? '') ?>">
                        </div>

                        <!-- ✅ Résultat année N+1 (AJOUTÉ) -->
                        <div class="form-group">
                            <label class="control-label">Résultat année N+1:</label>
                            <input type="number" 
                                   step="0.01" 
                                   name="resultat_annee_n1" 
                                   class="form-control"
                                   placeholder="Ex: 88.25"
                                   value="<?= esc($pilotage_edit['resultat_annee_n1'] ?? '') ?>">
                        </div>

                        <!-- Visa direction -->
                        <div class="form-group">
                            <label class="control-label">
                                <input type="checkbox" 
                                       name="visa_direction" 
                                       value="1"
                                       <?= (isset($pilotage_edit) && $pilotage_edit['visa_direction']) ? 'checked' : '' ?>>
                                Visa direction
                            </label>
                        </div>

                        <!-- Remarque -->
                        <div class="form-group">
                            <label class="control-label">Remarque:</label>
                            <textarea name="remarque" 
                                      class="form-control" 
                                      rows="4"
                                      placeholder="Observations ou commentaires"><?= esc($pilotage_edit['remarque'] ?? '') ?></textarea>
                        </div>
                    </div>
                </div>

                <!-- BOUTON SUBMIT -->
                <div class="text-center m-t-30">
                    <button type="submit" class="btn btn-danger btn-lg px-5">
                        <i class="fa fa-save"></i> 
                        <?= isset($pilotage_edit) ? 'Modifier' : 'Ajouter' ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>