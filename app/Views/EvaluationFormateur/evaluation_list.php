<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<?php if(session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Succès</strong> — <?= session()->getFlashdata('success') ?>
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
    </div>
<?php endif; ?>

<?php if(session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Erreur</strong> — <?= session()->getFlashdata('error') ?>
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
    </div>
<?php endif; ?>

<div class="row">
    <div class="col-md-12">
        <div class="white-box">

            <h3 class="box-title">Évaluations des Formateurs</h3>

            <div class="text-right m-b-20">
                <a href="<?= site_url('EvaluationFormateur/ajouter_form') ?>" class="btn btn-success">
                    <i class="fa fa-plus"></i> Ajouter une Évaluation
                </a>
                <a href="<?= site_url('EvaluationFormateur/export_pdf') ?>" class="btn btn-danger" target="_blank">
                    <i class="fa fa-file-pdf-o"></i> Exporter en PDF
                </a>
            </div>

            <!-- Historique récent (5 dernières) -->
            <h4 class="m-t-30">Historique récent</h4>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="bg-info">
                        <tr style="color:#fff;">
                            <th>Formateur</th>
                            <th>Activité</th>
                            <th>Client</th>
                            <th>Score Global</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($evaluations)): ?>
                            <?php
                                $recent = array_slice(array_reverse($evaluations), 0, 5);
                            ?>
                            <?php foreach ($recent as $e): ?>
                                <tr>
                                    <td><?= esc($formateursMap[$e['id_formateur']] ?? '—') ?></td>
                                    <td><?= esc($activitesMap[$e['id_activite']] ?? '—') ?></td>
                                    <td><?= esc($clientsMap[$e['id_client']] ?? '—') ?></td>
                                    <td>
                                        <strong class="text-primary" style="font-size:16px;">
                                            <?= esc($e['score_global']) ?>/10
                                        </strong>
                                    </td>
                                    <td><?= date('d/m/Y', strtotime($e['date_evaluation'])) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center">Aucune évaluation</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Liste complète -->
            <h4 class="m-t-40">Liste complète des évaluations</h4>
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead style="background-color:#e3f2fd; color:#000;">
                        <tr>
                            <th>#</th>
                            <th>Formateur</th>
                            <th>Activité</th>
                            <th>Client</th>
                            <th>Date</th>
                            <th>Pédagogie</th>
                            <th>Maîtrise</th>
                            <th>Soft skills</th>
                            <th>Collaboration</th>
                            <th>Dossier</th>
                            <th>Flexibilité</th>
                            <th>Score Global</th>
                            <th>Remarque</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($evaluations)): ?>
                            <?php $num = 1; ?>
                            <?php foreach ($evaluations as $e): ?>
                                <tr>
                                    <td><?= $num++ ?></td>
                                    <td><?= esc($formateursMap[$e['id_formateur']] ?? '—') ?></td>
                                    <td><?= esc($activitesMap[$e['id_activite']] ?? '—') ?></td>
                                    <td><?= esc($clientsMap[$e['id_client']] ?? '—') ?></td>
                                    <td><?= date('d/m/Y', strtotime($e['date_evaluation'])) ?></td>
                                    <td class="text-center"><?= esc($e['pedagogie_methodes'] ?? '—') ?></td>
                                    <td class="text-center"><?= esc($e['maitrise_technique'] ?? '—') ?></td>
                                    <td class="text-center"><?= esc($e['posture_soft_skills'] ?? '—') ?></td>
                                    <td class="text-center"><?= esc($e['facilite_collaboration'] ?? '—') ?></td>
                                    <td class="text-center"><?= esc($e['dossier_administratif_ponctualite'] ?? '—') ?></td>
                                    <td class="text-center"><?= esc($e['flexibilite_delais_paiement'] ?? '—') ?></td>
                                    <td class="text-center">
                                        <strong class="text-danger" style="font-size:14px;">
                                            <?= esc($e['score_global']) ?>
                                        </strong>
                                    </td>
                                    <td><?= esc($e['remarque'] ?? '—') ?></td>
                                    <td class="text-center">
                                        <a href="<?= site_url('EvaluationFormateur/edit_form/' . $e['id_evaluation']) ?>"
                                           class="btn btn-warning btn-sm" title="Modifier">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a href="<?= site_url('EvaluationFormateur/supprimer/' . $e['id_evaluation']) ?>"
                                           class="btn btn-danger btn-sm"
                                           onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette évaluation ?')"
                                           title="Supprimer">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="14" class="text-center">
                                    <em>Aucune évaluation enregistrée</em>
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