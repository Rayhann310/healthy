<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="<?= base_url('assets/img/fav.png') ?>">
    <title><?= htmlspecialchars($title) ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #0076b6;
            --secondary: #8cc63f;
            --dark: #1f2937;
            --text-gray: #4b5563;
            --bg-color: #f9fafb;
            --input-border: #e5e7eb;
            --danger: #ef4444;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Outfit', sans-serif;
        }

        body {
            background-color: var(--bg-color);
            color: var(--dark);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            position: relative;
        }

        .bg-shapes {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            overflow: hidden;
            background: var(--bg-color);
            background-image: 
                radial-gradient(at 0% 0%, hsla(201, 100%, 75%, 0.1) 0px, transparent 50%),
                radial-gradient(at 100% 100%, hsla(84, 100%, 75%, 0.1) 0px, transparent 50%);
        }

        .login-container {
            background: #ffffff;
            width: 100%;
            max-width: 420px;
            border-radius: 24px;
            padding: 3rem 2.5rem;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.04);
            border: 1px solid rgba(0, 0, 0, 0.03);
            z-index: 1;
            text-align: center;
            position: relative;
        }

        .logo img {
            height: 50px;
            margin-bottom: 1.5rem;
        }

        .login-container h2 {
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: var(--dark);
        }

        .login-container p {
            color: var(--text-gray);
            font-size: 0.95rem;
            margin-bottom: 2rem;
        }
        
        .alert-error {
            background: rgba(239, 68, 68, 0.1);
            color: var(--danger);
            padding: 0.75rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .form-group {
            text-align: left;
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--dark);
        }

        .form-control {
            width: 100%;
            padding: 0.85rem 1.2rem;
            border-radius: 12px;
            border: 1px solid var(--input-border);
            background: #ffffff;
            font-size: 1rem;
            color: var(--dark);
            outline: none;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(0, 118, 182, 0.1);
        }
        
        .form-control[readonly] {
            background: #f3f4f6;
            color: var(--text-gray);
            cursor: not-allowed;
        }

        .btn-submit {
            width: 100%;
            padding: 0.9rem;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            font-size: 1rem;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.3s;
            margin-top: 1rem;
            box-shadow: 0 8px 20px rgba(0, 118, 182, 0.2);
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 25px rgba(0, 118, 182, 0.3);
        }

        .footer-links {
            margin-top: 2rem;
            font-size: 0.9rem;
        }

        .footer-links a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
        }

        .footer-links a:hover {
            text-decoration: underline;
        }

        .fast-login-avatar {
            width: 70px;
            height: 70px;
            background: rgba(0, 118, 182, 0.1);
            color: var(--primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            font-weight: bold;
            margin: 0 auto 1rem;
            text-transform: uppercase;
        }
    </style>
</head>
<body>
    <div class="bg-shapes"></div>

    <div class="login-container">
        <div class="logo">
            <a href="<?= base_url('/') ?>">
                <img src="<?= base_url('assets/img/logo.png') ?>" alt="KathaHealthy Logo">
            </a>
        </div>
        
        <?php if (!empty($error)): ?>
            <div class="alert-error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <?php if (!empty($fastLoginUser)): ?>
            <div class="fast-login-avatar">
                <?= substr(htmlspecialchars($fastLoginUser), 0, 1) ?>
            </div>
            <h2>Session Expired</h2>
            <p>Welcome back, <strong><?= htmlspecialchars($fastLoginUser) ?></strong>! Please enter your password to continue.</p>
            
            <form action="<?= base_url('auth/login-process') ?>" method="POST">
                <input type="hidden" name="username" value="<?= htmlspecialchars($fastLoginUser) ?>">
                
                <div class="form-group">
                    <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password" required autofocus>
                </div>
                
                <button type="submit" class="btn-submit">Fast Login</button>
            </form>
            
            <div class="footer-links">
                <p><a href="<?= base_url('auth/login?reset_fast_login=1') ?>">Login with another account</a></p>
            </div>
        <?php else: ?>
            <h2>Welcome Back</h2>
            <p>Please enter your credentials to access the system.</p>

            <form action="<?= base_url('auth/login-process') ?>" method="POST">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" class="form-control" placeholder="Enter your username" required autofocus>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password" required>
                </div>
                
                <button type="submit" class="btn-submit">Sign In</button>
            </form>

            <div class="footer-links">
                <p><a href="<?= base_url('/') ?>">&larr; Back to Home</a></p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
