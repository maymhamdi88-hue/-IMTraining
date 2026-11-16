<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<style>
    .user-management-card {
        background: white;
        border-radius: 16px;
        padding: 30px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
        margin-bottom: 30px;
        border: 1px solid #e2e8f0;
    }

    .user-management-card h3 {
        color: #1e293b;
        font-weight: 700;
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 20px;
    }

    .user-management-card h3 i {
        color: #2563eb;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        font-weight: 600;
        color: #334155;
        margin-bottom: 8px;
        font-size: 14px;
        display: block;
    }

    .form-group label .text-danger {
        color: #ef4444;
        margin-left: 3px;
    }

    .form-control {
        border: 2px solid #e2e8f0;
        border-radius: 8px;
        padding: 10px 14px;
        font-size: 14px;
        transition: all 0.3s ease;
        width: 100%;
    }

    .form-control:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
        outline: none;
    }

    .btn-primary-custom {
        background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
        color: white;
        border: none;
        padding: 12px 30px;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .btn-primary-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(37, 99, 235, 0.4);
    }

    .btn-secondary {
        background: #64748b;
        color: white;
        border: none;
        padding: 12px 30px;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        display: inline-block;
        transition: all 0.3s ease;
    }

    .btn-secondary:hover {
        background: #475569;
        color: white;
        text-decoration: none;
    }

    .table-modern {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        width: 100%;
        border-collapse: collapse;
    }

    .table-modern thead {
        background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
        color: white;
    }

    .table-modern thead th {
        padding: 16px;
        font-weight: 600;
        border: none;
        text-align: left;
        font-size: 14px;
    }

    .table-modern tbody td {
        padding: 14px 16px;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
        font-size: 14px;
    }

    .table-modern tbody tr:hover {
        background: #f8fafc;
    }

    .table-modern tbody tr:last-child td {
        border-bottom: none;
    }

    .badge-role {
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        display: inline-block;
    }

    .badge-admin {
        background: #fee2e2;
        color: #991b1b;
    }

    .badge-user {
        background: #dbeafe;
        color: #1e40af;
    }

    .badge-manager {
        background: #fef3c7;
        color: #92400e;
    }

    .alert-modern {
        border-radius: 10px;
        padding: 14px 18px;
        border: none;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 14px;
    }

    .alert-success {
        background: #d1fae5;
        color: #065f46;
    }

    .alert-danger {
        background: #fee2e2;
        color: #991b1b;
    }

    .btn-action {
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 13px;
        text-decoration: none;
        display: inline-block;
        margin-right: 5px;
        transition: all 0.3s ease;
    }

    .btn-action i {
        margin-right: 4px;
    }

    .btn-action.btn-edit {
        background: #3b82f6;
        color: white;
    }

    .btn-action.btn-edit:hover {
        background: #2563eb;
        color: white;
    }

    .btn-action.btn-delete {
        background: #ef4444;
        color: white;
    }

    .btn-action.btn-delete:hover {
        background: #dc2626;
        color: white;
    }

    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: #94a3b8;
    }

    .empty-state i {
        font-size: 48px;
        margin-bottom: 15px;
    }
</style>

<!-- Messages Flash -->
<?php if (session()->getFlashdata('success')): ?>
    <div class="alert-modern alert-success">
        <i class="fa-solid fa-circle-check"></i>
        <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert-modern alert-danger">
        <i class="fa-solid fa-circle-exclamation"></i>
        <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>

<!-- Formulaire Ajout/Modification -->
<div class="row">
    <div class="col-md-12">
        <div class="user-management-card">
            <h3>
                <i class="fa-solid fa-user-<?= isset($utilisateur_edit) ? 'pen' : 'plus' ?>"></i>
                <?= isset($utilisateur_edit) ? "Modification d'un utilisateur" : "Ajout d'un utilisateur" ?>
            </h3>

            <form method="post" action="<?= isset($utilisateur_edit) ? site_url('utilisateurs/update/'.$utilisateur_edit['id']) : site_url('utilisateurs/store') ?>">
                <?= csrf_field() ?>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Prénom</label>
                            <input type="text" name="prenom" class="form-control" 
                                   value="<?= $utilisateur_edit['prenom'] ?? old('prenom') ?? '' ?>" 
                                   placeholder="Prénom de l'utilisateur">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>
                                Nom d'utilisateur 
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="nom_utilisateur" class="form-control" 
                                   value="<?= $utilisateur_edit['nom_utilisateur'] ?? old('nom_utilisateur') ?? '' ?>" 
                                   placeholder="Nom d'utilisateur (login)" 
                                   required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" 
                                   value="<?= $utilisateur_edit['email'] ?? old('email') ?? '' ?>" 
                                   placeholder="adresse@email.com">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>
                                Rôle 
                                <span class="text-danger">*</span>
                            </label>
                            <select name="role" class="form-control" required>
                                <option value="user" <?= (isset($utilisateur_edit) && $utilisateur_edit['role'] == 'user') ? 'selected' : '' ?>>
                                    Utilisateur
                                </option>
                                <option value="admin" <?= (isset($utilisateur_edit) && $utilisateur_edit['role'] == 'admin') ? 'selected' : '' ?>>
                                    Administrateur
                                </option>
                                <option value="manager" <?= (isset($utilisateur_edit) && $utilisateur_edit['role'] == 'manager') ? 'selected' : '' ?>>
                                    Manager
                                </option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>
                        Mot de passe 
                        <?= isset($utilisateur_edit) ? '(Laissez vide pour ne pas modifier)' : '<span class="text-danger">*</span>' ?>
                    </label>
                    <input type="password" name="mot_de_passe" class="form-control" 
                           placeholder="Minimum 6 caractères" 
                           <?= isset($utilisateur_edit) ? '' : 'required' ?>>
                    <?php if (!isset($utilisateur_edit)): ?>
                        <small style="color: #64748b; font-size: 12px;">Minimum 6 caractères requis</small>
                    <?php endif; ?>
                </div>

                <div class="text-center" style="margin-top: 25px;">
                    <button type="submit" class="btn-primary-custom">
                        <i class="fa-solid fa-<?= isset($utilisateur_edit) ? 'save' : 'plus' ?>"></i>
                        <?= isset($utilisateur_edit) ? "Enregistrer les modifications" : "Ajouter l'utilisateur" ?>
                    </button>
                    
                    <?php if (isset($utilisateur_edit)): ?>
                        <a href="<?= site_url('utilisateurs') ?>" class="btn-secondary">
                            <i class="fa-solid fa-times"></i> Annuler
                        </a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Liste des Utilisateurs -->
<div class="row">
    <div class="col-md-12">
        <div class="user-management-card">
            <h3>
                <i class="fa-solid fa-users"></i>
                Liste des utilisateurs
            </h3>

            <div class="table-responsive">
                <table class="table-modern">
                    <thead>
                        <tr>
                            <th>Prénom</th>
                            <th>Nom d'utilisateur</th>
                            <th>Email</th>
                            <th>Rôle</th>
                            <th>Dernière connexion</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($utilisateur)): ?>
                            <?php foreach ($utilisateur as $u): ?>
                                <tr>
                                    <td><?= esc($u['prenom'] ?? '-') ?></td>
                                    <td><strong><?= esc($u['nom_utilisateur']) ?></strong></td>
                                    <td><?= esc($u['email'] ?? '-') ?></td>
                                    <td>
                                        <?php 
                                        $roleClass = 'badge-user';
                                        if ($u['role'] == 'admin') $roleClass = 'badge-admin';
                                        if ($u['role'] == 'manager') $roleClass = 'badge-manager';
                                        ?>
                                        <span class="badge-role <?= $roleClass ?>">
                                            <?= ucfirst($u['role']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php if (!empty($u['derniere_connexion'])): ?>
                                            <?= date('d/m/Y H:i', strtotime($u['derniere_connexion'])) ?>
                                        <?php else: ?>
                                            <span style="color: #94a3b8;">Jamais</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="<?= site_url('Utilisateurs/modifier_utilisateur/'.$u['id']) ?>" 
                                           class="btn-action btn-edit" 
                                           title="Modifier">
                                            <i class="fa fa-edit"></i> Modifier
                                        </a>
                                        <a href="<?= site_url('Utilisateurs/delete/'.$u['id']) ?>"
                                           onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')"
                                           class="btn-action btn-delete" 
                                           title="Supprimer">
                                            <i class="fa fa-trash"></i> Supprimer
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="empty-state">
                                    <i class="fa-solid fa-inbox"></i>
                                    <p>Aucun utilisateur trouvé</p>
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