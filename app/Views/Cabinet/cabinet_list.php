<!--
================================================
VIEW: Liste des Clients Cabinet (cabinet_list.php)
================================================
Rôle: Afficher le tableau des clients cabinet avec actions
- Bouton Ajouter → redirige vers formulaire
- Bouton Modifier → redirige vers formulaire pré-rempli
- Bouton Supprimer → supprime le client
- Bouton Export PDF → génère PDF de tous les clients
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
            <h3 class="box-title">🏢 Liste des Clients Cabinet</h3>
            
            <!-- Barre d'actions -->
            <div class="text-right m-b-20">
                <!-- Bouton Ajouter → redirige vers le formulaire d'ajout -->
                <a href="<?= site_url('Cabinet/ajouter_cabinet_form') ?>" class="btn btn-success">
                    <i class="fa fa-plus"></i> Ajouter un Client Cabinet
                </a>
                
                <!-- Bouton Export PDF → génère le PDF de tous les clients -->
                <a href="<?= site_url('Cabinet/export_cabinet_pdf') ?>" class="btn btn-danger" target="_blank">
                    <i class="fa fa-file-pdf-o"></i> Exporter en PDF
                </a>
            </div>

            <!-- ======================================== -->
            <!-- TABLEAU DES CLIENTS CABINET -->
            <!-- ======================================== -->
            
            <!-- Tableau Bootstrap avec bordures et lignes alternées -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <!-- En-tête du tableau (noms des colonnes) -->
                    <thead style="background-color:#e3f2fd; color:#000;">
                        <tr>
                            <th>#</th>                    <!-- Numéro de ligne -->
                            <th>Nom société</th>          <!-- Nom de la société -->
                            <th>Matricule fiscal</th>     <!-- Matricule fiscal -->
                            <th>Secteur</th>              <!-- Secteur d'activité -->
                            <th>Activité</th>             <!-- Activité -->
                            <th>Responsable</th>          <!-- Responsable -->
                            <th>Adresse</th>              <!-- Adresse -->
                            <th>Téléphone</th>            <!-- Téléphone -->
                            <th>Email société</th>         <!-- Email société -->
                            <th>Mobile</th>               <!-- Mobile contact -->
                            <th>Fax</th>                   <!-- Fax -->
                            <th>Site Web</th>              <!-- Site Web -->
                            <th>Personne Contactée</th>    <!-- Personne Contactée-->
                            <th>Email Contact</th>                   <!-- Email Contact (obligatoire) -->
                            <th>Actions</th>              <!-- Boutons d'actions -->
                        </tr>
                    </thead>
                    
                    <!-- Corps du tableau: données des clients -->
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
                                    
                                    <!-- Matricule fiscal -->
                                    <td><?= esc($c['matricule_fiscal']) ?></td>
                                    
                                    <!-- Secteur -->
                                    <td><?= esc($c['secteur'] ?? '—') ?></td>
                                    
                                    <!-- Activité -->
                                    <td><?= esc($c['activite'] ?? '—') ?></td>
                                    
                                    <!-- Responsable -->
                                    <td><?= esc($c['responsable']) ?></td>
                                    
                                    <!-- Adresse (limitée à 50 caractères) -->
                                    <td>
                                        <?php 
                                        $adresse = esc($c['adresse'] ?? '—');
                                        if (strlen($adresse) > 50) {
                                            echo substr($adresse, 0, 50) . '...';
                                        } else {
                                            echo $adresse;
                                        }
                                        ?>
                                    </td>
                                    
                                    <!-- Téléphone -->
                                    <td><?= esc($c['telephone'] ?? '—') ?></td>
                                    
                                    <!-- Email -->
                                    <td><?= esc($c['email']) ?></td>
                                    
                                    <!-- Mobile -->
                                    <td><?= esc($c['mob_tel'] ?? '—') ?></td>

                                    <!-- Fax -->
                                    <td><?= esc($c['fax'] ?? '—') ?></td>

                                    <!-- Site Web-->
                                    <td><?= esc($c['site_web'] ?? '—') ?></td>

                                    <!-- Personne Contactée-->
                                    <td><?= esc($c['personne_contactee'] ?? '—') ?></td>

                                    <!-- Email Contact-->
                                    <td><?= esc($c['email_contact'] ?? '—') ?></td>

                                    <!-- Boutons d'actions -->
                                    <td class="text-center">
                                        <!-- Bouton Modifier -->
                                        <!-- Redirige vers le formulaire pré-rempli avec l'ID -->
                                        <a href="<?= site_url('Cabinet/modifier_cabinet/' . $c['id_client']) ?>" 
                                           class="btn btn-warning btn-sm" 
                                           title="Modifier">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        
                                        <!-- Bouton Supprimer -->
                                        <!-- onclick: demande confirmation avant suppression -->
                                        <a href="<?= site_url('Cabinet/supprimer_client_cabinet/' . $c['id_client']) ?>" 
                                           class="btn btn-danger btn-sm" 
                                           onclick="return confirm('⚠️ Êtes-vous sûr de vouloir supprimer ce client ?')"
                                           title="Supprimer">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <!-- Message si aucun client n'existe -->
                            <tr>
                                <td colspan="11" class="text-center">
                                    <em>Aucun client cabinet enregistré</em>
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