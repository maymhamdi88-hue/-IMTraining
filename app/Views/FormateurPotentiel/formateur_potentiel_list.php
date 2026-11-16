<!--
================================================
VIEW: Liste des Formateurs Potentiels
================================================
Rôle: Afficher le tableau complet des formateurs potentiels
- Tous les attributs visibles
- Boutons: Ajouter / Modifier / Supprimer / Export PDF
================================================
-->

<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<!-- ======================================== -->
<!-- MESSAGES DE NOTIFICATION -->
<!-- ======================================== -->

<?php if(session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <p><strong>✅ Mise à jour</strong></p>
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
<!-- EN-TÊTE DE LA PAGE -->
<!-- ======================================== -->

<div class="row">
    <div class="col-md-12">
        <div class="white-box">
            <!-- Titre -->
            <h3 class="box-title">🌟 Liste des Formateurs Potentiels</h3>
            
            <!-- Barre d'actions -->
            <div class="text-right m-b-20">
                <!-- Bouton Ajouter -->
                <a href="<?= site_url('FormateurPotentiel/ajouter_form') ?>" class="btn btn-success">
                    <i class="fa fa-plus"></i> Ajouter un Formateur Potentiel
                </a>
                
                <!-- Bouton Export PDF -->
                <a href="<?= site_url('FormateurPotentiel/export_pdf') ?>" class="btn btn-danger" target="_blank">
                    <i class="fa fa-file-pdf-o"></i> Exporter en PDF
                </a>
            </div>

            <!-- ======================================== -->
            <!-- TABLEAU DES FORMATEURS POTENTIELS -->
            <!-- ======================================== -->
            
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <!-- En-tête -->
                    <thead style="background-color:#e3f2fd; color:#000;">
                        <tr>
                            <th>#</th>
                            <th>Nom & Prénom</th>
                            <th>Date Naissance</th>
                            <th>Adresse</th>
                            <th>Téléphone</th>
                            <th>Email</th>
                            <th>Diplôme</th>
                            <th>Domaine Compétence</th>
                            <th>Type Formateur</th>
                            <th>Autorisation</th>
                            <th>Type Autorisation</th>
                            <th>Honoraire</th>
                            <th>Remarque</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    
                    <!-- Corps du tableau -->
                    <tbody>
                        <?php if (!empty($formateur_potentiel)): ?>
                            <?php $num = 1; ?>
                            <?php foreach ($formateur_potentiel as $f): ?>
                                <tr>
                                    <!-- Numéro -->
                                    <td><?= $num++ ?></td>
                                    
                                    <!-- Nom & Prénom -->
                                    <td><?= esc($f['nom_prenom']) ?></td>
                                    
                                    <!-- Date de naissance -->
                                    <td>
                                        <?php 
                                        if ($f['date_naissance']) {
                                            echo date('d/m/Y', strtotime($f['date_naissance']));
                                        } else {
                                            echo '—';
                                        }
                                        ?>
                                    </td>
                                    
                                    <!-- Adresse -->
                                    <td><?= esc($f['adresse'] ?? '—') ?></td>
                                    
                                    <!-- Téléphone -->
                                    <td><?= esc($f['telephone'] ?? '—') ?></td>
                                    
                                    <!-- Email -->
                                    <td><?= esc($f['email'] ?? '—') ?></td>
                                    
                                    <!-- Diplôme -->
                                    <td><?= esc($f['diplome'] ?? '—') ?></td>
                                    
                                    <!-- Domaine de compétence -->
                                    <td><?= esc($f['domaine_competence'] ?? '—') ?></td>
                                    
                                    <!-- Type formateur -->
                                    <td>
                                        <span class="badge badge-info">
                                            <?= strtoupper(esc($f['type_formateur_potentiel'] ?? '—')) ?>
                                        </span>
                                    </td>
                                    
                                    <!-- Autorisation -->
                                    <td>
                                        <?php
                                        $badge_class = 'badge-success';
                                        if ($f['autorisation'] == 'sans') {
                                            $badge_class = 'badge-danger';
                                        }
                                        ?>
                                        <span class="badge <?= $badge_class ?>">
                                            <?= ucfirst(esc($f['autorisation'] ?? '—')) ?>
                                        </span>
                                    </td>
                                    
                                    <!-- Type autorisation -->
                                    <td><?= esc($f['type_autorisation'] ?? '—') ?></td>
                                    
                                    <!-- Honoraire -->
                                    <td class="text-right">
                                        <?= number_format($f['honoraire'], 3) ?> DT
                                    </td>
                                    <!-- Remarque -->
                                    <td><?= esc($f['remarque'] ?? '—') ?></td>
                                    <!-- Boutons d'actions -->
                                    <td class="text-center">
                                        <!-- Bouton Modifier -->
                                        <a href="<?= site_url('FormateurPotentiel/edit/' . $f['id_formateur_potentiel']) ?>" 
                                           class="btn btn-warning btn-sm" 
                                           title="Modifier">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        
                                        <!-- Bouton Supprimer -->
                                        <a href="<?= site_url('FormateurPotentiel/supprimer/' . $f['id_formateur_potentiel']) ?>" 
                                           class="btn btn-danger btn-sm" 
                                           onclick="return confirm('⚠️ Êtes-vous sûr de vouloir supprimer ce formateur potentiel ?')"
                                           title="Supprimer">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <!-- Message si aucun formateur potentiel -->
                            <tr>
                                <td colspan="13" class="text-center">
                                    <em>Aucun formateur potentiel enregistré</em>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>