<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Contattaci - GameStore</title>
  <link rel="stylesheet" href="../css/global.css">
  <link rel="stylesheet" href="../css/slider.css">
  <link rel="stylesheet" href="../css/footer.css">
  <link rel="stylesheet" href="../css/darkmode.css">
  <link rel="stylesheet" href="../css/galleria.css">
  <link rel="stylesheet" href="../css/barra-navigazione.css">
  <style>
    .contact-container {
      max-width: 1000px;
      margin: 0 auto;
      padding: 40px 20px;
    }

    h1 {
      text-align: center;
      color: rgb(0, 0, 0);
      margin-bottom: 30px;
    }

    .contact-info, .contact-form, .links-social {
      background-color: white;
      padding: 20px;
      margin-bottom: 20px;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .contact-info p {
      line-height: 1.6;
    }

    .contact-form form {
      display: flex;
      flex-direction: column;
    }

    .contact-form input,
    .contact-form textarea {
      margin-bottom: 15px;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    .contact-form button {
      background-color: #01cd01;
      color: white;
      border: none;
      padding: 12px;
      border-radius: 5px;
      cursor: pointer;
      font-size: 16px;
      transition: transform 0.2s ease-in-out;
    }

    .contact-form button:hover {
      transform: scale(1.05);
    }

    .links-social ul {
      list-style: none;
      padding: 0;
    }

    .links-social li {
      margin: 8px 0;
    }

    .links-social a {
      color: #01cd01;
      text-decoration: none;
    }

    .links-social a:hover {
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
        <textarea name="messaggio" rows="5" placeholder="Scrivi il tuo messaggio..." required></textarea>
        <button type="submit">Invia</button>
      </form>
    </div>

    <div class="links-social">
      <h2>📱 Seguici sui Social</h2>
      <ul>
        <li><a href="#">Instagram</a></li>
        <li><a href="#">Facebook</a></li>
        <li><a href="#">TikTok</a></li>
        <li><a href="#">YouTube</a></li>
      </ul>
    </div>
  </div>
</body>
</html>