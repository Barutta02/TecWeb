<!DOCTYPE html>
<html lang="it">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ristorante Sushi</title>
  <meta name="keywords" content="Sushi Brombeis, Ristorante sushi via brombeis">
  <meta name="description" content="Sito ufficiale del ristorante di sushi a Napoli in via brombeis">
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="images.css">
</head>

<body>
  <header tabindex="1">
    <h1>Sushi Brombeis</h1>
    <h3>all you can eat</h3>
  </header>
  <nav class="menu">
    <ul>
      <li><a href="index.html" tabindex="2"> <span lang="en">Home </span></a></li>
      <li tabindex="3"> Menu pranzo</li>
      <li><a href="menuCena.php" tabindex="4">Menu cena</a></li>
      <li> <a href="chiSiamo.html" tabindex="5"> Chi siamo </a> </li>
      <li> <a href="contattaci.html" tabindex="6"> Contattaci </a> </li>
    </ul>
  </nav>
  <nav id="breadcrumb" tabindex="7">
    <p>Ti trovi in: Menu Pranzo</p>
  </nav>
  <main>
    <?php
    // Include the Database and UserDao classes
    require_once 'DAO/PiattoDAO.php';
    $piattoDao = new PiattoDAO();
    $piatti = PiattoDAO::getPiattoByTipoMenu('Pranzo');
    ?>
    <section id="PiattiMenu" class="colonne">
      <h2 tabindex="9">Menu All You Can Eat - Pranzo</h2>
      <dl id="ListinoPrezziPranzo">
        <div tabindex="10">
          <dt>Dal lunedi al venerdi:</dt>
          <dd>15.90 €</dd>
        </div>
        <div tabindex="11">
          <dt>Sabato domenica e festivi:</dt>
          <dd>18.90 €</dd>
        </div>
      </dl>
      <p tabindex="12">Escluse bevande, dolci e coperto, prezzi riferiti al take away</p>
      <!-- Inserisci qui il tuo menu sushi -->
      <ul>
        <?php
        $tabIndex_offset = 12;
        if (!empty($piatti)) {
          foreach ($piatti as $piatto) {
            $tabIndex_offset = $tabIndex_offset + 1;
            $ariaLabel = 'Piatto: ' . $piatto['NomePiatto'] . ', Descrizione: ' . $piatto['Descrizione'] . ', Prezzo: ' . $piatto['Prezzo'] . ' Euro';
            echo '<li class="menuItem" tabindex="' . (10 + $tabIndex_offset) . '" aria-label="' . $ariaLabel . '">';
            echo '<div class="imageMenuItem ' . str_replace(' ', '_', strtolower($piatto['NomePiatto'])) . '"></div>';
            echo '<div class="infoItem">';
            echo '<dl><dt class="nomePiatto" data-title="Nome Piatto">' . $piatto['NomePiatto'] . '</dt>';
            echo '<dd class="ingradienti" data-title="Descrizione ingradienti">' . $piatto['Descrizione'] . '</dd>';
            echo '<dd class="prezzo" data-title="Prezzo">' . $piatto['Prezzo'] . '€</dd> </dl>';
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