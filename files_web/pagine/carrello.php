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
  <style>
    .cart-container {
      max-width: 800px;
      margin: auto;
      background: #fff;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      margin-top: 50px;
    }
    h1 {
      text-align: center;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }
    th, td {
      padding: 12px;
      text-align: center;
      border-bottom: 1px solid #ddd;
    }
    .total {
      text-align: right;
      font-size: 1.2em;
      margin-top: 20px;
    }
    .checkout-btn {
      display: block;
      width: 100%;
      padding: 15px;
      background-color: #28a745;
      color: white;
      font-size: 1em;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      margin-top: 20px;
    }
    .checkout-btn:hover {
      background-color: #218838;
    }
    .qty-controls {
      text-align: center;
    }
    .action-buttons {
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 8px;
    }
    .action-buttons button {
      padding: 6px 10px;
      cursor: pointer;
      font-size: 16px;
    }
  </style>
</head>
<body>
  <?php include '../php_files/header_check.php'; ?>
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
        <tr data-price="15.00">
          <td>Maglietta Bianca</td>
          <td class="qty">1</td>
          <td>€15.00</td>
          <td class="line-total">€0.00</td>
          <td class="qty-controls">
            <div class="action-buttons">
              <button onclick="changeQty(this, 1)">+</button>
              <button onclick="removeItem(this)">🗑️</button>
              <button onclick="changeQty(this, -1)">−</button>
            </div>
          </td>
        </tr>
        <tr data-price="15.00">
          <td>Maglietta Bianca</td>
          <td class="qty">2</td>
          <td>€15.00</td>
          <td class="line-total">€0.00</td>
          <td class="qty-controls">
            <div class="action-buttons">
              <button onclick="changeQty(this, 1)">+</button>
              <button onclick="removeItem(this)">🗑️</button>
              <button onclick="changeQty(this, -1)">−</button>
            </div>
          </td>
        </tr>
        <tr data-price="40.00">
          <td>Jeans Blu</td>
          <td class="qty">1</td>
          <td>€40.00</td>
          <td class="line-total">€0.00</td>
          <td class="qty-controls">
            <div class="action-buttons">
              <button onclick="changeQty(this, 1)">+</button>
              <button onclick="removeItem(this)">🗑️</button>
              <button onclick="changeQty(this, -1)">−</button>
            </div>
          </td>
        </tr>
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
