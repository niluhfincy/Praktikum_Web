<?php
// Mulai session untuk cek status login
session_start();

// Ambil parameter dari query string
$page = isset($_GET['page']) ? $_GET['page'] : 'home';
$category = isset($_GET['category']) ? $_GET['category'] : '';
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Cek apakah user sudah login
$is_logged_in = isset($_SESSION['username']);
$username = $is_logged_in ? $_SESSION['username'] : '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Flower Market - Toko bunga online terpercaya dengan koleksi bunga segar untuk berbagai acara spesial">
    <meta name="keywords" content="toko bunga, bunga segar, buket, karangan bunga, hadiah, pernikahan">
    <meta name="author" content="Flower Market Team">
    <title>Flower Market - Toko Bunga Online Terpercaya</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Dancing+Script:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- External CSS -->
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <div class="container">
            <nav class="nav flex-between">
                <div class="nav-brand text-gradient">🌸 Flower Market</div>
                <ul class="nav-list">
                    <li><a href="index.php?page=home" class="nav-link">Beranda</a></li>
                    <li><a href="index.php?page=products" class="nav-link">Produk</a></li>
                    <li><a href="index.php?page=about" class="nav-link">Tentang</a></li>
                    <li><a href="index.php?page=contact" class="nav-link">Kontak</a></li>
                    <?php if ($is_logged_in): ?>
                        <li><a href="dashboard.php" class="nav-link">Dashboard</a></li>
                        <li><a href="logout.php" class="nav-link" style="background: var(--gradient-primary); color: white; border-radius: 25px;">Logout (<?php echo htmlspecialchars($username); ?>)</a></li>
                    <?php else: ?>
                        <li><a href="login.php" class="nav-link" style="background: var(--gradient-primary); color: white; border-radius: 25px;">Login</a></li>
                    <?php endif; ?>
                </ul>
                <!-- Burger Menu -->
                <button class="burger" aria-label="Menu">&#9776;</button>
            </nav>
        </div>
    </header>

    <main>
        <section id="home" class="hero flex-center">
            <div class="container hero-content text-center animate-fade-in">
                <h1 class="heading-primary text-gradient">Where Every Bloom Tells a Story</h1>
                <p class="hero-subtitle">Temukan koleksi bunga segar terbaik untuk membuat setiap acara Anda menjadi istimewa</p>
                <?php if (!empty($search)): ?>
                    <p style="background: white; padding: 10px 20px; border-radius: 25px; display: inline-block; margin-top: 10px;">
                        Hasil pencarian untuk: <strong><?php echo htmlspecialchars($search); ?></strong>
                    </p>
                <?php endif; ?>
                <a href="index.php?page=products" class="btn btn-primary">Jelajahi Koleksi</a>
            </div>
        </section>

        <section class="section">
            <div class="container">
                <h2 class="heading-secondary text-center text-gradient">Mengapa Memilih Kami?</h2>
                <div class="grid grid-3">
                    <article class="card feature-card">
                        <span class="feature-icon">🌹</span>
                        <h3 class="heading-tertiary">Bunga Segar</h3>
                        <p>Kami menyediakan bunga-bunga segar yang dipetik langsung dari kebun terbaik untuk memastikan kualitas dan kesegaran terjamin.</p>
                    </article>
                    
                    <article class="card feature-card card-featured">
                        <span class="feature-icon">🚚</span>
                        <h3 class="heading-tertiary">Pengiriman Cepat</h3>
                        <p>Layanan pengiriman same-day untuk area Samarinda dan sekitarnya, memastikan bunga sampai dalam kondisi sempurna.</p>
                    </article>
                    
                    <article class="card feature-card">
                        <span class="feature-icon">🎨</span>
                        <h3 class="heading-tertiary">Desain Kreatif</h3>
                        <p>Tim florist berpengalaman siap membuat rangkaian bunga sesuai dengan keinginan dan tema acara Anda.</p>
                    </article>
                </div>
            </div>
        </section>

        <section id="products" class="section section-alt">
            <div class="container">
                <h2 class="heading-secondary text-center text-gradient">Koleksi Produk Kami</h2>
                
                <!-- Filter Kategori -->
                <div style="text-align: center; margin-bottom: 2rem;">
                    <a href="index.php?page=products" class="btn" style="margin: 5px; <?php echo empty($category) ? 'background: var(--gradient-primary); color: white;' : 'background: white;'; ?>">Semua</a>
                    <a href="index.php?page=products&category=buket" class="btn" style="margin: 5px; <?php echo $category === 'buket' ? 'background: var(--gradient-primary); color: white;' : 'background: white;'; ?>">Buket</a>
                    <a href="index.php?page=products&category=pernikahan" class="btn" style="margin: 5px; <?php echo $category === 'pernikahan' ? 'background: var(--gradient-primary); color: white;' : 'background: white;'; ?>">Pernikahan</a>
                    <a href="index.php?page=products&category=wisuda" class="btn" style="margin: 5px; <?php echo $category === 'wisuda' ? 'background: var(--gradient-primary); color: white;' : 'background: white;'; ?>">Wisuda</a>
                </div>

                <!-- Search Form -->
                <div style="text-align: center; margin-bottom: 2rem;">
                    <form method="GET" action="index.php" style="display: inline-block;">
                        <input type="hidden" name="page" value="products">
                        <input type="text" name="search" placeholder="Cari produk..." value="<?php echo htmlspecialchars($search); ?>" style="padding: 10px 20px; border: 2px solid var(--pink-milk); border-radius: 25px; width: 300px;">
                        <button type="submit" class="btn btn-primary" style="margin-left: 10px;">Cari</button>
                    </form>
                </div>

                <div class="grid grid-3">
                    <?php
                    // Data produk
                    $products = [
                        ['name' => 'Buket Mawar', 'category' => 'buket', 'emoji' => '🌹', 'desc' => 'Buket mawar merah segar untuk ungkapan cinta dan kasih sayang', 'price' => 150000],
                        ['name' => 'Buket Matahari', 'category' => 'buket', 'emoji' => '🌻', 'desc' => 'Buket bunga matahari yang ceria dan penuh semangat untuk berbagai acara', 'price' => 120000],
                        ['name' => 'Rangkaian Pernikahan', 'category' => 'pernikahan', 'emoji' => '🌺', 'desc' => 'Rangkaian bunga elegan dan mewah untuk hari bahagia pernikahan Anda', 'price' => 500000, 'featured' => true],
                        ['name' => 'Buket Tulip', 'category' => 'buket', 'emoji' => '🌷', 'desc' => 'Buket tulip warna-warni yang menawan dan cocok untuk hadiah spesial', 'price' => 200000],
                        ['name' => 'Buket Daisy', 'category' => 'buket', 'emoji' => '🌼', 'desc' => 'Buket bunga daisy putih yang simpel namun elegan', 'price' => 100000],
                        ['name' => 'Buket Sakura', 'category' => 'buket', 'emoji' => '🌸', 'desc' => 'Buket bunga sakura pink yang cantik dan romantis', 'price' => 180000],
                        ['name' => 'Hand Bouquet Wisuda', 'category' => 'wisuda', 'emoji' => '🎓', 'desc' => 'Hand bouquet spesial untuk hari kelulusan yang istimewa', 'price' => 130000],
                    ];

                    // Filter produk berdasarkan kategori dan pencarian
                    foreach ($products as $product) {
                        $show = true;
                        
                        // Filter kategori
                        if (!empty($category) && $product['category'] !== $category) {
                            $show = false;
                        }
                        
                        // Filter pencarian
                        if (!empty($search)) {
                            $search_lower = strtolower($search);
                            if (strpos(strtolower($product['name']), $search_lower) === false && 
                                strpos(strtolower($product['desc']), $search_lower) === false) {
                                $show = false;
                            }
                        }
                        
                        if ($show):
                    ?>
                    <article class="card product-card <?php echo isset($product['featured']) ? 'card-featured' : ''; ?>">
                        <div class="product-image"><?php echo $product['emoji']; ?></div>
                        <div>
                            <h3 class="heading-tertiary product-title"><?php echo htmlspecialchars($product['name']); ?></h3>
                            <p><?php echo htmlspecialchars($product['desc']); ?></p>
                            <p class="product-price">Rp <?php echo number_format($product['price'], 0, ',', '.'); ?></p>
                        </div>
                    </article>
                    <?php 
                        endif;
                    } 
                    ?>
                </div>
            </div>
        </section>

        <section class="section">
            <div class="container">
                <h2 class="heading-secondary text-center text-gradient">Galeri Karya Kami</h2>
                <div class="grid grid-4">
                    <figure class="gallery-item">
                        <div class="gallery-placeholder">🖼️</div>
                        <figcaption>Rangkaian bunga pernikahan tema putih elegant</figcaption>
                    </figure>
                    
                    <figure class="gallery-item">
                        <div class="gallery-placeholder">🖼️</div>
                        <figcaption>Buket mawar merah spesial untuk Valentine</figcaption>
                    </figure>
                    
                    <figure class="gallery-item">
                        <div class="gallery-placeholder">🖼️</div>
                        <figcaption>Dekorasi bunga untuk acara corporate</figcaption>
                    </figure>
                    
                    <figure class="gallery-item">
                        <div class="gallery-placeholder">🖼️</div>
                        <figcaption>Hand bouquet untuk wisuda</figcaption>
                    </figure>
                </div>
            </div>
        </section>

        <section id="about" class="section section-alt">
            <div class="container">
                <h2 class="heading-secondary text-center text-gradient">Tentang Flower Market</h2>
                <div class="grid">
                    <article class="card">
                        <p>
                            Flower Market telah melayani kebutuhan bunga segar di Samarinda, Kalimantan Timur sejak tahun 2018. 
                            Kami berkomitmen untuk memberikan bunga berkualitas tinggi dengan pelayanan terbaik kepada setiap pelanggan.
                        </p>
                        <p>
                            Tim florist kami yang berpengalaman siap membantu Anda menciptakan momen-momen indah dengan 
                            rangkaian bunga yang sempurna untuk setiap ocasion, mulai dari pernikahan, ulang tahun, 
                            wisuda, anniversary, hingga acara corporate dan duka cita.
                        </p>
                        <p>
                            Dengan pengalaman lebih dari 7 tahun, kami telah melayani ribuan pelanggan dan menciptakan 
                            ribuan rangkaian bunga yang memukau. Kepuasan pelanggan adalah prioritas utama kami.
                        </p>
                    </article>
                </div>
            </div>
        </section>

        <section class="section">
            <div class="container">
                <h2 class="heading-secondary text-center text-gradient">Testimoni Pelanggan</h2>
                <div class="grid grid-3">
                    <blockquote class="card testimonial">
                        <p>"Bunga dari Flower Market selalu segar dan indah. Pelayanannya juga sangat memuaskan!"</p>
                        <cite class="testimonial-author">- Nayul, Pelanggan Setia</cite>
                    </blockquote>
                    
                    <blockquote class="card testimonial card-featured">
                        <p>"Rangkaian bunga pernikahan saya sangat sempurna. Terima kasih Flower Market!"</p>
                        <cite class="testimonial-author">- Ayu & Irvan, Pasangan Pengantin</cite>
                    </blockquote>
                    
                    <blockquote class="card testimonial">
                        <p>"Pengiriman cepat dan bunga selalu dalam kondisi prima. Recommended banget!"</p>
                        <cite class="testimonial-author">- Ojan, Pelanggan Regular</cite>
                    </blockquote>
                </div>
            </div>
        </section>

        <section id="contact" class="section section-alt">
            <div class="container">
                <h2 class="heading-secondary text-center text-gradient">Hubungi Kami</h2>
                <div class="grid grid-2">
                    <div class="grid">
                        <article class="card contact-card">
                            <h3 class="heading-tertiary"><span class="contact-icon">📍</span>Alamat Toko</h3>
                            <address>
                                Jl. M Yamin No. 123<br>
                                Kelurahan Air Putih<br>
                                Samarinda, Kalimantan Timur<br>
                                76114
                            </address>
                        </article>
                        
                        <article class="card contact-card">
                            <h3 class="heading-tertiary"><span class="contact-icon">📞</span>Nomor Telepon</h3>
                            <p>Telepon Toko: <a href="tel:+6254212345678">+62 542-123-4567</a></p>
                            <p>WhatsApp: <a href="https://wa.me/6281234567890">+62 812-3456-7890</a></p>
                        </article>
                        
                        <article class="card contact-card">
                            <h3 class="heading-tertiary"><span class="contact-icon">✉️</span>Email</h3>
                            <p>Email Pemesanan: <a href="mailto:order@flowermarket.com">order@flowermarket.com</a></p>
                        </article>
                        
                        <article class="card contact-card">
                            <h3 class="heading-tertiary"><span class="contact-icon">🕐</span>Jam Operasional</h3>
                            <table class="contact-table">
                                <tr>
                                    <td>Senin - Jumat</td>
                                    <td>08:00 - 20:00 WITA</td>
                                </tr>
                                <tr>
                                    <td>Sabtu</td>
                                    <td>08:00 - 21:00 WITA</td>
                                </tr>
                                <tr>
                                    <td>Minggu</td>
                                    <td>09:00 - 18:00 WITA</td>
                                </tr>
                            </table>
                        </article>
                    </div>
                    
                    <aside class="card card-featured">
                        <h3 class="heading-tertiary text-gradient">Area Pengiriman</h3>
                        <ul>
                            <li>Samarinda Seberang</li>
                            <li>Samarinda Kota</li>
                            <li>Palaran</li>
                            <li>Balikpapan (Dengan Biaya Tambahan)</li>
                        </ul>
                    </aside>
                </div>
            </div>
        </section>
    </main>

    <footer>
        <div class="container">
            <div class="grid grid-4">
                <section class="footer-section">
                    <h3 class="footer-title">Flower Market</h3>
                    <p>
                        Toko bunga terpercaya di Samarinda dengan koleksi bunga segar berkualitas tinggi 
                        untuk setiap momen spesial dalam hidup Anda. Kepuasan pelanggan adalah prioritas kami.
                    </p>
                </section>
                
                <section class="footer-section">
                    <h3 class="footer-title">Layanan Kami</h3>
                    <ul class="footer-list">
                        <li><a href="index.php?page=products&category=buket" class="footer-link">Buket Bunga</a></li>
                        <li><a href="index.php?page=products&category=pernikahan" class="footer-link">Rangkaian Pernikahan</a></li>
                        <li><a href="index.php?page=products" class="footer-link">Dekorasi Event</a></li>
                        <li><a href="index.php?page=contact" class="footer-link">Pengiriman Same Day</a></li>
                        <li><a href="index.php?page=products&category=wisuda" class="footer-link">Hand Bouquet Wisuda</a></li>
                    </ul>
                </section>
                
                <section class="footer-section">
                    <h3 class="footer-title">Informasi</h3>
                    <ul class="footer-list">
                        <li><a href="index.php?page=about" class="footer-link">Tentang Kami</a></li>
                        <li><a href="index.php?page=contact" class="footer-link">Cara Pemesanan</a></li>
                        <li><a href="index.php?page=contact" class="footer-link">Kebijakan Pengiriman</a></li>
                        <li><a href="#" class="footer-link">Syarat & Ketentuan</a></li>
                        <li><a href="#" class="footer-link">FAQ</a></li>
                    </ul>
                </section>
                
                <section class="footer-section">
                    <h3 class="footer-title">Media Sosial</h3>
                    <ul class="footer-list">
                        <li><a href="https://instagram.com/flowermarket_smd" target="_blank" class="footer-link">Instagram</a></li>
                        <li><a href="https://facebook.com/flowermarketsamarinda" target="_blank" class="footer-link">Facebook</a></li>
                        <li><a href="https://wa.me/6281234567890" target="_blank" class="footer-link">WhatsApp</a></li>
                        <li><a href="https://tiktok.com/@flowermarket_smd" target="_blank" class="footer-link">TikTok</a></li>
                    </ul>
                </section>
            </div>
            
            <div class="footer-bottom text-center">
                <hr style="border: none; height: 1px; background: rgba(255, 255, 255, 0.1); margin: var(--spacing-md) 0;">
                <p>&copy; 2025 Flower Market Samarinda. Semua hak cipta dilindungi undang-undang.</p>
            </div>
        </div>
    </footer>

    <!-- External JavaScript -->
    <script src="script.js"></script>
</body>
</html>