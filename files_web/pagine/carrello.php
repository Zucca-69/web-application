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
  <script src="../js/change_cart_total.js" defer></script>

</head>
<body>
  <?php 
    // setup per la pagina
    session_start();
    include '../php_files/db_connection.php';
    include '../php_files/cart_actions_handler.php';
    include '../php_files/header.php';  
    include '../php_files/get_cart.php'; 

  ?>

  <div class="cart-container">
    <h1>Il tuo carrello</h1>

        <?php
        // verifico che cartItem esista
        $giochiCarrello = $giochiCarrello ?? [];

        // mostra i prodotti nel carrello
        if (empty($giochiCarrello)) : ?> 
          <tr>
            <td colspan="5">
              Il tuo carrello è vuoto, <a href = 'catalogo.php'>VAI AL CATALOGO</a>!
            </td>
          </tr>
        <?php else: ?>
          <!-- intestazione del resoconto d'acquisto -->
          <table>
            <thead>
              <tr>
                <th>Prodotto</th>
                <th>Piattaforma</th>
                <th>Quantità</th>
                <th>Prezzo</th>
                <th>Totale</th>
                <th>Azioni</th>
              </tr>
            </thead>

            <tbody id="cart-items">

            <!-- per ogni gioco fa una riga del carrello -->
            <?php foreach ($giochiCarrello as $prodotto) : ?>
                <tr data-price="<?= htmlspecialchars($prodotto['prezzo']) ?>"
                    data-product-id="<?= htmlspecialchars($prodotto['productId']) ?>"
                    data-max-quantity="<?= htmlspecialchars($prodotto['disponibilita'] ?? 99) ?>">
                    
                    <td><?= htmlspecialchars($prodotto['nome']) ?></td>
                    <td><?= htmlspecialchars($prodotto['piattaforma'] ?? 'N/D') ?></td>
                    <td class="qty"><?= htmlspecialchars($prodotto['quantita']) ?></td>
                    <td>€<?= number_format($prodotto['prezzo'], 2) ?></td>
                    <td class="line-total">€<?= number_format($prodotto['prezzo'] * $prodotto['quantita'], 2) ?></td>
                    <td class="qty-controls">
                        <div class="action-buttons">
                          <form method="post" class="cart-action-form">
                              <input type="hidden" name="productId" value="<?= $prodotto['productId'] ?>">
                              <input type="hidden" name="piattaforma" value="<?= $prodotto['piattaforma'] ?>">

                              <input type="hidden" name="cart_action" value="update">
                              <input type="hidden" name="quantity" value="<?= $prodotto['quantita'] - 1 ?>">
                              <input type="hidden" name="redirect" value="carrello.php">
                              <button type="submit">−</button>
                          </form>

                          <form method="post" class="cart-action-form">
                              <input type="hidden" name="productId" value="<?= $prodotto['productId'] ?>">
                              <input type="hidden" name="piattaforma" value="<?= $prodotto['piattaforma'] ?>">
                              <input type="hidden" name="cart_action" value="remove">
                              <input type="hidden" name="redirect" value="carrello.php">
                              <button type="submit">🗑️</button>
                          </form>

                          <form method="post" class="cart-action-form">
                              <input type="hidden" name="productId" value="<?= $prodotto['productId'] ?>">
                              <input type="hidden" name="piattaforma" value="<?= $prodotto['piattaforma'] ?>">
                              <input type="hidden" name="cart_action" value="update">
                              <input type="hidden" name="quantity" value="<?= $prodotto['quantita'] + 1 ?>">
                              <input type="hidden" name="redirect" value="carrello.php">
                              <button type="submit">+</button>
                          </form>

                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

        <!-- calcolo il costo totale -->
        <div class="total">
          <strong>Totale Carrello: €<span id="total">0.00</span></strong>
        </div>
        <button class="checkout-btn">Procedi al Checkout</button>
      </div>
      <?php endif; ?>
</body>
</html>