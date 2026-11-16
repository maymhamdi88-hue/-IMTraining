<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="row">
    <div class="col-md-12">
        <div class="page-title-box">
            <h4 class="page-title">📊 <?= esc($title) ?></h4>
            <ol class="breadcrumb">
                <li><a href="<?= site_url('dashboard') ?>">Accueil</a></li>
                <li><a href="<?= site_url('declaration') ?>"><?= esc($title) ?></a></li>
                <li class="active"><?= isset($declaration) ? 'Modifier' : 'Ajouter' ?></li>
            </ol>
        </div>
    </div>
</div>

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

            <div class="d-flex justify-content-between align-items-center m-b-20">
                <h3 class="box-title m-b-0">
                    <?= isset($declaration) ? '✏️ Modifier' : '➕ Ajouter' ?> — <?= esc($title) ?>
                </h3>
                <a href="<?= site_url('declaration') ?>" class="btn btn-secondary">
                    <i class="fa fa-arrow-left"></i> Retour
                </a>
            </div>

            <form method="post"
                  action="<?= isset($declaration)
                      ? site_url('declaration/update/' . $declaration['id_declaration'])
                      : site_url('declaration/store') ?>">
                <?= csrf_field() ?>

                <!-- ══════════════════════════════════════════════
                     CHARGES — TVA Déductible
                ══════════════════════════════════════════════ -->
                <div class="panel panel-info m-b-20">
                    <div class="panel-heading">
                        <h4 class="panel-title" style="margin:0;">
                            🧾 Charges / Dépenses
                            <small class="text-white">— TVA Déductible = Σ TVA des charges cochées</small>
                        </h4>
                    </div>
                    <div class="panel-body">
                        <?php if (!empty($charges)): ?>
                        <div class="table-responsive" style="max-height:250px; overflow-y:auto;">
                            <table class="table table-bordered table-sm table-hover" style="font-size:11px;">
                                <thead class="bg-info text-white">
                                    <tr>
                                        <th style="width:35px;" class="text-center">✓</th>
                                        <th>Type</th>
                                        <th>Date</th>
                                        <th>Fournisseur</th>
                                        <th>Désignation</th>
                                        <th class="text-right">HTVA</th>
                                        <th class="text-right">TVA</th>
                                        <th class="text-right">TTC</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($charges as $ch): ?>
                                    <tr class="charge-row"
                                        data-ttc="<?= (float)$ch['montant_tva'] ?>"
                                        style="cursor:pointer;">
                                        <td class="text-center">
                                            <input type="checkbox"
                                                   name="id_charges[]"
                                                   value="<?= $ch['id_charge'] ?>"
                                                   class="chk-charge"
                                                   <?= in_array($ch['id_charge'], $sel_charges) ? 'checked' : '' ?>>
                                        </td>
                                        <td><?= esc($ch['type_charge']) ?></td>
                                        <td><?= date('d/m/Y', strtotime($ch['date_charge'])) ?></td>
                                        <td><?= esc($ch['fournisseur'] ?? '—') ?></td>
                                        <td><?= esc(mb_strimwidth($ch['designation'] ?? '', 0, 40, '…')) ?></td>
                                        <td class="text-right"><?= number_format((float)$ch['montant_htva'], 3, ',', ' ') ?></td>
                                        <td class="text-right"><?= number_format((float)$ch['montant_tva'],  3, ',', ' ') ?></td>
                                        <td class="text-right">
                                            <strong class="text-info">
                                                <?= number_format((float)$ch['montant_ttc'], 3, ',', ' ') ?>
                                            </strong>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <?php else: ?>
                            <p class="text-muted text-center"><em>Aucune charge disponible.</em></p>
                        <?php endif; ?>

                        <div class="m-t-10 p-10" style="background:#e8f4f8; border-radius:4px;">
                            <strong>💰 TVA Déductible :
                                <span id="lbl_tva_deductible" class="text-info" style="font-size:15px;">0,000</span> TND
                            </strong>
                        </div>
                        <input type="hidden" name="tva_deductible" id="tva_deductible" value="0">
                    </div>
                </div>

                <!-- ══════════════════════════════════════════════
                     PRODUITS — TVA Collectée
                ══════════════════════════════════════════════ -->
                <div class="panel panel-success m-b-20">
                    <div class="panel-heading">
                        <h4 class="panel-title" style="margin:0;">
                            📦 Factures / Produits
                            <small class="text-white">— TVA Collectée = Σ TVA des factures cochées | TCL = Σ MTTC × 0.2%</small>
                        </h4>
                    </div>
                    <div class="panel-body">
                        <?php if (!empty($produits)): ?>
                        <div class="table-responsive" style="max-height:250px; overflow-y:auto;">
                            <table class="table table-bordered table-sm table-hover" style="font-size:11px;">
                                <thead class="bg-success text-white">
                                    <tr>
                                        <th style="width:35px;" class="text-center">✓</th>
                                        <th>N° Facture</th>
                                        <th>Date</th>
                                        <th class="text-right">MHTVA</th>
                                        <th class="text-center">TVA %</th>
                                        <th class="text-right">TVA</th>
                                        <th class="text-right">MTTC</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($produits as $pr): ?>
                                    <tr class="produit-row"
                                        data-tva="<?= (float)$pr['tva'] ?>"
                                        data-mttc="<?= (float)$pr['mttc'] ?>"
                                        style="cursor:pointer;">
                                        <td class="text-center">
                                            <input type="checkbox"
                                                   name="id_produits[]"
                                                   value="<?= $pr['id_produit'] ?>"
                                                   class="chk-produit"
                                                   <?= in_array($pr['id_produit'], $sel_produits) ? 'checked' : '' ?>>
                                        </td>
                                        <td><?= esc($pr['numero_facture'] ?? '—') ?></td>
                                        <td><?= $pr['date_facture'] ? date('d/m/Y', strtotime($pr['date_facture'])) : '—' ?></td>
                                        <td class="text-right"><?= number_format((float)$pr['mhtva'],     3, ',', ' ') ?></td>
                                        <td class="text-center"><?= number_format((float)$pr['taux_tva'], 2, ',', ' ') ?>%</td>
                                        <td class="text-right"><?= number_format((float)$pr['tva'],       3, ',', ' ') ?></td>
                                        <td class="text-right">
                                            <strong class="text-success">
                                                <?= number_format((float)$pr['mttc'], 3, ',', ' ') ?>
                                            </strong>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <?php else: ?>
                            <p class="text-muted text-center"><em>Aucun produit disponible.</em></p>
                        <?php endif; ?>

                        <div class="m-t-10 p-10" style="background:#eafaf1; border-radius:4px;">
                            <strong>💰 TVA Collectée :
                                <span id="lbl_tva_collectee" class="text-success" style="font-size:15px;">0,000</span> TND
                            </strong>
                        </div>
                        <input type="hidden" name="tva_collectee" id="tva_collectee" value="0">
                    </div>
                </div>

                <!-- ══════════════════════════════════════════════
                     FORMULAIRE PRINCIPAL
                ══════════════════════════════════════════════ -->
                <div class="row">

                    <!-- Colonne Gauche -->
                    <div class="col-md-6">
                        <h5 class="text-primary"><i class="fa fa-calendar"></i> Période</h5>
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label>Mois <span class="text-danger">*</span></label>
                                    <input type="number" name="mois" id="mois" class="form-control"
                                           required min="1" max="12" placeholder="1 → 12"
                                           value="<?= isset($declaration) ? $declaration['mois'] : '' ?>">
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label>Année <span class="text-danger">*</span></label>
                                    <input type="number" name="annee" id="annee" class="form-control"
                                           required min="2000" max="2099"
                                           placeholder="ex: 2026"
                                           value="<?= isset($declaration) ? $declaration['annee'] : '' ?>">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <button type="button" id="btn_load_report" class="btn btn-info btn-block"
                                            title="Charger le report du mois précédent"
                                            style="padding:6px 8px;">
                                        <i class="fa fa-refresh"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <hr>
                        <h5 class="text-primary"><i class="fa fa-calculator"></i> Bases & Retenues</h5>

                        <?php
                        $lignes = [
                            ['salaire',   'Salaire',   false],
                            ['comptable', 'Comptable', true],
                            ['formateur', 'Formateur', true],
                            ['loyer',     'Loyer',     true],
                        ];
                        foreach ($lignes as [$key, $label, $autoCalc]):
                        ?>
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label>Base <?= $label ?> <span class="text-danger">*</span></label>
                                    <input type="number" step="0.001"
                                           name="base_<?= $key ?>" id="base_<?= $key ?>"
                                           class="form-control base-input"
                                           value="<?= $declaration['base_'.$key] ?? '0' ?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Taux %</label>
                                    <input type="number" step="0.01"
                                           name="taux_<?= $key ?>" id="taux_<?= $key ?>"
                                           class="form-control taux-input"
                                           value="<?= $declaration['taux_'.$key] ?? '0' ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>
                                        RS <?= $label ?>
                                        <?php if (!$autoCalc): ?>
                                            <span class="label label-warning" style="font-size:9px;">MANUEL</span>
                                        <?php else: ?>
                                            <span class="label label-default" style="font-size:9px;">AUTO</span>
                                        <?php endif; ?>
                                    </label>
                                    <input type="number" step="0.001"
                                           name="rs_<?= $key ?>" id="rs_<?= $key ?>"
                                           class="form-control"
                                           <?= $autoCalc ? 'readonly style="background:#f2dede;"' : 'style="background:#fff9e6; border:2px solid #f0ad4e; font-weight:bold;"' ?>
                                           value="<?= $declaration['rs_'.$key] ?? '0' ?>">
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>

                        <hr>
                        <div class="form-group">
                            <label><strong>Total Base (auto)</strong></label>
                            <input type="number" step="0.001" name="total_base" id="total_base"
                                   class="form-control" readonly
                                   style="background:#d9edf7; font-weight:bold;"
                                   value="<?= $declaration['total_base'] ?? '0' ?>">
                        </div>
                        <div class="form-group">
                            <label><strong>Total Retenue (auto)</strong></label>
                            <input type="number" step="0.001" name="total_retenue" id="total_retenue"
                                   class="form-control" readonly
                                   style="background:#f2dede; font-weight:bold;"
                                   value="<?= $declaration['total_retenue'] ?? '0' ?>">
                        </div>
                    </div>

                    <!-- Colonne Droite -->
                    <div class="col-md-6">
                        <h5 class="text-primary"><i class="fa fa-university"></i> TFP & FORPROLOS</h5>
                        <div class="form-group">
                            <label>TFP — 1% base salaire (auto)</label>
                            <input type="number" step="0.001" name="tfp" id="tfp"
                                   class="form-control" readonly style="background:#d9edf7;"
                                   value="<?= $declaration['tfp'] ?? '0' ?>">
                        </div>
                        <div class="form-group">
                            <label>FORPROLOS — 2% base salaire (auto)</label>
                            <input type="number" step="0.001" name="forprolos" id="forprolos"
                                   class="form-control" readonly style="background:#d9edf7;"
                                   value="<?= $declaration['forprolos'] ?? '0' ?>">
                        </div>

                        <hr>
                        <h5 class="text-success"><i class="fa fa-percent"></i> TVA</h5>
                        <div class="form-group">
                            <label>TVA Déductible (auto)</label>
                            <input type="number" step="0.001" id="display_tva_deductible"
                                   class="form-control" readonly style="background:#dff0d8; font-weight:bold;"
                                   value="<?= $declaration['tva_deductible'] ?? '0' ?>">
                        </div>
                        <div class="form-group">
                            <label>TVA Collectée (auto)</label>
                            <input type="number" step="0.001" id="display_tva_collectee"
                                   class="form-control" readonly style="background:#dff0d8; font-weight:bold;"
                                   value="<?= $declaration['tva_collectee'] ?? '0' ?>">
                        </div>

                        <!-- REPORT MOIS PRÉCÉDENT -->
                        <div class="form-group">
                            <label>
                                <i class="fa fa-history text-info"></i>
                                Report TVA — Mois précédent (auto)
                            </label>
                            <?php if (!empty($report_auto) && !$report_auto['zero']): ?>
                                <div id="report_auto_alert" class="alert alert-info p-5 m-b-5" style="font-size:11px;">
                                    📥 Report de <strong><?= esc($report_auto['periode']) ?></strong> :
                                    <strong class="text-primary"><?= number_format((float)$report_auto['valeur'], 3, ',', ' ') ?> TND</strong>
                                    — inclus automatiquement dans le calcul.
                                </div>
                            <?php elseif (!empty($report_auto) && $report_auto['zero']): ?>
                                <div id="report_auto_alert" class="alert alert-light p-5 m-b-5" style="font-size:11px; background:#f8f9fa;">
                                    ℹ️ Aucun report du mois précédent
                                    (<strong><?= esc($report_auto['periode']) ?></strong> = 0,000 TND).
                                </div>
                            <?php else: ?>
                                <div id="report_auto_alert" class="alert alert-light p-5 m-b-5" style="font-size:11px; background:#f8f9fa;">
                                    ℹ️ Saisissez le mois et l'année pour charger le report automatiquement.
                                </div>
                            <?php endif; ?>
                            <input type="hidden" id="report_auto_val"
                                   value="<?= !empty($report_auto) ? (float)$report_auto['valeur'] : '0' ?>">
                        </div>

                        <!-- REPORT MOIS COURANT -->
                        <div class="form-group">
                            <label>
                                <i class="fa fa-pencil text-warning"></i>
                                Report TVA — Mois courant
                                <span class="label label-warning" style="font-size:9px;">MANUEL</span>
                            </label>
                            <div class="input-group">
                                <input type="number" step="0.001" name="report" id="report"
                                       class="form-control"
                                       style="background:#fff9e6; border:2px solid #f0ad4e;"
                                       placeholder="0.000 — sera reporté au mois prochain"
                                       value="<?= isset($declaration) ? ($declaration['report'] ?? '0') : '0' ?>">
                                <span class="input-group-addon" style="background:#fff3cd;">TND</span>
                            </div>
                            <small class="text-muted">
                                💡 Ce montant sera automatiquement repris dans la déclaration du mois prochain.
                            </small>
                        </div>

                        <div class="form-group">
                            <label><strong>TVA Finale = Collectée − Déductible + Report précédent (auto)</strong></label>
                            <input type="number" step="0.001" name="tva_final" id="tva_final"
                                   class="form-control" readonly
                                   style="background:#dff0d8; font-weight:bold; font-size:14px;"
                                   value="<?= $declaration['tva_final'] ?? '0' ?>">
                        </div>
                        <div class="form-group">
                            <label>TCL — 0.2% Σ MTTC des factures cochées (auto)</label>
                            <input type="number" step="0.001" name="tcl" id="tcl"
                                   class="form-control" readonly style="background:#d9edf7;"
                                   value="<?= $declaration['tcl'] ?? '0' ?>">
                        </div>

                        <hr>
                        <div class="form-group">
                            <label><strong style="font-size:15px;">💵 TOTAL À PAYER (auto)</strong></label>
                            <input type="number" step="0.001" name="total_a_payer" id="total_a_payer"
                                   class="form-control" readonly
                                   style="background:#fff3cd; font-weight:bold; font-size:20px; color:#d9534f;"
                                   value="<?= $declaration['total_a_payer'] ?? '0' ?>">
                        </div>
                    </div>
                </div>

                <!-- SUBMIT -->
                <div class="text-center m-t-30 m-b-20">
                    <button type="submit" class="btn btn-danger btn-lg" style="min-width:220px;">
                        <i class="fa fa-save"></i>
                        <?= isset($declaration) ? ' Modifier' : ' Enregistrer' ?>
                    </button>
                    <a href="<?= site_url('declaration') ?>" class="btn btn-default btn-lg m-l-10">
                        Annuler
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
// ── Variable globale : somme MTTC des produits cochés (pour TCL) ──
let _totalMttcProduits = 0;

// ── TVA Déductible ──────────────────────────────
function calcTvaDeductible() {
    let total = 0;
    document.querySelectorAll('.chk-charge:checked').forEach(chk => {
        total += parseFloat(chk.closest('tr').dataset.ttc) || 0;
    });
    total = parseFloat(total.toFixed(3));
    document.getElementById('tva_deductible').value          = total;
    document.getElementById('display_tva_deductible').value  = total.toFixed(3);
    document.getElementById('lbl_tva_deductible').textContent = total.toFixed(3).replace('.', ',');
    return total;
}

// ── TVA Collectée ───────────────────────────────
// data-tva  = montant TVA de la facture  → TVA Collectée
// data-mttc = montant TTC de la facture  → base TCL (0.2%)
function calcTvaCollectee() {
    let totalTva  = 0;
    let totalMttc = 0;
    document.querySelectorAll('.chk-produit:checked').forEach(chk => {
        totalTva  += parseFloat(chk.closest('tr').dataset.tva)  || 0;
        totalMttc += parseFloat(chk.closest('tr').dataset.mttc) || 0;
    });
    totalTva  = parseFloat(totalTva.toFixed(3));
    totalMttc = parseFloat(totalMttc.toFixed(3));

    document.getElementById('tva_collectee').value           = totalTva;
    document.getElementById('display_tva_collectee').value   = totalTva.toFixed(3);
    document.getElementById('lbl_tva_collectee').textContent  = totalTva.toFixed(3).replace('.', ',');

    // Stocker la somme MTTC pour que calc() puisse calculer TCL
    _totalMttcProduits = totalMttc;

    return totalTva;
}

// ── Calcul général ──────────────────────────────
function calc() {
    const bS = parseFloat(document.getElementById('base_salaire').value)   || 0;
    const bC = parseFloat(document.getElementById('base_comptable').value) || 0;
    const bF = parseFloat(document.getElementById('base_formateur').value) || 0;
    const bL = parseFloat(document.getElementById('base_loyer').value)     || 0;
    document.getElementById('total_base').value = (bS + bC + bF + bL).toFixed(3);

    const tC = parseFloat(document.getElementById('taux_comptable').value) || 0;
    const tF = parseFloat(document.getElementById('taux_formateur').value) || 0;
    const tL = parseFloat(document.getElementById('taux_loyer').value)     || 0;

    const rsS = parseFloat(document.getElementById('rs_salaire').value) || 0; // MANUEL
    const rsC = bC * tC / 100;
    const rsF = bF * tF / 100;
    const rsL = bL * tL / 100;

    document.getElementById('rs_comptable').value = rsC.toFixed(3);
    document.getElementById('rs_formateur').value = rsF.toFixed(3);
    document.getElementById('rs_loyer').value     = rsL.toFixed(3);

    const totalRetenue = rsS + rsC + rsF + rsL;
    document.getElementById('total_retenue').value = totalRetenue.toFixed(3);

    const tfp       = bS * 0.01;
    const forprolos = bS * 0.02;
    document.getElementById('tfp').value       = tfp.toFixed(3);
    document.getElementById('forprolos').value = forprolos.toFixed(3);

    const tvaD    = parseFloat(document.getElementById('tva_deductible').value)  || 0;
    const tvaC    = parseFloat(document.getElementById('tva_collectee').value)   || 0;
    const repAuto = parseFloat(document.getElementById('report_auto_val').value) || 0;
    const tvaF    = tvaC - tvaD + repAuto;

    // TCL = 0.2% × Σ MTTC des factures cochées (et non sur TVA Collectée)
    const tcl = _totalMttcProduits * 0.002;

    const elTvaF = document.getElementById('tva_final');
    elTvaF.value       = tvaF.toFixed(3);
    elTvaF.style.color = tvaF < 0 ? '#d9534f' : '#5cb85c';
    document.getElementById('tcl').value = tcl.toFixed(3);

    const total = totalRetenue + tfp + forprolos + Math.max(0, tvaF) + tcl;
    document.getElementById('total_a_payer').value = total.toFixed(3);
}

// ── AJAX : fetch report ────────────────────────
function doFetchReport(mois, annee) {
    const alertDiv = document.getElementById('report_auto_alert');
    alertDiv.className = 'alert alert-warning p-5 m-b-5';
    alertDiv.style.cssText = 'font-size:11px;';
    alertDiv.innerHTML = '⏳ Chargement...';

    fetch(`<?= site_url('declaration/getReport') ?>?mois=${mois}&annee=${annee}`)
        .then(r => r.json())
        .then(data => {
            document.getElementById('report_auto_val').value = data.report;
            if (data.found && data.report > 0) {
                alertDiv.className = 'alert alert-info p-5 m-b-5';
                alertDiv.style.cssText = 'font-size:11px;';
                alertDiv.innerHTML = `📥 Report de <strong>${data.periode}</strong> : <strong class="text-primary">${parseFloat(data.report).toFixed(3).replace('.', ',')} TND</strong> — inclus automatiquement dans le calcul.`;
            } else {
                alertDiv.className = 'alert p-5 m-b-5';
                alertDiv.style.cssText = 'font-size:11px; background:#f8f9fa;';
                alertDiv.innerHTML = `ℹ️ Aucun report du mois précédent (${data.periode} = 0,000 TND).`;
            }
            calc();
        })
        .catch(() => {
            alertDiv.className = 'alert alert-danger p-5 m-b-5';
            alertDiv.innerHTML = '❌ Erreur lors du chargement du report.';
        });
}

// ── AJAX : report auto avec timer anti-spam ────
let fetchTimer = null;
function fetchReportAuto() {
    clearTimeout(fetchTimer);
    fetchTimer = setTimeout(() => {
        const mois  = document.getElementById('mois').value;
        const annee = document.getElementById('annee').value;
        if (!mois  || parseInt(mois)  < 1   || parseInt(mois)  > 12)  return;
        if (!annee || annee.length    < 4   || parseInt(annee) < 2000) return;
        doFetchReport(mois, annee);
    }, 600);
}

// ── Événements ──────────────────────────────────
document.querySelectorAll('.chk-charge').forEach(chk =>
    chk.addEventListener('change', () => { calcTvaDeductible(); calc(); }));

document.querySelectorAll('.charge-row').forEach(row =>
    row.addEventListener('click', e => {
        if (e.target.type !== 'checkbox') {
            const chk = row.querySelector('.chk-charge');
            chk.checked = !chk.checked;
            calcTvaDeductible(); calc();
        }
    }));

document.querySelectorAll('.chk-produit').forEach(chk =>
    chk.addEventListener('change', () => { calcTvaCollectee(); calc(); }));

document.querySelectorAll('.produit-row').forEach(row =>
    row.addEventListener('click', e => {
        if (e.target.type !== 'checkbox') {
            const chk = row.querySelector('.chk-produit');
            chk.checked = !chk.checked;
            calcTvaCollectee(); calc();
        }
    }));

['base_salaire','taux_salaire','rs_salaire','base_comptable','base_formateur','base_loyer',
 'taux_comptable','taux_formateur','taux_loyer'
].forEach(id => {
    const el = document.getElementById(id);
    if (el) el.addEventListener('input', calc);
});

document.getElementById('mois').addEventListener('blur',   fetchReportAuto);
document.getElementById('mois').addEventListener('change', fetchReportAuto);
document.getElementById('annee').addEventListener('blur',  fetchReportAuto);
document.getElementById('annee').addEventListener('change',fetchReportAuto);

// Bouton 🔄 — force le fetch immédiat
document.getElementById('btn_load_report').addEventListener('click', function() {
    clearTimeout(fetchTimer);
    const mois  = document.getElementById('mois').value;
    const annee = document.getElementById('annee').value;
    if (!mois || parseInt(mois) < 1 || parseInt(mois) > 12) {
        alert('Veuillez saisir un mois valide (1 → 12)');
        return;
    }
    if (!annee || annee.length < 4 || parseInt(annee) < 2000) {
        alert('Veuillez saisir une année valide (ex: 2026)');
        return;
    }
    doFetchReport(mois, annee);
});

// ── Init au chargement ──────────────────────────
window.addEventListener('load', () => {
    calcTvaDeductible();
    calcTvaCollectee(); // initialise aussi _totalMttcProduits
    const mois  = document.getElementById('mois').value;
    const annee = document.getElementById('annee').value;
    if (mois && parseInt(mois) >= 1 && parseInt(mois) <= 12 &&
        annee && annee.length >= 4 && parseInt(annee) >= 2000) {
        fetchReportAuto();
    } else {
        calc();
    }
});
</script>

<?= $this->endSection() ?>