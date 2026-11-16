<!--
================================================
VIEW: Liste des Attestations (attestations_list.php)
================================================
-->

<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<!-- MESSAGES -->
<?php if(session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <strong>✅</strong><hr><?= session()->getFlashdata('success') ?>
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
    </div>
<?php endif; ?>

<?php if(session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show">
        <strong>❌</strong><hr><?= session()->getFlashdata('error') ?>
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
    </div>
<?php endif; ?>

<div class="row">
    <div class="col-md-12">
        <div class="white-box">
            <h3 class="box-title">📜 Liste des Attestations</h3>
            
            <div class="text-right m-b-20">
                <a href="<?= site_url('EtatAttestation/attestations_ajouter_form') ?>" class="btn btn-success">
                    <i class="fa fa-plus"></i> Ajouter une Attestation
                </a>
            
            <!-- Bouton Export PDF → génère le PDF -->
                <a href="<?= site_url('EtatAttestation/attestations_export_pdf') ?>" class="btn btn-danger" target="_blank">
                    <i class="fa fa-file-pdf-o"></i> Exporter en PDF
                </a>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead style="background-color:#e3f2fd; color:#000;">
                        <tr>
                            <th>#</th>
                            <th>Client</th>
                            <th>Mode</th>
                            <th>N° Action</th>
                            <th>Thème</th>
                            <th>Date Préparation</th>
                            <th>Date Tirage</th>
                            <th>Date Remise</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($rows)): ?>
                            <?php $num = 1; ?>
                            <?php foreach ($rows as $r): ?>
                                <tr>
                                    <!-- # -->
                                    <td><?= $num++ ?></td>
                                    
                                    <!-- Client -->
                                    <td>
                                        <strong><?= esc($clientsMap[$r['id_client']] ?? '—') ?></strong>
                                    </td>
                                    
                                    <!-- Mode -->
                                    <td><?= esc($r['mode'] ?? '—') ?></td>
                                    
                                    <!-- Numéro action -->
                                    <td><?= esc($r['num_action'] ?? '—') ?></td>
                                    
                                    <!-- Thème -->
                                    <td>
                                        <?php 
                                        $theme = esc($r['theme'] ?? '—');
                                        echo strlen($theme) > 50 ? substr($theme, 0, 50) . '...' : $theme;
                                        ?>
                                    </td>
                                    
                                    <!-- Date préparation -->
                                    <td>
                                        <?= $r['date_preparation'] ? date('d/m/Y', strtotime($r['date_preparation'])) : '—' ?>
                                    </td>
                                    
                                    <!-- Date tirage -->
                                    <td>
                                        <?= $r['date_tirage'] ? date('d/m/Y', strtotime($r['date_tirage'])) : '—' ?>
                                    </td>
                                    
                                    <!-- Date remise -->
                                    <td>
                                        <?= $r['date_remise'] ? date('d/m/Y', strtotime($r['date_remise'])) : '—' ?>
                                    </td>
                                    
                                    <!-- Actions -->
                                    <td class="text-center">
                                        <a href="<?= site_url('EtatAttestation/attestations_modifier_form/' . $r['id_attestation']) ?>" 
                                           class="btn btn-warning btn-sm" title="Modifier">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a href="<?= site_url('EtatAttestation/attestations_supprimer/' . $r['id_attestation']) ?>" 
                                           class="btn btn-danger btn-sm" 
                                           onclick="return confirm('⚠️ Supprimer cette attestation ?')"
                                           title="Supprimer">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="9" class="text-center"><em>Aucune attestation enregistrée</em></td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>