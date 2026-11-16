<!--
================================================
VIEW: Formulaire Salaire (salaire_form.php)
================================================
Rôle: Formulaire pour ajouter ou modifier un salaire
- Mode Ajout: $salaire = null
- Mode Modification: $salaire contient les données existantes
- Calcul automatique: Brut = Base + Prime
- Calcul automatique: Net = Brut - Déduction
- JavaScript pour calcul en temps réel
================================================
-->

<!-- Étend le layout principal "admin" -->
<?= $this->extend('layouts/admin') ?>

<!-- Début de la section "content" -->
<?= $this->section('content') ?>

<!-- ======================================== -->
<!-- MESSAGES DE NOTIFICATION -->
<!-- ======================================== -->

<!-- Message de succès -->
<?php if(session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <p><strong>✅ Succès</strong></p>
        <hr>
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="close" data-dismiss="alert">
            <span>&times;</span>
        </button>
    </div>
<?php endif; ?>

<!-- Message d'erreur -->
<?php if(session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <p><strong>❌ Erreur</strong></p>
        <hr>
        <?= session()->getFlashdata('error') ?>
        <button type="button" class="close" data-dismiss="alert">
            <span>&times;</span>
        </button>
    </div>
<?php endif; ?>

<!-- ======================================== -->
<!-- FORMULAIRE -->
<!-- ======================================== -->

<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="white-box">
            <!-- Titre dynamique selon le mode -->
            <h3 class="box-title m-b-30 text-center">
                <?= isset($salaire) ? '✏️ Modifier un Salaire' : '➕ Ajouter un Salaire' ?>
            </h3>
            
            <!-- Bouton retour vers la liste -->
            <div class="text-right m-b-20">
                <a href="<?= site_url('Salaire/salaire_list') ?>" class="btn btn-secondary">
                    <i class="fa fa-arrow-left"></i> Retour à la liste
                </a>
            </div>

            <!-- Formulaire -->
            <form method="post" 
                  action="<?= isset($salaire) 
                      ? site_url('Salaire/update/' . $salaire['id_salaire']) 
                      : site_url('Salaire/ajouter') ?>">
                
                <!-- Token CSRF pour la sécurité -->
                <?= csrf_field() ?>

                <!-- ======================================== -->
                <!-- COLONNE GAUCHE -->
                <!-- ======================================== -->
                <div class="row">
                    <div class="col-md-6">
                        
                        <!-- Employé (obligatoire) -->
                        <div class="form-group">
                            <label class="control-label">Employé: <span class="text-danger">*</span></label>
                            <!-- Liste déroulante des employés -->
                            <select name="id_employe" class="form-control" required>
                                <option value="">Choisir un employé</option>
                                <?php foreach ($employes as $e): ?>
                                    <option value="<?= $e['id_employe'] ?>" 
                                        <?= (isset($salaire) && $salaire['id_employe'] == $e['id_employe']) ? 'selected' : '' ?>>
                                        <?= esc($e['nom'] . ' ' . $e['prenom']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Mois (obligatoire) -->
                        <div class="form-group">
                            <label class="control-label">Mois: <span class="text-danger">*</span></label>
                            <!-- Type number avec min/max pour limiter à 1-12 -->
                            <input type="number" 
                                   name="mois" 
                                   class="form-control" 
                                   required 
                                   min="1" 
                                   max="12"
                                   placeholder="1 à 12"
                                   value="<?= $salaire['mois'] ?? '' ?>">
                        </div>

                        <!-- Année (obligatoire) -->
                        <div class="form-group">
                            <label class="control-label">Année: <span class="text-danger">*</span></label>
                            <input type="number" 
                                   name="annee" 
                                   class="form-control" 
                                   required
                                   placeholder="Ex: 2024"
                                   value="<?= $salaire['annee'] ?? date('Y') ?>">
                        </div>

                        <!-- Salaire de base (obligatoire) -->
                        <div class="form-group">
                            <label class="control-label">Salaire de base: <span class="text-danger">*</span></label>
                            <!-- id="salaire_base" : utilisé par JavaScript pour calcul auto -->
                            <input type="number" 
                                   step="0.001" 
                                   name="salaire_base" 
                                   id="salaire_base" 
                                   class="form-control" 
                                   required
                                   placeholder="0.000"
                                   value="<?= $salaire['salaire_base'] ?? '' ?>">
                        </div>

                        <!-- Prime -->
                        <div class="form-group">
                            <label class="control-label">Prime:</label>
                            <!-- id="prime" : utilisé par JavaScript pour calcul auto -->
                            <input type="number" 
                                   step="0.001" 
                                   name="prime" 
                                   id="prime" 
                                   class="form-control"
                                   placeholder="0.000"
                                   value="<?= $salaire['prime'] ?? '0' ?>">
                        </div>

                        <!-- Salaire brut (calculé automatiquement) -->
                        <div class="form-group">
                            <label class="control-label">Salaire brut: <span class="text-muted">(Auto)</span></label>
                            <!-- readonly : champ en lecture seule, calculé par JavaScript -->
                            <!-- id="salaire_brut" : utilisé par JavaScript -->
                            <input type="number" 
                                   step="0.001" 
                                   name="salaire_brut" 
                                   id="salaire_brut" 
                                   class="form-control bg-light" 
                                   readonly
                                   value="<?= $salaire['salaire_brut'] ?? '' ?>">
                            <small class="text-info">
                                <i class="fa fa-info-circle"></i> Calculé automatiquement: Base + Prime
                            </small>
                        </div>
                    </div>

                    <!-- ======================================== -->
                    <!-- COLONNE DROITE -->
                    <!-- ======================================== -->
                    <div class="col-md-6">

                        <!-- Déduction -->
                        <div class="form-group">
                            <label class="control-label">Déduction:</label>
                            <!-- id="deduction" : utilisé par JavaScript pour calcul auto -->
                            <input type="number" 
                                   step="0.001" 
                                   name="deduction" 
                                   id="deduction" 
                                   class="form-control"
                                   placeholder="0.000"
                                   value="<?= $salaire['deduction'] ?? '0' ?>">
                        </div>

                        <!-- Salaire net (calculé automatiquement) -->
                        <div class="form-group">
                            <label class="control-label">Salaire net: <span class="text-muted">(Auto)</span></label>
                            <!-- readonly : champ en lecture seule, calculé par JavaScript -->
                            <!-- id="salaire_net" : utilisé par JavaScript -->
                            <input type="number" 
                                   step="0.001" 
                                   name="salaire_net" 
                                   id="salaire_net" 
                                   class="form-control bg-light text-success" 
                                   readonly
                                   value="<?= $salaire['salaire_net'] ?? '' ?>">
                            <small class="text-info">
                                <i class="fa fa-info-circle"></i> Calculé automatiquement: Brut - Déduction
                            </small>
                        </div>

                        <!-- Mode de paiement (obligatoire) -->
                        <div class="form-group">
                            <label class="control-label">Mode de paiement: <span class="text-danger">*</span></label>
                            <select name="mode_paiement" class="form-control" required>
                                <option value="">Choisir</option>
                                <option value="virement" 
                                    <?= (isset($salaire) && $salaire['mode_paiement'] == 'virement') ? 'selected' : '' ?>>
                                    Virement
                                </option>
                                <option value="cash" 
                                    <?= (isset($salaire) && $salaire['mode_paiement'] == 'cash') ? 'selected' : '' ?>>
                                    Cash
                                </option>
                                <option value="cheque" 
                                    <?= (isset($salaire) && $salaire['mode_paiement'] == 'cheque') ? 'selected' : '' ?>>
                                    Chèque
                                </option>
                            </select>
                        </div>

                        <!-- Date de paiement -->
                        <div class="form-group">
                            <label class="control-label">Date de paiement:</label>
                            <input type="date" 
                                   name="date_paiement" 
                                   class="form-control" 
                                   value="<?= $salaire['date_paiement'] ?? '' ?>">
                        </div>

                        <!-- Remarque -->
                        <div class="form-group">
                            <label class="control-label">Remarque:</label>
                            <textarea name="remarque" 
                                      class="form-control" 
                                      rows="3"
                                      placeholder="Remarques ou notes supplémentaires..."><?= $salaire['remarque'] ?? '' ?></textarea>
                        </div>
                    </div>
                </div>

                <!-- ======================================== -->
                <!-- BOUTON SUBMIT -->
                <!-- ======================================== -->
                <div class="text-center m-t-30">
                    <button type="submit" class="btn btn-danger btn-lg px-5">
                        <i class="fa fa-save"></i> 
                        <?= isset($salaire) ? 'Modifier' : 'Ajouter' ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ======================================== -->
<!-- SCRIPT JAVASCRIPT - CALCUL AUTOMATIQUE -->
<!-- ======================================== -->
<script>
/**
 * ================================================
 * FONCTION: Calcul Automatique du Salaire
 * ================================================
 * Cette fonction est appelée à chaque modification
 * dans les champs: salaire_base, prime, ou deduction
 * 
 * Formules:
 * - Salaire Brut = Salaire Base + Prime
 * - Salaire Net = Salaire Brut - Déduction
 * ================================================
 */
function calculSalaire() {
    // Récupération de la valeur du salaire de base
    // parseFloat() : convertit la valeur en nombre décimal
    // || 0 : si le champ est vide, utilise 0 par défaut
    let base = parseFloat(document.getElementById('salaire_base').value) || 0;

    // Récupération de la prime (valeur par défaut = 0 si vide)
    let prime = parseFloat(document.getElementById('prime').value) || 0;

    // Récupération de la déduction (valeur par défaut = 0 si vide)
    let deduction = parseFloat(document.getElementById('deduction').value) || 0;

    // ========================================
    // CALCUL DU SALAIRE BRUT
    // ========================================
    // Formule: Salaire Brut = Salaire Base + Prime
    let brut = base + prime;

    // ========================================
    // CALCUL DU SALAIRE NET
    // ========================================
    // Formule: Salaire Net = Salaire Brut - Déduction
    let net = brut - deduction;

    // ========================================
    // AFFICHAGE DES RÉSULTATS
    // ========================================
    // Affichage automatique du résultat dans les champs correspondants
    // toFixed(3) : affiche 3 chiffres après la virgule (ex: 1250.000)
    document.getElementById('salaire_brut').value = brut.toFixed(3);
    document.getElementById('salaire_net').value = net.toFixed(3);
}

/**
 * ================================================
 * ÉVÉNEMENTS - DÉCLENCHEMENT DU CALCUL
 * ================================================
 * Ajout d'écouteurs d'événements (Event Listeners)
 * L'événement "input" déclenche la fonction à chaque modification
 * Résultat: Calcul en temps réel pendant la saisie
 * ================================================
 */

// Écouteur sur le champ "Salaire de base"
document.getElementById('salaire_base').addEventListener('input', calculSalaire);

// Écouteur sur le champ "Prime"
document.getElementById('prime').addEventListener('input', calculSalaire);

// Écouteur sur le champ "Déduction"
document.getElementById('deduction').addEventListener('input', calculSalaire);

/**
 * Calcul initial au chargement de la page
 * Utile en mode modification pour afficher les calculs existants
 */
window.addEventListener('DOMContentLoaded', function() {
    calculSalaire();
});
</script>

<!-- Fin de la section "content" -->
<?= $this->endSection() ?>