<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<style>
    .dashboard-header {
        background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
        border-radius: 16px;
        padding: 40px;
        margin-bottom: 30px;
        color: white;
        box-shadow: 0 10px 30px rgba(37, 99, 235, 0.2);
    }
    .dashboard-header h1 { font-size: 32px; font-weight: 700; margin: 0 0 10px 0; }
    .dashboard-header p  { font-size: 16px; opacity: 0.9; margin: 0; }

    .stats-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 24px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: white; border-radius: 16px; padding: 28px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.06);
        transition: all 0.3s ease; border: 1px solid #e2e8f0;
        position: relative; overflow: hidden;
    }
    .stat-card::before {
        content: ''; position: absolute; top: 0; left: 0;
        width: 4px; height: 100%;
        background: linear-gradient(180deg, var(--card-color) 0%, var(--card-color-dark) 100%);
    }
    .stat-card:hover { transform: translateY(-4px); box-shadow: 0 12px 24px rgba(0,0,0,0.1); }
    .stat-card.blue   { --card-color: #3b82f6; --card-color-dark: #2563eb; }
    .stat-card.green  { --card-color: #10b981; --card-color-dark: #059669; }
    .stat-card.purple { --card-color: #8b5cf6; --card-color-dark: #7c3aed; }
    .stat-card.orange { --card-color: #f59e0b; --card-color-dark: #d97706; }

    .stat-card-icon {
        width: 56px; height: 56px; border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 24px; color: white; margin-bottom: 20px;
        background: linear-gradient(135deg, var(--card-color) 0%, var(--card-color-dark) 100%);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    .stat-card-content h4 {
        font-size: 14px; font-weight: 600; color: #64748b;
        margin: 0 0 8px 0; text-transform: uppercase; letter-spacing: 0.5px;
    }
    .stat-card-content .stat-number {
        font-size: 36px; font-weight: 700; color: #1e293b; margin: 0; line-height: 1;
    }
    .stat-card-footer {
        margin-top: 16px; padding-top: 16px;
        border-top: 1px solid #f1f5f9; font-size: 13px; color: #64748b;
    }
    .stat-card-footer i { margin-right: 6px; }

    .info-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 24px; margin-bottom: 30px;
    }
    .info-card {
        background: white; border-radius: 16px; padding: 28px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.06); border: 1px solid #e2e8f0;
    }
    .info-card h3 {
        font-size: 18px; font-weight: 700; color: #1e293b;
        margin: 0 0 16px 0; display: flex; align-items: center; gap: 10px;
    }
    .info-card h3 i { color: #3b82f6; font-size: 20px; }
    .info-card-list { list-style: none; padding: 0; margin: 0; }
    .info-card-list li {
        padding: 12px 0; border-bottom: 1px solid #f1f5f9;
        color: #475569; font-size: 14px; display: flex; align-items: center; gap: 10px;
    }
    .info-card-list li:last-child { border-bottom: none; }
    .info-card-list li i { color: #10b981; font-size: 16px; }

    .quick-actions {
        background: white; border-radius: 16px; padding: 28px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.06); border: 1px solid #e2e8f0;
    }
    .quick-actions h3 { font-size: 18px; font-weight: 700; color: #1e293b; margin: 0 0 20px 0; }

    .action-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
        gap: 16px;
    }
    .action-btn {
        display: flex; flex-direction: column; align-items: center;
        justify-content: center; gap: 12px; padding: 24px 16px;
        background: #f8fafc; border: 2px solid #e2e8f0; border-radius: 12px;
        text-decoration: none; color: #475569; font-size: 13px; font-weight: 600;
        transition: all 0.3s ease; text-align: center;
    }
    .action-btn:hover {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: white; border-color: #3b82f6;
        transform: translateY(-2px);
        box-shadow: 0 8px 16px rgba(59,130,246,0.2);
        text-decoration: none;
    }
    .action-btn i { font-size: 28px; }

    @media (max-width: 768px) {
        .dashboard-header { padding: 24px; }
        .dashboard-header h1 { font-size: 24px; }
        .stats-row, .info-cards { grid-template-columns: 1fr; }
        .action-grid { grid-template-columns: repeat(2, 1fr); }
    }
</style>

<!-- Dashboard Header -->
<div class="row">
    <div class="col-12">
        <div class="dashboard-header">
            <h1><i class="fa-solid fa-gauge-high"></i> Tableau de Bord</h1>
            <p>Cabinet de formation IM Training - Gestion administrative complète</p>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="stats-row">
    <div class="stat-card blue">
        <div class="stat-card-icon"><i class="fa-solid fa-graduation-cap"></i></div>
        <div class="stat-card-content">
            <h4>Formations actives</h4>
            <p class="stat-number">12</p>
        </div>
        <div class="stat-card-footer"><i class="fa-solid fa-arrow-up"></i> +2 ce mois</div>
    </div>
    <div class="stat-card green">
        <div class="stat-card-icon"><i class="fa-solid fa-users"></i></div>
        <div class="stat-card-content">
            <h4>Clients</h4>
            <p class="stat-number">44</p>
        </div>
        <div class="stat-card-footer"><i class="fa-solid fa-arrow-up"></i> +5 nouveaux</div>
    </div>
    <div class="stat-card purple">
        <div class="stat-card-icon"><i class="fa-solid fa-chalkboard-user"></i></div>
        <div class="stat-card-content">
            <h4>Intervenants</h4>
            <p class="stat-number">8</p>
        </div>
        <div class="stat-card-footer"><i class="fa-solid fa-check-circle"></i> Tous actifs</div>
    </div>
    <div class="stat-card orange">
        <div class="stat-card-icon"><i class="fa-solid fa-briefcase"></i></div>
        <div class="stat-card-content">
            <h4>Opérations</h4>
            <p class="stat-number">28</p>
        </div>
        <div class="stat-card-footer"><i class="fa-solid fa-clock"></i> 6 en cours</div>
    </div>
</div>

<!-- Info Cards -->
<div class="info-cards">
    <div class="info-card">
        <h3><i class="fa-solid fa-calendar-check"></i> Activités récentes</h3>
        <ul class="info-card-list">
            <li><i class="fa-solid fa-circle-check"></i> Formation Excel avancé - Terminée</li>
            <li><i class="fa-solid fa-circle-check"></i> Nouveau client ajouté</li>
            <li><i class="fa-solid fa-circle-check"></i> Évaluation formateur complétée</li>
            <li><i class="fa-solid fa-circle-check"></i> Attestation générée</li>
        </ul>
    </div>
    <div class="info-card">
        <h3><i class="fa-solid fa-bell"></i> À venir</h3>
        <ul class="info-card-list">
            <li><i class="fa-solid fa-clock"></i> Formation Marketing - 15 Fév</li>
            <li><i class="fa-solid fa-clock"></i> Réunion équipe - 18 Fév</li>
            <li><i class="fa-solid fa-clock"></i> Déclaration mensuelle - 28 Fév</li>
            <li><i class="fa-solid fa-clock"></i> Évaluation trimestrielle - 1 Mars</li>
        </ul>
    </div>
</div>

<!-- Quick Actions -->
<div class="row">
    <div class="col-12">
        <div class="quick-actions">
            <h3><i class="fa-solid fa-bolt"></i> Actions rapides</h3>
            <div class="action-grid">

                <!-- ✅ Route: Operations > prestation_list -->
                <a href="<?=base_url()?>Operations/prestation_list" class="action-btn">
                    <i class="fa-solid fa-plus-circle"></i>
                    <span>Nouvelle<br>Prestation</span>
                </a>

                <!-- ✅ Route: Cabinet > cabinet_list -->
                <a href="<?=base_url()?>Cabinet/cabinet_list" class="action-btn">
                    <i class="fa-solid fa-user-plus"></i>
                    <span>Ajouter<br>Client</span>
                </a>

                <!-- ✅ Route: Formateur > formateurs_list -->
                <a href="<?=base_url()?>Formateur/formateurs_list" class="action-btn">
                    <i class="fa-solid fa-chalkboard-user"></i>
                    <span>Gérer<br>Formateurs</span>
                </a>

                <!-- ✅ Route: Banque > banque_list -->
                <a href="<?=base_url()?>Banque/banque_list" class="action-btn">
                    <i class="fa-solid fa-money-bill-wave"></i>
                    <span>Gestion<br>Financière</span>
                </a>

                <!-- ✅ Route: Pilotage > pilotage_list -->
                <a href="<?=base_url()?>Pilotage/pilotage_list" class="action-btn">
                    <i class="fa-solid fa-chart-line"></i>
                    <span>Voir<br>Statistiques</span>
                </a>

                <!-- ✅ Route: EtatAttestation > attestations_list -->
                <a href="<?=base_url()?>EtatAttestation/attestations_list" class="action-btn">
                    <i class="fa-solid fa-certificate"></i>
                    <span>Générer<br>Attestation</span>
                </a>

            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>