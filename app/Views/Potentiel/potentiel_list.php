<!--
================================================
VIEW: Liste des Clients Potentiels (potentiel_list.php)
================================================
Rôle: Afficher le tableau des clients potentiels avec actions
- Bouton Ajouter → redirige vers formulaire
- Bouton Modifier → redirige vers formulaire pré-rempli
- Bouton Supprimer → supprime le client
- Bouton Export PDF → génère PDF de tous les clients potentiels
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
            <h3 class="box-title">🎯 Liste des Clients Potentiels</h3>
            
            <!-- Barre d'actions -->
            <div class="text-right m-b-20">
                <!-- Bouton Ajouter → redirige vers le formulaire d'ajout -->
                <a href="<?= site_url('Potentiel/ajouter_potentiel_form') ?>" class="btn btn-success">
                    <i class="fa fa-plus"></i> Ajouter un Client Potentiel
                </a>
                
                <!-- Bouton Export PDF → génère le PDF de tous les clients potentiels -->
                <a href="<?= site_url('Potentiel/export_potentiels_pdf') ?>" class="btn btn-danger" target="_blank">
                    <i class="fa fa-file-pdf-o"></i> Exporter en PDF
                </a>
            </div>

            <!-- ======================================== -->
            <!-- TABLEAU DES CLIENTS POTENTIELS -->
            <!-- ======================================== -->
            
            <!-- Tableau Bootstrap avec bordures et lignes alternées -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <!-- En-tête du tableau (noms des colonnes) -->
                    <thead class="bg-warning text-white">
                        <tr>
                            <th>#</th>                    <!-- Numéro de ligne -->
                            <th>Nom société</th>          <!-- Nom de la société -->
                            <th>Secteur</th>              <!-- Secteur d'activité -->
                            <th>Activité</th>             <!-- Activité -->
                            <th>Responsable</th>          <!-- Responsable -->
                            <th>Adresse</th>              <!-- Adresse -->
                            <th>Téléphone</th>            <!-- Téléphone -->
                            <th>Mobile</th>               <!-- Mobile -->
                            <th>Email</th>                <!-- Email -->
                            <th>Personne contactée</th>   <!-- Personne contactée -->
                            <th>Remarque</th>             <!-- Remarque -->
                            <th>Fax</th>                   <!-- Fax -->
                            <th>Site Web</th>              <!-- Site Web -->
                            <th>Actions</th>              <!-- Boutons d'actions -->
                        </tr>
                    </thead>
                    
                    <!-- Corps du tableau: données des clients potentiels -->
                    <tbody>
                        <!-- Vérifie si la liste n'est pas vide -->
                        <?php if (!empty($clients)): ?>
                            <!-- Boucle foreach pour parcourir la liste des clients -->
                            <?php $num = 1; // Compteur pour numéroter les lignes ?>
                            <?php foreach ($clients as $c): ?>
                                <tr>
                                    <!-- Numéro de ligne -->
                                    <td><?= $num++ ?></td>
                                    
                                    <!-- Nom de la société -->
                                    <!-- esc(): fonction de sécurité pour éviter les injections XSS -->
                                    <td><strong><?= esc($c['nom_societe']) ?></strong></td>
                                    
                                    <!-- Secteur -->
                                    <td><?= esc($c['secteur'] ?? '—') ?></td>
                                    
                                    <!-- Activité -->
                                    <td><?= esc($c['activite'] ?? '—') ?></td>
                                    
                                    <!-- Responsable -->
                                    <td><?= esc($c['responsable'] ?? '—') ?></td>
                                    
                                    <!-- Adresse (limitée à 40 caractères) -->
                                    <td>
                                        <?php 
                                        $adresse = esc($c['adresse'] ?? '—');
                                        if (strlen($adresse) > 40) {
                                            echo substr($adresse, 0, 40) . '...';
                                        } else {
                                            echo $adresse;
                                        }
                                        ?>
                                    </td>
                                    
                                    <!-- Téléphone -->
                                    <td><?= esc($c['telephone'] ?? '—') ?></td>
                                    
                                    <!-- Mobile -->
                                    <td><?= esc($c['mobile'] ?? '—') ?></td>
                                    
                                    <!-- Email -->
                                    <td><?= esc($c['email'] ?? '—') ?></td>
                                    
                                    <!-- Personne contactée -->
                                    <td><?= esc($c['personne_contactee'] ?? '—') ?></td>
                                    
                                    <!-- Remarque (limitée à 30 caractères) -->
                                    <td>
                                        <?php 
                                        $remarque = esc($c['remarque'] ?? '—');
                                        if (strlen($remarque) > 30) {
                                            echo substr($remarque, 0, 30) . '...';
                                        } else {
                                            echo $remarque;
                                        }
                                        ?>
                                    </td>
                                    <!-- Fax -->
                                    <td><?= esc($c['fax'] ?? '—') ?></td>

                                    <!-- Site Web-->
                                    <td><?= esc($c['site_web'] ?? '—') ?></td>
                                    
                                    <!-- Boutons d'actions -->
                                    <td class="text-center">
                                        <!-- Bouton Modifier -->
                                        <!-- Redirige vers le formulaire pré-rempli avec l'ID -->
                                        <a href="<?= site_url('Potentiel/modifier_potentiel/' . $c['id_client_potentiel']) ?>" 
                                           class="btn btn-warning btn-sm" 
                                           title="Modifier">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        
                                        <!-- Bouton Supprimer -->
                                        <!-- onclick: demande confirmation avant suppression -->
                                        <a href="<?= site_url('Potentiel/supprimer_client_potentiel/' . $c['id_client_potentiel']) ?>" 
                                           class="btn btn-danger btn-sm" 
                                           onclick="return confirm('⚠️ Êtes-vous sûr de vouloir supprimer ce client potentiel ?')"
                                           title="Supprimer">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <!-- Message si aucun client potentiel n'existe -->
                            <tr>
                                <td colspan="12" class="text-center">
                                    <em>Aucun client potentiel enregistré</em>
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