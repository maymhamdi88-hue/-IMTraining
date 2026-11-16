<!--
================================================
VIEW: Liste COMPLÈTE des Pilotages
================================================
✅ Tous les 14 attributs du formulaire affichés
================================================
-->

<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<!-- MESSAGES -->
<?php if(session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <p><strong>✅ Mise à jour</strong></p><hr>
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
    </div>
<?php endif; ?>

<?php if(session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <p><strong>❌ Erreur</strong></p><hr>
        <?= session()->getFlashdata('error') ?>
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
    </div>
<?php endif; ?>

<div class="row">
    <div class="col-md-12">
        <div class="white-box">
            <h3 class="box-title">📊 Liste des Objectifs & Résultats</h3>
            
            <div class="text-right m-b-20">
                <a href="<?= site_url('Pilotage/ajouter_pilotage_form') ?>" class="btn btn-success">
                    <i class="fa fa-plus"></i> Ajouter un Pilotage
                </a>
                <a href="<?= site_url('Pilotage/export_pilotage_pdf') ?>" class="btn btn-danger" target="_blank">
                    <i class="fa fa-file-pdf-o"></i> Exporter en PDF
                </a>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover" style="font-size: 10px;">
                    <thead style="background-color:#e3f2fd; color:#000;">
                        <tr>
                            <th>#</th>
                            <th>Année</th>
                            <th>Processus</th>
                            <th>Objectif</th>
                            <th>Indicateur</th>
                            <th>Mode de Calcul</th>
                            <th>Résultat</th>
                            <th>Fréquence Suivi</th>
                            <th>Cible Année N</th>
                            <th>Résultat Année N</th>
                            <th>Cible Année N+1</th>
                            <th>Résultat Année N+1</th>
                            <th>Visa Direction</th>
                            <th>Remarque</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($pilotages)): ?>
                            <?php $num = 1; ?>
                            <?php foreach ($pilotages as $p): ?>
                                <tr>
                                    <!-- # -->
                                    <td><?= $num++ ?></td>
                                    
                                    <!-- Année -->
                                    <td class="text-center"><strong><?= esc($p['annee']) ?></strong></td>
                                    
                                    <!-- Processus -->
                                    <td><?= esc($p['processus']) ?></td>
                                    
                                    <!-- Objectif -->
                                    <td>
                                        <?php 
                                        $objectif = esc($p['objectif'] ?? '—');
                                        echo strlen($objectif) > 50 ? substr($objectif, 0, 50) . '...' : $objectif;
                                        ?>
                                    </td>
                                    
                                    <!-- Indicateur -->
                                    <td>
                                        <?php 
                                        $indicateur = esc($p['indicateur'] ?? '—');
                                        echo strlen($indicateur) > 50 ? substr($indicateur, 0, 50) . '...' : $indicateur;
                                        ?>
                                    </td>
                                    
                                    <!-- Mode de calcul -->
                                    <td>
                                        <?php 
                                        $mode = esc($p['mode_calcul'] ?? '—');
                                        echo strlen($mode) > 40 ? substr($mode, 0, 40) . '...' : $mode;
                                        ?>
                                    </td>
                                    
                                    <!-- Résultat -->
                                    <td>
                                        <?php 
                                        $resultat = esc($p['resultat'] ?? '—');
                                        echo strlen($resultat) > 40 ? substr($resultat, 0, 40) . '...' : $resultat;
                                        ?>
                                    </td>
                                    
                                    <!-- Fréquence de suivi -->
                                    <td class="text-center">
                                        <span class="badge badge-info">
                                            <?= esc($p['frequence_suivi'] ?? '—') ?>
                                        </span>
                                    </td>
                                    
                                    <!-- Cible année N -->
                                    <td class="text-center">
                                        <?= $p['cible_annee_n'] ? number_format($p['cible_annee_n'], 2, ',', ' ') : '—' ?>
                                    </td>
                                    
                                    <!-- Résultat année N -->
                                    <td class="text-center" style="background-color: #d4edda;">
                                        <strong><?= $p['resultat_annee_n'] ? number_format($p['resultat_annee_n'], 2, ',', ' ') : '—' ?></strong>
                                    </td>
                                    
                                    <!-- Cible année N+1 -->
                                    <td class="text-center">
                                        <?= $p['cible_annee_n1'] ? number_format($p['cible_annee_n1'], 2, ',', ' ') : '—' ?>
                                    </td>
                                    
                                    <!-- ✅ Résultat année N+1 (AJOUTÉ) -->
                                    <td class="text-center" style="background-color: #d4edda;">
                                        <strong><?= $p['resultat_annee_n1'] ? number_format($p['resultat_annee_n1'], 2, ',', ' ') : '—' ?></strong>
                                    </td>
                                    
                                    <!-- Visa direction -->
                                    <td class="text-center">
                                        <?php if ($p['visa_direction']): ?>
                                            <span class="badge badge-success">✔ Validé</span>
                                        <?php else: ?>
                                            <span class="badge badge-secondary">— En attente</span>
                                        <?php endif; ?>
                                    </td>
                                    
                                    <!-- Remarque -->
                                    <td>
                                        <?php 
                                        $remarque = esc($p['remarque'] ?? '—');
                                        echo strlen($remarque) > 40 ? substr($remarque, 0, 40) . '...' : $remarque;
                                        ?>
                                    </td>
                                    
                                    <!-- Actions -->
                                    <td class="text-center" style="white-space: nowrap;">
                                        <a href="<?= site_url('Pilotage/modifier_pilotage/' . $p['id_resultat']) ?>" 
                                           class="btn btn-warning btn-sm" 
                                           title="Modifier">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a href="<?= site_url('Pilotage/supprimer_pilotage/' . $p['id_resultat']) ?>" 
                                           class="btn btn-danger btn-sm" 
                                           onclick="return confirm('⚠️ Êtes-vous sûr de vouloir supprimer ce pilotage ?')"
                                           title="Supprimer">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="15" class="text-center"><em>Aucun pilotage enregistré</em></td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>