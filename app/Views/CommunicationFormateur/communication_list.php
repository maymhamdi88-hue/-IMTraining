<!--
================================================
VIEW: Liste des Communications Formateurs
================================================
Rôle: Afficher le tableau complet des communications
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
            <h3 class="box-title">💬 Historique des Communications Formateurs</h3>
            
            <!-- Barre d'actions -->
            <div class="text-right m-b-20">
                <!-- Bouton Ajouter -->
                <a href="<?= site_url('CommunicationFormateur/ajouter_form') ?>" class="btn btn-success">
                    <i class="fa fa-plus"></i> Ajouter une Communication
                </a>
                
                <!-- Bouton Export PDF -->
                <a href="<?= site_url('CommunicationFormateur/export_pdf') ?>" class="btn btn-danger" target="_blank">
                    <i class="fa fa-file-pdf-o"></i> Exporter en PDF
                </a>
            </div>

            <!-- ======================================== -->
            <!-- TABLEAU DES COMMUNICATIONS -->
            <!-- ======================================== -->
            
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <!-- En-tête -->
                    <thead style="background-color:#e3f2fd; color:#000;">
                        <tr>
                            <th>#</th>
                            <th>Formateur</th>
                            <th>Responsable</th>
                            <th>Domaine / Objet</th>
                            <th>Moyen</th>
                            <th>Avis</th>
                            <th>Date</th>
                            <th>Commentaire</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    
                    <!-- Corps du tableau -->
                    <tbody>
                        <?php if (!empty($communications)): ?>
                            <?php $num = 1; ?>
                            <?php foreach ($communications as $c): ?>
                                <tr>
                                    <!-- Numéro -->
                                    <td><?= $num++ ?></td>
                                    
                                    <!-- Formateur -->
                                    <td><?= esc($formateursMap[$c['id_formateur']] ?? '—') ?></td>
                                    
                                    <!-- Responsable -->
                                    <td><?= esc($usersMap[$c['id_responsable']] ?? '—') ?></td>
                                    
                                    <!-- Domaine -->
                                    <td><?= esc($c['domaine'] ?? '—') ?></td>
                                    
                                    <!-- Moyen de communication -->
                                    <td>
                                        <?php
                                        $badge_class = 'badge-info';
                                        $icon = '📞';
                                        
                                        if ($c['moyen_communication'] == 'email') {
                                            $badge_class = 'badge-primary';
                                            $icon = '📧';
                                        } elseif ($c['moyen_communication'] == 'reunion') {
                                            $badge_class = 'badge-warning';
                                            $icon = '🤝';
                                        }
                                        ?>
                                        <span class="badge <?= $badge_class ?>">
                                            <?= $icon ?> <?= ucfirst(esc($c['moyen_communication'])) ?>
                                        </span>
                                    </td>
                                    
                                    <!-- Avis -->
                                    <td>
                                        <?php
                                        $avis_badge = 'badge-secondary';
                                        $avis_icon = '⚪';
                                        
                                        if ($c['avis'] == 'positif') {
                                            $avis_badge = 'badge-success';
                                            $avis_icon = '✅';
                                        } elseif ($c['avis'] == 'negatif') {
                                            $avis_badge = 'badge-danger';
                                            $avis_icon = '❌';
                                        }
                                        ?>
                                        <span class="badge <?= $avis_badge ?>">
                                            <?= $avis_icon ?> <?= ucfirst(esc($c['avis'] ?? 'Non spécifié')) ?>
                                        </span>
                                    </td>
                                    
                                    <!-- Date -->
                                    <td>
                                        <?php 
                                        if ($c['date_communication']) {
                                            echo date('d/m/Y', strtotime($c['date_communication']));
                                        } else {
                                            echo '—';
                                        }
                                        ?>
                                    </td>
                                    
                                    <!-- Commentaire -->
                                    <td>
                                        <?php 
                                        $commentaire = esc($c['commentaire'] ?? '—');
                                        // Limiter à 100 caractères pour l'affichage
                                        if (strlen($commentaire) > 100) {
                                            echo substr($commentaire, 0, 100) . '...';
                                        } else {
                                            echo $commentaire;
                                        }
                                        ?>
                                    </td>
                                    
                                    <!-- Boutons d'actions -->
                                    <td class="text-center">
                                        <!-- Bouton Modifier -->
                                        <a href="<?= site_url('CommunicationFormateur/edit_form/' . $c['id_communication']) ?>" 
                                           class="btn btn-warning btn-sm" 
                                           title="Modifier">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        
                                        <!-- Bouton Supprimer -->
                                        <a href="<?= site_url('CommunicationFormateur/supprimer/' . $c['id_communication']) ?>" 
                                           class="btn btn-danger btn-sm" 
                                           onclick="return confirm('⚠️ Êtes-vous sûr de vouloir supprimer cette communication ?')"
                                           title="Supprimer">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <!-- Message si aucune communication -->
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

<?= $this->endSection() ?>