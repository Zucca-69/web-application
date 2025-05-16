<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <title>Pagamento</title>
  <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="../css/slider.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/darkmode.css">
    <link rel="stylesheet" href="../css/galleria.css">
    <link rel="stylesheet" href="../css/barra-navigazione.css">
  <style>
    
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
    input[type="number"],
    select,
    input[type="password"] {
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

    .payment-method-fields {
      margin-top: 20px;
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

    <!-- Dropdown tipo di pagamento -->
    <div class="section-title">Tipo di pagamento</div>
    <label for="tipoPagamento">Seleziona metodo di pagamento</label>
    <select id="tipoPagamento">
      <option value="carta" selected>Carta di credito / debito</option>
      <option value="paypal">PayPal</option>
      <option value="visa">Visa</option>
      <option value="mastercard">Mastercard</option>
      <option value="poste">Poste Italiane</option>
    </select>

    <!-- Metodo di pagamento - solo per carta -->
    <div class="section-title">Metodo di pagamento</div>
    <div class="payment-method-fields" id="cartaFields">
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
    </div>

    <!-- Metodo di pagamento - PayPal -->
    <div class="payment-method-fields" id="paypalFields" style="display: none;">
      <label>Indirizzo Email PayPal</label>
      <input type="email" placeholder="email@paypal.com">
    </div>

    <!-- Aggiungi il campo password -->
    <div class="section-title">Sicurezza</div>
    <label for="password">Inserisci la tua password per completare il pagamento</label>
    <input type="password" id="password" placeholder="Password" required>

    <!-- Riepilogo ordine -->
    <div class="section-title">Riepilogo ordine</div>
    <div class="order-summary">
      <p>Maglietta Bianca ×2 — €30.00</p>
      <p>Jeans Blu ×1 — €40.00</p>
      <hr>
      <p><strong>Totale: €70.00</strong></p>
    </div>

    <button class="confirm-btn">Conferma ordine</button>
  </div>

  <script>
    const tipoPagamento = document.getElementById('tipoPagamento');
    const cartaFields = document.getElementById('cartaFields');
    const paypalFields = document.getElementById('paypalFields');

    function aggiornaMetodoPagamento() {
      if (tipoPagamento.value === 'carta') {
        cartaFields.style.display = 'block';
        paypalFields.style.display = 'none';
      } else if (tipoPagamento.value === 'paypal') {
        cartaFields.style.display = 'none';
        paypalFields.style.display = 'block';
      } else if (tipoPagamento.value === 'visa' || tipoPagamento.value === 'mastercard' || tipoPagamento.value === 'poste') {
        cartaFields.style.display = 'block';
        paypalFields.style.display = 'none';
      }
    }

    // Al cambio del valore nel dropdown
    tipoPagamento.addEventListener('change', aggiornaMetodoPagamento);

    // Imposta lo stato iniziale
    window.addEventListener('DOMContentLoaded', aggiornaMetodoPagamento);
  </script>

</body>
</html>
