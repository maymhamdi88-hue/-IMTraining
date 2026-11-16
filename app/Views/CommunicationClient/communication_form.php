<!--
================================================
VIEW: Formulaire Communication (communication_form.php)
================================================
Rôle: Formulaire COMPLET pour communication
- Tous les champs: Client, Responsable, Objet, Moyen, Avis, Commentaire, Date
================================================
-->

<!-- Étend le layout principal "admin" -->
<?= $this->extend('layouts/admin') ?>

<!-- Début de la section "content" -->
<?= $this->section('content') ?>

<!-- ======================================== -->
<!-- MESSAGES DE NOTIFICATION -->
<!-- ======================================== -->

<!-- Message de succès -->
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

<!-- Message d'erreur -->
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
            <!-- Titre dynamique selon le mode -->
            <h3 class="box-title m-b-30 text-center">
                <?= isset($communication) ? '✏️ Modifier une Communication' : '➕ Ajouter une Communication' ?>
            </h3>
            
            <!-- Bouton retour vers la liste -->
            <div class="text-right m-b-20">
                <a href="<?= site_url('CommunicationClient/communication_list') ?>" class="btn btn-secondary">
                    <i class="fa fa-arrow-left"></i> Retour à la liste
                </a>
            </div>

            <!-- Formulaire -->
            <form method="post" 
                  action="<?= isset($communication) 
                      ? site_url('CommunicationClient/update_communication/' . $communication['id_communication_client']) 
                      : site_url('CommunicationClient/ajouter_communication') ?>">
                
                <!-- Token CSRF pour la sécurité -->
                <?= csrf_field() ?>

                <!-- ======================================== -->
                <!-- COLONNE GAUCHE -->
                <!-- ======================================== -->
                <div class="row">
                    <div class="col-md-6">
                        
                        <!-- Client (obligatoire) -->
                        <div class="form-group">
                            <label class="control-label">Client: <span class="text-danger">*</span></label>
                            <!-- Liste déroulante des clients -->
                            <select name="id_client" class="form-control" required>
                                <option value="">Choisir un client</option>
                                <?php foreach ($clients as $cl): ?>
                                    <option value="<?= $cl['id_client'] ?>" 
                                        <?= (isset($communication) && $communication['id_client'] == $cl['id_client']) ? 'selected' : '' ?>>
                                        <?= esc($cl['nom_societe']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Responsable de communication (obligatoire) -->
                        <div class="form-group">
                            <label class="control-label">Responsable de communication: <span class="text-danger">*</span></label>
                            <!-- Liste déroulante des utilisateurs -->
                            <select name="id_responsable" class="form-control" required>
                                <option value="">Choisir un responsable</option>
                                <?php foreach ($utilisateurs as $u): ?>
                                    <option value="<?= $u['id'] ?>" 
                                        <?= (isset($communication) && $communication['id_responsable'] == $u['id']) ? 'selected' : '' ?>>
                                        <?= esc($u['nom_utilisateur']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Objet/Domaine -->
                        <div class="form-group">
                            <label class="control-label">Objet:</label>
                            <input type="text" 
                                   name="domaine" 
                                   class="form-control"
                                   placeholder="Objet de la communication"
                                   value="<?= $communication['domaine'] ?? '' ?>">
                        </div>

                        <!-- Date de communication (obligatoire) -->
                        <div class="form-group">
                            <label class="control-label">Date de communication: <span class="text-danger">*</span></label>
                            <input type="date" 
                                   name="date_communication" 
                                   class="form-control" 
                                   required 
                                   value="<?= $communication['date_communication'] ?? '' ?>">
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
                                    <?= (isset($communication) && $communication['moyen_communication'] == 'appel') ? 'selected' : '' ?>>
                                    Appel
                                </option>
                                <option value="email" 
                                    <?= (isset($communication) && $communication['moyen_communication'] == 'email') ? 'selected' : '' ?>>
                                    Email
                                </option>
                                <option value="reunion" 
                                    <?= (isset($communication) && $communication['moyen_communication'] == 'reunion') ? 'selected' : '' ?>>
                                    Réunion
                                </option>
                            </select>
                        </div>

                        <!-- Avis -->
                        <div class="form-group">
                            <label class="control-label">Avis:</label>
                            <select name="avis" class="form-control">
                                <option value="">Sélectionner</option>
                                <option value="positif" 
                                    <?= (isset($communication) && $communication['avis'] == 'positif') ? 'selected' : '' ?>>
                                    Positif
                                </option>
                                <option value="negatif" 
                                    <?= (isset($communication) && $communication['avis'] == 'negatif') ? 'selected' : '' ?>>
                                    Négatif
                                </option>
                                <option value="neutre" 
                                    <?= (isset($communication) && $communication['avis'] == 'neutre') ? 'selected' : '' ?>>
                                    Neutre
                                </option>
                            </select>
                        </div>

                        <!-- Commentaire -->
                        <div class="form-group">
                            <label class="control-label">Commentaire:</label>
                            <textarea name="commentaire" 
                                      class="form-control" 
                                      rows="6"
                                      placeholder="Détails de la communication..."><?= $communication['commentaire'] ?? '' ?></textarea>
                        </div>
                    </div>
                </div>

                <!-- ======================================== -->
                <!-- BOUTON SUBMIT -->
                <!-- ======================================== -->
                <div class="text-center m-t-30">
                    <button type="submit" class="btn btn-danger btn-lg px-5">
                        <i class="fa fa-save"></i> 
                        <?= isset($communication) ? 'Modifier' : 'Ajouter' ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Fin de la section "content" -->
<?= $this->endSection() ?>