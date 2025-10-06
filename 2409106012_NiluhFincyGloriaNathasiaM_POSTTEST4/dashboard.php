<?php
// Mulai session
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['username'])) {
    // Jika belum login, redirect ke halaman login
    header('Location: login.php');
    exit;
}

// Ambil data dari session
$username = $_SESSION['username'];
$login_time = isset($_SESSION['login_time']) ? $_SESSION['login_time'] : 'Tidak diketahui';

// Data statistik (contoh data statis)
$total_products = 25;
$total_orders = 142;
$total_customers = 89;
$revenue = 45750000;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Flower Market</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Dancing+Script:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        .dashboard-header {
            background: var(--gradient-primary);
            color: white;
            padding: 2rem 0;
            margin-top: 70px;
        }
        
        .welcome-box {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 5px 20px var(--shadow-light);
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            text-align: center;
            box-shadow: 0 5px 20px var(--shadow-light);
            transition: var(--transition);
            border-left: 4px solid var(--pink-milk);
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px var(--shadow-medium);
        }
        
        .stat-card.blue {
            border-left-color: var(--baby-blue);
        }
        
        .stat-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }
        
        .stat-value {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--pink-milk);
            margin-bottom: 0.5rem;
        }
        
        .stat-label {
            color: var(--gray-medium);
            font-size: 1rem;
        }
        
        .action-buttons {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            margin-top: 1.5rem;
        }
        
        .dashboard-section {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 5px 20px var(--shadow-light);
        }
        
        .recent-orders-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }
        
        .recent-orders-table th {
            background: var(--gradient-bg);
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            border-bottom: 2px solid var(--pink-milk);
        }
        
        .recent-orders-table td {
            padding: 1rem;
            border-bottom: 1px solid rgba(248, 187, 217, 0.2);
        }
        
        .recent-orders-table tr:hover {
            background: var(--pink-light);
        }
        
        .status-badge {
            display: inline-block;
            padding: 0.3rem 1rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
        }
        
        .status-success {
            background: #d4edda;
            color: #155724;
        }
        
        .status-pending {
            background: #fff3cd;
            color: #856404;
        }
        
        .status-processing {
            background: #cce5ff;
            color: #004085;
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            background: var(--gradient-bg);
            border-radius: 10px;
        }
        
        .user-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: var(--gradient-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: white;
        }
        
        @media (max-width: 768px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }
            
            .action-buttons {
                flex-direction: column;
            }
            
            .action-buttons .btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <nav class="nav flex-between">
                <div class="nav-brand text-gradient">🌸 Flower Market</div>
                <ul class="nav-list">
                    <li><a href="index.php" class="nav-link">Beranda</a></li>
                    <li><a href="dashboard.php" class="nav-link" style="background: var(--gradient-primary); color: white; border-radius: 25px;">Dashboard</a></li>
                    <li><a href="logout.php" class="nav-link">Logout</a></li>
                </ul>
                <button class="burger" aria-label="Menu">&#9776;</button>
            </nav>
        </div>
    </header>

    <div class="dashboard-header">
        <div class="container">
            <h1 class="heading-primary" style="color: white; margin-bottom: 0.5rem;">Dashboard Admin</h1>
            <p style="font-size: 1.1rem;">Selamat datang kembali, kelola toko bunga Anda dengan mudah</p>
        </div>
    </div>

    <main style="padding: 3rem 0; min-height: 70vh;">
        <div class="container">
            <!-- Welcome Box -->
            <div class="welcome-box">
                <div class="user-info">
                    <div class="user-avatar">👤</div>
                    <div>
                        <h2 style="margin: 0; color: var(--gray-dark);">Halo, <span class="text-gradient"><?php echo htmlspecialchars($username); ?>!</span></h2>
                        <p style="margin: 0.3rem 0 0 0; color: var(--gray-medium);">
                            Login terakhir: <?php echo htmlspecialchars($login_time); ?>
                        </p>
                    </div>
                </div>
                
                <div class="action-buttons">
                    <a href="index.php?page=products" class="btn btn-primary">📦 Kelola Produk</a>
                    <a href="index.php?page=contact" class="btn" style="background: var(--baby-blue); color: white;">📧 Lihat Pesanan</a>
                    <a href="index.php" class="btn" style="background: white; border: 2px solid var(--pink-milk);">🏠 Ke Website</a>
                </div>
            </div>

            <!-- Statistics Cards -->
            <h2 class="heading-secondary text-gradient">Statistik Toko</h2>
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">🌸</div>
                    <div class="stat-value"><?php echo $total_products; ?></div>
                    <div class="stat-label">Total Produk</div>
                </div>
                
                <div class="stat-card blue">
                    <div class="stat-icon">🛒</div>
                    <div class="stat-value" style="color: var(--baby-blue);"><?php echo $total_orders; ?></div>
                    <div class="stat-label">Total Pesanan</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">👥</div>
                    <div class="stat-value"><?php echo $total_customers; ?></div>
                    <div class="stat-label">Total Pelanggan</div>
                </div>
                
                <div class="stat-card blue">
                    <div class="stat-icon">💰</div>
                    <div class="stat-value" style="color: var(--baby-blue); font-size: 1.8rem;">Rp <?php echo number_format($revenue / 1000000, 1); ?>Jt</div>
                    <div class="stat-label">Total Pendapatan</div>
                </div>
            </div>

            <!-- Recent Orders -->
            <div class="dashboard-section">
                <h3 class="heading-tertiary text-gradient">Pesanan Terbaru</h3>
                <table class="recent-orders-table">
                    <thead>
                        <tr>
                            <th>ID Pesanan</th>
                            <th>Pelanggan</th>
                            <th>Produk</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#ORD001</td>
                            <td>Siti Aminah</td>
                            <td>Buket Mawar</td>
                            <td>Rp 150.000</td>
                            <td><span class="status-badge status-success">Selesai</span></td>
                            <td>05 Okt 2025</td>
                        </tr>
                        <tr>
                            <td>#ORD002</td>
                            <td>Budi Santoso</td>
                            <td>Rangkaian Pernikahan</td>
                            <td>Rp 500.000</td>
                            <td><span class="status-badge status-processing">Diproses</span></td>
                            <td>05 Okt 2025</td>
                        </tr>
                        <tr>
                            <td>#ORD003</td>
                            <td>Maya Putri</td>
                            <td>Buket Matahari</td>
                            <td>Rp 120.000</td>
                            <td><span class="status-badge status-pending">Pending</span></td>
                            <td>04 Okt 2025</td>
                        </tr>
                        <tr>
                            <td>#ORD004</td>
                            <td>Doni Pratama</td>
                            <td>Hand Bouquet Wisuda</td>
                            <td>Rp 130.000</td>
                            <td><span class="status-badge status-success">Selesai</span></td>
                            <td>04 Okt 2025</td>
                        </tr>
                        <tr>
                            <td>#ORD005</td>
                            <td>Rina Wati</td>
                            <td>Buket Tulip</td>
                            <td>Rp 200.000</td>
                            <td><span class="status-badge status-processing">Diproses</span></td>
                            <td>03 Okt 2025</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Quick Actions -->
            <div class="dashboard-section">
                <h3 class="heading-tertiary text-gradient">Aksi Cepat</h3>
                <div class="grid grid-3" style="margin-top: 1.5rem;">
                    <div class="card" style="text-align: center; cursor: pointer;" onclick="alert('Fitur tambah produk akan segera hadir!')">
                        <span style="font-size: 3rem; display: block; margin-bottom: 1rem;">➕</span>
                        <h4>Tambah Produk Baru</h4>
                        <p>Tambahkan produk bunga baru ke katalog</p>
                    </div>
                    
                    <div class="card" style="text-align: center; cursor: pointer;" onclick="alert('Fitur laporan akan segera hadir!')">
                        <span style="font-size: 3rem; display: block; margin-bottom: 1rem;">📊</span>
                        <h4>Lihat Laporan</h4>
                        <p>Cek laporan penjualan dan analitik</p>
                    </div>
                    
                    <div class="card" style="text-align: center; cursor: pointer;" onclick="alert('Fitur pengaturan akan segera hadir!')">
                        <span style="font-size: 3rem; display: block; margin-bottom: 1rem;">⚙️</span>
                        <h4>Pengaturan</h4>
                        <p>Kelola pengaturan toko dan akun</p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer>
        <div class="container">
            <div class="footer-bottom text-center" style="padding: 2rem 0;">
                <p>&copy; 2025 Flower Market Dashboard. Semua hak cipta dilindungi undang-undang.</p>
            </div>
        </div>
    </footer>

    <script src="script.js"></script>
</body>
</html>