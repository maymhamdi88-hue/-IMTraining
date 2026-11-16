<!--
================================================
VIEW: Liste des Charges & Dépenses (charges_list.php)
Champs: nefs le formulaire
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
            <h3 class="box-title">💰 Liste des Charges & Dépenses</h3>

            <div class="text-right m-b-20">
                <a href="<?= base_url('ChargeDepense/charges_ajouter_form') ?>" class="btn btn-success">
                    <i class="fa fa-plus"></i> Ajouter une Charge
                </a>
                <a href="<?= base_url('ChargeDepense/charges_export_pdf') ?>" class="btn btn-danger" target="_blank">
                    <i class="fa fa-file-pdf-o"></i> Exporter en PDF
                </a>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover" style="font-size:12px;">
                   <thead style="background-color:#e3f2fd; color:#000;">
                        <tr>
                            <th>#</th>
                            <th>Type Charge</th>
                            <th>Fournisseur</th>
                            <th>Désignation</th>
                            <th>Banque/Poste</th>
                            <th>Employé</th>
                            <th>Date</th>
                            <th>Montant Net</th>
                            <th>Mode Paiement</th>
                            <th>HTVA</th>
                            <th>TVA</th>
                            <th>TTC</th>
                            <th>Remarque</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($rows)): ?>
                            <?php $num = 1; ?>
                            <?php foreach ($rows as $r): ?>
                                <tr>
                                    <td><?= $num++ ?></td>

                                    <!-- Type charge -->
                                    <td><strong><?= esc($r['type_charge'] ?? '—') ?></strong></td>

                                    <!-- Fournisseur -->
                                    <td><?= esc($r['fournisseur'] ?? '—') ?></td>

                                    <!-- Désignation -->
                                    <td>
                                        <?php
                                        $d = esc($r['designation'] ?? '—');
                                        echo strlen($d) > 35 ? substr($d, 0, 35) . '...' : $d;
                                        ?>
                                    </td>

                                    <!-- Banque/Poste -->
                                    <td><?= esc($r['banque_poste'] ?? '—') ?></td>

                                    <!-- Employé -->
                                    <td><?= esc($employesMap[$r['id_employe']] ?? '—') ?></td>

                                    <!-- Date -->
                                    <td class="text-center">
                                        <?= $r['date_charge'] ? date('d/m/Y', strtotime($r['date_charge'])) : '—' ?>
                                    </td>

                                    <!-- Montant Net -->
                                    <td class="text-right">
                                        <strong style="color:#d9534f;">
                                            <?= $r['montant_net'] ? number_format($r['montant_net'], 3, ',', ' ') . ' TND' : '—' ?>
                                        </strong>
                                    </td>

                                    <!-- Mode paiement -->
                                    <td class="text-center"><?= esc(ucfirst($r['mode_paiement'] ?? '—')) ?></td>

                                    <!-- HTVA -->
                                    <td class="text-right">
                                        <?= $r['montant_htva'] ? number_format($r['montant_htva'], 3, ',', ' ') : '—' ?>
                                    </td>

                                    <!-- TVA -->
                                    <td class="text-right">
                                        <?= $r['montant_tva'] ? number_format($r['montant_tva'], 3, ',', ' ') : '—' ?>
                                    </td>

                                    <!-- TTC -->
                                    <td class="text-right">
                                        <?= $r['montant_ttc'] ? number_format($r['montant_ttc'], 3, ',', ' ') : '—' ?>
                                    </td>

                                    <!-- Remarque -->
                                    <td>
                                        <?php
                                        $rem = esc($r['remarque'] ?? '—');
                                        echo strlen($rem) > 30 ? substr($rem, 0, 30) . '...' : $rem;
                                        ?>
                                    </td>

                                    <!-- Actions -->
                                    <td class="text-center" style="white-space:nowrap;">
                                        <a href="<?= base_url('ChargeDepense/charges_modifier_form/' . $r['id_charge']) ?>"
                                           class="btn btn-warning btn-sm" title="Modifier">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a href="<?= base_url('ChargeDepense/charges_supprimer/' . $r['id_charge']) ?>"
                                           class="btn btn-danger btn-sm"
                                           onclick="return confirm('⚠️ Supprimer cette charge ?')"
                                           title="Supprimer">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="14" class="text-center"><em>Aucune charge enregistrée</em></td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>