<!--
================================================
VIEW: Liste des Opérations Banque (banque_list.php)
================================================
-->

<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<!-- MESSAGES -->
<?php if(session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>✅</strong><hr><?= session()->getFlashdata('success') ?>
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
    </div>
<?php endif; ?>

<?php if(session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>❌</strong><hr><?= session()->getFlashdata('error') ?>
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
    </div>
<?php endif; ?>

<div class="row">
    <div class="col-md-12">
        <div class="white-box">
            <h3 class="box-title">🏦 Journal de Banque</h3>

            <!-- SOLDE ACTUEL -->
            <div class="alert <?= $solde_actuel >= 0 ? 'alert-success' : 'alert-danger' ?> text-right">
                <strong>Solde Actuel : <?= number_format($solde_actuel, 3, ',', ' ') ?> DT</strong>
            </div>

            <!-- BOUTONS -->
            <div class="text-right m-b-20">
                <a href="<?= base_url('Banque/banque_ajouter_form') ?>" class="btn btn-success">
                    <i class="fa fa-plus"></i> Ajouter une Opération
                </a>
                <a href="<?= base_url('Banque/banque_export_pdf') ?>" class="btn btn-danger" target="_blank">
                    <i class="fa fa-file-pdf-o"></i> Exporter en PDF
                </a>
            </div>

            <!-- TABLEAU -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead style="background-color:#e3f2fd; color:#000;">
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Mois</th>
                            <th>Année</th>
                            <th>Type</th>
                            <th>Libellé</th>
                            <th>Désignation</th>
                            <th>Solde Initial (DT)</th>
                            <th>Montant (DT)</th>
                            <th>Solde Final (DT)</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($operations)): ?>
                            <?php $num = 1; ?>
                            <?php foreach ($operations as $op): ?>
                                <tr>
                                    <td><?= $num++ ?></td>
                                    <td><?= date('d/m/Y', strtotime($op['date_operation'])) ?></td>
                                    <td><?= ucfirst(esc($op['mois'] ?? '—')) ?></td>
                                    <td><?= esc($op['annee'] ?? '—') ?></td>

                                    <!-- Type avec badge couleur -->
                                    <td>
                                        <?php if($op['type_operation'] === 'credit'): ?>
                                            <span class="label label-success">✅ Crédit</span>
                                        <?php else: ?>
                                            <span class="label label-danger">🔴 Débit</span>
                                        <?php endif; ?>
                                    </td>

                                    <td><?= esc($op['libelle'] ?? '—') ?></td>
                                    <td>
                                        <?php
                                        $desig = esc($op['designation_precise'] ?? '—');
                                        echo strlen($desig) > 40 ? substr($desig, 0, 40) . '...' : $desig;
                                        ?>
                                    </td>

                                    <!-- Solde initiale -->
                                    <td class="text-right">
                                        <?= number_format((float)$op['solde_initiale'], 3, ',', ' ') ?>
                                    </td>

                                    <!-- Montant coloré -->
                                    <td class="text-right <?= $op['type_operation'] === 'credit' ? 'text-success' : 'text-danger' ?>">
                                        <strong>
                                            <?= $op['type_operation'] === 'credit' ? '+' : '-' ?>
                                            <?= number_format((float)$op['montant'], 3, ',', ' ') ?>
                                        </strong>
                                    </td>

                                    <!-- Solde finale -->
                                    <td class="text-right">
                                        <strong><?= number_format((float)$op['solde_finale'], 3, ',', ' ') ?></strong>
                                    </td>

                                    <!-- Actions -->
                                    <td class="text-center">
                                        <a href="<?= base_url('Banque/banque_modifier_form/' . $op['id_banque']) ?>"
                                           class="btn btn-warning btn-sm" title="Modifier">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a href="<?= base_url('Banque/banque_supprimer/' . $op['id_banque']) ?>"
                                           class="btn btn-danger btn-sm"
                                           onclick="return confirm('⚠️ Supprimer cette opération ? Les soldes seront recalculés.')"
                                           title="Supprimer">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="11" class="text-center"><em>Aucune opération enregistrée</em></td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<?= $this->endSection() ?>