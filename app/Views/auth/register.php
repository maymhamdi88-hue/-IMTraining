<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - IM Training</title>
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

        .register-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            max-width: 900px;
            width: 100%;
            display: flex;
        }

        .register-left {
            flex: 1;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            padding: 60px 40px;
            color: white;
        }

        .register-left h1 {
            font-size: 36px;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .register-left p {
            font-size: 16px;
            opacity: 0.9;
            line-height: 1.6;
            margin-bottom: 40px;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
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

        .register-right {
            flex: 1;
            padding: 50px 40px;
            max-height: 90vh;
            overflow-y: auto;
        }

        .register-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .register-header img {
            width: 70px;
            border-radius: 16px;
            margin-bottom: 15px;
        }

        .register-header h2 {
            font-size: 26px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 5px;
        }

        .register-header p {
            color: #64748b;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            font-weight: 600;
            color: #334155;
            margin-bottom: 8px;
            font-size: 13px;
        }

        .form-group label .required {
            color: #ef4444;
            margin-left: 3px;
        }

        .input-group {
            position: relative;
        }

        .input-group i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 16px;
        }

        .form-control {
            padding: 12px 16px 12px 44px;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #10b981;
            box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
            outline: none;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .btn-register {
            width: 100%;
            padding: 13px;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(16, 185, 129, 0.4);
        }

        .divider {
            text-align: center;
            margin: 25px 0;
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
            font-size: 13px;
            position: relative;
        }

        .login-link {
            text-align: center;
            margin-top: 20px;
            color: #64748b;
            font-size: 14px;
        }

        .login-link a {
            color: #10b981;
            font-weight: 600;
            text-decoration: none;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        .alert {
            padding: 12px 16px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 13px;
        }

        .alert-danger {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }

        .error-text {
            color: #ef4444;
            font-size: 12px;
            margin-top: 5px;
            display: none;
        }

        .error-text.show {
            display: block;
        }

        @media (max-width: 768px) {
            .register-container {
                flex-direction: column;
            }

            .register-left {
                padding: 40px 30px;
            }

            .register-right {
                padding: 40px 30px;
                max-height: none;
            }

            .form-row {
                grid-template-columns: 1fr;
            }
        }

        /* Scrollbar for register-right */
        .register-right::-webkit-scrollbar {
            width: 6px;
        }

        .register-right::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        .register-right::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <!-- Left Side -->
        <div class="register-left">
            <h1><i class="fa-solid fa-user-plus"></i> Rejoignez-nous</h1>
            <p>Créez votre compte pour accéder à la plateforme de gestion IM Training</p>
            
            <div class="features">
                <div class="feature-item">
                    <i class="fa-solid fa-shield-halved"></i>
                    <span>Sécurité garantie</span>
                </div>
                <div class="feature-item">
                    <i class="fa-solid fa-bolt"></i>
                    <span>Accès instantané</span>
                </div>
                <div class="feature-item">
                    <i class="fa-solid fa-headset"></i>
                    <span>Support 24/7</span>
                </div>
            </div>
        </div>

        <!-- Right Side - Form -->
        <div class="register-right">
            <div class="register-header">
                <img src="<?=base_url()?>/plugins/images/logo im training png.png" alt="IM Training">
                <h2>Créer un compte</h2>
                <p>Remplissez le formulaire ci-dessous</p>
            </div>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('errors')): ?>
                <div class="alert alert-danger">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <ul style="margin: 5px 0 0 20px; padding: 0;">
                        <?php foreach (session()->getFlashdata('errors') as $error): ?>
                            <li><?= $error ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('Auth/attemptRegister') ?>" method="POST" id="registerForm">
                <?= csrf_field() ?>

                <!-- Prénom -->
                <div class="form-group">
                    <label for="prenom">Prénom</label>
                    <div class="input-group">
                        <i class="fa-solid fa-user"></i>
                        <input 
                            type="text" 
                            class="form-control" 
                            id="prenom" 
                            name="prenom" 
                            placeholder="Entrez votre prénom"
                            value="<?= old('prenom') ?>"
                        >
                    </div>
                </div>

                <!-- Nom d'utilisateur -->
                <div class="form-group">
                    <label for="nom_utilisateur">
                        Nom d'utilisateur <span class="required">*</span>
                    </label>
                    <div class="input-group">
                        <i class="fa-solid fa-at"></i>
                        <input 
                            type="text" 
                            class="form-control" 
                            id="nom_utilisateur" 
                            name="nom_utilisateur" 
                            placeholder="Choisissez un nom d'utilisateur"
                            value="<?= old('nom_utilisateur') ?>"
                            required
                        >
                    </div>
                </div>

                <!-- Email -->
                <div class="form-group">
                    <label for="email">Email</label>
                    <div class="input-group">
                        <i class="fa-solid fa-envelope"></i>
                        <input 
                            type="email" 
                            class="form-control" 
                            id="email" 
                            name="email" 
                            placeholder="votre@email.com"
                            value="<?= old('email') ?>"
                        >
                    </div>
                </div>

                <!-- Mot de passe -->
                <div class="form-group">
                    <label for="mot_de_passe">
                        Mot de passe <span class="required">*</span>
                    </label>
                    <div class="input-group">
                        <i class="fa-solid fa-lock"></i>
                        <input 
                            type="password" 
                            class="form-control" 
                            id="mot_de_passe" 
                            name="mot_de_passe" 
                            placeholder="Minimum 6 caractères"
                            required
                        >
                    </div>
                    <small style="color: #64748b; font-size: 12px;">Au moins 6 caractères</small>
                </div>

                <!-- Confirmer mot de passe -->
                <div class="form-group">
                    <label for="confirmer_mot_de_passe">
                        Confirmer le mot de passe <span class="required">*</span>
                    </label>
                    <div class="input-group">
                        <i class="fa-solid fa-lock"></i>
                        <input 
                            type="password" 
                            class="form-control" 
                            id="confirmer_mot_de_passe" 
                            name="confirmer_mot_de_passe" 
                            placeholder="Retapez votre mot de passe"
                            required
                        >
                    </div>
                </div>

                <button type="submit" class="btn-register">
                    <i class="fa-solid fa-user-plus"></i> Créer mon compte
                </button>
            </form>

            <div class="divider">
                <span>OU</span>
            </div>

            <div class="login-link">
                Vous avez déjà un compte ? <a href="<?= base_url('Auth/login') ?>">Se connecter</a>
            </div>
        </div>
    </div>

    <script>
        // Validation côté client
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            const password = document.getElementById('mot_de_passe').value;
            const confirmPassword = document.getElementById('confirmer_mot_de_passe').value;

            if (password !== confirmPassword) {
                e.preventDefault();
                alert('Les mots de passe ne correspondent pas !');
                return false;
            }

            if (password.length < 6) {
                e.preventDefault();
                alert('Le mot de passe doit contenir au moins 6 caractères !');
                return false;
            }
        });
    </script>
</body>
</html>