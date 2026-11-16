<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="IM Training - Cabinet de formation professionnel">
    <meta name="author" content="IM Training">
    <link rel="icon" type="image/png" sizes="16x16" href="<?=base_url()?>/plugins/images/logo im training png.png">
    <title>IM Training - <?=esc($title ?? 'Accueil')?></title>

    <link href="<?=base_url()?>/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="<?=base_url()?>/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">
    <link href="<?=base_url()?>/plugins/bower_components/toast-master/css/jquery.toast.css" rel="stylesheet">
    <link href="<?=base_url()?>/css/animate.css" rel="stylesheet">
    <link href="<?=base_url()?>/css/style.css" rel="stylesheet">

    <style>
        :root {
            --primary-color: #2563eb;
            --secondary-color: #1e40af;
            --accent-color: #3b82f6;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --dark-color: #1e293b;
            --light-gray: #f8fafc;
            --border-color: #e2e8f0;
            --sidebar-width: 260px;
            --navbar-height: 60px;
        }

        body {
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f1f5f9;
            color: #334155;
        }

        /* ── NAVBAR ── */
        .navbar-default {
            background: linear-gradient(135deg, var(--dark-color) 0%, #0f172a 100%);
            border: none;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
            min-height: var(--navbar-height);
            margin-bottom: 0;
        }
        .navbar-header { min-height: var(--navbar-height); }
        .navbar-header .top-left-part {
            background: transparent; padding: 8px 20px;
            height: var(--navbar-height); display: flex; align-items: center;
        }
        .navbar-header .logo {
            display: flex; align-items: center;
            color: white !important; text-decoration: none; height: 100%;
        }
        .navbar-header .logo span {
            color: white !important; font-size: 18px;
            font-weight: 700; margin-left: 10px;
        }
        .navbar-header .logo img {
            height: 36px; width: auto;
            border-radius: 6px; background: white; padding: 3px;
        }
        .navbar-top-links { margin-top: 0; }
        .navbar-top-links > li {
            height: var(--navbar-height); display: flex; align-items: center;
        }
        .navbar-top-links .profile-pic {
            color: white !important; padding: 8px 20px !important;
            display: flex; align-items: center; gap: 10px;
            transition: all 0.3s ease; height: 100%;
        }
        .navbar-top-links .profile-pic:hover { background: rgba(255,255,255,0.1); }
        .navbar-top-links .profile-pic b { color: white !important; font-weight: 500; font-size: 14px; }
        .navbar-top-links .profile-pic img {
            border: 2px solid white; box-shadow: 0 2px 4px rgba(0,0,0,0.2);
            width: 32px; height: 32px;
        }

        /* ── DROPDOWN ── */
        .dropdown-menu {
            border: none; border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.15);
            padding: 0; margin-top: 10px; min-width: 260px;
        }
        .dropdown-menu .dw-user-box {
            padding: 20px; border-bottom: 1px solid #e2e8f0;
            background: linear-gradient(135deg, #f8fafc 0%, #fff 100%);
        }
        .dropdown-menu .u-img img {
            width: 60px; height: 60px; border-radius: 50%;
            border: 3px solid white; box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .dropdown-menu .u-text { margin-left: 75px; margin-top: -60px; }
        .dropdown-menu .u-text h4 { margin: 0; font-size: 16px; font-weight: 700; color: #1e293b; }
        .dropdown-menu .u-text p { margin: 4px 0 8px 0; color: #64748b; font-size: 13px; }
        .dropdown-menu .u-text .badge {
            background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
            color: white; padding: 4px 10px; border-radius: 6px;
            font-size: 11px; font-weight: 600;
        }
        .dropdown-menu li a {
            padding: 12px 20px; color: #475569; transition: all 0.3s ease;
            display: flex; align-items: center; gap: 12px; font-size: 14px;
        }
        .dropdown-menu li a:hover { background: #f1f5f9; color: #2563eb; }
        .dropdown-menu li a i { width: 20px; text-align: center; font-size: 16px; }
        .dropdown-menu li:last-child a { color: #ef4444; border-top: 1px solid #e2e8f0; }
        .dropdown-menu li:last-child a:hover { background: #fee2e2; color: #dc2626; }
        .dropdown { position: relative; }
        .dropdown-menu { display: none !important; position: absolute; top: 100%; right: 0; left: auto; z-index: 99999; }
        .dropdown.open > .dropdown-menu { display: block !important; }

        /* ── SIDEBAR ── */
        .sidebar {
            background: white; box-shadow: 2px 0 8px rgba(0,0,0,0.05);
            width: var(--sidebar-width); margin-top: var(--navbar-height);
            position: fixed; height: calc(100vh - var(--navbar-height));
            overflow-y: auto; z-index: 1000;
        }
        .sidebar-nav { padding: 0; }
        .sidebar-head {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            padding: 16px 20px; margin-bottom: 0; position: sticky; top: 0; z-index: 10;
        }
        .sidebar-head h3 { color: white; font-size: 14px; font-weight: 600; margin: 0; text-transform: uppercase; letter-spacing: 1px; }
        #side-menu { padding-top: 0; }
        #side-menu > li { border-bottom: 1px solid var(--border-color); }
        #side-menu > li:first-child { padding-top: 0 !important; }
        #side-menu > li > a {
            padding: 14px 20px; color: #475569; font-weight: 500; font-size: 14px;
            transition: all 0.3s ease; display: flex; align-items: center; gap: 12px;
        }
        #side-menu > li > a i { font-size: 17px; width: 22px; text-align: center; color: var(--primary-color); }
        #side-menu > li > a:hover,
        #side-menu > li.active > a {
            background: linear-gradient(90deg, var(--light-gray) 0%, transparent 100%);
            color: var(--primary-color); border-left: 4px solid var(--primary-color); padding-left: 16px;
        }
        #side-menu .nav-second-level { background: #f8fafc; padding: 0; }
        #side-menu .nav-second-level li { border-bottom: none; }
        #side-menu .nav-second-level li a {
            padding: 11px 20px 11px 54px; color: #64748b; font-size: 13px; transition: all 0.3s ease;
        }
        #side-menu .nav-second-level li a:hover {
            background: white; color: var(--primary-color); padding-left: 58px;
        }
        .sidebar::-webkit-scrollbar { width: 6px; }
        .sidebar::-webkit-scrollbar-track { background: #f1f5f9; }
        .sidebar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }
        .sidebar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

        /* ── PAGE WRAPPER ── */
        #page-wrapper {
            background: #f1f5f9; margin-left: var(--sidebar-width);
            margin-top: var(--navbar-height);
            min-height: calc(100vh - var(--navbar-height)); padding-bottom: 60px;
        }
        .bg-title {
            background: white; padding: 18px 30px;
            margin: 0 -15px 30px -15px;
            border-bottom: 1px solid var(--border-color);
            box-shadow: 0 2px 4px rgba(0,0,0,0.02);
        }
        .page-title { font-size: 22px; font-weight: 700; color: var(--dark-color); margin: 0; }

        /* ── FOOTER ── */
        .footer {
            background: white !important; border-top: 2px solid var(--border-color);
            padding: 20px; font-size: 14px; color: #64748b;
            margin-top: 50px; text-align: center; position: relative; clear: both; width: 100%;
        }
        .footer strong { color: #1e293b; font-weight: 700; }

        /* ── PRELOADER ── */
        .preloader {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            position: fixed; width: 100%; height: 100%; top: 0; left: 0; z-index: 999999;
        }
        .preloader .circular .path { stroke: white; }

        /* ============================================================== */
        /* ACTIONS RAPIDES - Barre de raccourcis contextuels            */
        /* ============================================================== */

        /* Barre fixe en bas du contenu */
        .quick-actions-bar {
            position: fixed;
            bottom: 28px;
            right: 32px;
            z-index: 5000;
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 10px;
        }

        /* Bouton principal (déclencheur) */
        .qa-trigger {
            width: 54px;
            height: 54px;
            border-radius: 50%;
            background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
            border: none;
            cursor: pointer;
            box-shadow: 0 6px 20px rgba(37, 99, 235, 0.45);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 20px;
            transition: transform 0.3s cubic-bezier(.34,1.56,.64,1), box-shadow 0.3s;
            outline: none;
        }
        .qa-trigger:hover {
            transform: scale(1.1);
            box-shadow: 0 10px 28px rgba(37, 99, 235, 0.55);
        }
        .qa-trigger.open {
            transform: rotate(45deg) scale(1.05);
            background: linear-gradient(135deg, #ef4444 0%, #b91c1c 100%);
            box-shadow: 0 6px 20px rgba(239, 68, 68, 0.45);
        }
        .qa-trigger i { transition: transform 0.3s; }

        /* Label flottant à côté du bouton trigger */
        .qa-trigger-label {
            position: absolute;
            right: 64px;
            background: var(--dark-color);
            color: white;
            font-size: 12px;
            font-weight: 600;
            padding: 5px 12px;
            border-radius: 8px;
            white-space: nowrap;
            opacity: 0;
            transform: translateX(10px);
            transition: all 0.25s;
            pointer-events: none;
        }
        .qa-trigger:hover .qa-trigger-label,
        .qa-trigger-wrapper:hover .qa-trigger-label {
            opacity: 1;
            transform: translateX(0);
        }
        .qa-trigger-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        /* Container des actions */
        .qa-actions {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 8px;
            /* Caché par défaut */
            opacity: 0;
            pointer-events: none;
            transform: translateY(12px);
            transition: opacity 0.3s ease, transform 0.3s cubic-bezier(.34,1.56,.64,1);
        }
        .qa-actions.visible {
            opacity: 1;
            pointer-events: all;
            transform: translateY(0);
        }

        /* Chaque item d'action */
        .qa-item {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none !important;
            cursor: pointer;
            animation: none;
        }

        /* Étiquette de l'action */
        .qa-label {
            background: white;
            color: #1e293b;
            font-size: 13px;
            font-weight: 600;
            padding: 6px 14px;
            border-radius: 10px;
            box-shadow: 0 3px 12px rgba(0,0,0,0.12);
            white-space: nowrap;
            opacity: 0;
            transform: translateX(12px);
            transition: opacity 0.25s, transform 0.25s;
        }
        .qa-actions.visible .qa-label {
            opacity: 1;
            transform: translateX(0);
        }

        /* Bouton icône rond */
        .qa-btn {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            color: white;
            box-shadow: 0 4px 14px rgba(0,0,0,0.2);
            cursor: pointer;
            transition: transform 0.25s cubic-bezier(.34,1.56,.64,1), box-shadow 0.25s;
            flex-shrink: 0;
        }
        .qa-btn:hover {
            transform: scale(1.15);
            box-shadow: 0 6px 20px rgba(0,0,0,0.3);
        }

        /* Délais en cascade pour chaque item */
        .qa-actions.visible .qa-item:nth-child(1) .qa-label,
        .qa-actions.visible .qa-item:nth-child(1) .qa-btn { transition-delay: 0.04s; }
        .qa-actions.visible .qa-item:nth-child(2) .qa-label,
        .qa-actions.visible .qa-item:nth-child(2) .qa-btn { transition-delay: 0.08s; }
        .qa-actions.visible .qa-item:nth-child(3) .qa-label,
        .qa-actions.visible .qa-item:nth-child(3) .qa-btn { transition-delay: 0.12s; }
        .qa-actions.visible .qa-item:nth-child(4) .qa-label,
        .qa-actions.visible .qa-item:nth-child(4) .qa-btn { transition-delay: 0.16s; }
        .qa-actions.visible .qa-item:nth-child(5) .qa-label,
        .qa-actions.visible .qa-item:nth-child(5) .qa-btn { transition-delay: 0.20s; }

        /* Couleurs par type */
        .qa-btn.green  { background: linear-gradient(135deg, #10b981, #059669); }
        .qa-btn.blue   { background: linear-gradient(135deg, #3b82f6, #2563eb); }
        .qa-btn.orange { background: linear-gradient(135deg, #f59e0b, #d97706); }
        .qa-btn.red    { background: linear-gradient(135deg, #ef4444, #dc2626); }
        .qa-btn.purple { background: linear-gradient(135deg, #8b5cf6, #7c3aed); }
        .qa-btn.teal   { background: linear-gradient(135deg, #14b8a6, #0d9488); }
        .qa-btn.indigo { background: linear-gradient(135deg, #6366f1, #4f46e5); }
        .qa-btn.pink   { background: linear-gradient(135deg, #ec4899, #db2777); }

        /* Tooltip au survol du bouton uniquement (mobile-friendly) */
        @media (max-width: 768px) {
            :root { --sidebar-width: 0px; }
            #page-wrapper { margin-left: 0; }
            .sidebar {
                width: 100%; transform: translateX(-100%); transition: transform 0.3s ease;
            }
            .sidebar.active { transform: translateX(0); }
            .navbar-header .logo span { display: none; }

            .quick-actions-bar { bottom: 16px; right: 16px; }
            .qa-label { display: none; } /* Sur mobile, labels cachés = plus compact */
        }
    </style>
</head>

<body class="fix-header">

    <!-- PRELOADER -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
        </svg>
    </div>

    <div id="wrapper">

        <!-- ── NAVBAR ── -->
        <nav class="navbar navbar-default navbar-static-top m-b-0">
            <div class="navbar-header">
                <div class="top-left-part">
                    <a class="logo" href="<?=base_url()?>/Home/accueil">
                        <img src="<?=base_url()?>/plugins/images/logo im training png.png" alt="IM Training" />
                        <span>IM Training</span>
                    </a>
                </div>

                <ul class="nav navbar-top-links navbar-right pull-right">
                    <li class="dropdown">
                        <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" style="cursor: pointer;">
                            <img src="<?=base_url()?>/plugins/images/users/utilisateur.jpg" alt="user" class="img-circle">
                            <b class="hidden-xs">
                                <?php
                                $prenom = session()->get('prenom');
                                $nom    = session()->get('nom_utilisateur');
                                echo $prenom ? $prenom . ' ' . $nom : $nom;
                                ?>
                            </b>
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu dropdown-user animated flipInY">
                            <li>
                                <div class="dw-user-box">
                                    <div class="u-img">
                                        <img src="<?=base_url()?>/plugins/images/users/utilisateur.jpg" alt="user">
                                    </div>
                                    <div class="u-text">
                                        <h4><?= session()->get('nom_utilisateur') ?></h4>
                                        <p><?= session()->get('email') ?? 'Utilisateur' ?></p>
                                        <span class="badge"><?= ucfirst(session()->get('role') ?? 'user') ?></span>
                                    </div>
                                </div>
                            </li>
                            <li role="separator" class="divider"></li>
                            <li><a href="<?=base_url()?>/Utilisateurs/index"><i class="fa-solid fa-user"></i> Mon Profil</a></li>
                            <li><a href="<?=base_url()?>/Home/accueil"><i class="fa-solid fa-home"></i> Accueil</a></li>
                            <li><a href="<?=base_url()?>/Auth/logout"><i class="fa-solid fa-power-off"></i> Déconnexion</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- ── SIDEBAR ── -->
        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav slimscrollsidebar">
                <div class="sidebar-head">
                    <h3><i class="fa fa-bars"></i> Navigation</h3>
                </div>
                <ul class="nav" id="side-menu">
                    <li>
                        <a href="<?=base_url()?>/Home/accueil" class="waves-effect">
                            <i class="fa-solid fa-home"></i><span>Accueil</span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)" class="waves-effect">
                            <i class="fa-solid fa-building-columns"></i>
                            <span>Gestion administrative &amp; financière</span>
                            <span class="fa arrow"></span>
                        </a>
                        <ul class="nav nav-second-level">
                            <li><a href="<?=base_url()?>Banque/banque_list">Banque</a></li>
                            <li><a href="<?=base_url()?>ProduitFormation/produits_list">Produits de formation</a></li>
                            <li><a href="<?=base_url()?>ChargeDepense/charges_list">Charges &amp; Dépenses</a></li>
                            <li><a href="<?=base_url()?>EtatAttestation/attestations_list">États Attestations</a></li>
                            <li><a href="<?= site_url('declaration') ?>">Déclaration mensuelle</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:void(0)" class="waves-effect">
                            <i class="fa-solid fa-users"></i>
                            <span>Gestion Clients</span>
                            <span class="fa arrow"></span>
                        </a>
                        <ul class="nav nav-second-level">
                            <li><a href="<?=base_url()?>Potentiel/potentiel_list">Clients potentiels</a></li>
                            <li><a href="<?=base_url()?>Cabinet/cabinet_list">Clients cabinet</a></li>
                            <li><a href="<?=base_url()?>CommunicationClient/communication_list">Communication clients</a></li>
                            <li><a href="<?=base_url()?>EvaluationClient/evaluation_list">Évaluation client</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:void(0)" class="waves-effect">
                            <i class="fa-solid fa-chart-line"></i>
                            <span>Statistiques</span>
                            <span class="fa arrow"></span>
                        </a>
                        <ul class="nav nav-second-level">
                            <li><a href="<?=base_url()?>Pilotage/pilotage_list">Objectif &amp; résultat</a></li>
                            <li><a href="<?=base_url()?>SuivieNonConformite/suivi_list">Suivi non-conformité</a></li>
                            <li><a href="<?=base_url()?>ActionsCorrectivess/actions_list">Actions correctives</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:void(0)" class="waves-effect">
                            <i class="fa-solid fa-user-tie"></i>
                            <span>Gestion resource humaine</span>
                            <span class="fa arrow"></span>
                        </a>
                        <ul class="nav nav-second-level">
                            <li><a href="<?=base_url()?>Employes/employe_list">Employés</a></li>
                            <li><a href="<?=base_url()?>Conge/conge_list">Congés</a></li>
                            <li><a href="<?=base_url()?>Salaire/salaire_list">Salaires</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:void(0)" class="waves-effect">
                            <i class="fa-solid fa-cogs"></i>
                            <span>Gestion opérations</span>
                            <span class="fa arrow"></span>
                        </a>
                        <ul class="nav nav-second-level">
                            <li><a href="<?=base_url()?>/Operations/prestation_list">Prestation</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:void(0)" class="waves-effect">
                            <i class="fa-solid fa-chalkboard-user"></i>
                            <span>Gestion intervenants</span>
                            <span class="fa arrow"></span>
                        </a>
                        <ul class="nav nav-second-level">
                            <li><a href="<?=base_url()?>Formateur/formateurs_list">Formateurs</a></li>
                            <li><a href="<?=base_url()?>FormateurPotentiel/formateur_potentiel_list">Formateur Potentiel</a></li>
                            <li><a href="<?=base_url()?>EvaluationFormateur/evaluation_list">Évaluation formateur</a></li>
                            <li><a href="<?=base_url()?>CommunicationFormateur/communication_list">Communication</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="<?=base_url()?>/Utilisateurs/index" class="waves-effect">
                            <i class="fa-solid fa-user-shield"></i>
                            <span>Gestion utilisateurs</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- ── PAGE CONTENT ── -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row bg-title">
                    <div class="col-lg-12">
                        <h4 class="page-title"><?=esc($title ?? 'Accueil')?></h4>
                    </div>
                </div>

                <?= $this->renderSection('content') ?>
            </div>

            <footer class="footer text-center">
                <strong>2026 © IM Training</strong> - Cabinet de formation professionnel
            </footer>
        </div>

    </div>
    <!-- Fin wrapper -->

    <!-- ============================================================== -->
    <!-- ACTIONS RAPIDES - Speed dial flottant contextuel              -->
    <!--                                                               -->
    <!-- Les actions s'adaptent automatiquement selon le controller    -->
    <!-- actif détecté via l'URL (segment 1 = controller name).       -->
    <!-- Pour ajouter des actions à un nouveau controller, il suffit  -->
    <!-- d'ajouter une entrée dans l'objet JS `actionsMap` ci-dessous. -->
    <!-- ============================================================== -->
    <div class="quick-actions-bar" id="quickActionsBar">

        <!-- Actions contextuelles (générées dynamiquement) -->
        <div class="qa-actions" id="qaActions"></div>

        <!-- Bouton déclencheur -->
        <div class="qa-trigger-wrapper">
            <span class="qa-trigger-label">Actions rapides</span>
            <button class="qa-trigger" id="qaTrigger" title="Actions rapides">
                <i class="fa-solid fa-bolt"></i>
            </button>
        </div>

    </div>
    <!-- /Actions Rapides -->

    <!-- ── JS ── -->
    <script src="<?=base_url()?>/plugins/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="<?=base_url()?>/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js"></script>
    <script src="<?=base_url()?>/js/jquery.slimscroll.js"></script>
    <script src="<?=base_url()?>/js/waves.js"></script>
    <script src="<?=base_url()?>/js/custom.min.js"></script>

    <!-- Preloader -->
    <script>
    $(window).on('load', function() {
        $('.preloader').fadeOut('slow');
    });
    </script>

    <!-- Dropdown fix -->
    <script>
    $(document).ready(function() {
        $('.dropdown-toggle').dropdown();
        $('.dropdown-toggle').on('click', function(e) {
            e.preventDefault(); e.stopPropagation();
            $('.dropdown').removeClass('open');
            $(this).parent('.dropdown').toggleClass('open');
        });
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.dropdown').length) {
                $('.dropdown').removeClass('open');
            }
        });
    });
    </script>

    <!-- ============================================================== -->
    <!-- SCRIPT ACTIONS RAPIDES                                        -->
    <!-- ============================================================== -->
    <script>
    (function () {

        /* ─────────────────────────────────────────────────────────────
         * actionsMap : dictionnaire controller → liste d'actions
         *
         * Clé   = premier segment de l'URL (insensible à la casse)
         *         ex: "/Banque/banque_list"  →  clé "banque"
         *
         * Valeur = tableau d'objets {label, icon, color, url}
         *   label : texte affiché à gauche du bouton
         *   icon  : classe Font Awesome (fa-solid fa-xxx)
         *   color : classe CSS (green|blue|orange|red|purple|teal|indigo|pink)
         *   url   : lien de destination (peut utiliser base_url PHP ou chemin relatif)
         *
         * ── COMMENT AJOUTER UN NOUVEAU CONTROLLER ──────────────────
         * 1. Repérez le nom du controller dans vos routes CodeIgniter
         *    (ex: "Devis" → url commence par /Devis/...)
         * 2. Ajoutez une entrée dans actionsMap avec la clé en minuscule
         * 3. Listez les actions souhaitées
         * ─────────────────────────────────────────────────────────── */
        var BASE = '<?= base_url() ?>';

        var actionsMap = {

            /* ── Accueil ── */
            'home': [
                { label: 'Nouvelle prestation',   icon: 'fa-solid fa-plus',           color: 'green',  url: BASE + 'Operations/prestation_add' },
                { label: 'Nouveau client',         icon: 'fa-solid fa-user-plus',      color: 'blue',   url: BASE + 'Cabinet/cabinet_add' },
                { label: 'Nouveau formateur',      icon: 'fa-solid fa-chalkboard-user',color: 'purple', url: BASE + 'Formateur/formateur_add' },
                { label: 'Ajouter employé',        icon: 'fa-solid fa-id-badge',       color: 'teal',   url: BASE + 'Employes/employe_add' },
            ],

            /* ── Banque ── */
            'banque': [
                { label: 'Ajouter un compte',      icon: 'fa-solid fa-plus',           color: 'green',  url: BASE + 'Banque/banque_add' },
                { label: 'Liste des comptes',      icon: 'fa-solid fa-list',           color: 'blue',   url: BASE + 'Banque/banque_list' },
            ],

            /* ── Produits de formation ── */
            'produitformation': [
                { label: 'Nouveau produit',        icon: 'fa-solid fa-plus',           color: 'green',  url: BASE + 'ProduitFormation/produit_add' },
                { label: 'Liste produits',         icon: 'fa-solid fa-list',           color: 'blue',   url: BASE + 'ProduitFormation/produits_list' },
            ],

            /* ── Charges & Dépenses ── */
            'chargedepense': [
                { label: 'Nouvelle charge',        icon: 'fa-solid fa-plus',           color: 'red',    url: BASE + 'ChargeDepense/charge_add' },
                { label: 'Liste des charges',      icon: 'fa-solid fa-list',           color: 'orange', url: BASE + 'ChargeDepense/charges_list' },
            ],

            /* ── États Attestations ── */
            'etatAttestation': [
                { label: 'Nouvelle attestation',   icon: 'fa-solid fa-file-circle-plus', color: 'green', url: BASE + 'EtatAttestation/attestation_add' },
                { label: 'Liste attestations',     icon: 'fa-solid fa-list',             color: 'blue',  url: BASE + 'EtatAttestation/attestations_list' },
            ],

            /* ── Déclaration ── */
            'declaration': [
                { label: 'Nouvelle déclaration',   icon: 'fa-solid fa-file-plus',      color: 'green',  url: BASE + 'declaration/add' },
                { label: 'Liste déclarations',     icon: 'fa-solid fa-list',           color: 'blue',   url: BASE + 'declaration' },
            ],

            /* ── Clients potentiels ── */
            'potentiel': [
                { label: 'Ajouter potentiel',      icon: 'fa-solid fa-user-plus',      color: 'green',  url: BASE + 'Potentiel/potentiel_add' },
                { label: 'Liste potentiels',       icon: 'fa-solid fa-list',           color: 'blue',   url: BASE + 'Potentiel/potentiel_list' },
                { label: 'Communication',          icon: 'fa-solid fa-envelope',       color: 'teal',   url: BASE + 'CommunicationClient/communication_list' },
            ],

            /* ── Clients cabinet ── */
            'cabinet': [
                { label: 'Nouveau client',         icon: 'fa-solid fa-user-plus',      color: 'green',  url: BASE + 'Cabinet/cabinet_add' },
                { label: 'Liste clients',          icon: 'fa-solid fa-list',           color: 'blue',   url: BASE + 'Cabinet/cabinet_list' },
                { label: 'Évaluation',             icon: 'fa-solid fa-star',           color: 'orange', url: BASE + 'EvaluationClient/evaluation_list' },
                { label: 'Communication',          icon: 'fa-solid fa-envelope',       color: 'teal',   url: BASE + 'CommunicationClient/communication_list' },
            ],

            /* ── Communication clients ── */
            'communicationclient': [
                { label: 'Nouvelle communication', icon: 'fa-solid fa-paper-plane',    color: 'green',  url: BASE + 'CommunicationClient/communication_add' },
                { label: 'Liste communications',   icon: 'fa-solid fa-list',           color: 'blue',   url: BASE + 'CommunicationClient/communication_list' },
            ],

            /* ── Évaluation client ── */
            'evaluationclient': [
                { label: 'Nouvelle évaluation',    icon: 'fa-solid fa-plus',           color: 'green',  url: BASE + 'EvaluationClient/evaluation_add' },
                { label: 'Liste évaluations',      icon: 'fa-solid fa-list',           color: 'blue',   url: BASE + 'EvaluationClient/evaluation_list' },
            ],

            /* ── Pilotage (Objectifs) ── */
            'pilotage': [
                { label: 'Nouvel objectif',        icon: 'fa-solid fa-bullseye',       color: 'green',  url: BASE + 'Pilotage/pilotage_add' },
                { label: 'Liste objectifs',        icon: 'fa-solid fa-list',           color: 'blue',   url: BASE + 'Pilotage/pilotage_list' },
            ],

            /* ── Suivi non-conformité ── */
            'suivienonconformite': [
                { label: 'Nouveau suivi',          icon: 'fa-solid fa-plus',           color: 'orange', url: BASE + 'SuivieNonConformite/suivi_add' },
                { label: 'Liste suivis',           icon: 'fa-solid fa-list',           color: 'blue',   url: BASE + 'SuivieNonConformite/suivi_list' },
            ],

            /* ── Actions correctives ── */
            'actionscorrectivess': [
                { label: 'Nouvelle action',        icon: 'fa-solid fa-plus',           color: 'red',    url: BASE + 'ActionsCorrectivess/actions_add' },
                { label: 'Liste actions',          icon: 'fa-solid fa-list',           color: 'blue',   url: BASE + 'ActionsCorrectivess/actions_list' },
            ],

            /* ── Employés ── */
            'employes': [
                { label: 'Ajouter employé',        icon: 'fa-solid fa-id-badge',       color: 'green',  url: BASE + 'Employes/employe_add' },
                { label: 'Liste employés',         icon: 'fa-solid fa-list',           color: 'blue',   url: BASE + 'Employes/employe_list' },
                { label: 'Congés',                 icon: 'fa-solid fa-umbrella-beach', color: 'teal',   url: BASE + 'Conge/conge_list' },
                { label: 'Salaires',               icon: 'fa-solid fa-money-bill-wave',color: 'orange', url: BASE + 'Salaire/salaire_list' },
            ],

            /* ── Congés ── */
            'conge': [
                { label: 'Nouveau congé',          icon: 'fa-solid fa-plus',           color: 'green',  url: BASE + 'Conge/conge_add' },
                { label: 'Liste congés',           icon: 'fa-solid fa-list',           color: 'blue',   url: BASE + 'Conge/conge_list' },
                { label: 'Employés',               icon: 'fa-solid fa-users',          color: 'teal',   url: BASE + 'Employes/employe_list' },
            ],

            /* ── Salaires ── */
            'salaire': [
                { label: 'Nouveau salaire',        icon: 'fa-solid fa-plus',           color: 'green',  url: BASE + 'Salaire/salaire_add' },
                { label: 'Liste salaires',         icon: 'fa-solid fa-list',           color: 'blue',   url: BASE + 'Salaire/salaire_list' },
            ],

            /* ── Prestations (Opérations) ── */
            'operations': [
                { label: 'Nouvelle prestation',    icon: 'fa-solid fa-plus',           color: 'green',  url: BASE + 'Operations/prestation_add' },
                { label: 'Liste prestations',      icon: 'fa-solid fa-list',           color: 'blue',   url: BASE + 'Operations/prestation_list' },
            ],

            /* ── Formateurs ── */
            'formateur': [
                { label: 'Ajouter formateur',      icon: 'fa-solid fa-user-plus',      color: 'green',  url: BASE + 'Formateur/formateur_add' },
                { label: 'Liste formateurs',       icon: 'fa-solid fa-list',           color: 'blue',   url: BASE + 'Formateur/formateurs_list' },
                { label: 'Évaluation',             icon: 'fa-solid fa-star',           color: 'orange', url: BASE + 'EvaluationFormateur/evaluation_list' },
                { label: 'Communication',          icon: 'fa-solid fa-envelope',       color: 'teal',   url: BASE + 'CommunicationFormateur/communication_list' },
            ],

            /* ── Formateurs potentiels ── */
            'formateurpotentiel': [
                { label: 'Ajouter potentiel',      icon: 'fa-solid fa-user-plus',      color: 'green',  url: BASE + 'FormateurPotentiel/formateur_potentiel_add' },
                { label: 'Liste potentiels',       icon: 'fa-solid fa-list',           color: 'blue',   url: BASE + 'FormateurPotentiel/formateur_potentiel_list' },
            ],

            /* ── Évaluation formateur ── */
            'evaluationformateur': [
                { label: 'Nouvelle évaluation',    icon: 'fa-solid fa-plus',           color: 'green',  url: BASE + 'EvaluationFormateur/evaluation_add' },
                { label: 'Liste évaluations',      icon: 'fa-solid fa-list',           color: 'blue',   url: BASE + 'EvaluationFormateur/evaluation_list' },
            ],

            /* ── Communication formateurs ── */
            'communicationformateur': [
                { label: 'Nouvelle communication', icon: 'fa-solid fa-paper-plane',    color: 'green',  url: BASE + 'CommunicationFormateur/communication_add' },
                { label: 'Liste communications',   icon: 'fa-solid fa-list',           color: 'blue',   url: BASE + 'CommunicationFormateur/communication_list' },
            ],

            /* ── Utilisateurs ── */
            'utilisateurs': [
                { label: 'Nouvel utilisateur',     icon: 'fa-solid fa-user-plus',      color: 'green',  url: BASE + 'Utilisateurs/add' },
                { label: 'Liste utilisateurs',     icon: 'fa-solid fa-list',           color: 'blue',   url: BASE + 'Utilisateurs/index' },
            ],

        };

        /* ── Détecter le controller actif depuis l'URL ────────────── */
        function getController() {
            var path = window.location.pathname;
            // Retire la base_url si présente, prend le 1er segment
            var baseSegments = '<?= base_url() ?>'.replace(/https?:\/\/[^\/]+/, '').split('/').filter(Boolean);
            var pathSegments  = path.replace(/^\//, '').split('/').filter(Boolean);
            // Retire les segments communs (sous-dossier)
            baseSegments.forEach(function() { pathSegments.shift(); });
            return pathSegments[0] ? pathSegments[0].toLowerCase() : 'home';
        }

        /* ── Construire les actions ───────────────────────────────── */
        function buildActions() {
            var ctrl    = getController();
            var actions = actionsMap[ctrl] || actionsMap['home'];
            var bar     = document.getElementById('qaActions');
            bar.innerHTML = '';

            actions.forEach(function (action) {
                var item = document.createElement('a');
                item.className  = 'qa-item';
                item.href       = action.url;
                item.title      = action.label;
                item.innerHTML  =
                    '<span class="qa-label">' + action.label + '</span>' +
                    '<button class="qa-btn ' + action.color + '" tabindex="-1">' +
                        '<i class="' + action.icon + '"></i>' +
                    '</button>';
                bar.appendChild(item);
            });
        }

        /* ── Toggle ouverture/fermeture ─────────────────────────── */
        var trigger = document.getElementById('qaTrigger');
        var panel   = document.getElementById('qaActions');

        trigger.addEventListener('click', function (e) {
            e.stopPropagation();
            var isOpen = panel.classList.contains('visible');
            if (isOpen) {
                panel.classList.remove('visible');
                trigger.classList.remove('open');
            } else {
                buildActions(); // reconstruit à chaque ouverture (au cas où navigation SPA)
                panel.classList.add('visible');
                trigger.classList.add('open');
            }
        });

        /* Ferme si clic ailleurs */
        document.addEventListener('click', function (e) {
            if (!e.target.closest('#quickActionsBar')) {
                panel.classList.remove('visible');
                trigger.classList.remove('open');
            }
        });

        /* Pré-construire au chargement (sans afficher) */
        buildActions();

    })();
    </script>

</body>
</html>