<!--
================================================
VIEW: Liste des Salaires (salaire_list.php)
================================================
Rôle: Afficher le tableau des salaires avec actions
- Bouton Ajouter → redirige vers formulaire
- Bouton Modifier → redirige vers formulaire pré-rempli
- Bouton Supprimer → supprime le salaire
- Bouton Export PDF → génère PDF de tous les salaires
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
        <p><strong>✅ Mise à jour</strong></p>
        <hr>
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>

<!-- Message d'erreur -->
<?php if(session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <p><strong>❌ Erreur</strong></p>
        <hr>
        <?= session()->getFlashdata('error') ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>

<!-- ======================================== -->
<!-- EN-TÊTE DE LA PAGE -->
<!-- ======================================== -->

<div class="row">
    <div class="col-md-12">
        <div class="white-box">
            <!-- Titre de la page -->
            <h3 class="box-title">💰 Liste des Salaires</h3>
            
            <!-- Barre d'actions -->
            <div class="text-right m-b-20">
                <!-- Bouton Ajouter → redirige vers le formulaire d'ajout -->
                <a href="<?= site_url('Salaire/ajouter_form') ?>" class="btn btn-success">
                    <i class="fa fa-plus"></i> Ajouter un Salaire
                </a>
                
                <!-- Bouton Export PDF → génère le PDF de tous les salaires -->
                <a href="<?= site_url('Salaire/export_pdf') ?>" class="btn btn-danger" target="_blank">
                    <i class="fa fa-file-pdf-o"></i> Exporter en PDF
                </a>
            </div>

            <!-- ======================================== -->
            <!-- TABLEAU DES SALAIRES -->
            <!-- ======================================== -->
            
            <!-- Tableau Bootstrap avec bordures et lignes alternées -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <!-- En-tête du tableau (noms des colonnes) -->
                    <thead class="bg-success text-white">
                        <tr>
                            <th>#</th>                    <!-- Numéro de ligne -->
                            <th>Employé</th>              <!-- Nom de l'employé -->
                            <th>Mois</th>                 <!-- Mois -->
                            <th>Année</th>                <!-- Année -->
                            <th>Salaire base</th>         <!-- Salaire de base -->
                            <th>Prime</th>                <!-- Prime -->
                            <th>Salaire brut</th>         <!-- Salaire brut -->
                            <th>Déduction</th>            <!-- Déduction -->
                            <th>Salaire net</th>          <!-- Salaire net -->
                            <th>Mode paiement</th>        <!-- Mode de paiement -->
                            <th>Date paiement</th>        <!-- Date de paiement -->
                            <th>Remarque</th>             <!-- Remarque -->
                            <th>Actions</th>              <!-- Boutons d'actions -->
                        </tr>
                    </thead>
                    
                    <!-- Corps du tableau: données des salaires -->
                    <tbody>
                        <!-- Vérifie si la liste n'est pas vide -->
                        <?php if (!empty($salaires)): ?>
                            <!-- Boucle foreach pour parcourir la liste des salaires -->
                            <?php $num = 1; // Compteur pour numéroter les lignes ?>
                            <?php foreach ($salaires as $s): ?>
                                <tr>
                                    <!-- Numéro de ligne -->
                                    <td><?= $num++ ?></td>
                                    
                                    <!-- Nom de l'employé -->
                                    <!-- Utilise $employesMap pour afficher le nom au lieu de l'ID -->
                                    <td>
                                        <strong><?= esc($employesMap[$s['id_employe']] ?? '—') ?></strong>
                                    </td>
                                    
                                    <!-- Mois -->
                                    <td class="text-center">
                                        <?php
                                        // Tableau des noms de mois en français
                                        $mois_fr = [
                                            1 => 'Janvier', 2 => 'Février', 3 => 'Mars',
                                            4 => 'Avril', 5 => 'Mai', 6 => 'Juin',
                                            7 => 'Juillet', 8 => 'Août', 9 => 'Septembre',
                                            10 => 'Octobre', 11 => 'Novembre', 12 => 'Décembre'
                                        ];
                                        echo $mois_fr[$s['mois']] ?? $s['mois'];
                                        ?>
                                    </td>
                                    
                                    <!-- Année -->
                                    <td class="text-center"><?= esc($s['annee']) ?></td>
                                    
                                    <!-- Salaire de base -->
                                    <td class="text-right">
                                        <?= number_format($s['salaire_base'], 3) ?> DT
                                    </td>
                                    
                                    <!-- Prime -->
                                    <td class="text-right">
                                        <?= number_format($s['prime'] ?? 0, 3) ?> DT
                                    </td>
                                    
                                    <!-- Salaire brut -->
                                    <td class="text-right">
                                        <strong><?= number_format($s['salaire_brut'], 3) ?> DT</strong>
                                    </td>
                                    
                                    <!-- Déduction -->
                                    <td class="text-right text-danger">
                                        <?= number_format($s['deduction'] ?? 0, 3) ?> DT
                                    </td>
                                    
                                    <!-- Salaire net (en gras et couleur verte) -->
                                    <td class="text-right text-success">
                                        <strong><?= number_format($s['salaire_net'], 3) ?> DT</strong>
                                    </td>
                                    
                                    <!-- Mode de paiement avec badge -->
                                    <td>
                                        <?php
                                        // Attribution d'une couleur selon le mode
                                        $mode_badge = 'badge-primary';
                                        if ($s['mode_paiement'] == 'cash') {
                                            $mode_badge = 'badge-success';
                                        } elseif ($s['mode_paiement'] == 'cheque') {
                                            $mode_badge = 'badge-info';
                                        }
                                        ?>
                                        <span class="badge <?= $mode_badge ?>">
                                            <?= ucfirst(esc($s['mode_paiement'])) ?>
                                        </span>
                                    </td>
                                    
                                    <!-- Date de paiement -->
                                    <td>
                                        <?php 
                                        if ($s['date_paiement']) {
                                            echo date('d/m/Y', strtotime($s['date_paiement']));
                                        } else {
                                            echo '—';
                                        }
                                        ?>
                                    </td>
                                    
                                    <!-- Remarque -->
                                    <td>
                                        <?php 
                                        $remarque = esc($s['remarque'] ?? '—');
                                        // Limiter l'affichage à 30 caractères
                                        if (strlen($remarque) > 30) {
                                            echo substr($remarque, 0, 30) . '...';
                                        } else {
                                            echo $remarque;
                                        }
                                        ?>
                                    </td>
                                    
                                    <!-- Boutons d'actions -->
                                    <td class="text-center">
                                        <!-- Bouton Modifier -->
                                        <a href="<?= site_url('Salaire/edit_form/' . $s['id_salaire']) ?>" 
                                           class="btn btn-warning btn-sm" 
                                           title="Modifier">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        
                                        <!-- Bouton Supprimer -->
                                        <a href="<?= site_url('Salaire/supprimer/' . $s['id_salaire']) ?>" 
                                           class="btn btn-danger btn-sm" 
                                           onclick="return confirm('⚠️ Êtes-vous sûr de vouloir supprimer ce salaire ?')"
                                           title="Supprimer">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <!-- Message si aucun salaire n'existe -->
                            <tr>
                                <td colspan="13" class="text-center">
                                    <em>Aucun salaire enregistré</em>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Fin de la section "content" -->
<?= $this->endSection() ?>