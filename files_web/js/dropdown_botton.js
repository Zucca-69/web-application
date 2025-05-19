document.addEventListener("DOMContentLoaded", function () {
    // Seleziona tutti i dropdown
    const dropButtons = document.querySelectorAll(".dropbtn");

    dropButtons.forEach(button => {
        button.addEventListener("click", function (event) {
            event.stopPropagation();
            // Chiude eventuali altri dropdown aperti
            document.querySelectorAll(".dropdown-content").forEach(content => {
                if (content !== this.nextElementSibling) {
                    content.style.display = "none";
                }
            });

            // Alterna il dropdown corrente
            const dropdownContent = this.nextElementSibling;
            dropdownContent.style.display = (dropdownContent.style.display === "block") ? "none" : "block";
        });
    });

    // Chiude tutto cliccando fuori
    window.addEventListener("click", function () {
        document.querySelectorAll(".dropdown-content").forEach(content => {
            content.style.display = "none";
        });
    });
});
