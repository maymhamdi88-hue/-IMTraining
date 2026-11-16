<!--
================================================
VIEW: Formulaire Congé (conge_form.php)
================================================
Rôle: Formulaire pour ajouter ou modifier un congé
- Mode Ajout: $conge = null
- Mode Modification: $conge contient les données existantes
- Liste déroulante des employés
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
                <?= isset($conge) ? '✏️ Modifier un Congé' : '➕ Ajouter un Congé' ?>
            </h3>
            
            <!-- Bouton retour vers la liste -->
            <div class="text-right m-b-20">
                <a href="<?= site_url('Conge/conge_list') ?>" class="btn btn-secondary">
                    <i class="fa fa-arrow-left"></i> Retour à la liste
                </a>
            </div>

            <!-- Formulaire -->
            <!-- Action dynamique selon le mode -->
            <form method="post" 
                  action="<?= isset($conge) 
                      ? site_url('Conge/update/' . $conge['id_conge']) 
                      : site_url('Conge/ajouter') ?>">
                
                <!-- Token CSRF pour la sécurité -->
                <?= csrf_field() ?>

                <!-- ======================================== -->
                <!-- COLONNE GAUCHE -->
                <!-- ======================================== -->
                <div class="row">
                    <div class="col-md-6">
                        
                        <!-- Employé (obligatoire) -->
                        <div class="form-group">
                            <label class="control-label">Employé: <span class="text-danger">*</span></label>
                            <!-- Liste déroulante des employés -->
                            <!-- name="id_employe" : correspond à la clé étrangère -->
                            <select name="id_employe" class="form-control" required>
                                <option value="">Choisir un employé</option>
                                <!-- Boucle pour afficher tous les employés -->
                                <?php foreach ($employes as $e): ?>
                                    <!-- Pré-sélection de l'employé en mode modification -->
                                    <option value="<?= $e['id_employe'] ?>" 
                                        <?= (isset($conge) && $conge['id_employe'] == $e['id_employe']) ? 'selected' : '' ?>>
                                        <?= esc($e['nom'] . ' ' . $e['prenom']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Type de congé (obligatoire) -->
                        <div class="form-group">
                            <label class="control-label">Type de congé: <span class="text-danger">*</span></label>
                            <!-- Liste déroulante pour le type de congé -->
                            <select name="type_conge" class="form-control" required>
                                <option value="">Choisir</option>
                                <option value="annuel" 
                                    <?= (isset($conge) && $conge['type_conge'] == 'annuel') ? 'selected' : '' ?>>
                                    Annuel
                                </option>
                                <option value="maladie" 
                                    <?= (isset($conge) && $conge['type_conge'] == 'maladie') ? 'selected' : '' ?>>
                                    Maladie
                                </option>
                                <option value="sans_solde" 
                                    <?= (isset($conge) && $conge['type_conge'] == 'sans_solde') ? 'selected' : '' ?>>
                                    Sans solde
                                </option>
                            </select>
                        </div>

                        <!-- Date de début (obligatoire) -->
                        <div class="form-group">
                            <label class="control-label">Date de début: <span class="text-danger">*</span></label>
                            <input type="date" 
                                   name="date_debut" 
                                   class="form-control" 
                                   required 
                                   value="<?= $conge['date_debut'] ?? '' ?>">
                        </div>

                        <!-- Date de fin -->
                        <div class="form-group">
                            <label class="control-label">Date de fin:</label>
                            <input type="date" 
                                   name="date_fin" 
                                   class="form-control" 
                                   value="<?= $conge['date_fin'] ?? '' ?>">
                        </div>
                    </div>

                    <!-- ======================================== -->
                    <!-- COLONNE DROITE -->
                    <!-- ======================================== -->
                    <div class="col-md-6">

                        <!-- Nombre de jours (obligatoire) -->
                        <div class="form-group">
                            <label class="control-label">Nombre de jours: <span class="text-danger">*</span></label>
                            <!-- Type number pour saisir uniquement des nombres -->
                            <input type="number" 
                                   name="nombre_jours" 
                                   class="form-control" 
                                   required 
                                   min="1"
                                   placeholder="Ex: 5"
                                   value="<?= $conge['nombre_jours'] ?? '' ?>">
                        </div>

                        <!-- Statut (obligatoire) -->
                        <div class="form-group">
                            <label class="control-label">Statut: <span class="text-danger">*</span></label>
                            <!-- Liste déroulante pour le statut -->
                            <select name="statut" class="form-control" required>
                                <option value="">Choisir</option>
                                <option value="en_attente" 
                                    <?= (isset($conge) && $conge['statut'] == 'en_attente') ? 'selected' : '' ?>>
                                    En attente
                                </option>
                                <option value="accepte" 
                                    <?= (isset($conge) && $conge['statut'] == 'accepte') ? 'selected' : '' ?>>
                                    Accepté
                                </option>
                                <option value="refuse" 
                                    <?= (isset($conge) && $conge['statut'] == 'refuse') ? 'selected' : '' ?>>
                                    Refusé
                                </option>
                            </select>
                        </div>

                        <!-- Date de demande -->
                        <div class="form-group">
                            <label class="control-label">Date de demande:</label>
                            <input type="date" 
                                   name="date_demande" 
                                   class="form-control" 
                                   value="<?= $conge['date_demande'] ?? '' ?>">
                        </div>

                        <!-- Motif -->
                        <div class="form-group">
                            <label class="control-label">Motif:</label>
                            <!-- Champ textarea pour texte long -->
                            <textarea name="motif" 
                                      class="form-control" 
                                      rows="3"
                                      placeholder="Motif de la demande de congé..."><?= $conge['motif'] ?? '' ?></textarea>
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
                        <?= isset($conge) ? 'Modifier' : 'Ajouter' ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Fin de la section "content" -->
<?= $this->endSection() ?>