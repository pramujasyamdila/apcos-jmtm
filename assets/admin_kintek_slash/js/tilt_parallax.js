
    /* ============================================
   3D TILT PARALLAX
============================================ */
    document.querySelectorAll(".card.tilt").forEach(card => {

        card.addEventListener("mousemove", (e) => {
            const rect = card.getBoundingClientRect();

            // posisi mouse relatif
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;

            // hitung rotasi
            const rotateY = ((x / rect.width) - 0.5) * 20; // kiri–kanan
            const rotateX = ((y / rect.height) - 0.5) * -20; // atas–bawah

            card.style.transform = `
        perspective(800px)
        rotateX(${rotateX}deg)
        rotateY(${rotateY}deg)
    `;
        });

        card.addEventListener("mouseleave", () => {
            card.style.transform = `
        perspective(800px)
        rotateX(0deg)
        rotateY(0deg)
    `;
        });

    });
    