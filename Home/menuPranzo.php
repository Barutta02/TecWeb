<!DOCTYPE html>
<html lang="it">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Ristorante Sushi</title>
  <meta name="keywords" content="Sushi Brombeis, Ristorante sushi via brombeis" />
  <meta name="description" content="Sito ufficiale del ristorante di sushi a Napoli in via brombeis" />
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="images.css" />
</head>

<body>
  <header>
    <h1>Sushi Brombeis</h1>
    <h3>all you can eat</h3>
  </header>
  <nav class="menu">
    <ul>
      <li><a href="index.html"> <span lang="en">Home </span></a></li>
      <li> Menu pranzo</li>
      <li><a href="menuCena.php">Menu cena</a></li>
      <li> <a href="chiSiamo.html"> Chi siamo </a> </li>
      <li> <a href="contattaci.html"> Contattaci </a> </li>
    </ul>
  </nav>
  <nav id="breadcrumb">
    <p>Ti trovi in: Menu Pranzo</p>
  </nav>
  <main>
    <?php
    // Include the Database and UserDao classes
    require_once 'DAO/PiattoDAO.php';
    $piattoDAO = new PiattoDAO();
    $piatti = $piattoDAO->getPiattoByTipoMenu('Pranzo');
    ?>
    <section id="PiattiMenu" class="colonne">
      <h2>Menu All You Can Eat - Pranzo</h2>
      <dl id="ListinoPrezziPranzo">
        <div>
          <dt>Dal lunedi al venerdi:</dt>
          <dd>15.90 €</dd>
        </div>
        <div>
          <dt>Sabato domenica e festivi:</dt>
          <dd>18.90 €</dd>
        </div>
      </dl>
      <p>Escluse bevande, dolci e coperto, prezzi riferiti al take away</p>
      <!-- Inserisci qui il tuo menu sushi -->
      <ul>
        <?php
        if (!empty($piatti)) {
          foreach ($piatti as $piatto) {
            echo '<li class="menuItem">';
            echo '<div class="imageMenuItem ' . str_replace(' ', '_', strtolower($piatto['NomePiatto'])) . '"></div>';
            echo '<div class="infoItem">';
            echo '<dl><dt class="nomePiatto">' . $piatto['NomePiatto'] . '</dt>';
            echo '<dd class="ingradienti">' . $piatto['Descrizione'] . '</dd>';
            echo '<dd class="prezzo">' . $piatto['Prezzo'] . '€</dd> </dl>';
            echo '</div>';
            echo '</li>';
          }
        } else {
          echo "No piatti found.";
        }
        ?>
      </ul>
    </section>
  </main>
  <footer>
    <p>&copy; 2023 Sushi Brombeis. Tutti i diritti riservati.</p>
  </footer>
</body>

</html>