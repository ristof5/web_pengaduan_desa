<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sukasari Digital - Layanan Pengaduan</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Inter:wght@300;400;500;700&family=Source+Code+Pro:wght@400;600&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --forest-black: #001e2b;
            --mongodb-green: #00ed64;
            --dark-green: #00684a;
            --action-blue: #006cfa;
            --teal-gray: #3d4f58;
            --silver-teal: #b8c4c2;
            --forest-shadow: rgba(0, 30, 43, 0.12) 0px 26px 44px;
        }

        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            font-weight: 300; /* MongoDB style uses 300 for body */
            background-color: #fff;
            color: #001e2b;
        }

        h1, h2, .serif-font {
            font-family: 'Playfair Display', serif;
        }

        .label-tech {
            font-family: 'Source Code Pro', monospace;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-size: 14px;
        }

        /* Header / Navbar */
        nav {
            background-color: var(--forest-black);
            padding: 1.2rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid var(--teal-gray);
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #fff;
            text-decoration: none;
        }

        .logo-icon {
            width: 30px;
            height: 30px;
            background-color: var(--mongodb-green);
            border-radius: 6px;
        }

        .nav-links a {
            color: #fff;
            text-decoration: none;
            margin-left: 24px;
            font-weight: 500;
            font-size: 16px;
        }

        .btn-pill {
            border-radius: 100px;
            padding: 10px 24px;
            font-weight: 700;
            text-decoration: none;
            transition: transform 0.2s;
            display: inline-block;
        }

        .btn-green {
            background-color: var(--dark-green);
            color: #fff;
            border: 1px solid var(--dark-green);
        }

        .btn-green:hover {
            transform: scale(1.05);
            background-color: var(--mongodb-green);
            color: var(--forest-black);
        }
    </style>
</head>
<body>

<nav>
    <a href="/" class="logo">
        <div class="logo-icon"></div>
        <span style="font-weight:700; font-size: 18px;">SUKASARI <span style="font-weight:300; color: var(--silver-teal)">DIGITAL</span></span>
    </a>
    <div class="nav-links">
        <a href="#">Beranda</a>
        <a href="#">Prosedur</a>
        <a href="#">Cek Laporan</a>
        <a href="#" class="btn-pill btn-green">Buat Laporan</a>
    </div>
</nav>