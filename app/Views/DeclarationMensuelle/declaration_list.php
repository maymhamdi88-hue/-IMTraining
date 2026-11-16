<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<?php if(session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible">
        ✅ <?= session()->getFlashdata('success') ?>
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
    </div>
<?php endif; ?>
<?php if(session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible">
        ❌ <?= session()->getFlashdata('error') ?>
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
    </div>
<?php endif; ?>

<div class="row">
    <div class="col-md-12">
        <div class="white-box">
            <h3 class="box-title">📊 <?= esc($title) ?></h3>

            <div class="text-right m-b-20">
                <a href="<?= site_url('declaration/ajouter') ?>" class="btn btn-success">
                    <i class="fa fa-plus"></i> Ajouter
                </a>
                <a href="<?= site_url('declaration/pdf') ?>" class="btn btn-danger" target="_blank">
                    <i class="fa fa-file-pdf-o"></i> Exporter PDF
                </a>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover" style="font-size:10px;">
                    <thead style="background:#e3f2fd; color:#000;">
                        <tr>
                            <th rowspan="2" class="text-center">#</th>
                            <th rowspan="2" class="text-center">Mois</th>
                            <th rowspan="2" class="text-center">Année</th>

                            <!-- BASES -->
                            <th colspan="4" class="text-center" style="background:#d1ecf1;">Bases</th>
                            <th rowspan="2" class="text-center" style="background:#d1ecf1;">Tot. Base</th>

                            <!-- TAUX -->
                            <th colspan="4" class="text-center" style="background:#ffeeba;">Taux %</th>

                            <!-- RS -->
                            <th colspan="4" class="text-center" style="background:#f8d7da;">Retenues (RS)</th>
                            <th rowspan="2" class="text-center" style="background:#f8d7da;">Tot. Ret.</th>

                            <!-- TFP / FORPROLOS -->
                            <th rowspan="2" class="text-center" style="background:#d4edda;">TFP</th>
                            <th rowspan="2" class="text-center" style="background:#d4edda;">FORPROLOS</th>

                            <!-- TVA -->
                            <th rowspan="2" class="text-center" style="background:#cce5ff;">TVA Déd.</th>
                            <th rowspan="2" class="text-center" style="background:#cce5ff;">TVA Coll.</th>
                            <th rowspan="2" class="text-center" style="background:#fff3cd;">Report</th>
                            <th rowspan="2" class="text-center" style="background:#cce5ff;">TVA Fin.</th>
                            <th rowspan="2" class="text-center" style="background:#d4edda;">TCL</th>

                            <!-- TOTAL -->
                            <th rowspan="2" class="text-center" style="background:#fff3cd;">Total à Payer</th>

                            <!-- ACTIONS -->
                            <th rowspan="2" class="text-center">Actions</th>
                        </tr>
                        <tr>
                            <!-- Bases -->
                            <th class="text-center" style="background:#d1ecf1;">Sal.</th>
                            <th class="text-center" style="background:#d1ecf1;">Cpt.</th>
                            <th class="text-center" style="background:#d1ecf1;">Form.</th>
                            <th class="text-center" style="background:#d1ecf1;">Loyer</th>
                            <!-- Taux -->
                            <th class="text-center" style="background:#ffeeba;">Sal.</th>
                            <th class="text-center" style="background:#ffeeba;">Cpt.</th>
                            <th class="text-center" style="background:#ffeeba;">Form.</th>
                            <th class="text-center" style="background:#ffeeba;">Loyer</th>
                            <!-- RS -->
                            <th class="text-center" style="background:#f8d7da;">Sal.</th>
                            <th class="text-center" style="background:#f8d7da;">Cpt.</th>
                            <th class="text-center" style="background:#f8d7da;">Form.</th>
                            <th class="text-center" style="background:#f8d7da;">Loyer</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($rows)):
                            $mois_noms = [
                                1=>'Janvier', 2=>'Février', 3=>'Mars', 4=>'Avril',
                                5=>'Mai', 6=>'Juin', 7=>'Juillet', 8=>'Août',
                                9=>'Septembre', 10=>'Octobre', 11=>'Novembre', 12=>'Décembre'
                            ];
                            $num = 1;
                            foreach ($rows as $d): ?>
                        <tr>
                            <td class="text-center"><?= $num++ ?></td>
                            <td class="text-center"><strong><?= $mois_noms[$d['mois']] ?? $d['mois'] ?></strong></td>
                            <td class="text-center"><?= $d['annee'] ?></td>

                            <!-- Bases -->
                            <td class="text-right"><?= number_format($d['base_salaire'],   3, ',', ' ') ?></td>
                            <td class="text-right"><?= number_format($d['base_comptable'], 3, ',', ' ') ?></td>
                            <td class="text-right"><?= number_format($d['base_formateur'], 3, ',', ' ') ?></td>
                            <td class="text-right"><?= number_format($d['base_loyer'],     3, ',', ' ') ?></td>
                            <td class="text-right"><strong><?= number_format($d['total_base'], 3, ',', ' ') ?></strong></td>

                            <!-- Taux -->
                            <td class="text-center"><?= number_format($d['taux_salaire'],   2, ',', ' ') ?>%</td>
                            <td class="text-center"><?= number_format($d['taux_comptable'], 2, ',', ' ') ?>%</td>
                            <td class="text-center"><?= number_format($d['taux_formateur'], 2, ',', ' ') ?>%</td>
                            <td class="text-center"><?= number_format($d['taux_loyer'],     2, ',', ' ') ?>%</td>

                            <!-- RS -->
                            <td class="text-right"><?= number_format($d['rs_salaire'],   3, ',', ' ') ?></td>
                            <td class="text-right"><?= number_format($d['rs_comptable'], 3, ',', ' ') ?></td>
                            <td class="text-right"><?= number_format($d['rs_formateur'], 3, ',', ' ') ?></td>
                            <td class="text-right"><?= number_format($d['rs_loyer'],     3, ',', ' ') ?></td>
                            <td class="text-right"><strong><?= number_format($d['total_retenue'], 3, ',', ' ') ?></strong></td>

                            <!-- TFP / FORPROLOS -->
                            <td class="text-right"><?= number_format($d['tfp'],       3, ',', ' ') ?></td>
                            <td class="text-right"><?= number_format($d['forprolos'], 3, ',', ' ') ?></td>

                            <!-- TVA -->
                            <td class="text-right"><?= number_format($d['tva_deductible'], 3, ',', ' ') ?></td>
                            <td class="text-right"><?= number_format($d['tva_collectee'],  3, ',', ' ') ?></td>
                            <td class="text-right"><?= number_format($d['report'],         3, ',', ' ') ?></td>
                            <td class="text-right">
                                <strong style="color:<?= $d['tva_final'] < 0 ? '#d9534f' : '#5cb85c' ?>">
                                    <?= number_format($d['tva_final'], 3, ',', ' ') ?>
                                </strong>
                            </td>
                            <td class="text-right"><?= number_format($d['tcl'], 3, ',', ' ') ?></td>

                            <!-- Total à payer -->
                            <td class="text-right" style="background:#fff3cd;">
                                <strong style="color:#d9534f; font-size:12px;">
                                    <?= number_format($d['total_a_payer'], 3, ',', ' ') ?>
                                </strong>
                            </td>

                            <!-- Actions -->
                            <td class="text-center" style="white-space:nowrap;">
                                <a href="<?= site_url('declaration/modifier/' . $d['id_declaration']) ?>"
                                   class="btn btn-warning btn-sm" title="Modifier">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a href="<?= site_url('declaration/supprimer/' . $d['id_declaration']) ?>"
                                   class="btn btn-danger btn-sm"
                                   onclick="return confirm('⚠️ Supprimer cette déclaration ?')"
                                   title="Supprimer">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach;
                        else: ?>
                        <tr>
                            <td colspan="27" class="text-center"><em>Aucune déclaration enregistrée.</em></td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>