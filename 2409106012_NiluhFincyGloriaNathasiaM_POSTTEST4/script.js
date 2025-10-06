document.addEventListener("DOMContentLoaded", () => {
    // Tombol "Jelajahi Koleksi" scroll ke bagian produk
    const exploreBtn = document.querySelector(".btn-primary");
    if (exploreBtn) {
        exploreBtn.addEventListener("click", (e) => {
            const href = exploreBtn.getAttribute("href");
            if (href && href.startsWith("#")) {
                e.preventDefault();
                const target = document.querySelector(href);
                if (target) target.scrollIntoView({ behavior: "smooth" });
            }
        });
    }

    // Navigasi: hanya scroll untuk link yang pakai "#"
    const navLinks = document.querySelectorAll(".nav-link");
    navLinks.forEach(link => {
        link.addEventListener("click", (e) => {
            const href = link.getAttribute("href");

            // Pastikan link punya href
            if (!href) return;

            // Kalau href diawali "#" → scroll halus
            if (href.startsWith("#")) {
                e.preventDefault();
                const target = document.querySelector(href);
                if (target) {
                    target.scrollIntoView({ behavior: "smooth" });
                }
            } else {
                // selain itu (login.php, index.php?page=home, dll)
                // biarkan browser redirect normal
                window.location.href = href; // <--- ini penting
            }

            // Tutup burger menu di mode mobile
            document.querySelector(".nav-list").classList.remove("show");
        });
    });

    // Klik kartu produk
    const productCards = document.querySelectorAll(".product-card");
    productCards.forEach(card => {
        card.addEventListener("click", () => {
            productCards.forEach(c => c.classList.remove("selected"));
            card.classList.add("selected");
            const productName = card.querySelector(".product-title").textContent;
            alert(`Kamu memilih: ${productName}`);
        });
    });

    // Burger menu (mobile)
    const burger = document.querySelector(".burger");
    const navList = document.querySelector(".nav-list");
    if (burger && navList) {
        burger.addEventListener("click", () => {
            navList.classList.toggle("show");
        });
    }
});
