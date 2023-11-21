<!DOCTYPE html>
<html lang="it">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ristorante Sushi</title>
  <meta name="keywords" content="Sushi Brombeis, Ristorante sushi via brombeis">
  <meta name="description" content="Sito ufficiale del ristorante di sushi a Napoli in via brombeis">
  <link rel="stylesheet" href="../style.css">
</head>

<body>
  <header>
    <h1>Sushi Brombeis</h1>
    <h3>all you can eat</h3>
  </header>
  <nav class="menu">
    <ul>
      <li><a href="../home.html"></a><span lang="en">Home</span> </li>
      <li> <a href="../menuPranzo.php">Menu pranzo</a></li>
      <li> <a href="../menuCena.php">Menu pranzo</a></li>
      <li> <a href="../chiSiamo.html"> Chi siamo </a> </li>
      <li> <a href="../contattaci.html"> Contattaci </a> </li>
      <li><span lang="en">SignIn</span> </li>
      <li> <a href="login.php"><span lang="en">Login</span></a> </li>
    </ul>
  </nav>
  <nav id="breadcrumb">
    <p>Ti trovi in: <span lang="en">SignIn</span></p>
  </nav>
  <main>
    <section id="signIn">
      <h2>SignIn</h2>
      <form action="signIn_request.php" method="post">
        <fieldset>
          <legend>
            Inserisci dati per la registrazione
          </legend>
          <ul>
            <li><label for="username">Username:</label>
              <input type="text" id="username" name="username" required>
            </li>
            <li> <label for="firstname">Nome:</label>
              <input type="text" id="firstname" name="firstname" required>
            </li>
            <li> <label for="lastname">Cognome:</label>
              <input type="text" id="lastname" name="lastname" required>
            </li>
            <li> <label for="email">Email:</label>
              <input type="email" id="email" name="email" required>
            </li>
            <li>
              <label for="password">Password:</label>
              <input type="password" id="password" name="password" required>
            </li>
          </ul>
          <input type="submit" value="Registrati">
        </fieldset>
      </form>
    </section>
  </main>
  <footer>
    <p>&copy; 2023 Sushi Brombeis. Tutti i diritti riservati.</p>
  </footer>
</body>

</html>