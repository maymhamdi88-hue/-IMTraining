<!--
================================================
VIEW: Formulaire Formateur (formateurs_form.php)
================================================
Rôle: Formulaire pour ajouter ou modifier un formateur
- Mode Ajout: $formateur_edit = null
- Mode Modification: $formateur_edit contient les données
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
                <?= isset($formateur_edit) ? '✏️ Modifier un Formateur' : '➕ Ajouter un Formateur' ?>
            </h3>
            
            <!-- Bouton retour -->
            <div class="text-right m-b-20">
                <a href="<?= site_url('Formateur/formateurs_list') ?>" class="btn btn-secondary">
                    <i class="fa fa-arrow-left"></i> Retour à la liste
                </a>
            </div>

            <!-- Formulaire -->
            <!-- Action dynamique selon le mode -->
            <form method="post" 
                  action="<?= isset($formateur_edit) 
                      ? site_url('Formateur/update/' . $formateur_edit['id_formateur']) 
                      : site_url('Formateur/ajouter') ?>">
                
                <?= csrf_field() ?>

                <!-- ======================================== -->
                <!-- COLONNE GAUCHE -->
                <!-- ======================================== -->
                <div class="row">
                    <div class="col-md-6">
                        
                        <!-- Nom et Prénom (obligatoire) -->
                        <div class="form-group">
                            <label class="control-label">Nom et prénom: <span class="text-danger">*</span></label>
                            <input type="text" 
                                   name="nom_prenom" 
                                   class="form-control" 
                                   required 
                                   placeholder="Nom complet du formateur"
                                   value="<?= esc($formateur_edit['nom_prenom'] ?? '') ?>">
                        </div>

                        <!-- Date de naissance -->
                        <div class="form-group">
                            <label class="control-label">Date de naissance:</label>
                            <input type="date" 
                                   name="date_naissance" 
                                   class="form-control"
                                   value="<?= esc($formateur_edit['date_naissance'] ?? '') ?>">
                        </div>

                        <!-- Adresse -->
                        <div class="form-group">
                            <label class="control-label">Adresse:</label>
                            <textarea name="adresse" 
                                      class="form-control" 
                                      rows="2"
                                      placeholder="Adresse complète"><?= esc($formateur_edit['adresse'] ?? '') ?></textarea>
                        </div>

                        <!-- Téléphone -->
                        <div class="form-group">
                            <label class="control-label">Téléphone:</label>
                            <input type="text" 
                                   name="telephone" 
                                   class="form-control"
                                   placeholder="Ex: 20 123 456"
                                   value="<?= esc($formateur_edit['telephone'] ?? '') ?>">
                        </div>

                        <!-- Email -->
                        <div class="form-group">
                            <label class="control-label">Email:</label>
                            <input type="email" 
                                   name="email" 
                                   class="form-control"
                                   placeholder="exemple@email.com"
                                   value="<?= esc($formateur_edit['email'] ?? '') ?>">
                        </div>

                        <!-- Diplôme -->
                        <div class="form-group">
                            <label class="control-label">Diplôme:</label>
                            <input type="text" 
                                   name="diplome" 
                                   class="form-control"
                                   placeholder="Ex: Master en Informatique"
                                   value="<?= esc($formateur_edit['diplome'] ?? '') ?>">
                        </div>

                        <!-- Domaine de compétence -->
                        <div class="form-group">
                            <label class="control-label">Domaine de compétence:</label>
                            <textarea name="domaine_competence" 
                                      class="form-control" 
                                      rows="3">
                                      <?= esc($formateur_edit['domaine_competence'] ?? '') ?></textarea>
                        </div>
                    </div>

                    <!-- ======================================== -->
                    <!-- COLONNE DROITE -->
                    <!-- ======================================== -->
                    <div class="col-md-6">

                        <!-- Type de formateur (obligatoire) -->
                        <div class="form-group">
                            <label class="control-label">Type de formateur: <span class="text-danger">*</span></label>
                            <select name="type_formateur" class="form-control" required>
                                <option value="">Sélectionner</option>
                                <option value="prive" 
                                    <?= (isset($formateur_edit) && $formateur_edit['type_formateur'] == 'prive') ? 'selected' : '' ?>>
                                    Privé
                                </option>
                                <option value="public" 
                                    <?= (isset($formateur_edit) && $formateur_edit['type_formateur'] == 'public') ? 'selected' : '' ?>>
                                    Public
                                </option>
                            </select>
                        </div>

                        <!-- Autorisation (obligatoire) -->
                        <div class="form-group">
                            <label class="control-label">Autorisation: <span class="text-danger">*</span></label>
                            <select name="autorisation" class="form-control" required>
                                <option value="">Sélectionner</option>
                                <option value="avec" 
                                    <?= (isset($formateur_edit) && $formateur_edit['autorisation'] == 'avec') ? 'selected' : '' ?>>
                                    Avec autorisation
                                </option>
                                <option value="sans" 
                                    <?= (isset($formateur_edit) && $formateur_edit['autorisation'] == 'sans') ? 'selected' : '' ?>>
                                    Sans autorisation
                                </option>
                            </select>
                        </div>

                        <!-- Type d'autorisation -->
                        <div class="form-group">
                            <label class="control-label">Type d'autorisation:</label>
                            <select name="type_autorisation" class="form-control">
                                <option value="">Sélectionner</option>
                                <option value="aucun" 
                                    <?= (isset($formateur_edit) && $formateur_edit['type_autorisation'] == 'aucun') ? 'selected' : '' ?>>
                                    Aucun
                                </option>
                                <option value="annuelle" 
                                    <?= (isset($formateur_edit) && $formateur_edit['type_autorisation'] == 'annuelle') ? 'selected' : '' ?>>
                                    Annuelle
                                </option>
                                <option value="par_theme" 
                                    <?= (isset($formateur_edit) && $formateur_edit['type_autorisation'] == 'par_theme') ? 'selected' : '' ?>>
                                    Par thème
                                </option>
                            </select>
                        </div>

                        <!-- Honoraire (obligatoire) -->
                        <div class="form-group">
                            <label class="control-label">Honoraire: <span class="text-danger">*</span></label>
                            <input type="number" 
                                   step="0.001" 
                                   name="honoraire" 
                                   class="form-control" 
                                   required
                                   placeholder="0.000"
                                   value="<?= esc($formateur_edit['honoraire'] ?? '') ?>">
                        </div>

                        <!-- RIB -->
                        <div class="form-group">
                            <label class="control-label">RIB:</label>
                            <input type="text" 
                                   name="rib" 
                                   class="form-control"
                                   placeholder="Numéro RIB"
                                   value="<?= esc($formateur_edit['rib'] ?? '') ?>">
                        </div>

                        <!-- Banque -->
                        <div class="form-group">
                            <label class="control-label">Banque:</label>
                            <input type="text" 
                                   name="banque" 
                                   class="form-control"
                                   placeholder="Nom de la banque"
                                   value="<?= esc($formateur_edit['banque'] ?? '') ?>">
                        </div>

                        <!-- Remarque -->
                        <div class="form-group">
                            <label class="control-label">Remarque:</label>
                            <textarea name="remarque" 
                                      class="form-control" 
                                      rows="3"
                                      placeholder="Informations supplémentaires"><?= esc($formateur_edit['remarque'] ?? '') ?></textarea>
                        </div>
                    </div>
                </div>

                <!-- ======================================== -->
                <!-- BOUTON SUBMIT -->
                <!-- ======================================== -->
                <div class="text-center m-t-30">
                    <button type="submit" class="btn btn-danger btn-lg px-5">
                        <i class="fa fa-save"></i> 
                        <?= isset($formateur_edit) ? 'Modifier' : 'Ajouter' ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>