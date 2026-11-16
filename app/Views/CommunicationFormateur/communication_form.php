<!--
================================================
VIEW: Formulaire Communication Formateur
================================================
Rôle: Formulaire pour ajouter ou modifier une communication
- Sélection formateur et responsable
- Moyen de communication et avis
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
                <?= isset($communication_edit) ? '✏️ Modifier une Communication' : '💬 Ajouter une Communication Formateur' ?>
            </h3>
            
            <!-- Bouton retour -->
            <div class="text-right m-b-20">
                <a href="<?= site_url('CommunicationFormateur/communication_list') ?>" class="btn btn-secondary">
                    <i class="fa fa-arrow-left"></i> Retour à la liste
                </a>
            </div>

            <!-- Formulaire -->
            <form method="post" 
                  action="<?= isset($communication_edit) 
                      ? site_url('CommunicationFormateur/update/' . $communication_edit['id_communication']) 
                      : site_url('CommunicationFormateur/ajouter') ?>">
                
                <?= csrf_field() ?>

                <!-- ======================================== -->
                <!-- COLONNE GAUCHE -->
                <!-- ======================================== -->
                <div class="row">
                    <div class="col-md-6">
                        
                        <!-- Sélection Formateur (obligatoire) -->
                        <div class="form-group">
                            <label class="control-label">Formateur: <span class="text-danger">*</span></label>
                            <select name="id_formateur" class="form-control" required>
                                <option value="">Choisir un formateur</option>
                                <?php foreach ($formateurs as $f): ?>
                                    <option value="<?= $f['id_formateur'] ?>"
                                        <?= (isset($communication_edit) && $communication_edit['id_formateur'] == $f['id_formateur']) ? 'selected' : '' ?>>
                                        <?= esc($f['nom_prenom']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Sélection Responsable (obligatoire) -->
                        <div class="form-group">
                            <label class="control-label">Responsable de communication: <span class="text-danger">*</span></label>
                            <select name="id_responsable" class="form-control" required>
                                <option value="">Choisir un responsable</option>
                                <?php foreach ($utilisateurs as $u): ?>
                                    <option value="<?= $u['id'] ?>"
                                        <?= (isset($communication_edit) && $communication_edit['id_responsable'] == $u['id']) ? 'selected' : '' ?>>
                                        <?= esc($u['nom_utilisateur']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Domaine / Objet -->
                        <div class="form-group">
                            <label class="control-label">Objet / Domaine:</label>
                            <input type="text" 
                                   name="domaine" 
                                   class="form-control"
                                   placeholder="Ex: Négociation contrat, Suivi formation..."
                                   value="<?= esc($communication_edit['domaine'] ?? '') ?>">
                        </div>

                        <!-- Date de communication (obligatoire) -->
                        <div class="form-group">
                            <label class="control-label">Date de communication: <span class="text-danger">*</span></label>
                            <input type="date" 
                                   name="date_communication" 
                                   class="form-control" 
                                   required
                                   value="<?= esc($communication_edit['date_communication'] ?? '') ?>">
                        </div>
                    </div>

                    <!-- ======================================== -->
                    <!-- COLONNE DROITE -->
                    <!-- ======================================== -->
                    <div class="col-md-6">

                        <!-- Moyen de communication (obligatoire) -->
                        <div class="form-group">
                            <label class="control-label">Moyen de communication: <span class="text-danger">*</span></label>
                            <select name="moyen_communication" class="form-control" required>
                                <option value="">Sélectionner</option>
                                <option value="appel" 
                                    <?= (isset($communication_edit) && $communication_edit['moyen_communication'] == 'appel') ? 'selected' : '' ?>>
                                    📞 Appel téléphonique
                                </option>
                                <option value="email" 
                                    <?= (isset($communication_edit) && $communication_edit['moyen_communication'] == 'email') ? 'selected' : '' ?>>
                                    📧 Email
                                </option>
                                <option value="reunion" 
                                    <?= (isset($communication_edit) && $communication_edit['moyen_communication'] == 'reunion') ? 'selected' : '' ?>>
                                    🤝 Réunion
                                </option>
                            </select>
                        </div>

                        <!-- Avis -->
                        <div class="form-group">
                            <label class="control-label">Avis:</label>
                            <select name="avis" class="form-control">
                                <option value="">Sélectionner</option>
                                <option value="positif" 
                                    <?= (isset($communication_edit) && $communication_edit['avis'] == 'positif') ? 'selected' : '' ?>>
                                    ✅ Positif
                                </option>
                                <option value="negatif" 
                                    <?= (isset($communication_edit) && $communication_edit['avis'] == 'negatif') ? 'selected' : '' ?>>
                                    ❌ Négatif
                                </option>
                                <option value="neutre" 
                                    <?= (isset($communication_edit) && $communication_edit['avis'] == 'neutre') ? 'selected' : '' ?>>
                                    ⚪ Neutre
                                </option>
                            </select>
                        </div>

                        <!-- Commentaire -->
                        <div class="form-group">
                            <label class="control-label">Commentaire / Détails:</label>
                            <textarea name="commentaire" 
                                      class="form-control" 
                                      rows="8"
                                      placeholder="Décrivez le contenu de la communication, les points importants abordés, les décisions prises..."><?= esc($communication_edit['commentaire'] ?? '') ?></textarea>
                        </div>
                    </div>
                </div>

                <!-- ======================================== -->
                <!-- BOUTON SUBMIT -->
                <!-- ======================================== -->
                <div class="text-center m-t-30">
                    <button type="submit" class="btn btn-danger btn-lg px-5">
                        <i class="fa fa-save"></i> 
                        <?= isset($communication_edit) ? 'Modifier' : 'Ajouter' ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>