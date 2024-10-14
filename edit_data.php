<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
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

// Fungsi untuk menyimpan data game
function saveGame($conn, $id, $name, $weight, $price, $releaseDate) {
    $stmt = $conn->prepare("INSERT INTO uts (id, nama_game, berat_game, harga_game, tgl_rilis) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issss", $id, $name, $weight, $price, $releaseDate);
    $stmt->execute();
    $stmt->close();
}

// Fungsi untuk memperbarui data game
function updateGame($conn, $id, $name, $weight, $price, $releaseDate) {
    $stmt = $conn->prepare("UPDATE uts SET nama_game = ?, berat_game = ?, harga_game = ?, tgl_rilis = ? WHERE id = ?");
    $stmt->bind_param("ssssi", $name, $weight, $price, $releaseDate, $id);
    $stmt->execute();
    $stmt->close();
}

// Fungsi untuk menghapus data game
function deleteGame($conn, $id) {
    $stmt = $conn->prepare("DELETE FROM uts WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

// Simpan data game yang diedit
if (isset($_POST['edit_game'])) {
    $game_id = $_POST['game_id'];
    $nama_game = $_POST['nama_game'];
    $berat_game = $_POST['berat_game'];
    $harga_game = $_POST['harga_game'];
    $tgl_rilis = $_POST['tgl_rilis'];

    updateGame($conn, $game_id, $nama_game, $berat_game, $harga_game, $tgl_rilis);
}

// Simpan game baru ke database
if (isset($_POST['add_game'])) {
    $game_id = $_POST['game_id']; // Ambil ID dari input
    $nama_game = $_POST['nama_game'];
    $berat_game = $_POST['berat_game'];
    $harga_game = $_POST['harga_game'];
    $tgl_rilis = $_POST['tgl_rilis'];

    saveGame($conn, $game_id, $nama_game, $berat_game, $harga_game, $tgl_rilis);
}

// Hapus game jika parameter 'delete' ada
if (isset($_GET['delete'])) {
    $game_id = intval($_GET['delete']);
    deleteGame($conn, $game_id);
}

// Ambil data game dari database
$sql = "SELECT * FROM uts";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Game</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-900 text-gray-300">

    <div class="container mx-auto mt-10 p-6 bg-gray-800 rounded-lg shadow-lg">
        <h1 class="text-3xl font-bold mb-4 text-yellow-300">Edit Data Game</h1>

        <h2 class="text-xl font-semibold mb-3">Tambahkan Game Baru</h2>
        <form method="POST" class="mb-6">
            <div class="mb-3">
                <label for="game_id" class="form-label">ID Game</label>
                <input type="number" class="form-control" name="game_id" required>
            </div>
            <div class="mb-3">
                <label for="nama_game" class="form-label">Nama Game</label>
                <input type="text" class="form-control" name="nama_game" required>
            </div>
            <div class="mb-3">
                <label for="berat_game" class="form-label">Berat Game</label>
                <input type="text" class="form-control" name="berat_game" required>
            </div>
            <div class="mb-3">
                <label for="harga_game" class="form-label">Harga Game</label>
                <input type="text" class="form-control" name="harga_game" required>
            </div>
            <div class="mb-3">
                <label for="tgl_rilis" class="form-label">Tanggal Rilis</label>
                <input type="date" class="form-control" name="tgl_rilis" required>
            </div>
            <button type="submit" name="add_game" class="btn btn-success">Tambahkan Game</button>
        </form>

        <h2 class="text-xl font-semibold mb-3">Daftar Game</h2>
        <div class="overflow-x-auto">
            <table class="table-auto w-full bg-gray-700 rounded-lg shadow-md">
                <thead class="bg-gray-800">
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
                    <?php while ($game = $result->fetch_assoc()) { ?>
                        <tr class="hover:bg-gray-600">
                            <td class="border px-4 py-2"><?= $game['id']; ?></td>
                            <td class="border px-4 py-2"><?= $game['nama_game']; ?></td>
                            <td class="border px-4 py-2"><?= $game['berat_game']; ?></td>
                            <td class="border px-4 py-2"><?= $game['harga_game']; ?></td>
                            <td class="border px-4 py-2"><?= $game['tgl_rilis']; ?></td>
                            <td class="border px-4 py-2">
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal<?= $game['id']; ?>">Edit</button>
                                <a href="edit_data.php?delete=<?= $game['id']; ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus game ini?')">Delete</a>
                            </td>
                        </tr>

                        <!-- Modal Edit -->
                        <div class="modal fade" id="editModal<?= $game['id']; ?>" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editModalLabel" class="text-gray-600">Edit Game <?= $game['nama_game']; ?></h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST">
                                            <input type="hidden" name="game_id" value="<?= $game['id']; ?>">
                                            <div class="mb-3">
                                                <label for="nama_game" class="form-label text-gray-600">Nama Game</label>
                                                <input type="text" class="form-control" name="nama_game" value="<?= $game['nama_game']; ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="berat_game" class="form-label text-gray-600">Berat Game</label>
                                                <input type="text" class="form-control" name="berat_game" value="<?= $game['berat_game']; ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="harga_game" class="form-label text-gray-600">Harga Game</label>
                                                <input type="text" class="form-control" name="harga_game" value="<?= $game['harga_game']; ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="tgl_rilis" class="form-label text-gray-600">Tanggal Rilis</label>
                                                <input type="date" class="form-control" name="tgl_rilis" value="<?= $game['tgl_rilis']; ?>" required>
                                            </div>
                                            <button type="submit" name="edit_game" class="btn btn-primary">Simpan</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <a href="dashboard.php" class="btn btn-secondary mt-4">Kembali ke Dashboard</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
