<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <title>Pagamento</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      margin: 0;
      padding: 0;
    }

    .payment-container {
      max-width: 800px;
      margin: 50px auto;
      background-color: white;
      padding: 40px;
      border-radius: 10px;
      box-shadow: 0 0 20px rgba(0,0,0,0.1);
      font-size: 18px;
    }

    h1 {
      text-align: center;
      margin-bottom: 40px;
      font-size: 2.2em;
    }

    .section-title {
      font-weight: bold;
      margin-top: 30px;
      font-size: 1.3em;
      border-bottom: 2px solid #ccc;
      padding-bottom: 6px;
    }

    label {
      display: block;
      margin-top: 15px;
    }

    input[type="text"],
    input[type="email"],
    input[type="number"] {
      width: 100%;
      padding: 14px;
      margin-top: 6px;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 16px;
    }

    .row {
      display: flex;
      gap: 20px;
    }

    .row > div {
      flex: 1;
    }

    .order-summary {
      margin-top: 30px;
      background-color: #f9f9f9;
      padding: 20px;
      border-radius: 6px;
      border: 1px solid #ddd;
    }

    .order-summary p {
      margin: 8px 0;
    }

    .order-summary strong {
      font-size: 1.3em;
    }

    .confirm-btn {
      display: block;
      width: 100%;
      padding: 18px;
      margin-top: 40px;
      background-color: #28a745;
      color: white;
      border: none;
      font-size: 1.4em;
      border-radius: 10px;
      cursor: pointer;
    }

    .confirm-btn:hover {
      background-color: #218838;
    }
  </style>
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
