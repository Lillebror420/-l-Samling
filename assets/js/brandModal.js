    // Modal elementer
    const modal = document.getElementById("imageModal");
    const modalImg = document.getElementById("modalImage");
    const captionText = document.getElementById("caption");
    const closeModal = document.querySelector(".close");

    // Åbn modal, når man klikker på billedet
    document.querySelectorAll(".image-cell img").forEach(img => {
        img.addEventListener("click", function() {
            modal.style.display = "block";
            modalImg.src = this.src;
            captionText.innerHTML = this.alt; // Brug billedets alt-tekst som caption
        });
    });

    // Luk modal, når man klikker på luk-knappen
    closeModal.addEventListener("click", function() {
        modal.style.display = "none";
    });

    // Luk modal, når man klikker uden for billedet
    modal.addEventListener("click", function(event) {
        if (event.target === modal) {
            modal.style.display = "none";
        }
    });

    // function toggleDetails(row) {
    //     // Find næste søskende element (detaljerækken)
    //     const nextRow = row.nextElementSibling;
    //     if (nextRow && nextRow.classList.contains('details-row')) {
    //         // Skift synlighed
    //         nextRow.style.display = nextRow.style.display === 'table-row' ? 'none' : 'table-row';
    //     }
    // }