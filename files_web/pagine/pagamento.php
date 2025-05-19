<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <title>RunGame - Aquista</title>
  <link rel="stylesheet" href="../css/pagamento.css">
</head>
<body>

  <div class="payment-container">
    <h1>Pagamento</h1>

    <div class="section-title">Dati di fatturazione</div>
    <label>Nome completo</label>
    <input type="text" placeholder="Nicolò Zuccarino">

    <label>Email</label>
    <input type="email" placeholder="mario@example.com">

    <label>Indirizzo</label>
    <input type="text" placeholder="Via Roma 123, Milano">

    <div class="section-title">Metodo di pagamento</div>
    <label>Numero carta</label>
    <input type="text" placeholder="1234 5678 9012 3456">

    <div class="row">
      <div>
        <label>Scadenza</label>
        <input type="text" placeholder="MM/AA">
      </div>
      <div>
        <label>CVV</label>
        <input type="text" placeholder="123">
      </div>
    </div>

    <div class="section-title">Riepilogo ordine</div>
    <div class="order-summary">
      <p>Maglietta Bianca ×2 — €30.00</p>
      <p>Jeans Blu ×1 — €40.00</p>
      <hr>
      <p><strong>Totale: €70.00</strong></p>
    </div>

    <button class="confirm-btn">Conferma ordine</button>
  </div>

</body>
</html>
