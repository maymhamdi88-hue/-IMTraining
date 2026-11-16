<!--
================================================
VIEW: Liste des Suivis Non-Conformité (suivi_list.php)
================================================
Rôle: Afficher le tableau complet des suivis
- Tous les 6 attributs visibles
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
            <h3 class="box-title">⚠️ Liste des Suivis Non-Conformité</h3>
            
            <!-- Barre d'actions -->
            <div class="text-right m-b-20">
                <!-- Bouton Ajouter → Redirige vers formulaire séparé -->
                <a href="<?= site_url('SuivieNonConformite/ajouter_suivi_form') ?>" class="btn btn-success">
                    <i class="fa fa-plus"></i> Ajouter un Suivi
                </a>
                
                <!-- Bouton Export PDF -->
                <a href="<?= site_url('SuivieNonConformite/export_suivi_pdf') ?>" class="btn btn-danger" target="_blank">
                    <i class="fa fa-file-pdf-o"></i> Exporter en PDF
                </a>
            </div>

            <!-- ======================================== -->
            <!-- TABLEAU DES SUIVIS -->
            <!-- ======================================== -->
            
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <!-- En-tête du tableau - 6 colonnes + Actions -->
                    <thead style="background-color:#e3f2fd; color:#000;">
                        <tr>
                            <th>#</th>
                            <th>Date Constat</th>
                            <th>Désignation</th>
                            <th>Correction Immédiate</th>
                            <th>Date Réalisation</th>
                            <th>Responsable</th>
                            <th>Causes Probables</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    
                    <!-- Corps du tableau -->
                    <tbody>
                        <?php if (!empty($suivis)): ?>
                            <?php $num = 1; ?>
                            <?php foreach ($suivis as $s): ?>
                                <tr>
                                    <!-- Numéro -->
                                    <td><?= $num++ ?></td>
                                    
                                    <!-- Date constat -->
                                    <td>
                                        <?php 
                                        if ($s['date_constat']) {
                                            echo date('d/m/Y', strtotime($s['date_constat']));
                                        } else {
                                            echo '—';
                                        }
                                        ?>
                                    </td>
                                    
                                    <!-- Désignation -->
                                    <td><?= esc($s['designation'] ?? '—') ?></td>
                                    
                                    <!-- Correction immédiate -->
                                    <td><?= esc($s['correction_immediate'] ?? '—') ?></td>
                                    
                                    <!-- Date réalisation -->
                                    <td>
                                        <?php 
                                        if ($s['date_realisation']) {
                                            echo date('d/m/Y', strtotime($s['date_realisation']));
                                        } else {
                                            echo '—';
                                        }
                                        ?>
                                    </td>
                                    
                                    <!-- Responsable -->
                                    <td><?= esc($s['responsable']) ?></td>
                                    
                                    <!-- Causes probables -->
                                    <td><?= esc($s['causes_probables'] ?? '—') ?></td>
                                    
                                    <!-- Boutons d'actions -->
                                    <td class="text-center">
                                        <!-- Bouton Modifier → Redirige vers formulaire séparé -->
                                        <a href="<?= site_url('SuivieNonConformite/modifier_suivi/' . $s['id_suivi']) ?>" 
                                           class="btn btn-warning btn-sm" 
                                           title="Modifier">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        
                                        <!-- Bouton Supprimer -->
                                        <a href="<?= site_url('SuivieNonConformite/supprimer_suivi/' . $s['id_suivi']) ?>" 
                                           class="btn btn-danger btn-sm" 
                                           onclick="return confirm('⚠️ Êtes-vous sûr de vouloir supprimer ce suivi ?')"
                                           title="Supprimer">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <!-- Message si aucun suivi -->
                            <tr>
                                <td colspan="8" class="text-center">
                                    <em>Aucun suivi non-conformité enregistré</em>
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