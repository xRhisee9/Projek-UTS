<?php
session_start();
if (!isset($_SESSION['role'])) {
    header("Location: login.php");
    exit();
}

// Koneksi ke database
$servername = "localhost";
$username = "root"; // Ganti dengan username database Anda
$password = ""; // Ganti dengan password database Anda
$dbname = "tugas"; // Ganti dengan nama database Anda

$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Inisialisasi array library jika belum ada
if (!isset($_SESSION['library'])) {
    $_SESSION['library'] = [];
}

// Menambahkan game ke library jika parameter 'add' ada
if (isset($_GET['add'])) {
    $gameId = intval($_GET['add']);
    if (!in_array($gameId, $_SESSION['library'])) {
        $_SESSION['library'][] = $gameId; // Tambahkan ID game ke library session
    }
}

// Menghapus game dari library jika parameter 'remove' ada
if (isset($_GET['remove'])) {
    $gameIdToRemove = intval($_GET['remove']);
    $_SESSION['library'] = array_diff($_SESSION['library'], [$gameIdToRemove]); // Hapus ID game dari library
}

// Dapatkan pencarian dari user
$searchQuery = isset($_GET['search']) ? trim($_GET['search']) : '';

// Mengambil data game dari database untuk ditampilkan di library
function getLibraryGames($conn, $library, $searchQuery) {
    if (empty($library)) return []; // Mengembalikan array kosong jika library kosong
    
    // Membangun query SQL
    $ids = implode(',', array_map('intval', $library));
    $searchQuery = $conn->real_escape_string($searchQuery); // Prevent SQL Injection
    $sql = "SELECT * FROM uts WHERE id IN ($ids) AND (nama_game LIKE '%$searchQuery%' OR berat_game LIKE '%$searchQuery%')";
    
    return $conn->query($sql); // Mengembalikan objek mysqli_result
}

// Dapatkan data game di library
$libraryGames = getLibraryGames($conn, $_SESSION['library'], $searchQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Game</title>
    <!-- Link Ripple UI -->
    <link href="https://cdn.jsdelivr.net/npm/@ripple-ui/core@0.4.0/dist/ripple.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/rippleui@1.12.1/dist/css/styles.css" />
    <!-- Link Tailwinds -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Link FontAwesome -->
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

        /* Footer */
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
    <div class="flex-grow p-10 text-white">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-3xl font-semibold mb-6">Library Game</h1>

            <!-- Search Form -->
            <form method="get" class="mb-6 flex flex-col sm:flex-row justify-left">
                <input type="text" name="search" value="<?= htmlspecialchars($searchQuery); ?>" placeholder="Cari game..." class="p-2 rounded-l-lg text-white sm:w-64 w-full mb-2 sm:mb-0">
                <button type="submit" class="bg-blue-600 text-white p-2 rounded-r-lg">Cari</button>
            </form>

            <h1 class="my-2">Daftar Game yang Ditambahkan</h1>
            <div class="overflow-x-auto">
                <table class="w-full bg-white text-black rounded-lg overflow-hidden">
                    <thead class="bg-gray-500 text-white">
                        <tr>
                            <th class="px-4 py-2">ID Game</th>
                            <th class="px-4 py-2">Nama Game</th>
                            <th class="px-4 py-2">Berat Game</th>
                            <th class="px-4 py-2">Harga Game</th>
                            <th class="px-4 py-2">Tanggal Rilis</th>
                            <th class="px-4 py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($libraryGames && $libraryGames->num_rows > 0): ?>
                            <?php while ($game = $libraryGames->fetch_assoc()) : ?>
                                <tr>
                                    <td class="border px-4 py-2"><?= $game['id']; ?></td>
                                    <td class="border px-4 py-2"><?= $game['nama_game']; ?></td>
                                    <td class="border px-4 py-2"><?= $game['berat_game']; ?></td>
                                    <td class="border px-4 py-2"><?= $game['harga_game']; ?></td>
                                    <td class="border px-4 py-2"><?= $game['tgl_rilis']; ?></td>
                                    <td class="border px-4 py-2">
                                        <a href="library.php?remove=<?= $game['id']; ?>" class="btn btn-error">Batalkan</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center">Game tidak ditemukan</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <a href="dashboard.php" class="btn btn-warning my-5">Kembali ke Dashboard</a>
        </div>
    </div>

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

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-row">
            <span>&copy; 2024 Falauz GameListID.</span>
            <span>Contact: info@gameListID.com</span>
        </div>
    </footer>
</body>
</html>
