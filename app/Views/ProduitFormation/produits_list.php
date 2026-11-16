<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

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
            <h3 class="box-title">📚 Liste des Produits Formation</h3>

            <div class="text-right m-b-20">
                <a href="<?= base_url('ProduitFormation/produits_ajouter_form') ?>" class="btn btn-success">
                    <i class="fa fa-plus"></i> Ajouter un Produit
                </a>
                <a href="<?= base_url('ProduitFormation/produits_export_pdf') ?>" class="btn btn-danger" target="_blank">
                    <i class="fa fa-file-pdf-o"></i> Exporter en PDF
                </a>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover" style="font-size: 11px;">
                    <thead style="background-color:#e3f2fd; color:#000;">
                        <tr>
                            <th>#</th>
                            <th>Client</th>
                            <th>Prestation</th>
                            <th>Type</th>
                            <th>Thème</th>
                            <th>Date Prestation</th>
                            <th>Formateur</th>
                            <th>Honoraire</th>
                            <th>Prix Unit.</th>
                            <th>Nb H/J</th>        <!-- ✅ Séparé -->
                            <th>Nb Jours</th>       <!-- ✅ Séparé -->
                            <th>Taux TVA</th>
                            <th>Taux RAS</th>
                            <th>MHTVA</th>
                            <th>TVA</th>
                            <th>MTTC</th>
                            <th>RAS</th>
                            <th>Net</th>
                            <th>N° Action</th>
                            <th>N° Facture</th>
                            <th>Date Fact.</th>
                            <th>Date Réglement</th>
                            <th>Date Réglement Formateur</th>
                            <th>Date Certif. RAS</th>
                            <th>Mois Décl.</th>
                            <th>Mode Paiem.</th>
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
                                    <td><strong><?= esc($r['nom_societe'] ?? '—') ?></strong></td>
                                    <td><?= esc($r['reference'] ?? '—') ?></td>
                                    <td><small><?= esc($r['type_activite'] ?? '—') ?></small></td>
                                    <td><?= esc($r['theme_domaine'] ?? '—') ?></td>
                                    <td class="text-center">
                                        <?php if (!empty($r['date_prestation'])): ?>
                                            <?= nl2br(esc($r['date_prestation'])) ?>
                                        <?php else: ?>—
                                        <?php endif; ?>
                                    </td>
                                    <td><?= esc($r['nom_prenom'] ?? '—') ?></td>
                                    <td class="text-right">
                                        <?= $r['honoraire'] ? number_format($r['honoraire'], 3, ',', ' ') : '—' ?>
                                    </td>
                                    <td class="text-right">
                                        <?= number_format($r['montant_unitaire'] ?? 0, 3, ',', ' ') ?>
                                    </td>

                                    <!-- ✅ Nb H/J et Nb Jours séparés -->
                                    <td class="text-center">
                                        <?= esc($r['nombre_heures_jour'] ?? '—') ?>
                                    </td>
                                    <td class="text-center">
                                        <?= esc($r['nombre_jours'] ?? '—') ?>
                                    </td>

                                    <td class="text-right"><?= number_format($r['taux_tva'] ?? 0, 2, ',', ' ') ?>%</td>
                                    <td class="text-right"><?= number_format($r['taux_ras'] ?? 0, 2, ',', ' ') ?>%</td>
                                    <td class="text-right"><?= number_format($r['mhtva'] ?? 0, 3, ',', ' ') ?></td>
                                    <td class="text-right"><?= number_format($r['tva'] ?? 0, 3, ',', ' ') ?></td>
                                    <td class="text-right"><?= number_format($r['mttc'] ?? 0, 3, ',', ' ') ?></td>
                                    <td class="text-right"><?= number_format($r['ras'] ?? 0, 3, ',', ' ') ?></td>
                                    <td class="text-right">
                                        <strong style="color:#5cb85c;">
                                            <?= number_format($r['montant_net'] ?? 0, 3, ',', ' ') ?>
                                        </strong>
                                    </td>
                                    <td><?= esc($r['numero_action'] ?? '—') ?></td>
                                    <td><?= esc($r['numero_facture'] ?? '—') ?></td>
                                    <td class="text-center">
                                        <?= $r['date_facture'] ? date('d/m/Y', strtotime($r['date_facture'])) : '—' ?>
                                    </td>
                                    <td class="text-center">
                                        <?= $r['date_entree'] ? date('d/m/Y', strtotime($r['date_entree'])) : '—' ?>
                                    </td>
                                    <td class="text-center">
                                        <?= $r['date_sortie'] ? date('d/m/Y', strtotime($r['date_sortie'])) : '—' ?>
                                    </td>
                                    <td class="text-center">
                                        <?= $r['date_certificat_ras'] ? date('d/m/Y', strtotime($r['date_certificat_ras'])) : '—' ?>
                                    </td>
                                    <td><?= esc($r['mois_declaration'] ?? '—') ?></td>
                                    <td><?= esc(ucfirst($r['mode_paiement'] ?? '—')) ?></td>
                                    <td>
                                        <?php
                                        $remarque = esc($r['remarque'] ?? '—');
                                        echo strlen($remarque) > 30 ? substr($remarque, 0, 30) . '...' : $remarque;
                                        ?>
                                    </td>
                                    <td class="text-center" style="white-space:nowrap;">
                                        <a href="<?= base_url('ProduitFormation/produits_modifier_form/' . $r['id_produit']) ?>"
                                           class="btn btn-warning btn-sm" title="Modifier">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a href="<?= base_url('ProduitFormation/produits_supprimer/' . $r['id_produit']) ?>"
                                           class="btn btn-danger btn-sm"
                                           onclick="return confirm('⚠️ Supprimer ce produit ?')"
                                           title="Supprimer">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="28" class="text-center">  <!-- ✅ 27+1 = 28 -->
                                    <em>Aucun produit enregistré</em>
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