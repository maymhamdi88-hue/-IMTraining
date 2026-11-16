<!--
================================================
VIEW: Liste des Employés (employe_list.php)
================================================
Rôle: Afficher le tableau des employés avec actions
- Bouton Ajouter → redirige vers formulaire
- Bouton Modifier → redirige vers formulaire pré-rempli
- Bouton Supprimer → supprime l'employé
- Bouton Export PDF → génère PDF de tous les employés
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
        <p><strong>✅ Mise à jour</strong></p>
        <hr>
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>

<!-- Message d'erreur -->
<?php if(session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <p><strong>❌ Erreur</strong></p>
        <hr>
        <?= session()->getFlashdata('error') ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>

<!-- ======================================== -->
<!-- EN-TÊTE DE LA PAGE -->
<!-- ======================================== -->

<div class="row">
    <div class="col-md-12">
        <div class="white-box">
            <!-- Titre de la page -->
            <h3 class="box-title">👥 Liste des Employés</h3>
            
            <!-- Barre d'actions -->
            <div class="text-right m-b-20">
                <!-- Bouton Ajouter → redirige vers le formulaire d'ajout -->
                <a href="<?= site_url('Employes/ajouter_form') ?>" class="btn btn-success">
                    <i class="fa fa-plus"></i> Ajouter un Employé
                </a>
                
                <!-- Bouton Export PDF → génère le PDF de tous les employés -->
                <a href="<?= site_url('Employes/export_employes_pdf') ?>" class="btn btn-danger" target="_blank">
                    <i class="fa fa-file-pdf-o"></i> Exporter en PDF
                </a>
            </div>

            <!-- ======================================== -->
            <!-- TABLEAU DES EMPLOYÉS -->
            <!-- ======================================== -->
            
            <!-- Tableau Bootstrap avec bordures et lignes alternées -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <!-- En-tête du tableau (noms des colonnes) -->
                    <thead style="background-color:#e3f2fd; color:#000;">
                        <tr>
                            <th>#</th>                    <!-- Numéro de ligne -->
                            <th>Nom</th>                  <!-- Nom de l'employé -->
                            <th>Prénom</th>               <!-- Prénom -->
                            <th>Poste</th>                <!-- Poste occupé -->
                            <th>Date embauche</th>        <!-- Date d'embauche -->
                            <th>Type contrat</th>         <!-- Type de contrat -->
                            <th>Salaire base</th>         <!-- Salaire de base -->
                            <th>Email</th>                <!-- Email -->
                            <th>Téléphone</th>            <!-- Téléphone -->
                            <th>Statut</th>               <!-- Statut (actif/suspendu) -->
                            <th>Actions</th>              <!-- Boutons d'actions -->
                        </tr>
                    </thead>
                    
                    <!-- Corps du tableau: données des employés -->
                    <tbody>
                        <!-- Vérifie si la liste n'est pas vide -->
                        <?php if (!empty($employes)): ?>
                            <!-- Boucle foreach pour parcourir la liste des employés -->
                            <?php $num = 1; // Compteur pour numéroter les lignes ?>
                            <?php foreach ($employes as $e): ?>
                                <tr>
                                    <!-- Numéro de ligne -->
                                    <td><?= $num++ ?></td>
                                    
                                    <!-- Nom de l'employé -->
                                    <!-- esc(): fonction de sécurité pour éviter les injections XSS -->
                                    <td><?= esc($e['nom']) ?></td>
                                    
                                    <!-- Prénom -->
                                    <td><?= esc($e['prenom']) ?></td>
                                    
                                    <!-- Poste -->
                                    <td><?= esc($e['poste']) ?></td>
                                    
                                    <!-- Date d'embauche formatée -->
                                    <td>
                                        <?php 
                                        if ($e['date_embauche']) {
                                            echo date('d/m/Y', strtotime($e['date_embauche']));
                                        } else {
                                            echo '—';
                                        }
                                        ?>
                                    </td>
                                    
                                    <!-- Type de contrat -->
                                    <!-- strtoupper(): affiche en majuscules (CDI, CDD, FREELANCE) -->
                                    <td>
                                        <span class="badge badge-info">
                                            <?= strtoupper(esc($e['type_contrat'] ?? '—')) ?>
                                        </span>
                                    </td>
                                    
                                    <!-- Salaire de base -->
                                    <td class="text-right">
                                        <?= number_format($e['salaire_base'], 3) ?> DT
                                    </td>
                                    
                                    <!-- Email -->
                                    <td><?= esc($e['email'] ?? '—') ?></td>
                                    
                                    <!-- Téléphone -->
                                    <td><?= esc($e['telephone'] ?? '—') ?></td>
                                    
                                    <!-- Statut avec badge coloré -->
                                    <td>
                                        <?php
                                        // Attribution d'une couleur selon le statut
                                        $badge_class = 'badge-success';
                                        if ($e['statut'] == 'suspendu') {
                                            $badge_class = 'badge-danger';
                                        }
                                        ?>
                                        <span class="badge <?= $badge_class ?>">
                                            <?= ucfirst(esc($e['statut'] ?? 'actif')) ?>
                                        </span>
                                    </td>
                                    
                                    <!-- Boutons d'actions -->
                                    <td class="text-center">
                                        <!-- Bouton Modifier -->
                                        <!-- Redirige vers le formulaire pré-rempli avec l'ID -->
                                        <a href="<?= site_url('Employes/edit/' . $e['id_employe']) ?>" 
                                           class="btn btn-warning btn-sm" 
                                           title="Modifier">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        
                                        <!-- Bouton Supprimer -->
                                        <!-- onclick: demande confirmation avant suppression -->
                                        <a href="<?= site_url('Employes/supprimer/' . $e['id_employe']) ?>" 
                                           class="btn btn-danger btn-sm" 
                                           onclick="return confirm('⚠️ Êtes-vous sûr de vouloir supprimer cet employé ?')"
                                           title="Supprimer">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <!-- Message si aucun employé n'existe -->
                            <tr>
                                <td colspan="11" class="text-center">
                                    <em>Aucun employé enregistré</em>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Fin de la section "content" -->
<?= $this->endSection() ?>