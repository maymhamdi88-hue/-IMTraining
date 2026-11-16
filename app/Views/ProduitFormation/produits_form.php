<!--
================================================
VIEW: Formulaire Produit Formation (produits_form.php)
CORRIGÉ: URLs → base_url('ProduitFormation/...')
================================================
-->

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
                <?= isset($produit) ? '✏️ Modifier un Produit Formation' : '➕ Ajouter un Produit Formation' ?>
            </h3>

            <div class="text-right m-b-20">
                <a href="<?= base_url('ProduitFormation/produits_list') ?>" class="btn btn-secondary">
                    <i class="fa fa-arrow-left"></i> Retour à la liste
                </a>
            </div>

            <form method="post"
                  action="<?= isset($produit)
                      ? base_url('ProduitFormation/produits_update/' . $produit['id_produit'])
                      : base_url('ProduitFormation/produits_store') ?>">

                <?= csrf_field() ?>

                <div class="row">
                    <!-- COLONNE GAUCHE -->
                    <div class="col-md-6">

                        <!-- Client -->
                        <div class="form-group">
                            <label>Client: <span class="text-danger">*</span></label>
                            <select name="id_client" class="form-control" required>
                                <option value="">Choisir</option>
                                <?php foreach ($clients as $c): ?>
                                    <option value="<?= $c['id_client'] ?>"
                                        <?= isset($produit) && $produit['id_client'] == $c['id_client'] ? 'selected' : '' ?>>
                                        <?= esc($c['nom_societe']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Prestation (Activité) -->
                        <div class="form-group">
                            <label>Prestation: <span class="text-danger">*</span></label>
                            <select name="id_activite" id="activiteSelect" class="form-control" required>
                                <option value="">Choisir</option>
                                <?php foreach ($activites as $a): ?>
                                    <option value="<?= $a['id_activite'] ?>"
                                        <?= isset($produit) && $produit['id_activite'] == $a['id_activite'] ? 'selected' : '' ?>
                                        data-type="<?= esc($a['type_activite']) ?>"
                                        data-theme="<?= esc($a['theme_domaine']) ?>"
                                        data-date="<?= esc($a['date_prestation']) ?>">
                                        <?= esc($a['reference']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Type prestation (auto-rempli) -->
                        <div class="form-group">
                            <label>Type prestation:</label>
                            <input type="text" name="type_activite" id="type_activite"
                                   class="form-control" readonly style="background-color:#e9ecef;"
                                   value="<?= esc($produit['type_activite'] ?? '') ?>">
                        </div>

                        <!-- Thème (auto-rempli) -->
                        <div class="form-group">
                            <label>Thème:</label>
                            <input type="text" name="theme_domaine" id="theme_domaine"
                                   class="form-control" readonly style="background-color:#e9ecef;"
                                   value="<?= esc($produit['theme_domaine'] ?? '') ?>">
                        </div>

                        <!-- Date prestation (auto-rempli) -->
                        <div class="form-group">
                            <label>Date prestation:</label>
                            <textarea  name="date_prestation" id="date_prestation"
                                   class="form-control" readonly style="background-color:#e9ecef;">
                                   <?= esc($produit['date_prestation'] ?? '') ?></textarea>
                        </div>

                        <!-- Formateur -->
                        <div class="form-group">
                            <label>Formateur:</label>
                            <select name="id_formateur" id="formateurSelect" class="form-control">
                                <option value="">Choisir</option>
                                <?php foreach ($formateurs as $f): ?>
                                    <option value="<?= $f['id_formateur'] ?>"
                                        <?= isset($produit) && $produit['id_formateur'] == $f['id_formateur'] ? 'selected' : '' ?>>
                                        <?= esc($f['nom_prenom']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Honoraire -->
                        <div class="form-group">
                            <label>Honoraire:</label>
                            <input type="number" step="0.001" name="honoraire" id="honoraire"
                                   class="form-control"
                                   value="<?= esc($produit['honoraire'] ?? '') ?>">
                        </div>

                        <!-- Montant unitaire -->
                        <div class="form-group">
                            <label>Montant unitaire: <span class="text-danger">*</span></label>
                            <input type="number" step="0.001" name="montant_unitaire" id="montant_unitaire"
                                   class="form-control" required
                                   value="<?= esc($produit['montant_unitaire'] ?? '') ?>">
                        </div>

                        <!-- Nombre heures par jour -->
                        <div class="form-group">
                            <label>Nombre heures/jour:</label>
                            <input type="number" name="nombre_heures_jour" id="nombre_heures_jour"
                                   class="form-control"
                                   value="<?= esc($produit['nombre_heures_jour'] ?? '') ?>">
                        </div>

                        <!-- Nombre jours -->
                        <div class="form-group">
                            <label>Nombre jours:</label>
                            <input type="number" name="nombre_jours" id="nombre_jours"
                                   class="form-control"
                                   value="<?= esc($produit['nombre_jours'] ?? '') ?>">
                        </div>

                        <!-- Taux TVA -->
                        <div class="form-group">
                            <label>Taux TVA (%): <span class="text-danger">*</span></label>
                            <input type="number" step="0.001" name="taux_tva" id="taux_tva"
                                   class="form-control" required
                                   value="<?= esc($produit['taux_tva'] ?? '') ?>">
                        </div>

                        <!-- Taux RAS -->
                        <div class="form-group">
                            <label>Taux RAS (%): <span class="text-danger">*</span></label>
                            <input type="number" step="0.001" name="taux_ras" id="taux_ras"
                                   class="form-control" required
                                   value="<?= esc($produit['taux_ras'] ?? '') ?>">
                        </div>

                        <!-- Mode de paiement -->
                        <div class="form-group">
                            <label>Mode de paiement:</label>
                            <select name="mode_paiement" class="form-control">
                                <option value="">Choisir</option>
                                <option value="virement" <?= isset($produit) && $produit['mode_paiement'] == 'virement' ? 'selected' : '' ?>>Virement</option>
                                <option value="cash"     <?= isset($produit) && $produit['mode_paiement'] == 'cash'     ? 'selected' : '' ?>>Cash</option>
                                <option value="cheque"   <?= isset($produit) && $produit['mode_paiement'] == 'cheque'   ? 'selected' : '' ?>>Chèque</option>
                            </select>
                        </div>
                    </div>

                    <!-- COLONNE DROITE -->
                    <div class="col-md-6">

                        <!-- MHTVA (auto-calculé) -->
                        <div class="form-group">
                            <label>MHTVA:</label>
                            <input type="number" step="0.001" name="mhtva" id="mhtva"
                                   class="form-control" readonly style="background-color:#e9ecef;"
                                   value="<?= esc($produit['mhtva'] ?? '') ?>">
                        </div>

                        <!-- TVA (auto-calculé) -->
                        <div class="form-group">
                            <label>TVA:</label>
                            <input type="number" step="0.001" name="tva" id="tva"
                                   class="form-control" readonly style="background-color:#e9ecef;"
                                   value="<?= esc($produit['tva'] ?? '') ?>">
                        </div>

                        <!-- MTTC (auto-calculé) -->
                        <div class="form-group">
                            <label>MTTC:</label>
                            <input type="number" step="0.001" name="mttc" id="mttc"
                                   class="form-control" readonly style="background-color:#e9ecef;"
                                   value="<?= esc($produit['mttc'] ?? '') ?>">
                        </div>

                        <!-- RAS (auto-calculé) -->
                        <div class="form-group">
                            <label>RAS:</label>
                            <input type="number" step="0.001" name="ras" id="ras"
                                   class="form-control" readonly style="background-color:#e9ecef;"
                                   value="<?= esc($produit['ras'] ?? '') ?>">
                        </div>

                        <!-- Montant Net (auto-calculé) -->
                        <div class="form-group">
                            <label><strong>Montant Net:</strong></label>
                            <input type="number" step="0.001" name="montant_net" id="montant_net"
                                   class="form-control" readonly
                                   style="background-color:#fff3cd; font-weight:bold;"
                                   value="<?= esc($produit['montant_net'] ?? '') ?>">
                        </div>

                        <hr>

                        <!-- Numéro d'action -->
                        <div class="form-group">
                            <label>Numéro d'action:</label>
                            <input type="text" name="numero_action" class="form-control"
                                   value="<?= esc($produit['numero_action'] ?? '') ?>">
                        </div>

                        <!-- Numéro de facture -->
                        <div class="form-group">
                            <label>Numéro de facture:</label>
                            <input type="text" name="numero_facture" class="form-control"
                                   value="<?= esc($produit['numero_facture'] ?? '') ?>">
                        </div>

                        <!-- Date facture -->
                        <div class="form-group">
                            <label>Date facture:</label>
                            <input type="date" name="date_facture" class="form-control"
                                   value="<?= esc($produit['date_facture'] ?? '') ?>">
                        </div>

                        <!-- Date Réglement (→ date_entree en BD) -->
                        <div class="form-group">
                            <label>Date Réglement:</label>
                            <input type="date" name="date_reglement" class="form-control"
                                   value="<?= esc($produit['date_entree'] ?? '') ?>">
                        </div>

                        <!-- Date Réglement Formateur (→ date_sortie en BD) -->
                        <div class="form-group">
                            <label>Date Réglement Formateur:</label>
                            <input type="date" name="date_sortie" class="form-control"
                                   value="<?= esc($produit['date_sortie'] ?? '') ?>">
                        </div>

                        <!-- Date certificat RAS -->
                        <div class="form-group">
                            <label>Date certificat RAS:</label>
                            <input type="date" name="date_certificat_ras" class="form-control"
                                   value="<?= esc($produit['date_certificat_ras'] ?? '') ?>">
                        </div>

                        <!-- Mois déclaration -->
                        <div class="form-group">
                            <label>Mois déclaration:</label>
                            <input type="text" name="mois_declaration" class="form-control"
                                   value="<?= esc($produit['mois_declaration'] ?? '') ?>">
                        </div>

                        <!-- Remarque -->
                        <div class="form-group">
                            <label>Remarque:</label>
                            <textarea name="remarque" class="form-control" rows="3"><?= esc($produit['remarque'] ?? '') ?></textarea>
                        </div>
                    </div>
                </div>

                <!-- BOUTON SUBMIT -->
                <div class="text-center m-t-30">
                    <button type="submit" class="btn btn-danger btn-lg px-5">
                        <i class="fa fa-save"></i>
                        <?= isset($produit) ? 'Modifier' : 'Ajouter' ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- SCRIPTS -->
<script>
// Auto-remplissage depuis Activité
document.getElementById("activiteSelect").addEventListener("change", function() {
    let sel = this.options[this.selectedIndex];
    document.getElementById("type_activite").value    = sel.getAttribute("data-type")  || '';
    document.getElementById("theme_domaine").value    = sel.getAttribute("data-theme") || '';
    document.getElementById("date_prestation").value  = sel.getAttribute("data-date")  || '';
    calculerMontants(); // recalculer après changement type
});

// Auto-remplissage depuis Formateur
document.getElementById("formateurSelect").addEventListener("change", function() {
    let sel = this.options[this.selectedIndex];
    document.getElementById("honoraire").value = sel.getAttribute("data-honoraire") || '';
});

// Calcul automatique des montants
function calculerMontants() {
    let jours    = parseFloat(document.getElementById("nombre_jours").value)        || 0;
    let prix     = parseFloat(document.getElementById("montant_unitaire").value)    || 0;
    let tauxTVA  = parseFloat(document.getElementById("taux_tva").value)            || 0;
    let tauxRAS  = parseFloat(document.getElementById("taux_ras").value)            || 0;
    let typeForm = document.getElementById("type_activite").value;

    let mhtva = jours * prix;
    let tva   = mhtva * tauxTVA / 100;
    let mttc  = mhtva + tva;
    let ras   = 0;
    let net   = 0;

    if (typeForm === "DROIT DE TIRAGE") {
        ras = mhtva * tauxRAS / 100;
        net = mhtva - ras;
    } else {
        ras = mttc * tauxRAS / 100;
        net = mttc - ras;
    }

    document.getElementById("mhtva").value       = mhtva.toFixed(3);
    document.getElementById("tva").value         = tva.toFixed(3);
    document.getElementById("mttc").value        = mttc.toFixed(3);
    document.getElementById("ras").value         = ras.toFixed(3);
    document.getElementById("montant_net").value = net.toFixed(3);
}

document.querySelectorAll("#nombre_jours, #montant_unitaire, #taux_tva, #taux_ras")
    .forEach(el => el.addEventListener("input", calculerMontants));

window.addEventListener("load", calculerMontants);
</script>

<?= $this->endSection() ?>