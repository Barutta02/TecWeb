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
      <li><a href="../index.html"><span lang="en">Home</span></a> </li>
      <li> <a href="../menuPranzo.php">Menu pranzo</a></li>
      <li> <a href="../menuCena.php">Menu pranzo</a></li>
      <li> <a href="../chiSiamo.html"> Chi siamo </a> </li>
      <li> <a href="../contattaci.html"> Contattaci </a> </li>
      <li> <a href="signIn.php"><span lang="en">SignIn</span> </a></li>
      <li> <span lang="en">Login</span> </li>
    </ul>
  </nav>
  <nav id="breadcrumb">
    <p>Ti trovi in: <span lang="en">Login</span></p>
  </nav>
  <main>
    <section id="login">
      <h2>Login</h2>
      <form action="process/login_request.php" method="post">
        <fieldset>
          <legend>
            Inserisci dati per il <span lang="en">Login</span>
          </legend>
          <ul>
            <li><label for="username_or_email"><span lang="en">Username o Email:</span></label>
              <input type="text" id="username_or_email" name="username_or_email" required>
            </li>

            <li> <label for="password"><span lang="en">Password:</span></label>
              <input type="password" id="password" name="password" required>
            </li>
          </ul>



          <button type="submit"><span lang="en">Login</span></button>
        </fieldset>
      </form>
    </section>
  </main>
  <footer>
    <p>&copy; 2023 Sushi Brombeis. Tutti i diritti riservati.</p>
  </footer>
</body>

</html>