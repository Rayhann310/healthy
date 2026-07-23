<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?></title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary: #0076b6; /* blue from logo */
            --secondary: #8cc63f; /* green from logo */
            --dark: #1f2937;
            --text-gray: #4b5563;
            --bg-color: #ffffff;
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
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
        }

        /* Subtle Background to look modern but clean */
        .bg-shapes {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            overflow: hidden;
            background: #ffffff;
            background-image: 
                radial-gradient(at 0% 0%, hsla(201, 100%, 75%, 0.1) 0px, transparent 50%),
                radial-gradient(at 100% 100%, hsla(84, 100%, 75%, 0.1) 0px, transparent 50%);
        }

        /* Navigation */
        nav {
            padding: 1.5rem 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(15px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .logo img {
            height: 55px;
            width: auto;
            object-fit: contain;
        }

        .nav-links a {
            color: var(--text-gray);
            text-decoration: none;
            margin-left: 2.5rem;
            font-weight: 500;
            transition: color 0.3s;
        }

        .nav-links a:hover {
            color: var(--primary);
        }

        /* Hero Section */
        .hero {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 5rem 5% 4rem;
            position: relative;
        }

        .hero-content {
            text-align: center;
            max-width: 900px;
            z-index: 1;
        }

        .badge {
            display: inline-block;
            padding: 0.5rem 1.5rem;
            border-radius: 50px;
            background: rgba(0, 118, 182, 0.05);
            border: 1px solid rgba(0, 118, 182, 0.15);
            color: var(--primary);
            font-size: 0.95rem;
            font-weight: 600;
            margin-bottom: 2rem;
            animation: slideUp 0.8s ease forwards;
            opacity: 0;
            transform: translateY(20px);
        }

        .hero h1 {
            font-size: 4.5rem;
            line-height: 1.1;
            font-weight: 800;
            margin-bottom: 1.5rem;
            letter-spacing: -1.5px;
            animation: slideUp 0.8s ease 0.2s forwards;
            opacity: 0;
            transform: translateY(20px);
            color: var(--dark);
        }

        .hero h1 .highlight {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero p {
            font-size: 1.25rem;
            color: var(--text-gray);
            margin-bottom: 3rem;
            max-width: 650px;
            margin-inline: auto;
            line-height: 1.6;
            animation: slideUp 0.8s ease 0.4s forwards;
            opacity: 0;
            transform: translateY(20px);
        }

        /* Clean Cards Container */
        .features {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
            margin-top: 4rem;
            animation: slideUp 0.8s ease 0.6s forwards;
            opacity: 0;
            transform: translateY(20px);
        }

        .clean-card {
            background: #ffffff;
            border: 1px solid rgba(0, 0, 0, 0.05);
            border-radius: 24px;
            padding: 2.5rem;
            text-align: left;
            transition: all 0.3s ease;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03);
            cursor: pointer;
        }

        .clean-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
            border-color: rgba(0, 118, 182, 0.15);
        }

        .icon-box {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            background: rgba(0, 118, 182, 0.06);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            color: var(--primary);
        }

        .icon-box svg {
            width: 26px;
            height: 26px;
            stroke: currentColor;
            stroke-width: 2;
            fill: none;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .clean-card h3 {
            font-size: 1.35rem;
            margin-bottom: 1rem;
            font-weight: 600;
            color: var(--dark);
        }

        .clean-card p {
            font-size: 1rem;
            color: var(--text-gray);
            margin: 0;
            line-height: 1.6;
        }

        /* Buttons */
        .btn-group {
            display: flex;
            gap: 1.25rem;
            justify-content: center;
            animation: slideUp 0.8s ease 0.5s forwards;
            opacity: 0;
            transform: translateY(20px);
        }

        .btn {
            padding: 1.1rem 2.8rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1rem;
            text-decoration: none;
            transition: all 0.3s ease;
            cursor: pointer;
            border: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            box-shadow: 0 10px 25px rgba(0, 118, 182, 0.25);
        }

        .btn-primary:hover {
            box-shadow: 0 15px 35px rgba(0, 118, 182, 0.35);
            transform: translateY(-3px);
        }

        .btn-outline {
            background: white;
            color: var(--primary);
            border: 2px solid rgba(0, 118, 182, 0.15);
        }

        .btn-outline:hover {
            border-color: var(--primary);
            color: var(--primary);
            background: rgba(0, 118, 182, 0.03);
            transform: translateY(-3px);
        }

        @keyframes slideUp {
            to { opacity: 1; transform: translateY(0); }
        }

        .nav-links .btn-signin {
            color: var(--primary); 
            font-weight: 600;
        }

        @media (max-width: 900px) {
            .hero h1 { font-size: 2.5rem; }
            .hero p { font-size: 1.1rem; padding: 0 1rem; }
            .features { grid-template-columns: 1fr; gap: 1.5rem; }
            .nav-links a:not(.btn-signin) { display: none; }
            .nav-links .btn-signin {
                background: var(--primary);
                color: white !important;
                padding: 0.5rem 1.2rem;
                border-radius: 50px;
                margin-left: 0;
            }
            .btn-group { flex-direction: column; width: 100%; padding: 0 1rem; box-sizing: border-box; }
            .btn { width: 100%; }
            .hero { padding: 3rem 1rem 2rem; }
        }
    </style>
</head>
<body>

    <div class="bg-shapes"></div>

    <nav>
        <div class="logo">
            <img src="<?= base_url('assets/img/logo.png') ?>" alt="KathaHealthy Logo">
        </div>
        <div class="nav-links">
            <a href="#">About</a>
            <a href="#">Features</a>
            <a href="#">Contact</a>
            <a href="<?= base_url('auth/login') ?>" class="btn-signin">Sign In</a>
        </div>
    </nav>

    <div class="hero">
        <div class="hero-content">
            <div class="badge">Advanced Health Analytics</div>
            <h1>Smart Blood Pressure <br><span class="highlight">Monitoring System</span></h1>
            <p>Empower your cardiovascular health with real-time analytics, insightful tracking, and modern technological precision.</p>
            
            <div class="btn-group">
                <a href="<?= base_url('auth/login') ?>" class="btn btn-primary">Get Started</a>
                <a href="<?= base_url('dashboard') ?>" class="btn btn-outline">View Dashboard</a>
            </div>

            <div class="features">
                <div class="clean-card">
                    <div class="icon-box">
                        <svg viewBox="0 0 24 24"><path d="M3 3v18h18"/><path d="M18 17V9"/><path d="M13 17V5"/><path d="M8 17v-3"/></svg>
                    </div>
                    <h3>Analytics</h3>
                    <p>Track your systolic and diastolic pressure trends with beautifully rendered charts.</p>
                </div>
                <div class="clean-card">
                    <div class="icon-box">
                        <svg viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                    </div>
                    <h3>Secure</h3>
                    <p>Your health data is encrypted and protected by industry-standard security protocols.</p>
                </div>
                <div class="clean-card">
                    <div class="icon-box">
                        <svg viewBox="0 0 24 24"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg>
                    </div>
                    <h3>Fast</h3>
                    <p>Built on a custom high-performance architecture to ensure seamless experience.</p>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
