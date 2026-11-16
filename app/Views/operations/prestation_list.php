<!--
================================================
VIEW: Liste des Prestations (prestation_list.php)
================================================
Rôle: Afficher le tableau des activités avec actions
- Bouton Ajouter → redirige vers formulaire
- Bouton Modifier → redirige vers formulaire pré-rempli
- Bouton Supprimer → supprime l'activité
- Bouton Export PDF → génère PDF de toutes les données
================================================
-->

<!-- Étend le layout principal "admin" -->
<!-- Permet de réutiliser l'en-tête, le menu et le footer -->
<?= $this->extend('layouts/admin') ?>

<!-- Début de la section "content" -->
<!-- Le contenu de cette page sera injecté dans le layout -->
<?= $this->section('content') ?>

<!-- ======================================== -->
<!-- MESSAGES DE NOTIFICATION -->
<!-- ======================================== -->

<!-- Vérifie s'il existe un message de succès stocké dans la session -->
<?php if(session()->getFlashdata('success')): ?>
    <!-- Conteneur Bootstrap pour afficher une alerte de succès (couleur verte) -->
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <p><strong>✅ Mise à jour</strong></p>
        <hr>
        <!-- Affiche le message de succès récupéré depuis la session -->
        <?= session()->getFlashdata('success') ?>
        <!-- Bouton pour fermer l'alerte -->
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>

<!-- Vérifie s'il existe un message d'erreur stocké dans la session -->
<?php if(session()->getFlashdata('error')): ?>
    <!-- Conteneur Bootstrap pour afficher une alerte d'erreur (couleur rouge) -->
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <p><strong>❌ Erreur</strong></p>
        <hr>
        <!-- Affiche le message d'erreur récupéré depuis la session -->
        <?= session()->getFlashdata('error') ?>
        <!-- Bouton pour fermer l'alerte -->
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
            <h3 class="box-title">📋 Historique des Prestations</h3>
            
            <!-- Barre d'actions -->
            <div class="text-right m-b-20">
                <!-- Bouton Ajouter → redirige vers le formulaire d'ajout -->
                <a href="<?= site_url('Operations/ajouter_form') ?>" class="btn btn-success">
                    <i class="fa fa-plus"></i> Ajouter une Prestation
                </a>
                
                <!-- Bouton Export PDF → génère le PDF de toutes les prestations -->
                <a href="<?= site_url('Operations/export_pdf') ?>" class="btn btn-danger" target="_blank">
                    <i class="fa fa-file-pdf-o"></i> Exporter en PDF
                </a>
            </div>

            <!-- ======================================== -->
            <!-- TABLEAU DES PRESTATIONS -->
            <!-- ======================================== -->
            
            <!-- Tableau Bootstrap avec bordures et lignes alternées -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <!-- En-tête du tableau (noms des colonnes) -->
                    <thead style="background-color:#e3f2fd; color:#000;">
                        <tr>
                            <th>#</th>                    <!-- Numéro de ligne -->
                            <th>Type d'activité</th>                 <!-- Type d'activité -->
                            <th>Réference</th>                <!-- Réference -->
                            <th>Thème</th>                <!-- Thème/Domaine -->
                            <th>Formateur</th>            <!-- Nom du formateur -->
                            <th>Client</th>            <!-- Nom du Client -->
                            <th>Date Prestation</th>      <!-- Date de prestation -->
                            <th>Lieu</th>                 <!-- Lieu -->
                            <th>Participants</th>         <!-- Nombre de participants -->
                            <th>Statut</th>               <!-- Statut -->
                            <th>Remarque</th>             <!-- Remarque -->
                            <th>Objectif</th>             <!--Objectif -->
                            <th>Date de début</th>            <!-- Date de début -->
                            <th>Date de fin</th>             <!-- Date de fin -->
                            <th>Actions</th>              <!-- Boutons actions -->
                        </tr>
                    </thead>
                    
                    <!-- Corps du tableau: données des activités -->
                    <tbody>
                        <!-- Vérifie si la liste n'est pas vide -->
                        <?php if (!empty($activites)): ?>
                            <!-- Boucle foreach pour parcourir la liste des activités -->
                            <?php $num = 1; // Compteur pour numéroter les lignes ?>
                            <?php foreach ($activites as $a): ?>
                                <tr>
                                    <!-- Numéro de ligne -->
                                    <td><?= $num++ ?></td>
                                    
                                    
                                    <!-- Type d'activité avec badge -->
                                    <td>
                                        <?php
                                            // Couleur par type d'activité
                                            $type_badge = 'badge-secondary';
                                            if ($a['type_activite'] == 'tfp') {
                                                $type_badge = 'badge-primary';
                                            } elseif ($a['type_activite'] == 'droit_de_tirage') {
                                                $type_badge = 'badge-success';
                                            } elseif ($a['type_activite'] == 'contenu') {
                                                $type_badge = 'badge-info';
                                            } elseif ($a['type_activite'] == 'audit') {
                                                $type_badge = 'badge-warning';
                                            } elseif ($a['type_activite'] == 'consulting') {
                                                $type_badge = 'badge-dark';
                                            }
                                        ?>
                                        <span class="badge <?= $type_badge ?> text-white">
                                            <?= strtoupper(esc($a['type_activite'])) ?>
                                        </span>
                                    </td>
                                    
                                    <!-- Réference de l'activité -->
                                    <td><?= esc($a['reference']) ?></td>
                                    
                                    <!-- Thème/Domaine -->
                                    <td><?= esc($a['theme_domaine']) ?></td>
                                    
                                    <!-- Nom du formateur -->
                                    <!-- Utilise $formateursMap pour afficher le nom au lieu de l'ID -->
                                    <!-- ?? '—' : si l'ID n'existe pas, affiche "—" -->
                                    <td><?= esc($formateursMap[$a['id_formateur']] ?? '—') ?></td>
                                    <!-- Nom du client -->
                                    <!-- Utilise $clientsMap pour afficher le nom au lieu de l'ID -->
                                    <!-- ?? '—' : si l'ID n'existe pas, affiche "—" -->
                                    <td><?= esc($clientsMap[$a['id_client']] ?? '—') ?></td>
                                    
                                    <!-- Date de prestation -->
                                    <!-- Formatage de la date en français -->
                                    <td>

                                        <?php 
                                        $date_prestation = esc($a['date_prestation'] ?? '—');
                                        // Limiter l'affichage à 30 caractères
                                        if (strlen($date_prestation) > 150) {
                                            echo substr($date_prestation, 0, 150) . '...';
                                        } else {
                                            echo $date_prestation;
                                        }
                                        ?>
                                    </td>
                                    
                                    <!-- Lieu -->
                                    <td><?= esc($a['lieu']) ?></td>
                                    
                                    <!-- Nombre de participants -->
                                    <td class="text-center"><?= esc($a['nombre_participants'] ?? '—') ?></td>
                                    
                                    <!-- Statut avec badge coloré -->
                                     <td>
                                        <?php
                                           // Attribution d'une couleur selon le statut
                                           $badge_class = 'badge-secondary';
                                           if ($a['statut'] == 'Terminé') {
                                              $badge_class = 'badge-success';
                                            } elseif ($a['statut'] == 'En cours') {
                                                $badge_class = 'badge-warning';
                                            } elseif ($a['statut'] == 'Planifié') {
                                                $badge_class = 'badge-info';
                                            }
                                        ?>
                                        <span class="badge <?= $badge_class ?> text-white">
                                            <?= esc($a['statut'] ?? 'Non défini') ?>
                                        </span>
                                   </td>

                                    <!-- Remarque -->
                                    <td>
                                        <?php 
                                        $remarque = esc($a['remarque'] ?? '—');
                                        // Limiter l'affichage à 30 caractères
                                        if (strlen($remarque) > 150) {
                                            echo substr($remarque, 0, 150) . '...';
                                        } else {
                                            echo $remarque;
                                        }
                                        ?>
                                    </td>
                                    <!-- Objectif -->
                                     <td>
                                        <?php 
                                          $objectif = esc($a['objectif'] ?? '—');
                                          if (strlen($objectif) > 150) {
                                              echo substr($objectif, 0, 150) . '...';
                                            } else {
                                                echo $objectif;
                                            }
                                        ?>
                                    </td>
                                    
                                     <!-- Date de début -->
                                    <td>
                                        <?php 
                                        if ($a['date_debut']) {
                                            echo date('d/m/Y', strtotime($a['date_debut']));
                                        } else {
                                            echo '—';
                                        }
                                        ?>
                                    </td>
                                    <!-- Date de fin -->
                                    <td>
                                        <?php 
                                        if ($a['date_fin']) {
                                            echo date('d/m/Y', strtotime($a['date_fin']));
                                        } else {
                                            echo '—';
                                        }
                                        ?>
                                    </td>
                                    >
                                    
                                    <!-- Boutons d'actions -->
                                    <td class="text-center">
                                        <!-- Bouton Modifier -->
                                        <!-- Redirige vers le formulaire pré-rempli avec l'ID -->
                                        <a href="<?= site_url('Operations/modifier/' . $a['id_activite']) ?>" 
                                           class="btn btn-warning btn-sm" 
                                           title="Modifier">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        
                                        <!-- Bouton Supprimer -->
                                        <!-- onclick: demande confirmation avant suppression -->
                                        <a href="<?= site_url('Operations/supprimer/' . $a['id_activite']) ?>" 
                                           class="btn btn-danger btn-sm" 
                                           onclick="return confirm('⚠️ Êtes-vous sûr de vouloir supprimer cette activité ?')"
                                           title="Supprimer">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <!-- Message si aucune activité n'existe -->
                            <tr>
                                <td colspan="10" class="text-center">
                                    <em>Aucune activité enregistrée</em>
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
<!-- Le layout affichera ce contenu à l'endroit prévu -->
<?= $this->endSection() ?>