<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Contattaci - GameStore</title>
  <link rel="stylesheet" href="../css/global.css">
  <style>
    /* Stile per il container principale */
    .contact-container {
      max-width: 1000px;
      margin: 0 auto;
      padding: 40px 20px;
      background-color: #a8e6a8;
    }

    h1, h2 {
      color: #0a0a0a;
      margin-bottom: 20px;
    }

    h1 {
      text-align: center;
      font-size: 36px;
      padding-bottom: 20px;
      border-bottom: 2px solid #01cd01;
    }

    h2 {
      font-size: 24px;
      color: #01cd01;
    }

    /* Stile per le sezioni */
    .contact-info, 
    .contact-form, 
    .links-social {
      background-color: white;
      padding: 25px;
      margin-bottom: 25px;
      border-radius: 8px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .contact-info p {
      line-height: 1.8;
      margin-bottom: 10px;
      color: #333;
    }

    /* Stile per il form */
    .contact-form form {
      display: flex;
      flex-direction: column;
    }

    .contact-form input,
    .contact-form textarea {
      margin-bottom: 15px;
      padding: 12px;
      border: 1px solid #ddd;
      border-radius: 5px;
      font-size: 16px;
    }

    .contact-form textarea {
      min-height: 150px;
    }

    .contact-form button {
      background-color: #01cd01;
      color: white;
      border: none;
      padding: 14px;
      border-radius: 5px;
      cursor: pointer;
      font-size: 18px;
      font-weight: bold;
      transition: background-color 0.3s;
    }

    .contact-form button:hover {
      background-color: #00b300;
    }

    /* Stile per i link social */
    .links-social ul {
      list-style: none;
    }

    .links-social li {
      margin: 12px 0;
    }

    .links-social a {
      color: #01cd01;
      text-decoration: none;
      font-size: 18px;
      display: inline-block;
      padding: 5px 0;
      transition: color 0.3s;
    }

    .links-social a:hover {
      color: #008000;
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <?php include '../php_files/header_check.php'; ?>
  
  <div class="contact-container">
    <h1>CONTATTACI</h1>

    <div class="contact-info">
      <h2>📞 Informazioni di Contatto</h2>
      <p><strong>Email:</strong> assistenza@gamestore.it</p>
      <p><strong>Telefono:</strong> +39 0123 456 789</p>
      <p><strong>Orari di Assistenza:</strong> Lun–Ven, 9:00 – 18:00</p>
      <p><strong>Indirizzo:</strong> Via dei Videogiochi 42, 20100 Milano (MI)</p>
    </div>

    <div class="contact-form">
      <h2>📝 Inviaci un Messaggio</h2>
      <form>
        <input type="text" name="nome" placeholder="Il tuo nome" required>
        <input type="email" name="email" placeholder="La tua email" required>
        <input type="text" name="oggetto" placeholder="Oggetto" required>
        <textarea name="messaggio" placeholder="Scrivi il tuo messaggio..." required></textarea>
        <button type="submit">Invia</button>
      </form>
    </div>

    <div class="links-social">
      <h2>📱 Seguici sui Social</h2>
      <ul>
        <li><a href="#" target="_blank">Instagram</a></li>
        <li><a href="#" target="_blank">Facebook</a></li>
        <li><a href="#" target="_blank">TikTok</a></li>
        <li><a href="#" target="_blank">YouTube</a></li>
      </ul>
    </div>
  </div>
</body>
</html>