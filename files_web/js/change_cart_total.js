/**
 * Updates the cart total displayed on the page
 */
function updateCartTotal() {
    const rows = document.querySelectorAll("#cart-items tr");
    let total = 0;
    rows.forEach(row => {
        const qty = parseInt(row.querySelector(".qty").textContent);
        const price = parseFloat(row.dataset.price);
        const lineTotal = qty * price;
        row.querySelector(".line-total").textContent = `€${lineTotal.toFixed(2)}`;
        total += lineTotal;
    });
    document.getElementById("total").textContent = total.toFixed(2);
}

/**
 * Changes the quantity of an item in the cart with min/max limits
 * @param {HTMLElement} button - The button that was clicked
 * @param {number} delta - The amount to change (+1 or -1)
 */
function changeQty(button, delta) {
    const row = button.closest("tr");
    const qtyCell = row.querySelector(".qty");
    const maxQty = parseInt(row.dataset.maxQuantity) || 99; // Gets from data-max-quantity
    let qty = parseInt(qtyCell.textContent) + delta;
    
    qty = Math.max(1, qty);          // Minimum 1
    qty = Math.min(qty, maxQty);     // Maximum from data attribute
    
    qtyCell.textContent = qty;
    updateCartTotal();
    
    // Optional: Show message if hitting max
    if (qty >= maxQty) {
        console.log("Maximum quantity reached: " + maxQty);
    }
}

/**
 * Removes an item from the cart
 * @param {HTMLElement} button - The remove button that was clicked
 */
function removeItem(button, productId, piattaforma) {
    const form = document.createElement('form');
        form.method = 'post';
        form.innerHTML = `
            <input type="hidden" name="cart_action" value="remove">
            <input type="hidden" name="productId" value="${productId}">
            <input type="hidden" name="piattaforma" value="${piattaforma}">
        `;
        document.body.appendChild(form);
        form.submit();
    const row = button.closest("tr");
    row.remove();
    updateCartTotal();
}

/**
 * Merges duplicate items in the cart
 */
function mergeDuplicateItems() {
    const rows = document.querySelectorAll("#cart-items tr");
    const map = {};

    rows.forEach(row => {
        const name = row.children[0].textContent.trim();
        const qty = parseInt(row.querySelector(".qty").textContent);
        const price = parseFloat(row.dataset.price);

        if (!map[name]) {
            map[name] = {
                qty: qty,
                row: row
            };
        } else {
            map[name].qty += qty;
            row.remove();
        }
    });

    for (const name in map) {
        const row = map[name].row;
        row.querySelector(".qty").textContent = map[name].qty;
    }
}

// Initialize when page loads
window.addEventListener("DOMContentLoaded", () => {
    mergeDuplicateItems();
    updateCartTotal();
});