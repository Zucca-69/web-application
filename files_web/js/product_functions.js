// product_functions.js

document.addEventListener("DOMContentLoaded", function() {
    // Dropdown piattaforme
    const riquadro = document.getElementById('riquadro');
    const barraRichieste = document.getElementById('barra-richieste');
    if (riquadro && barraRichieste) {
        riquadro.addEventListener('click', function() {
            barraRichieste.style.display = (barraRichieste.style.display === "block") ? "none" : "block";
        });
    }

    // Miniature click
    const miniature = document.querySelectorAll('.mini');
    const imgGrande = document.getElementById('imgGrande');
    miniature.forEach(mini => {
        mini.addEventListener('click', () => {
            imgGrande.src = mini.src;
            imgGrande.alt = mini.alt;
        });
    });

    // Gestione click bottone "Aggiungi al carrello"
    const addToCartBtn = document.getElementById("addToCartBtn");
    if (addToCartBtn) {
        addToCartBtn.addEventListener('click', function () {
            const productId = this.dataset.productId;
            const piattaforma = this.dataset.piattaforma;
            addToCart(productId, piattaforma);
        });
    }
});

// Aggiorna quantità nel carrello
function updateCart(change) {
    const quantitySpan = document.getElementById("quantita");
    const quantityInput = document.getElementById("quantityInput");
    let currentQty = parseInt(quantitySpan.textContent);
    let newQty = currentQty + change;
    if (newQty < 1) newQty = 1;
    quantitySpan.textContent = newQty;
    quantityInput.value = newQty;
    document.querySelector('form').submit();
}

// Aggiunta al carrello
function addToCart(productId, piattaforma) {
    const form = document.createElement('form');
    form.method = 'post';
    form.innerHTML = `
        <input type="hidden" name="cart_action" value="add">
        <input type="hidden" name="productId" value="${productId}">
        <input type="hidden" name="piattaforma" value="${piattaforma}">
        <input type="hidden" name="quantity" value="1">
    `;
    document.body.appendChild(form);
    form.submit();
}

// Rimuovi dal carrello
function removeFromCart(productId, piattaforma) {
    if (confirm("Rimuovere questo prodotto dal carrello?")) {
        const form = document.createElement('form');
        form.method = 'post';
        form.innerHTML = `
            <input type="hidden" name="cart_action" value="remove">
            <input type="hidden" name="productId" value="${productId}">
            <input type="hidden" name="piattaforma" value="${piattaforma}">
        `;
        document.body.appendChild(form);
        form.submit();
    }
}

