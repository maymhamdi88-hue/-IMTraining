<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - IM Training</title>
    <link href="<?=base_url()?>/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            font-family: 'Inter', 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            max-width: 900px;
            width: 100%;
            display: flex;
        }

        .login-left {
            flex: 1;
            background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
            padding: 60px 40px;
            color: white;
        }

        .login-left h1 {
            font-size: 36px;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
            margin-top: 40px;
        }

        .feature-item i {
            font-size: 24px;
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-right {
            flex: 1;
            padding: 60px 40px;
        }

        .login-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .login-header img {
            width: 80px;
            border-radius: 16px;
            margin-bottom: 20px;
        }

        .login-header h2 {
            font-size: 28px;
            font-weight: 700;
            color: #1e293b;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-group label {
            font-weight: 600;
            color: #334155;
            margin-bottom: 8px;
        }

        .input-group i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
        }

        .form-control {
            padding: 14px 16px 14px 48px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
        }

        .form-control:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
        }

        .btn-login {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(37, 99, 235, 0.4);
        }

        .alert {
            padding: 12px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .alert-danger {
            background: #fee2e2;
            color: #991b1b;
        }

        .alert-success {
            background: #d1fae5;
            color: #065f46;
        }

        /* Divider & Register Link */
        .divider {
            text-align: center;
            margin: 30px 0;
            position: relative;
        }

        .divider::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            width: 100%;
            height: 1px;
            background: #e2e8f0;
        }

        .divider span {
            background: white;
            padding: 0 15px;
            color: #64748b;
            font-size: 14px;
            position: relative;
        }

        .register-link {
            text-align: center;
            margin-top: 20px;
            color: #64748b;
            font-size: 14px;
        }

        .register-link a {
            color: #2563eb;
            font-weight: 600;
            text-decoration: none;
        }

        .register-link a:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-left">
            <h1><i class="fa-solid fa-graduation-cap"></i> IM Training</h1>
            <p>Cabinet de formation - Gestion administrative complète</p>
            
            <div class="feature-item">
                <i class="fa-solid fa-chart-line"></i>
                <span>Gestion simplifiée</span>
            </div>
            <div class="feature-item">
                <i class="fa-solid fa-users"></i>
                <span>Suivi clients</span>
            </div>
        </div>

        <div class="login-right">
            <div class="login-header">
                <img src="<?=base_url()?>/plugins/images/logo im training png.png" alt="IM Training">
                <h2>Connexion</h2>
                <p>Accédez à votre espace</p>
            </div>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success">
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('Auth/attemptLogin') ?>" method="POST">
                <?= csrf_field() ?>

                <div class="form-group">
                    <label>Login ou Email</label>
                    <div class="input-group" style="position: relative;">
                        <i class="fa-solid fa-user"></i>
                        <input type="text" class="form-control" name="login" 
                               placeholder="Votre login" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Mot de passe</label>
                    <div class="input-group" style="position: relative;">
                        <i class="fa-solid fa-lock"></i>
                        <input type="password" class="form-control" name="mot_de_passe" 
                               placeholder="Votre mot de passe" required>
                    </div>
                </div>

                <button type="submit" class="btn-login">
                    Se connecter
                </button>
            </form>

            <!-- Lien Créer Compte -->
            <div class="divider">
                <span>OU</span>
            </div>

            <div class="register-link">
                Pas encore de compte ? <a href="<?= base_url('Auth/register') ?>">Créer un compte</a>
            </div>
        </div>
    </div>
</body>
</html>