function updateCart(change) {
    const quantitySpan = document.getElementById("quantita");
    const quantityInput = document.getElementById("quantityInput");
    let currentQty = parseInt(quantitySpan.textContent);
    let newQty = currentQty + change;
    
    // Don't allow quantities less than 1
    if (newQty < 1) newQty = 1;
    
    // Update display
    quantitySpan.textContent = newQty;
    quantityInput.value = newQty;
    
    // Submit form
    document.querySelector('form').submit();
}



function addToCart() {
    const form = document.createElement('form');
    form.method = 'post';
    form.innerHTML = `
        <input type="hidden" name="cart_action" value="add">
        <input type="hidden" name="quantity" value="1">
    `;
    document.body.appendChild(form);
    form.submit();
}

let addToCartBtn = document.getElementById("addToCartBtn");
if (addToCartBtn) {
    addToCartBtn.addEventListener('click', function() {
    addToCart();
});
}

function removeFromCart() {
    if (confirm("Rimuovere questo prodotto dal carrello?")) {
        const form = document.createElement('form');
        form.method = 'post';
        form.innerHTML = `
            <input type="hidden" name="cart_action" value="remove">
        `;
        document.body.appendChild(form);
        form.submit();
    }
}

// Controllo quantità
function cambiaQuantita(valore) {
    const span = document.getElementById("quantita");
    let quantita = parseInt(span.textContent);
    quantita = Math.max(1, quantita + valore); // evita valori minori di 1
    span.textContent = quantita;
}

// Funzione per aggiungere al carrello
function aggiungiAlCarrello() {
    const quantita = document.getElementById("quantita").textContent;
    const titoloPrezzo = document.querySelector(".titolo-prezzo").textContent.split('\n');
    const titolo = titoloPrezzo[0].trim();
    const prezzo = titoloPrezzo[1].trim();
    
    // Reindirizza alla pagina del carrello con i parametri
    window.location.href = "carrello.php?titolo=" + encodeURIComponent(titolo) + 
                        "&prezzo=" + encodeURIComponent(prezzo) + 
                        "&quantita=" + encodeURIComponent(quantita);
}