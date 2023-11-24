<!DOCTYPE html>
<html lang="it">
<?php
session_start();
if (!isset($_SESSION["username"])) {
  header("Location: ../Registration/login.php");
}
?>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Ristorante Sushi</title>
  <meta name="keywords" content="Sushi Brombeis, Ristorante sushi via brombeis" />
  <meta name="description" content="Sito ufficiale del ristorante di sushi a Napoli in via brombeis" />
  <link rel="stylesheet" href="style.css" />
</head>

<body>
  <header>
    <h1>Sushi Brombeis</h1>
    <h3>all you can eat</h3>
  </header>
  <nav class="menu">
    <ul>
      <li>Nuova prenotazione</li>
      <li><a href="#">Chiama cameriere</a></li>
    </ul>
  </nav>
  <nav id="breadcrumb">
    <p>Ti trovi in: Nuova prenotazione</p>
  </nav>
  <main>
    <section id="login">
      <h2>Nuova prenotazione</h2>
      <form action="process/newPrenotazione_process.php" method="post">
        <fieldset>
          <legend>Inserisci dati</legend>
          <ul>
            <li>
              <label for="n_persone">Numero di persone:</label>
              <input type="number" id="n_persone" name="n_persone" min="0" max="100" required />
            </li>

            <li>
              <label for="n_tavolo">Numero tavolo:</label>
              <input type="number" id="n_tavolo" name="n_tavolo" min="0" max="100" required />
            </li>
          </ul>
          <input type="submit" value="Crea nuova prenotazione" />
        </fieldset>
      </form>
    </section>
  </main>
  <footer>
    <p>&copy; 2023 Sushi Brombeis. Tutti i diritti riservati.</p>
  </footer>
</body>

</html>