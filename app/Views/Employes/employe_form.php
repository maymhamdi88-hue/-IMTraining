<!--
================================================
VIEW: Formulaire Employé (employe_form.php)
================================================
Rôle: Formulaire pour ajouter ou modifier un employé
- Mode Ajout: $employe = null
- Mode Modification: $employe contient les données existantes
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
            <!-- Si $employe existe → Modification, sinon → Ajout -->
            <h3 class="box-title m-b-30 text-center">
                <?= isset($employe) ? '✏️ Modifier un Employé' : '➕ Ajouter un Employé' ?>
            </h3>
            
            <!-- Bouton retour vers la liste -->
            <div class="text-right m-b-20">
                <a href="<?= site_url('Employes') ?>" class="btn btn-secondary">
                    <i class="fa fa-arrow-left"></i> Retour à la liste
                </a>
            </div>

            <!-- Formulaire -->
            <!-- Action dynamique selon le mode -->
            <!-- Mode Ajout: envoie vers /Employes/ajouter_employe -->
            <!-- Mode Modification: envoie vers /Employes/update/{id} -->
            <form method="post" 
                  action="<?= isset($employe) 
                      ? site_url('Employes/update/' . $employe['id_employe']) 
                      : site_url('Employes/ajouter_employe') ?>">
                
                <!-- Token CSRF pour la sécurité -->
                <!-- Protège contre les attaques Cross-Site Request Forgery -->
                <?= csrf_field() ?>

                <!-- ======================================== -->
                <!-- COLONNE GAUCHE -->
                <!-- ======================================== -->
                <div class="row">
                    <div class="col-md-6">
                        
                        <!-- Nom (obligatoire) -->
                        <div class="form-group">
                            <label class="control-label">Nom: <span class="text-danger">*</span></label>
                            <!-- value: pré-remplit le champ en mode modification -->
                            <!-- ?? '' : si la variable n'existe pas, valeur vide -->
                            <input type="text" 
                                   name="nom" 
                                   class="form-control" 
                                   required 
                                   placeholder="Nom de l'employé"
                                   value="<?= esc($employe['nom'] ?? '') ?>">
                        </div>

                        <!-- Prénom (obligatoire) -->
                        <div class="form-group">
                            <label class="control-label">Prénom: <span class="text-danger">*</span></label>
                            <input type="text" 
                                   name="prenom" 
                                   class="form-control" 
                                   required
                                   placeholder="Prénom de l'employé"
                                   value="<?= esc($employe['prenom'] ?? '') ?>">
                        </div>

                        <!-- Poste -->
                        <div class="form-group">
                            <label class="control-label">Poste:</label>
                            <input type="text" 
                                   name="poste" 
                                   class="form-control"
                                   placeholder="Ex: Développeur, Comptable..."
                                   value="<?= esc($employe['poste'] ?? '') ?>">
                        </div>

                        <!-- Date d'embauche (obligatoire) -->
                        <div class="form-group">
                            <label class="control-label">Date d'embauche: <span class="text-danger">*</span></label>
                            <!-- Type date: affiche un sélecteur de date -->
                            <input type="date" 
                                   name="date_embauche" 
                                   class="form-control" 
                                   required 
                                   value="<?= esc($employe['date_embauche'] ?? '') ?>">
                        </div>

                        <!-- Type de contrat -->
                        <div class="form-group">
                            <label class="control-label">Type de contrat:</label>
                            <!-- Liste déroulante pour le type de contrat -->
                            <select name="type_contrat" class="form-control">
                                <option value="">Sélectionner</option>
                                <?php foreach (['cdi', 'cdd', 'freelance'] as $t): ?>
                                    <!-- Pré-sélection du type en mode modification -->
                                    <option value="<?= $t ?>" 
                                        <?= (isset($employe) && $employe['type_contrat'] == $t) ? 'selected' : '' ?>>
                                        <?= strtoupper($t) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <!-- ======================================== -->
                    <!-- COLONNE DROITE -->
                    <!-- ======================================== -->
                    <div class="col-md-6">

                        <!-- Salaire de base (obligatoire) -->
                        <div class="form-group">
                            <label class="control-label">Salaire de base: <span class="text-danger">*</span></label>
                            <!-- Type number avec step="0.001" pour 3 décimales -->
                            <input type="number" 
                                   step="0.001" 
                                   name="salaire_base" 
                                   class="form-control" 
                                   required
                                   placeholder="0.000"
                                   value="<?= esc($employe['salaire_base'] ?? '') ?>">
                        </div>

                        <!-- Email -->
                        <div class="form-group">
                            <label class="control-label">Email:</label>
                            <!-- Type email: validation automatique du format email -->
                            <input type="email" 
                                   name="email" 
                                   class="form-control"
                                   placeholder="exemple@email.com"
                                   value="<?= esc($employe['email'] ?? '') ?>">
                        </div>

                        <!-- Téléphone -->
                        <div class="form-group">
                            <label class="control-label">Téléphone:</label>
                            <input type="text" 
                                   name="telephone" 
                                   class="form-control"
                                   placeholder="Ex: 20 123 456"
                                   value="<?= esc($employe['telephone'] ?? '') ?>">
                        </div>

                        <!-- Statut -->
                        <div class="form-group">
                            <label class="control-label">Statut:</label>
                            <!-- Liste déroulante pour le statut -->
                            <select name="statut" class="form-control">
                                <?php foreach (['actif', 'suspendu'] as $s): ?>
                                    <!-- Pré-sélection du statut en mode modification -->
                                    <option value="<?= $s ?>" 
                                        <?= (isset($employe) && $employe['statut'] == $s) ? 'selected' : '' ?>>
                                        <?= ucfirst($s) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
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
                        <?= isset($employe) ? 'Modifier' : 'Ajouter' ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Fin de la section "content" -->
<?= $this->endSection() ?>