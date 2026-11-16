<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ============================================================
// ROUTES PUBLIQUES (Bla ma t7taj connexion)
// ============================================================
$routes->get('register', 'Auth::register');
$routes->post('register', 'Auth::attemptRegister');

$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::attemptLogin');
// Page login = Page par défaut (awel page)
$routes->get('/', 'Auth::login');

// Auth routes
$routes->get('Auth/login', 'Auth::login');
$routes->post('Auth/attemptLogin', 'Auth::attemptLogin');
$routes->get('Auth/logout', 'Auth::logout');

// Register (optionnel)
$routes->get('Auth/register', 'Auth::register');
$routes->post('Auth/attemptRegister', 'Auth::attemptRegister');

// ============================================================
// ROUTES PROTÉGÉES (Lazem tkoun connecté)
// ============================================================

// Groupe de routes protégées par filter 'auth'
$routes->group('', ['filter' => 'auth'], function($routes) {
    
    // ===== HOME / ACCUEIL =====
    $routes->get('Home', 'Home::index');
    $routes->get('Home/accueil', 'Home::accueil');
    
    // ===== GESTION UTILISATEURS =====
    $routes->match(['get','post'], 'utilisateurs', 'Utilisateurs::index');
    $routes->get('Utilisateurs/index', 'Utilisateurs::index');
    $routes->post('Utilisateurs/store', 'Utilisateurs::store');
    $routes->get('Utilisateurs/modifier_utilisateur/(:num)', 'Utilisateurs::modifier_utilisateur/$1');
    $routes->post('Utilisateurs/update/(:num)', 'Utilisateurs::update/$1');
    $routes->get('Utilisateurs/delete/(:num)', 'Utilisateurs::delete/$1');
    
    /*
|--------------------------------------------------------------------------
| ADMINISTRATION ROUTES (FULL FIX)
|--------------------------------------------------------------------------
*/



// =============================================================
// ROUTES — Module Banque
// À ajouter dans : app/Config/Routes.php
// =============================================================

$routes->get('Banque/banque_list',                        'Banque::banque_list');
$routes->get('Banque/banque_ajouter_form',                'Banque::banque_ajouter_form');
$routes->post('Banque/banque_store',                      'Banque::banque_store');
$routes->get('Banque/banque_modifier_form/(:num)',        'Banque::banque_modifier_form/$1');
$routes->post('Banque/banque_update/(:num)',              'Banque::banque_update/$1');
$routes->get('Banque/banque_supprimer/(:num)',            'Banque::banque_supprimer/$1');
$routes->get('Banque/banque_export_pdf',                  'Banque::banque_export_pdf');


// ══════════════════════════════════════════════
// Déclaration Mensuelle — Routes
// ══════════════════════════════════════════════
$routes->get('declaration',                      'DeclarationMensuelle::index');
$routes->get('declaration/getReport',            'DeclarationMensuelle::getReport');  // ← AJOUTÉ
$routes->get('declaration/ajouter',              'DeclarationMensuelle::ajouter');
$routes->post('declaration/store',               'DeclarationMensuelle::store');
$routes->get('declaration/modifier/(:num)',      'DeclarationMensuelle::modifier/$1');
$routes->post('declaration/update/(:num)',        'DeclarationMensuelle::update/$1');
$routes->get('declaration/supprimer/(:num)',      'DeclarationMensuelle::supprimer/$1');
$routes->get('declaration/pdf',                  'DeclarationMensuelle::exportPdf');    

   // =============================================================
// ROUTES — Module ProduitFormation
// À ajouter dans : app/Config/Routes.php
// =============================================================

$routes->get('ProduitFormation/produits_list',                        'ProduitFormation::produits_list');
$routes->get('ProduitFormation/produits_ajouter_form',                'ProduitFormation::produits_ajouter_form');
$routes->post('ProduitFormation/produits_store',                      'ProduitFormation::produits_store');
$routes->get('ProduitFormation/produits_modifier_form/(:num)',        'ProduitFormation::produits_modifier_form/$1');
$routes->post('ProduitFormation/produits_update/(:num)',              'ProduitFormation::produits_update/$1');
$routes->get('ProduitFormation/produits_supprimer/(:num)',            'ProduitFormation::produits_supprimer/$1');
$routes->get('ProduitFormation/produits_export_pdf',                  'ProduitFormation::produits_export_pdf');


   // =============================================================
// ROUTES — Module ChargeDepense
// À ajouter dans : app/Config/Routes.php
// =============================================================

$routes->get('ChargeDepense/charges_list',                       'ChargeDepense::charges_list');
$routes->get('ChargeDepense/charges_ajouter_form',               'ChargeDepense::charges_ajouter_form');
$routes->post('ChargeDepense/charges_store',                     'ChargeDepense::charges_store');
$routes->get('ChargeDepense/charges_modifier_form/(:num)',       'ChargeDepense::charges_modifier_form/$1');
$routes->post('ChargeDepense/charges_update/(:num)',             'ChargeDepense::charges_update/$1');
$routes->get('ChargeDepense/charges_supprimer/(:num)',           'ChargeDepense::charges_supprimer/$1');
$routes->get('ChargeDepense/charges_export_pdf',                 'ChargeDepense::charges_export_pdf');



// =============================================================
// ROUTES — Module EtatAttestation
// À ajouter dans : app/Config/Routes.php
// =============================================================

$routes->get('EtatAttestation/attestations_list',                 'EtatAttestation::attestations_list');
$routes->get('EtatAttestation/attestations_ajouter_form',         'EtatAttestation::attestations_ajouter_form');
$routes->post('EtatAttestation/attestations_store',               'EtatAttestation::attestations_store');
$routes->get('EtatAttestation/attestations_modifier_form/(:num)', 'EtatAttestation::attestations_modifier_form/$1');
$routes->post('EtatAttestation/attestations_update/(:num)',       'EtatAttestation::attestations_update/$1');
$routes->get('EtatAttestation/attestations_supprimer/(:num)',     'EtatAttestation::attestations_supprimer/$1');
$routes->get('EtatAttestation/attestations_export_pdf',           'EtatAttestation::attestations_export_pdf');



    
// ──────────────────────────────────────────────
// MODULE: Clients Cabinet
// ──────────────────────────────────────────────
$routes->get('Cabinet/cabinet_list',                   'Cabinet::cabinet_list');
$routes->get('Cabinet/ajouter_cabinet_form',           'Cabinet::ajouter_cabinet_form');
$routes->post('Cabinet/ajouter_client_cabinet',        'Cabinet::ajouter_client_cabinet');
$routes->get('Cabinet/modifier_cabinet/(:num)',        'Cabinet::modifier_cabinet/$1');
$routes->post('Cabinet/update_cabinet/(:num)',         'Cabinet::update_cabinet/$1');
$routes->get('Cabinet/supprimer_client_cabinet/(:num)','Cabinet::supprimer_client_cabinet/$1');
$routes->get('Cabinet/export_cabinet_pdf',             'Cabinet::export_cabinet_pdf');
// ──────────────────────────────────────────────
// MODULE: Clients Potentiels
// ──────────────────────────────────────────────
$routes->get('Potentiel/potentiel_list',                   'Potentiel::potentiel_list');
$routes->get('Potentiel/ajouter_potentiel_form',           'Potentiel::ajouter_potentiel_form');
$routes->post('Potentiel/ajouter_client_potentiel',        'Potentiel::ajouter_client_potentiel');
$routes->get('Potentiel/modifier_potentiel/(:num)',        'Potentiel::modifier_potentiel/$1');
$routes->post('Potentiel/update_potentiel/(:num)',         'Potentiel::update_potentiel/$1');
$routes->get('Potentiel/supprimer_client_potentiel/(:num)','Potentiel::supprimer_client_potentiel/$1');
$routes->get('Potentiel/export_potentiels_pdf',            'Potentiel::export_potentiels_pdf');
// ──────────────────────────────────────────────
// MODULE: Evaluation Client
// ──────────────────────────────────────────────
$routes->get('EvaluationClient/evaluation_list',              'EvaluationClient::evaluation_list');
$routes->get('EvaluationClient/ajouter_evaluation_form',      'EvaluationClient::ajouter_evaluation_form');
$routes->post('EvaluationClient/ajouter_evaluation',          'EvaluationClient::ajouter_evaluation');
$routes->get('EvaluationClient/modifier_evaluation/(:num)',   'EvaluationClient::modifier_evaluation/$1');
$routes->post('EvaluationClient/update_evaluation/(:num)',    'EvaluationClient::update_evaluation/$1');
$routes->get('EvaluationClient/supprimer_evaluation/(:num)',  'EvaluationClient::supprimer_evaluation/$1');
$routes->get('EvaluationClient/export_evaluations_pdf',       'EvaluationClient::export_evaluations_pdf');

// ──────────────────────────────────────────────
// MODULE: Communication Client
// ──────────────────────────────────────────────
$routes->get('CommunicationClient/communication_list',             'CommunicationClient::communication_list');
$routes->get('CommunicationClient/ajouter_communication_form',     'CommunicationClient::ajouter_communication_form');
$routes->post('CommunicationClient/ajouter_communication',         'CommunicationClient::ajouter_communication');
$routes->get('CommunicationClient/modifier_communication/(:num)',  'CommunicationClient::modifier_communication/$1');
$routes->post('CommunicationClient/update_communication/(:num)',   'CommunicationClient::update_communication/$1');
$routes->get('CommunicationClient/supprimer_communication/(:num)', 'CommunicationClient::supprimer_communication/$1');
$routes->get('CommunicationClient/export_communications_pdf',      'CommunicationClient::export_communications_pdf');
    
/*
================================================
ROUTES: Module Statistiques (Version Compatible URLs Anciennes)
================================================
À ajouter dans: app/Config/Routes.php

IMPORTANT: Ces routes utilisent les ANCIENS URLs mais pointent vers
           les NOUVELLES méthodes avec architecture séparée
================================================
*/

// ──────────────────────────────────────────────
// MODULE: Pilotage
// ──────────────────────────────────────────────
$routes->get('Pilotage/pilotage_list',              'Pilotage::pilotage_list');
$routes->get('Pilotage/ajouter_pilotage_form',      'Pilotage::ajouter_pilotage_form');
$routes->post('Pilotage/ajouter_pilotage',          'Pilotage::ajouter_pilotage');
$routes->get('Pilotage/modifier_pilotage/(:num)',   'Pilotage::modifier_pilotage/$1');
$routes->post('Pilotage/update_pilotage/(:num)',    'Pilotage::update_pilotage/$1');
$routes->get('Pilotage/supprimer_pilotage/(:num)', 'Pilotage::supprimer_pilotage/$1');
$routes->get('Pilotage/export_pilotage_pdf',        'Pilotage::export_pilotage_pdf');

// ──────────────────────────────────────────────
// MODULE: Suivi Non-Conformité
// ──────────────────────────────────────────────
$routes->get('SuivieNonConformite/suivi_list',             'SuivieNonConformite::suivi_list');
$routes->get('SuivieNonConformite/ajouter_suivi_form',     'SuivieNonConformite::ajouter_suivi_form');
$routes->post('SuivieNonConformite/ajouter_suivi',         'SuivieNonConformite::ajouter_suivi');
$routes->get('SuivieNonConformite/modifier_suivi/(:num)',  'SuivieNonConformite::modifier_suivi/$1');
$routes->post('SuivieNonConformite/update_suivi/(:num)',   'SuivieNonConformite::update_suivi/$1');
$routes->get('SuivieNonConformite/supprimer_suivi/(:num)', 'SuivieNonConformite::supprimer_suivi/$1');
$routes->get('SuivieNonConformite/export_suivi_pdf',       'SuivieNonConformite::export_suivi_pdf');

// ──────────────────────────────────────────────
// MODULE: Actions Correctives
// ──────────────────────────────────────────────
$routes->get('ActionsCorrectivess/actions_list',             'ActionsCorrectivess::actions_list');
$routes->get('ActionsCorrectivess/ajouter_action_form',      'ActionsCorrectivess::ajouter_action_form');
$routes->post('ActionsCorrectivess/ajouter_action',          'ActionsCorrectivess::ajouter_action');
$routes->get('ActionsCorrectivess/modifier_action/(:num)',   'ActionsCorrectivess::modifier_action/$1');
$routes->post('ActionsCorrectivess/update_action/(:num)',    'ActionsCorrectivess::update_action/$1');
$routes->get('ActionsCorrectivess/supprimer_action/(:num)',  'ActionsCorrectivess::supprimer_action/$1');
$routes->get('ActionsCorrectivess/export_actions_pdf',       'ActionsCorrectivess::export_actions_pdf');
// ──────────────────────────────────────────────
// MODULE: Employés
// ──────────────────────────────────────────────
$routes->get('Employes/employe_list',        'Employes::employe_list');
$routes->get('Employes/ajouter_form',        'Employes::ajouter_form');
$routes->post('Employes/ajouter_employe',    'Employes::ajouter_employe');
$routes->get('Employes/edit/(:num)',         'Employes::edit/$1');
$routes->post('Employes/update/(:num)',      'Employes::update/$1');
$routes->get('Employes/supprimer/(:num)',    'Employes::supprimer/$1');
$routes->get('Employes/export_employes_pdf', 'Employes::export_employes_pdf');
// ──────────────────────────────────────────────
// MODULE: Congés
// ──────────────────────────────────────────────
$routes->get('Conge/conge_list',       'Conge::conge_list');
$routes->get('Conge/ajouter_form',     'Conge::ajouter_form');
$routes->post('Conge/ajouter',         'Conge::ajouter');
$routes->get('Conge/edit_form/(:num)', 'Conge::edit_form/$1');
$routes->post('Conge/update/(:num)',   'Conge::update/$1');
$routes->get('Conge/supprimer/(:num)', 'Conge::supprimer/$1');
$routes->get('Conge/export_pdf',       'Conge::export_pdf');
// ──────────────────────────────────────────────
// MODULE: Salaires
// ──────────────────────────────────────────────
$routes->get('Salaire/salaire_list',       'Salaire::salaire_list');
$routes->get('Salaire/ajouter_form',       'Salaire::ajouter_form');
$routes->post('Salaire/ajouter',           'Salaire::ajouter');
$routes->get('Salaire/edit_form/(:num)',   'Salaire::edit_form/$1');
$routes->post('Salaire/update/(:num)',     'Salaire::update/$1');
$routes->get('Salaire/supprimer/(:num)',   'Salaire::supprimer/$1');
$routes->get('Salaire/export_pdf',         'Salaire::export_pdf');
    
// ============================================
// Routes - Module Opérations / Prestations
// ============================================

$routes->get('Operations/prestation_list',       'Operations::prestation_list');   // Liste

$routes->get('Operations/ajouter_form',          'Operations::ajouter_form');      // Formulaire ajout
$routes->post('Operations/ajouter',              'Operations::ajouter');           // Traitement ajout

$routes->get('Operations/modifier/(:num)',        'Operations::modifier/$1');       // Formulaire modif
$routes->post('Operations/update/(:num)',         'Operations::update/$1');         // Traitement modif

$routes->get('Operations/supprimer/(:num)',       'Operations::supprimer/$1');      // Suppression
$routes->get('Operations/export_pdf',            'Operations::export_pdf');        // Export PDF
    
// ✅ Sah — class Formateur
$routes->get('Formateur/formateurs_list',  'Formateur::formateurs_list');
$routes->get('Formateur/ajouter_form',     'Formateur::ajouter_form');
$routes->post('Formateur/ajouter',         'Formateur::ajouter');
$routes->get('Formateur/edit/(:num)',       'Formateur::edit/$1');
$routes->post('Formateur/update/(:num)',    'Formateur::update/$1');
$routes->get('Formateur/supprimer/(:num)', 'Formateur::supprimer/$1');
$routes->get('Formateur/export_pdf',       'Formateur::export_pdf');
// ============================================================
// FormateurPotentiel — CRUD + PDF
// ============================================================
$routes->get('FormateurPotentiel/formateur_potentiel_list', 'FormateurPotentiel::formateur_potentiel_list');
$routes->get('FormateurPotentiel/ajouter_form',             'FormateurPotentiel::ajouter_form');
$routes->post('FormateurPotentiel/ajouter',                 'FormateurPotentiel::ajouter');
$routes->get('FormateurPotentiel/edit/(:num)',               'FormateurPotentiel::edit/$1');
$routes->post('FormateurPotentiel/update/(:num)',            'FormateurPotentiel::update/$1');
$routes->get('FormateurPotentiel/supprimer/(:num)',          'FormateurPotentiel::supprimer/$1');
$routes->get('FormateurPotentiel/export_pdf',               'FormateurPotentiel::export_pdf');
// ──────────────────────────────────────────────
// MODULE: Évaluations Formateurs
// ──────────────────────────────────────────────
$routes->get('EvaluationFormateur/evaluation_list',        'EvaluationFormateur::evaluation_list');
$routes->get('EvaluationFormateur/ajouter_form',           'EvaluationFormateur::ajouter_form');
$routes->post('EvaluationFormateur/ajouter',               'EvaluationFormateur::ajouter');
$routes->get('EvaluationFormateur/edit_form/(:num)',        'EvaluationFormateur::edit_form/$1');
$routes->post('EvaluationFormateur/update/(:num)',          'EvaluationFormateur::update/$1');
$routes->get('EvaluationFormateur/supprimer/(:num)',        'EvaluationFormateur::supprimer/$1');
$routes->get('EvaluationFormateur/export_pdf',             'EvaluationFormateur::export_pdf');
// ──────────────────────────────────────────────
// MODULE: Communications Formateurs
// ──────────────────────────────────────────────
$routes->get('CommunicationFormateur/communication_list',   'CommunicationFormateur::communication_list');
$routes->get('CommunicationFormateur/ajouter_form',         'CommunicationFormateur::ajouter_form');
$routes->post('CommunicationFormateur/ajouter',             'CommunicationFormateur::ajouter');
$routes->get('CommunicationFormateur/edit_form/(:num)',      'CommunicationFormateur::edit_form/$1');
$routes->post('CommunicationFormateur/update/(:num)',        'CommunicationFormateur::update/$1');
$routes->get('CommunicationFormateur/supprimer/(:num)',      'CommunicationFormateur::supprimer/$1');
$routes->get('CommunicationFormateur/export_pdf',           'CommunicationFormateur::export_pdf');
    
    
    // ===== AUTO-ROUTE pour le reste =====
    // Permet d'accéder aux autres controllers automatiquement
   $routes->setAutoRoute(true);
});