<!--
================================================
VIEW: Liste des Communications (communication_list.php)
================================================
Rôle: Afficher TOUS les attributs de communication
- Client, Responsable, Objet, Moyen, Avis, Commentaire, Date
- Export PDF avec toutes les données
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
            <h3 class="box-title">💬 Historique des Communications Clients</h3>
            
            <!-- Barre d'actions -->
            <div class="text-right m-b-20">
                <!-- Bouton Ajouter → redirige vers le formulaire d'ajout -->
                <a href="<?= site_url('CommunicationClient/ajouter_communication_form') ?>" class="btn btn-success">
                    <i class="fa fa-plus"></i> Ajouter une Communication
                </a>
                
                <!-- Bouton Export PDF → génère le PDF de toutes les communications -->
                <a href="<?= site_url('CommunicationClient/export_communications_pdf') ?>" class="btn btn-danger" target="_blank">
                    <i class="fa fa-file-pdf-o"></i> Exporter en PDF
                </a>
            </div>

            <!-- ======================================== -->
            <!-- TABLEAU DES COMMUNICATIONS (TOUS LES ATTRIBUTS) -->
            <!-- ======================================== -->
            
            <!-- Tableau Bootstrap avec bordures et lignes alternées -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <!-- En-tête du tableau (TOUS les attributs) -->
                    <thead class="bg-info text-white">
                        <tr>
                            <th>#</th>                       <!-- Numéro de ligne -->
                            <th>Client</th>                  <!-- Nom du client -->
                            <th>Responsable</th>             <!-- Responsable communication -->
                            <th>Objet</th>                   <!-- Domaine/Objet -->
                            <th>Moyen</th>                   <!-- Moyen de communication -->
                            <th>Avis</th>                    <!-- Avis -->
                            <th>Commentaire</th>             <!-- Commentaire -->
                            <th>Date Communication</th>      <!-- Date communication -->
                            <th>Actions</th>                 <!-- Boutons d'actions -->
                        </tr>
                    </thead>
                    
                    <!-- Corps du tableau: TOUTES les données -->
                    <tbody>
                        <!-- Vérifie si la liste n'est pas vide -->
                        <?php if (!empty($communications)): ?>
                            <!-- Boucle foreach pour parcourir la liste -->
                            <?php $num = 1; // Compteur pour numéroter les lignes ?>
                            <?php foreach ($communications as $c): ?>
                                <tr>
                                    <!-- Numéro de ligne -->
                                    <td><?= $num++ ?></td>
                                    
                                    <!-- Client (via clientsMap) -->
                                    <td>
                                        <strong><?= esc($clientsMap[$c['id_client']] ?? '—') ?></strong>
                                    </td>
                                    
                                    <!-- Responsable (via usersMap) -->
                                    <td><?= esc($usersMap[$c['id_responsable']] ?? '—') ?></td>
                                    
                                    <!-- Objet/Domaine -->
                                    <td><?= esc($c['domaine'] ?? '—') ?></td>
                                    
                                    <!-- Moyen de communication avec badge -->
                                    <td>
                                        <?php
                                        // Attribution d'une couleur selon le moyen
                                        $moyen_badge = 'badge-primary';
                                        if ($c['moyen_communication'] == 'appel') {
                                            $moyen_badge = 'badge-success';
                                        } elseif ($c['moyen_communication'] == 'email') {
                                            $moyen_badge = 'badge-info';
                                        } elseif ($c['moyen_communication'] == 'reunion') {
                                            $moyen_badge = 'badge-warning';
                                        }
                                        ?>
                                        <span class="badge <?= $moyen_badge ?>">
                                            <?= ucfirst(esc($c['moyen_communication'])) ?>
                                        </span>
                                    </td>
                                    
                                    <!-- Avis avec badge coloré -->
                                    <td>
                                        <?php
                                        // Attribution d'une couleur selon l'avis
                                        $avis_badge = 'badge-secondary';
                                        if ($c['avis'] == 'positif') {
                                            $avis_badge = 'badge-success';
                                        } elseif ($c['avis'] == 'negatif') {
                                            $avis_badge = 'badge-danger';
                                        } elseif ($c['avis'] == 'neutre') {
                                            $avis_badge = 'badge-warning';
                                        }
                                        ?>
                                        <span class="badge <?= $avis_badge ?>">
                                            <?= ucfirst(esc($c['avis'] ?? 'Non défini')) ?>
                                        </span>
                                    </td>
                                    
                                    <!-- Commentaire (limité à 40 caractères) -->
                                    <td>
                                        <?php 
                                        $commentaire = esc($c['commentaire'] ?? '—');
                                        if (strlen($commentaire) > 40) {
                                            echo substr($commentaire, 0, 40) . '...';
                                        } else {
                                            echo $commentaire;
                                        }
                                        ?>
                                    </td>
                                    
                                    <!-- Date de communication -->
                                    <td>
                                        <?php 
                                        if ($c['date_communication']) {
                                            echo date('d/m/Y', strtotime($c['date_communication']));
                                        } else {
                                            echo '—';
                                        }
                                        ?>
                                    </td>
                                    
                                    <!-- Boutons d'actions -->
                                    <td class="text-center">
                                        <!-- Bouton Modifier -->
                                        <a href="<?= site_url('CommunicationClient/modifier_communication/' . $c['id_communication_client']) ?>" 
                                           class="btn btn-warning btn-sm" 
                                           title="Modifier">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        
                                        <!-- Bouton Supprimer -->
                                        <a href="<?= site_url('CommunicationClient/supprimer_communication/' . $c['id_communication_client']) ?>" 
                                           class="btn btn-danger btn-sm" 
                                           onclick="return confirm('⚠️ Êtes-vous sûr de vouloir supprimer cette communication ?')"
                                           title="Supprimer">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <!-- Message si aucune communication n'existe -->
                            <tr>
                                <td colspan="9" class="text-center">
                                    <em>Aucune communication enregistrée</em>
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