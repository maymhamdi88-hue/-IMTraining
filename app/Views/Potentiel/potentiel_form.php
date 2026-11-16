<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<!-- MESSAGES -->
<?php if(session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <strong>✅ Succès</strong><hr><?= session()->getFlashdata('success') ?>
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
    </div>
<?php endif; ?>
<?php if(session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show">
        <strong>❌ Erreur</strong><hr><?= session()->getFlashdata('error') ?>
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
    </div>
<?php endif; ?>

<div class="row">
    <div class="col-md-12">
        <div class="white-box">
            <h3 class="box-title m-b-30 text-center">
                <?= isset($client) ? '✏️ Modifier un Client Potentiel' : '➕ Ajouter un Client Potentiel' ?>
            </h3>

            <div class="text-right m-b-20">
                <a href="<?= site_url('Potentiel/potentiel_list') ?>" class="btn btn-secondary">
                    <i class="fa fa-arrow-left"></i> Retour à la liste
                </a>
            </div>

            <form method="post"
                  action="<?= isset($client)
                      ? site_url('Potentiel/update_potentiel/' . $client['id_client_potentiel'])
                      : site_url('Potentiel/ajouter_client_potentiel') ?>">

                <?= csrf_field() ?>

                <div class="row">
                    <!-- COLONNE GAUCHE -->
                    <div class="col-md-6">

                        <div class="form-group">
                            <label>Nom société: <span class="text-danger">*</span></label>
                            <input type="text" name="nom_societe" class="form-control" required
                                   maxlength="150"
                                   value="<?= esc($client['nom_societe'] ?? old('nom_societe')) ?>">
                        </div>

                        <div class="form-group">
                            <label>Secteur:</label>
                            <input type="text" name="secteur" class="form-control"
                                   maxlength="100"
                                   value="<?= esc($client['secteur'] ?? old('secteur')) ?>">
                        </div>

                        <div class="form-group">
                            <label>Activité: <span class="text-danger">*</span></label>
                            <input type="text" name="activite" class="form-control" required
                                   maxlength="150"
                                   value="<?= esc($client['activite'] ?? old('activite')) ?>">
                        </div>

                        <div class="form-group">
                            <label>Responsable: <span class="text-danger">*</span></label>
                            <input type="text" name="responsable" class="form-control" required
                                   maxlength="150"
                                   value="<?= esc($client['responsable'] ?? old('responsable')) ?>">
                        </div>

                        <div class="form-group">
                            <label>Adresse: <span class="text-danger">*</span></label>
                            <textarea name="adresse" class="form-control" rows="3" required><?= esc($client['adresse'] ?? old('adresse')) ?></textarea>
                        </div>

                        <div class="form-group">
                            <label>Téléphone:</label>
                            <input type="text" name="telephone" class="form-control"
                                   maxlength="20"
                                   value="<?= esc($client['telephone'] ?? old('telephone')) ?>">
                        </div>

                    </div>

                    <!-- COLONNE DROITE -->
                    <div class="col-md-6">

                        <div class="form-group">
                            <label>Mobile:</label>
                            <input type="text" name="mobile" class="form-control"
                                   maxlength="20"
                                   value="<?= esc($client['mobile'] ?? old('mobile')) ?>">
                        </div>

                        <div class="form-group">
                            <label>Fax:</label>
                            <input type="text" name="fax" class="form-control"
                                   maxlength="20"
                                   value="<?= esc($client['fax'] ?? old('fax')) ?>">
                        </div>

                        <div class="form-group">
                            <label>Email: <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" required
                                   maxlength="150"
                                   value="<?= esc($client['email'] ?? old('email')) ?>">
                        </div>

                        <div class="form-group">
                            <label>Site Web:</label>
                            <input type="text" name="site_web" class="form-control"
                                   maxlength="150"
                                   value="<?= esc($client['site_web'] ?? old('site_web')) ?>">
                        </div>

                        <div class="form-group">
                            <label>Personne contactée: <span class="text-danger">*</span></label>
                            <input type="text" name="personne_contactee" class="form-control" required
                                   maxlength="150"
                                   value="<?= esc($client['personne_contactee'] ?? old('personne_contactee')) ?>">
                        </div>

                        <div class="form-group">
                            <label>Remarque:</label>
                            <textarea name="remarque" class="form-control" rows="3"><?= esc($client['remarque'] ?? old('remarque')) ?></textarea>
                        </div>

                    </div>
                </div>

                <!-- BOUTON SUBMIT -->
                <div class="text-center m-t-30">
                    <button type="submit" class="btn btn-warning btn-lg px-5">
                        <i class="fa fa-save"></i>
                        <?= isset($client) ? 'Modifier' : 'Ajouter' ?>
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>