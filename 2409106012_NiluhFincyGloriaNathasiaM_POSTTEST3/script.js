document.addEventListener("DOMContentLoaded", () => {
    const exploreBtn = document.querySelector(".btn-primary");
    if (exploreBtn) {
        exploreBtn.addEventListener("click", (e) => {
            e.preventDefault();
            const target = document.querySelector("#products");
            target.scrollIntoView({ behavior: "smooth" });
        });
    }

    const navLinks = document.querySelectorAll(".nav-link");
    navLinks.forEach(link => {
        link.addEventListener("click", (e) => {
            e.preventDefault();
            const targetId = link.getAttribute("href");
            const targetSection = document.querySelector(targetId);
            if (targetSection) {
                targetSection.scrollIntoView({ behavior: "smooth" });
            }
        });
    });

    const productCards = document.querySelectorAll(".product-card");
    productCards.forEach(card => {
        card.addEventListener("click", () => {
            productCards.forEach(c => c.classList.remove("selected"));
            card.classList.add("selected");

            const productName = card.querySelector(".product-title").textContent;
            alert(`Kamu memilih: ${productName}`);
        });
    });
});