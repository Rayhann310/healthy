<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="<?= base_url('assets/img/fav.png') ?>">
    <title><?= htmlspecialchars($title ?? 'KathaHealthy') ?></title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        :root {
            --primary: #0076b6;
            --primary-hover: #005a8f;
            --secondary: #8cc63f;
            --dark: #1f2937;
            --text-gray: #4b5563;
            --text-light: #9ca3af;
            --bg-body: #f3f4f6;
            --bg-card: #ffffff;
            --border-color: #e5e7eb;
            --sidebar-width: 260px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Outfit', sans-serif;
        }

        body {
            background-color: var(--bg-body);
            color: var(--dark);
            display: flex;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Sidebar Styles */
        .sidebar {
            width: var(--sidebar-width);
            background-color: var(--bg-card);
            border-right: 1px solid var(--border-color);
            position: fixed;
            height: 100vh;
            display: flex;
            flex-direction: column;
            z-index: 100;
            transition: transform 0.3s ease;
        }

        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .sidebar-header img {
            height: 40px;
        }

        .sidebar-menu {
            padding: 1.5rem 1rem;
            flex-grow: 1;
            overflow-y: auto;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            padding: 0.8rem 1rem;
            color: var(--text-gray);
            text-decoration: none;
            font-weight: 500;
            border-radius: 8px;
            margin-bottom: 0.5rem;
            transition: all 0.2s ease;
        }

        .sidebar-menu a svg {
            margin-right: 12px;
            width: 20px;
            height: 20px;
            stroke: currentColor;
            fill: none;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .sidebar-menu a:hover, .sidebar-menu a.active {
            background-color: rgba(0, 118, 182, 0.05);
            color: var(--primary);
        }

        /* Main Content Area */
        .main-content {
            flex-grow: 1;
            margin-left: var(--sidebar-width);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            width: calc(100% - var(--sidebar-width));
        }

        /* Navbar Styles */
        .navbar {
            height: 70px;
            background-color: var(--bg-card);
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2rem;
            position: sticky;
            top: 0;
            z-index: 90;
        }

        .navbar-title {
            font-size: 1.2rem;
            font-weight: 600;
        }

        .navbar-user {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: rgba(0, 118, 182, 0.1);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            text-transform: uppercase;
        }

        .logout-btn {
            color: var(--text-gray);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            transition: color 0.2s;
        }

        .logout-btn:hover {
            color: #ef4444;
        }

        /* Content Padding */
        .content {
            padding: 2rem;
            flex-grow: 1;
        }

        /* Minimalist Cards */
        .card {
            background-color: var(--bg-card);
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            border: 1px solid var(--border-color);
        }

        .page-title {
            margin-bottom: 1.5rem;
            font-size: 1.5rem;
            font-weight: 700;
        }

        /* Footer Styles */
        .footer {
            padding: 1.5rem 2rem;
            text-align: center;
            color: var(--text-light);
            font-size: 0.9rem;
            border-top: 1px solid var(--border-color);
            background-color: var(--bg-card);
        }

        /* Mobile Toggle */
        .mobile-toggle {
            display: none;
            background: none;
            border: none;
            cursor: pointer;
            color: var(--dark);
        }
        
        .mobile-toggle svg {
            width: 24px;
            height: 24px;
            stroke: currentColor;
            stroke-width: 2;
        }

        /* Modal Styles */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.5);
            backdrop-filter: blur(4px);
            z-index: 1000;
            display: none;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .modal-overlay.active {
            display: flex;
            opacity: 1;
        }

        .modal-content {
            background: var(--bg-card);
            border-radius: 20px;
            padding: 2rem;
            width: 90%;
            max-width: 450px;
            max-height: 90vh;
            overflow-y: auto;
            transform: translateY(20px);
            transition: transform 0.3s ease;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }
        
        .modal-overlay.active .modal-content {
            transform: translateY(0);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }
        
        .modal-title {
            font-size: 1.3rem;
            font-weight: 700;
        }
        
        .modal-close {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: var(--text-gray);
        }

        /* Form Components */
        .form-group {
            margin-bottom: 1.2rem;
        }
        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            font-size: 0.9rem;
            color: var(--dark);
        }
        .form-control {
            width: 100%;
            padding: 0.8rem 1rem;
            border: 1px solid var(--border-color);
            border-radius: 10px;
            font-family: 'Outfit', sans-serif;
            font-size: 1rem;
            transition: border-color 0.2s;
        }
        .form-control:focus {
            outline: none;
            border-color: var(--primary);
        }
        
        .btn {
            padding: 0.8rem 1.5rem;
            border-radius: 10px;
            border: none;
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
            font-family: 'Outfit', sans-serif;
            transition: transform 0.2s, background-color 0.2s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        
        .btn-primary {
            background: var(--primary);
            color: white;
        }
        .btn-primary:hover {
            background: var(--primary-hover);
            transform: translateY(-2px);
        }
        
        /* Utility */
        .flex-between {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .table-responsive {
            overflow-x: auto;
            width: 100%;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.show {
                transform: translateX(0);
                box-shadow: 4px 0 20px rgba(0,0,0,0.1);
            }
            .main-content {
                margin-left: 0;
                width: 100%;
            }
            .mobile-toggle {
                display: block;
            }
            .navbar { padding: 0 1rem; }
            .content { padding: 1rem; }
        }
    </style>
</head>
<body>
