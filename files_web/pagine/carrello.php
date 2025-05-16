<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  
  <title>RunGame - Carrello</title>
  
  <link rel="stylesheet" href="../css/global.css">
  <link rel="stylesheet" href="../css/slider.css">
  <link rel="stylesheet" href="../css/darkmode.css">
  <link rel="stylesheet" href="../css/galleria.css">
  <link rel="stylesheet" href="../css/barra-navigazione.css">
  <link rel="stylesheet" href="../css/carrello.css">

</head>
<body>
  <?php 
    include '../php_files/header.php'; 
    include '../php_files/db_connection.php'; 
    include '../php_files/get_cart.php'; 

  ?>

  <div class="cart-container">
    <h1>Il tuo carrello</h1>
    <table>
      <thead>
        <tr>
          <th>Prodotto</th>
          <th>Quantità</th>
          <th>Prezzo</th>
          <th>Totale</th>
          <th>Azioni</th>
        </tr>
      </thead>

      <tbody id="cart-items">
        <?php
          foreach ($cartItems as $prodotto) :
          echo '<tr data-price=' . $prodotto['prezzo'] . '>';
            // <td>Maglietta Bianca</td>
            // <td class="qty">1</td>
            // <td>€15.00</td>
        ?>
            <td class="line-total">€0.00</td>
            <td class="qty-controls">
              <div class="action-buttons">
                <button onclick="changeQty(this, 1)">+</button>
                <button onclick="removeItem(this)">🗑️</button>
                <button onclick="changeQty(this, -1)">−</button>
              </div>
            </td>
          </tr>
        <?php endforeach; ?>

      </tbody>
    </table>
    <div class="total">
      <strong>Totale Carrello: €<span id="total">0.00</span></strong>
    </div>
    <button class="checkout-btn">Procedi al Checkout</button>
  </div>

  <script>
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

    function changeQty(button, delta) {
      const row = button.closest("tr");
      const qtyCell = row.querySelector(".qty");
      let qty = parseInt(qtyCell.textContent) + delta;
      if (qty < 1) qty = 1;
      qtyCell.textContent = qty;
      updateCartTotal();
    }

    function removeItem(button) {
      const row = button.closest("tr");
      row.remove();
      updateCartTotal();
    }

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
          // Somma la quantità
          map[name].qty += qty;
          // Rimuove la riga duplicata
          row.remove();
        }
      });

      // Aggiorna le quantità unite
      for (const name in map) {
        const row = map[name].row;
        row.querySelector(".qty").textContent = map[name].qty;
      }
    }

    // Esegui all'avvio
    window.addEventListener("DOMContentLoaded", () => {
      mergeDuplicateItems();
      updateCartTotal();
    });
  </script>
</body>
</html>
