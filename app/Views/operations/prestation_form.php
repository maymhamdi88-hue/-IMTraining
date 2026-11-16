<!--
================================================
VIEW: Formulaire Prestation (prestation_form.php)
================================================
Rôle: Formulaire pour ajouter ou modifier une prestation
- Mode Ajout: $activite = null
- Mode Modification: $activite contient les données existantes
- Formulaire adaptatif selon le mode
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
            <!-- Si $activite existe → Modification, sinon → Ajout -->
            <h3 class="box-title m-b-30 text-center">
                <?= isset($activite) ? '✏️ Modifier une Prestation' : '➕ Ajouter une Prestation' ?>
            </h3>
            
            <!-- Bouton retour vers la liste -->
            <div class="text-right m-b-20">
                <a href="<?= site_url('Operations/prestation_list') ?>" class="btn btn-secondary">
                    <i class="fa fa-arrow-left"></i> Retour à la liste
                </a>
            </div>

            <!-- Formulaire -->
            <!-- Action dynamique selon le mode -->
            <!-- Mode Ajout: envoie vers /Operations/ajouter -->
            <!-- Mode Modification: envoie vers /Operations/update/{id} -->
            <form method="post" 
                  action="<?= isset($activite) 
                      ? site_url('Operations/update/' . $activite['id_activite']) 
                      : site_url('Operations/ajouter') ?>">
                
                <!-- Token CSRF pour la sécurité -->
                <!-- Protège contre les attaques Cross-Site Request Forgery -->
                <?= csrf_field() ?>

                <!-- ======================================== -->
                <!-- COLONNE GAUCHE -->
                <!-- ======================================== -->
                <div class="row">
                    <div class="col-md-6">
                        
                        <!-- Type d'activité (obligatoire) -->
                        <div class="form-group">
                            <label class="control-label">Type d'activité: <span class="text-danger">*</span></label>
                            <select name="type_activite" class="form-control" required>
                                <option value="">Choisir</option>
                                <option value="tfp" 
                                    <?= (isset($activite) && $activite['type_activite'] == 'tfp') ? 'selected' : '' ?>>
                                    TFP
                                </option>
                                <option value="droit_de_tirage" 
                                    <?= (isset($activite) && $activite['type_activite'] == 'droit_de_tirage') ? 'selected' : '' ?>>
                                    Droit de tirage
                                </option>
                                <option value="contenu" 
                                    <?= (isset($activite) && $activite['type_activite'] == 'contenu') ? 'selected' : '' ?>>
                                    Contenu
                                </option>
                                <option value="audit" 
                                    <?= (isset($activite) &&$activite['type_activite'] == 'audit') ? 'selected' : '' ?>>
                                    Audit
                                </option>
                                <option value="consulting" 
                                    <?= (isset($activite) && $activite['type_activite'] == 'consulting') ? 'selected' : '' ?>>
                                    Consulting
                                </option>
                            </select>
                        </div>

                        <!--Réference -->
                        <div class="form-group">
                            <label class="control-label">Réference:</label>
                            <input type="text" 
                                   name="reference" 
                                   class="form-control"
                                   placeholder="Réference de la prestation"
                                   value="<?= $activite['reference'] ?? '' ?>">
                        </div>
                        <!-- Formateur (obligatoire) -->
                        <div class="form-group">
                            <label class="control-label">Formateur: <span class="text-danger">*</span></label>
                            <!-- Liste déroulante des formateurs -->
                            <select name="id_formateur" class="form-control" required>
                                <option value="">Choisir un formateur</option>
                                <!-- Boucle pour afficher tous les formateurs -->
                                <?php foreach ($formateurs as $f): ?>
                                    <!-- Pré-sélection du formateur en mode modification -->
                                    <option value="<?= $f['id_formateur'] ?>" 
                                        <?= (isset($activite) && $activite['id_formateur'] == $f['id_formateur']) ? 'selected' : '' ?>>
                                        <?= esc($f['nom_prenom']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <!-- Client (obligatoire) -->
                        <div class="form-group">
                            <label class="control-label">Client : <span class="text-danger">*</span></label>
                            <!-- Liste déroulante des Client  -->
                            <select name="id_client" class="form-control" required>
                                <option value="">Choisir un client</option>
                                <!-- Boucle pour afficher tous les Client -->
                                <?php foreach ($clients as $c): ?>
                                    <!-- Pré-sélection du formateur en mode modification -->
                                    <option value="<?= $c['id_client'] ?>" 
                                        <?= (isset($activite) && $activite['id_client'] == $c['id_client']) ? 'selected' : '' ?>>
                                        <?= esc($c['nom_societe']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Thème/Domaine (obligatoire) -->
                        <div class="form-group">
                            <label class="control-label">Thème: <span class="text-danger">*</span></label>
                            <input type="text" 
                                   name="theme_domaine" 
                                   class="form-control" 
                                   required
                                   placeholder="Thème ou domaine de la prestation"
                                   value="<?= $activite['theme_domaine'] ?? '' ?>">
                        </div>

                        <!-- Objectif -->
                        <div class="form-group">
                            <label class="control-label">Objectif:</label>
                            <!-- Champ textarea pour texte long -->
                            <textarea name="objectif" 
                                      class="form-control" 
                                      rows="3"
                                      placeholder="Objectifs de la prestation..."><?= $activite['objectif'] ?? '' ?></textarea>
                        </div>

                        

                        <!-- Statut -->
                        <div class="form-group">
                            <label class="control-label">Statut:</label>
                            <!-- Liste déroulante pour le statut -->
                            <select name="statut" class="form-control">
                                <option value="">Sélectionner un statut</option>
                                <option value="planifiee" <?= (isset($activite) && $activite['statut'] == 'planifiee') ? 'selected' : '' ?>>Planifié</option>
                                <option value="reporte" <?= (isset($activite) && $activite['statut'] == 'reporte') ? 'selected' : '' ?>>Reporté</option>
                                <option value="en_cours" <?= (isset($activite) && $activite['statut'] == 'en_cours') ? 'selected' : '' ?>>En cours</option>
                                <option value="terminee" <?= (isset($activite) && $activite['statut'] == 'terminee') ? 'selected' : '' ?>>Terminé</option>
                                <option value="annulee" <?= (isset($activite) && $activite['statut'] == 'annulee') ? 'selected' : '' ?>>Annulé</option>
                            </select>
                        </div>
                    </div>

                    <!-- ======================================== -->
                    <!-- COLONNE DROITE -->
                    <!-- ======================================== -->
                    <div class="col-md-6">
                        <!-- Date de début-->
                        <div class="form-group">
                            <label class="control-label">Date de début: </label>
                            <!-- Type date: affiche un sélecteur de date -->
                            <input type="date" 
                                   name="date_debut" 
                                   class="form-control" 
                                   
                                   value="<?= $activite['date_debut'] ?? '' ?>">
                        </div>

                        <!-- Date de fin -->
                        <div class="form-group">
                            <label class="control-label">Date de fin:</label>
                            <input type="date" 
                                   name="date_fin" 
                                   class="form-control" 
                                   value="<?= $activite['date_fin'] ?? '' ?>">
                        </div>

                        <!-- Date de prestation  -->
                        <div class="form-group">
                            <label class="control-label" required >Date prestation:</span></label>
                            <textarea  name="date_prestation" class="form-control" ><?= $activite['date_prestation'] ?? '' ?></textarea>
                        </div>

                        <!-- Lieu -->
                        <div class="form-group">
                            <label class="control-label">Lieu:</label>
                            <input type="text" 
                                   name="lieu" 
                                   class="form-control"
                                   placeholder="Lieu de la prestation"
                                   value="<?= $activite['lieu'] ?? '' ?>">
                        </div>

                        <!-- Nombre de participants -->
                        <div class="form-group">
                            <label class="control-label">Nombre de participants:</label>
                            <!-- Type number: accepte uniquement des nombres -->
                            <input type="number" 
                                   name="nombre_participants" 
                                   class="form-control"
                                   min="0"
                                   placeholder="0"
                                   value="<?= $activite['nombre_participants'] ?? '' ?>">
                        </div>


                        <!-- Remarque -->
                        <div class="form-group">
                            <label class="control-label">Remarque:</label>
                            <textarea name="remarque" 
                                      class="form-control" 
                                      rows="3"
                                      placeholder="Remarques supplémentaires..."><?= $activite['remarque'] ?? '' ?></textarea>
                        </div>
                    </div>
                </div>

                <!-- ======================================== -->
                <!-- BOUTON SUBMIT -->
                <!-- ======================================== -->
                <div class="text-center m-t-30">
                    <!-- Bouton Submit avec texte dynamique -->
                    <button type="submit" class="btn btn-danger btn-lg px-5">
                        <i class="fa fa-save"></i> 
                        <?= isset($activite) ? 'Modifier' : 'Ajouter' ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Fin de la section "content" -->
<?= $this->endSection() ?>