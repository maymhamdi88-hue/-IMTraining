<!--
================================================
VIEW: Liste des Actions Correctives (actions_list.php)
================================================
Rôle: Afficher le tableau complet des actions correctives
- Tous les 8 attributs visibles
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
            <h3 class="box-title">🔧 Liste des Actions Correctives</h3>
            
            <!-- Barre d'actions -->
            <div class="text-right m-b-20">
                <!-- Bouton Ajouter → Redirige vers formulaire séparé -->
                <a href="<?= site_url('ActionsCorrectivess/ajouter_action_form') ?>" class="btn btn-success">
                    <i class="fa fa-plus"></i> Ajouter une Action
                </a>
                
                <!-- Bouton Export PDF -->
                <a href="<?= site_url('ActionsCorrectivess/export_actions_pdf') ?>" class="btn btn-danger" target="_blank">
                    <i class="fa fa-file-pdf-o"></i> Exporter en PDF
                </a>
            </div>

            <!-- ======================================== -->
            <!-- TABLEAU DES ACTIONS -->
            <!-- ======================================== -->
            
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <!-- En-tête du tableau - 8 colonnes + Actions -->
                    <thead style="background-color:#e3f2fd; color:#000;">
                        <tr>
                            <th>#</th>
                            <th>Causes (Suivi)</th>
                            <th>Action Corrective</th>
                            <th>Responsable Action</th>
                            <th>Date Prévue</th>
                            <th>Date Réalisation</th>
                            <th>Date Vérification</th>
                            <th>Décision</th>
                            <th>Responsable Vérification</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    
                    <!-- Corps du tableau -->
                    <tbody>
                        <?php if (!empty($actions)): ?>
                            <?php $num = 1; ?>
                            <?php foreach ($actions as $a): ?>
                                <tr>
                                    <!-- Numéro -->
                                    <td><?= $num++ ?></td>
                                    
                                    <!-- Causes (relation avec Suivi) -->
                                    <td>
                                        <?= esc($causesMap[$a['id_suivi']] ?? '—') ?>
                                    </td>
                                    
                                    <!-- Action corrective -->
                                    <td><?= esc($a['action_corrective']) ?></td>
                                    
                                    <!-- Responsable action -->
                                    <td><?= esc($a['responsable_action']) ?></td>
                                    
                                    <!-- Date prévue -->
                                    <td>
                                        <?php 
                                        if ($a['date_prevue']) {
                                            echo date('d/m/Y', strtotime($a['date_prevue']));
                                        } else {
                                            echo '—';
                                        }
                                        ?>
                                    </td>
                                    
                                    <!-- Date réalisation -->
                                    <td>
                                        <?php 
                                        if ($a['date_realisation']) {
                                            echo date('d/m/Y', strtotime($a['date_realisation']));
                                        } else {
                                            echo '—';
                                        }
                                        ?>
                                    </td>
                                    
                                    <!-- Date vérification -->
                                    <td>
                                        <?php 
                                        if ($a['date_verification']) {
                                            echo date('d/m/Y', strtotime($a['date_verification']));
                                        } else {
                                            echo '—';
                                        }
                                        ?>
                                    </td>
                                    
                                    <!-- Décision -->
                                    <td class="text-center">
                                        <?php if ($a['decision'] == 'cloture'): ?>
                                            <span class="badge badge-success">✔ Clôturé</span>
                                        <?php elseif ($a['decision'] == 'non_cloture'): ?>
                                            <span class="badge badge-warning">⏳ Non clôturé</span>
                                        <?php else: ?>
                                            <span class="badge badge-secondary">—</span>
                                        <?php endif; ?>
                                    </td>
                                    
                                    <!-- Responsable vérification -->
                                    <td><?= esc($a['responsable_verification'] ?? '—') ?></td>
                                    
                                    <!-- Boutons d'actions -->
                                    <td class="text-center">
                                        <!-- Bouton Modifier → Redirige vers formulaire séparé -->
                                        <a href="<?= site_url('ActionsCorrectivess/modifier_action/' . $a['id_action']) ?>" 
                                           class="btn btn-warning btn-sm" 
                                           title="Modifier">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        
                                        <!-- Bouton Supprimer -->
                                        <a href="<?= site_url('ActionsCorrectivess/supprimer_action/' . $a['id_action']) ?>" 
                                           class="btn btn-danger btn-sm" 
                                           onclick="return confirm('⚠️ Êtes-vous sûr de vouloir supprimer cette action ?')"
                                           title="Supprimer">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <!-- Message si aucune action -->
                            <tr>
                                <td colspan="10" class="text-center">
                                    <em>Aucune action corrective enregistrée</em>
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