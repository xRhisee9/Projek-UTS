<?php
session_start();
if (!isset($_SESSION['role'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About - GameListID</title>
    <link href="https://cdn.jsdelivr.net/npm/@ripple-ui/core@0.4.0/dist/ripple.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/rippleui@1.12.1/dist/css/styles.css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/d795993f45.js" crossorigin="anonymous"></script>

    <style>
        body {
            background-image: url('backgroundvideo/Background3.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            color: #ffffff;
        }

        /* Navbar responsive */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem;
            background-color: #1E40AF; /* Warna biru tua */
        }

        .navbar-menu {
            display: none; /* Hide the menu by default */
            position: absolute; /* Allow dropdown behavior */
            top: 60px; /* Adjust according to your design */
            right: 0;
            background-color: #1E40AF;
            width: 100%; /* Full width on mobile */
        }

        .hamburger {
            cursor: pointer;
            display: block;
            font-size: 1.5rem;
        }

        @media (min-width: 768px) {
            .navbar-menu {
                display: flex; /* Show the menu in desktop view */
                position: static; /* Reset position */
                width: auto; /* Auto width */
            }
            .hamburger {
                display: none; /* Hide hamburger in desktop view */
            }
        }

        .navbar-menu.open {
            display: block; /* Show menu when toggled */
        }

        .navbar-menu li {
            list-style: none;
            padding: 1rem; /* Add padding for spacing */
        }

        .navbar-menu li a {
            color: white;
            text-decoration: none;
            display: block;
            text-align: center;
        }


        .about-container {
            background: rgba(0, 0, 0, 0.7);
            padding: 20px;
            border-radius: 10px;
        }

        .cv-section {
            margin-bottom: 20px;
        }

        .cv-section h2 {
            border-bottom: 2px solid #1E40AF;
            padding-bottom: 5px;
        }

        .footer {
            background-color: #1E40AF;
            padding: 10px;
            color: white;
            text-align: center;
        }

        .footer-row {
            display: flex;
            flex-direction: column;
            margin-bottom: 10px;
        }

        .footer-row span {
            margin-top: 5px;
        }

        @media (min-width: 768px) {
            .footer-row {
                flex-direction: row;
                justify-content: space-between;
            }
        }
    </style>
</head>
<body class="bg-gray-800 text-gray-300 h-screen flex flex-col">

<!-- Navbar -->
<nav class="navbar">
    <div class="logo flex items-center">
        <svg fill="none" height="42" viewBox="0 0 32 32" width="42" xmlns="http://www.w3.org/2000/svg">
            <rect height="100%" rx="16" width="100%"></rect>
            <path clip-rule="evenodd" d="M17.6482 10.1305L15.8785 7.02583L7.02979 22.5499H10.5278L17.6482 10.1305ZM19.8798 14.0457L18.11 17.1983L19.394 19.4511H16.8453L15.1056 22.5499H24.7272L19.8798 14.0457Z" fill="currentColor" fill-rule="evenodd"></path>
        </svg>
        <span class="text-white ml-2">Falauz GameListID</span>
    </div>
    <div class="hamburger text-white" onclick="toggleMenu()">
        <i class="fas fa-bars"></i>
    </div>
    <ul class="navbar-menu md:flex md:space-x-6">
        <li><a href="dashboard.php">Dashboard</a></li>
        <?php if ($_SESSION['role'] == 'admin'): ?>
            <li><a href="edit_data.php">Edit Data</a></li>
        <?php else: ?>
            <li><a href="library.php">Library</a></li>
        <?php endif; ?>
        <li><a href="about.php">About</a></li> <!-- Tambahkan link About -->
    </ul>
</nav>

    <!-- Main Content -->
    <div class="flex-grow p-4 md:p-10 text-white overflow-auto">
        <div class="max-w-4xl mx-auto about-container">
            <h1 class="text-3xl font-semibold mb-6 text-center">About</h1>
            <div class="cv-section">
                <h2 class="text-2xl">Fauzan Sahrul Ramadhan</h2>
                <p><strong>Email:</strong> fauzan@example.com</p>
                <p><strong>Phone:</strong> 123-456-7890</p>
                <h3 class="text-xl">Tentang Saya</h3>
                <p>Fauzan adalah seorang mahasiswa Informatika yang berfokus pada pengembangan perangkat lunak dan desain web. Memiliki pengalaman dalam PHP, JavaScript, dan CSS.</p>
            </div>
            <div class="cv-section">
                <h2 class="text-2xl">Muhammad Falih Alkhairy</h2>
                <p><strong>Email:</strong> falih@example.com</p>
                <p><strong>Phone:</strong> 098-765-4321</p>
                <h3 class="text-xl">Tentang Saya</h3>
                <p>Muhammad Falih adalah seorang mahasiswa Informatika yang berpengalaman dalam pengembangan aplikasi mobile dan backend. Menguasai Java, Python, dan database.</p>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-row">
            <span>&copy; 2024 Falauz GameListID.</span>
            <span>Contact: info@gameListID.com</span>
        </div>
    </footer>

    <!-- Script Toggle Menu -->
    <script>
    function toggleMenu() {
        const menu = document.querySelector('.navbar-menu');
        menu.classList.toggle('open');
    }

    // Reset the menu when the window is resized
    window.addEventListener('resize', function () {
        const menu = document.querySelector('.navbar-menu');
        if (window.innerWidth >= 768) {
            menu.classList.remove('open'); // Close menu when returning to desktop
        }
    });
</script>

</body>
</html>
