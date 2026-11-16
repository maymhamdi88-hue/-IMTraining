<!--
================================================
VIEW: Liste des Congés (conge_list.php)
================================================
Rôle: Afficher le tableau des congés avec actions
- Bouton Ajouter → redirige vers formulaire
- Bouton Modifier → redirige vers formulaire pré-rempli
- Bouton Supprimer → supprime le congé
- Bouton Export PDF → génère PDF de tous les congés
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
            <h3 class="box-title">🏖️ Liste des Congés</h3>
            
            <!-- Barre d'actions -->
            <div class="text-right m-b-20">
                <!-- Bouton Ajouter → redirige vers le formulaire d'ajout -->
                <a href="<?= site_url('Conge/ajouter_form') ?>" class="btn btn-success">
                    <i class="fa fa-plus"></i> Ajouter un Congé
                </a>
                
                <!-- Bouton Export PDF → génère le PDF de tous les congés -->
                <a href="<?= site_url('Conge/export_pdf') ?>" class="btn btn-danger" target="_blank">
                    <i class="fa fa-file-pdf-o"></i> Exporter en PDF
                </a>
            </div>

            <!-- ======================================== -->
            <!-- TABLEAU DES CONGÉS -->
            <!-- ======================================== -->
            
            <!-- Tableau Bootstrap avec bordures et lignes alternées -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <!-- En-tête du tableau (noms des colonnes) -->
                    <thead class="bg-info text-white">
                        <tr>
                            <th>#</th>                    <!-- Numéro de ligne -->
                            <th>Employé</th>              <!-- Nom de l'employé -->
                            <th>Type congé</th>           <!-- Type de congé -->
                            <th>Date début</th>           <!-- Date de début -->
                            <th>Date fin</th>             <!-- Date de fin -->
                            <th>Nb jours</th>             <!-- Nombre de jours -->
                            <th>Statut</th>               <!-- Statut du congé -->
                            <th>Motif</th>                <!-- Motif du congé -->
                            <th>Date demande</th>         <!-- Date de demande -->
                            <th>Actions</th>              <!-- Boutons d'actions -->
                        </tr>
                    </thead>
                    
                    <!-- Corps du tableau: données des congés -->
                    <tbody>
                        <!-- Vérifie si la liste n'est pas vide -->
                        <?php if (!empty($conges)): ?>
                            <!-- Boucle foreach pour parcourir la liste des congés -->
                            <?php $num = 1; // Compteur pour numéroter les lignes ?>
                            <?php foreach ($conges as $c): ?>
                                <tr>
                                    <!-- Numéro de ligne -->
                                    <td><?= $num++ ?></td>
                                    
                                    <!-- Nom de l'employé -->
                                    <!-- Utilise $employesMap pour afficher le nom au lieu de l'ID -->
                                    <!-- ?? '—' : si l'ID n'existe pas, affiche "—" -->
                                    <td>
                                        <strong><?= esc($employesMap[$c['id_employe']] ?? '—') ?></strong>
                                    </td>
                                    
                                    <!-- Type de congé avec badge coloré -->
                                    <td>
                                        <?php
                                        // Attribution d'une couleur selon le type
                                        $type_badge = 'badge-primary';
                                        if ($c['type_conge'] == 'maladie') {
                                            $type_badge = 'badge-warning';
                                        } elseif ($c['type_conge'] == 'sans_solde') {
                                            $type_badge = 'badge-secondary';
                                        }
                                        ?>
                                        <span class="badge <?= $type_badge ?>">
                                            <?= ucfirst(str_replace('_', ' ', esc($c['type_conge']))) ?>
                                        </span>
                                    </td>
                                    
                                    <!-- Date de début -->
                                    <td>
                                        <?php 
                                        if ($c['date_debut']) {
                                            echo date('d/m/Y', strtotime($c['date_debut']));
                                        } else {
                                            echo '—';
                                        }
                                        ?>
                                    </td>
                                    
                                    <!-- Date de fin -->
                                    <td>
                                        <?php 
                                        if ($c['date_fin']) {
                                            echo date('d/m/Y', strtotime($c['date_fin']));
                                        } else {
                                            echo '—';
                                        }
                                        ?>
                                    </td>
                                    
                                    <!-- Nombre de jours -->
                                    <td class="text-center">
                                        <span class="badge badge-light">
                                            <?= esc($c['nombre_jours']) ?> jour(s)
                                        </span>
                                    </td>
                                    
                                    <!-- Statut avec badge coloré -->
                                    <td>
                                        <?php
                                        // Attribution d'une couleur selon le statut
                                        $statut_badge = 'badge-info';
                                        if ($c['statut'] == 'accepte') {
                                            $statut_badge = 'badge-success';
                                        } elseif ($c['statut'] == 'refuse') {
                                            $statut_badge = 'badge-danger';
                                        }
                                        ?>
                                        <span class="badge <?= $statut_badge ?>">
                                            <?= ucfirst(str_replace('_', ' ', esc($c['statut']))) ?>
                                        </span>
                                    </td>
                                    
                                    <!-- Motif -->
                                    <td>
                                        <?php 
                                        $motif = esc($c['motif'] ?? '—');
                                        // Limiter l'affichage à 50 caractères
                                        if (strlen($motif) > 50) {
                                            echo substr($motif, 0, 50) . '...';
                                        } else {
                                            echo $motif;
                                        }
                                        ?>
                                    </td>
                                    
                                    <!-- Date de demande -->
                                    <td>
                                        <?php 
                                        if ($c['date_demande']) {
                                            echo date('d/m/Y', strtotime($c['date_demande']));
                                        } else {
                                            echo '—';
                                        }
                                        ?>
                                    </td>
                                    
                                    <!-- Boutons d'actions -->
                                    <td class="text-center">
                                        <!-- Bouton Modifier -->
                                        <!-- Redirige vers le formulaire pré-rempli avec l'ID -->
                                        <a href="<?= site_url('Conge/edit_form/' . $c['id_conge']) ?>" 
                                           class="btn btn-warning btn-sm" 
                                           title="Modifier">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        
                                        <!-- Bouton Supprimer -->
                                        <!-- onclick: demande confirmation avant suppression -->
                                        <a href="<?= site_url('Conge/supprimer/' . $c['id_conge']) ?>" 
                                           class="btn btn-danger btn-sm" 
                                           onclick="return confirm('⚠️ Êtes-vous sûr de vouloir supprimer ce congé ?')"
                                           title="Supprimer">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <!-- Message si aucun congé n'existe -->
                            <tr>
                                <td colspan="10" class="text-center">
                                    <em>Aucun congé enregistré</em>
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