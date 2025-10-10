<?php
session_start();
include 'koneksi.php';

// Cek login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// === CREATE ===
if (isset($_POST['tambah'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $kategori = mysqli_real_escape_string($conn, $_POST['kategori']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $harga = mysqli_real_escape_string($conn, $_POST['harga']);
    $emoji = mysqli_real_escape_string($conn, $_POST['emoji']);

    $query = "INSERT INTO produk (nama, kategori, deskripsi, harga, emoji)
              VALUES ('$nama', '$kategori', '$deskripsi', '$harga', '$emoji')";
    mysqli_query($conn, $query);
    header("Location: dashboard.php");
    exit;
}

// === DELETE ===
if (isset($_GET['hapus'])) {
    $id = intval($_GET['hapus']);
    mysqli_query($conn, "DELETE FROM produk WHERE id=$id");
    header("Location: dashboard.php");
    exit;
}

// === UPDATE ===
if (isset($_POST['update'])) {
    $id = intval($_POST['id']);
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $kategori = mysqli_real_escape_string($conn, $_POST['kategori']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $harga = mysqli_real_escape_string($conn, $_POST['harga']);
    $emoji = mysqli_real_escape_string($conn, $_POST['emoji']);

    $query = "UPDATE produk SET 
                nama='$nama', kategori='$kategori', deskripsi='$deskripsi', 
                harga='$harga', emoji='$emoji' 
              WHERE id=$id";
    mysqli_query($conn, $query);
    header("Location: dashboard.php");
    exit;
}

// === READ ===
$result = mysqli_query($conn, "SELECT * FROM produk ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin - Flower Market</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            padding-top: 100px;
            background: var(--gradient-bg);
        }
        .dashboard-container {
            max-width: 1000px;
            margin: auto;
            background: white;
            border-radius: var(--border-radius);
            box-shadow: 0 5px 25px var(--shadow-light);
            padding: var(--spacing-lg);
        }
        h1 {
            text-align: center;
            margin-bottom: var(--spacing-md);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: var(--spacing-md);
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        th {
            background: var(--pink-milk);
        }
        input, textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: var(--spacing-sm);
            border: 1px solid #ccc;
            border-radius: 10px;
        }
        button {
            background: var(--gradient-primary);
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 20px;
            cursor: pointer;
        }
        button:hover {
            opacity: 0.9;
        }
        .action-links a {
            margin: 0 5px;
            color: var(--baby-blue);
            text-decoration: none;
            font-weight: 500;
        }
        .action-links a:hover {
            color: var(--pink-milk);
        }
        .logout {
            display: inline-block;
            margin-bottom: var(--spacing-md);
            background: var(--gradient-primary);
            color: white;
            padding: 10px 20px;
            border-radius: 30px;
            text-decoration: none;
            font-weight: 600;
        }
        .logout:hover {
            opacity: 0.8;
        }
        .edit-section {
            margin-top: var(--spacing-lg);
            background: var(--pink-light);
            border-radius: var(--border-radius);
            padding: var(--spacing-md);
        }
    </style>
</head>
<body>
    <div class="container dashboard-container">
        <h1 class="text-gradient">🌸 Dashboard Admin</h1>
        <p style="text-align:center;">Halo, <strong><?= htmlspecialchars($_SESSION['username']); ?></strong>!</p>
        <div style="text-align:center;">
            <a href="logout.php" class="logout">Logout</a>
        </div>

        <h2>Tambah Produk Baru</h2>
        <form method="POST">
            <input type="text" name="nama" placeholder="Nama Produk" required>
            <input type="text" name="kategori" placeholder="Kategori (buket, wisuda, pernikahan, dll)" required>
            <textarea name="deskripsi" placeholder="Deskripsi produk" required></textarea>
            <input type="number" name="harga" placeholder="Harga (Rp)" required>
            <input type="text" name="emoji" placeholder="Emoji (contoh: 🌹)">
            <button type="submit" name="tambah">Tambah Produk</button>
        </form>

        <h2>Daftar Produk</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Kategori</th>
                <th>Deskripsi</th>
                <th>Harga</th>
                <th>Emoji</th>
                <th>Aksi</th>
            </tr>

            <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?= $row['id']; ?></td>
                <td><?= htmlspecialchars($row['nama']); ?></td>
                <td><?= htmlspecialchars($row['kategori']); ?></td>
                <td><?= htmlspecialchars($row['deskripsi']); ?></td>
                <td>Rp <?= number_format($row['harga'], 0, ',', '.'); ?></td>
                <td><?= htmlspecialchars($row['emoji']); ?></td>
                <td class="action-links">
                    <a href="dashboard.php?edit=<?= $row['id']; ?>">Edit</a> |
                    <a href="dashboard.php?hapus=<?= $row['id']; ?>" onclick="return confirm('Yakin ingin menghapus produk ini?')">Hapus</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>

        <?php if (isset($_GET['edit'])):
            $id = intval($_GET['edit']);
            $edit = mysqli_query($conn, "SELECT * FROM produk WHERE id=$id");
            $data = mysqli_fetch_assoc($edit);
        ?>
        <div class="edit-section">
            <h2>Edit Produk</h2>
            <form method="POST">
                <input type="hidden" name="id" value="<?= $data['id']; ?>">
                <input type="text" name="nama" value="<?= htmlspecialchars($data['nama']); ?>" required>
                <input type="text" name="kategori" value="<?= htmlspecialchars($data['kategori']); ?>" required>
                <textarea name="deskripsi" required><?= htmlspecialchars($data['deskripsi']); ?></textarea>
                <input type="number" name="harga" value="<?= htmlspecialchars($data['harga']); ?>" required>
                <input type="text" name="emoji" value="<?= htmlspecialchars($data['emoji']); ?>">
                <button type="submit" name="update">Update Produk</button>
            </form>
        </div>
        <?php endif; ?>
    </div>
</body>
</html>