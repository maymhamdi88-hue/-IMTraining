<!--
================================================
VIEW: Formulaire Client Cabinet (cabinet_form.php)
================================================
Rôle: Formulaire pour ajouter ou modifier un client cabinet
- Mode Ajout: $client = null
- Mode Modification: $client contient les données existantes
- Validation des champs obligatoires
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

<!-- NOUVEAU : Affichage des erreurs de validation -->
<?php if(session()->getFlashdata('errors')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <p><strong>❌ Erreurs de validation</strong></p>
        <hr>
        <ul class="mb-0">
            <?php foreach(session()->getFlashdata('errors') as $field => $msg): ?>
                <li><?= esc($msg) ?></li>
            <?php endforeach; ?>
        </ul>
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
                <?= isset($client) ? '✏️ Modifier un Client Cabinet' : '➕ Ajouter un Client Cabinet' ?>
            </h3>
            
            <!-- Bouton retour vers la liste -->
            <div class="text-right m-b-20">
                <a href="<?= site_url('Cabinet/cabinet_list') ?>" class="btn btn-secondary">
                    <i class="fa fa-arrow-left"></i> Retour à la liste
                </a>
            </div>

            <!-- Formulaire -->
            <form method="post" 
                  action="<?= isset($client) 
                      ? site_url('Cabinet/update_cabinet/' . $client['id_client']) 
                      : site_url('Cabinet/ajouter_client_cabinet') ?>">
                
                <!-- Token CSRF pour la sécurité -->
                <?= csrf_field() ?>

                <!-- ======================================== -->
                <!-- COLONNE GAUCHE -->
                <!-- ======================================== -->
                <div class="row">
                    <div class="col-md-6">
                        
                        <!-- Nom de la société (obligatoire) -->
                        <div class="form-group">
                            <label class="control-label">Nom de la société: <span class="text-danger">*</span></label>
                            <input type="text" 
                                   name="nom_societe" 
                                   class="form-control" 
                                   required
                                   placeholder="Nom de la société"
                                   value="<?= old('nom_societe', $client['nom_societe'] ?? '') ?>">
                        </div>

                        <!-- Secteur -->
                        <div class="form-group">
                            <label class="control-label">Secteur:</label>
                            <input type="text" 
                                   name="secteur" 
                                   class="form-control"
                                   placeholder="Ex: Industrie, Services..."
                                   value="<?= old('secteur', $client['secteur'] ?? '') ?>">
                        </div>

                        <!-- Matricule fiscal (obligatoire) -->
                        <div class="form-group">
                            <label class="control-label">Matricule fiscal: <span class="text-danger">*</span></label>
                            <input type="text" 
                                   name="matricule_fiscal" 
                                   class="form-control" 
                                   required
                                   placeholder="Matricule fiscal unique"
                                   value="<?= old('matricule_fiscal', $client['matricule_fiscal'] ?? '') ?>">
                        </div>

                        <!-- Responsable (obligatoire) -->
                        <div class="form-group">
                            <label class="control-label">Responsable: <span class="text-danger">*</span></label>
                            <input type="text" 
                                   name="responsable" 
                                   class="form-control" 
                                   required
                                   placeholder="Nom du responsable"
                                   value="<?= old('responsable', $client['responsable'] ?? '') ?>">
                        </div>

                        <!-- Adresse (obligatoire) -->
                        <div class="form-group">
                            <label class="control-label">Adresse: <span class="text-danger">*</span></label>
                            <textarea name="adresse" 
                                      class="form-control" 
                                      required 
                                      rows="2"
                                      placeholder="Adresse complète"><?= old('adresse', $client['adresse'] ?? '') ?></textarea>
                        </div>

                        <!-- Téléphone -->
                        <div class="form-group">
                            <label class="control-label">Téléphone:</label>
                            <input type="text" 
                                   name="telephone" 
                                   class="form-control"
                                   placeholder="Ex: 71 123 456"
                                   value="<?= old('telephone', $client['telephone'] ?? '') ?>">
                        </div>

                        <!-- Activité -->
                        <div class="form-group">
                            <label class="control-label">Activité:</label>
                            <input type="text" 
                                   name="activite" 
                                   class="form-control"
                                   placeholder="Domaine d'activité"
                                   value="<?= old('activite', $client['activite'] ?? '') ?>">
                        </div>
                    </div>

                    <!-- ======================================== -->
                    <!-- COLONNE DROITE -->
                    <!-- ======================================== -->
                    <div class="col-md-6">

                        <!-- Fax -->
                        <div class="form-group">
                            <label class="control-label">Fax:</label>
                            <input type="text" 
                                   name="fax" 
                                   class="form-control"
                                   placeholder="Numéro fax"
                                   value="<?= old('fax', $client['fax'] ?? '') ?>">
                        </div>

                        <!-- Email Société (obligatoire) -->
                        <div class="form-group">
                            <label class="control-label">Email Société: <span class="text-danger">*</span></label>
                            <input type="email" 
                                   name="email" 
                                   class="form-control" 
                                   required
                                   placeholder="email@societe.com"
                                   value="<?= old('email', $client['email'] ?? '') ?>">
                        </div>

                        <!-- Site Web -->
                        <div class="form-group">
                            <label class="control-label">Site Web:</label>
                            <input type="text" 
                                   name="site_web" 
                                   class="form-control"
                                   placeholder="www.exemple.com"
                                   value="<?= old('site_web', $client['site_web'] ?? '') ?>">
                        </div>

                        <!-- Personne Contactée (obligatoire) -->
                        <div class="form-group">
                            <label class="control-label">Personne Contactée: <span class="text-danger">*</span></label>
                            <input type="text" 
                                   name="personne_contactee" 
                                   class="form-control" 
                                   required
                                   placeholder="Nom de la personne de contact"
                                   value="<?= old('personne_contactee', $client['personne_contactee'] ?? '') ?>">
                        </div>

                        <!-- Mobile -->
                        <div class="form-group">
                            <label class="control-label">Mobile:</label>
                            <input type="text" 
                                   name="mob_tel" 
                                   class="form-control"
                                   placeholder="Ex: 20 123 456"
                                   value="<?= old('mob_tel', $client['mob_tel'] ?? '') ?>">
                        </div>

                        <!-- Email Contact (obligatoire) -->
                        <div class="form-group">
                            <label class="control-label">Email Contact: <span class="text-danger">*</span></label>
                            <input type="email" 
                                   name="email_contact" 
                                   class="form-control" 
                                   required
                                   placeholder="contact@exemple.com"
                                   value="<?= old('email_contact', $client['email_contact'] ?? '') ?>">
                        </div>
                    </div>
                </div>

                <!-- ======================================== -->
                <!-- BOUTON SUBMIT -->
                <!-- ======================================== -->
                <div class="text-center m-t-30">
                    <button type="submit" class="btn btn-danger btn-lg px-5">
                        <i class="fa fa-save"></i> 
                        <?= isset($client) ? 'Modifier' : 'Ajouter' ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Fin de la section "content" -->
<?= $this->endSection() ?>