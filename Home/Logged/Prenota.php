<!DOCTYPE html>
<html lang="it">
<?php
session_start();
?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ristorante Sushi</title>
  <meta name="keywords" content="Sushi Brombeis, Ristorante sushi via brombeis">
  <meta name="description" content="Pagina per la prenotazione dei piatti del ristorante di sushi Brombeis">
  <link rel="stylesheet" href="../style.css">
  <link rel="stylesheet" href="../images.css">
</head>

<body>
  <header tabindex="1">
    <h1>Sushi Brombeis</h1>
    <h3>all you can eat</h3>
  </header>
  <nav class="menu">
    <ul>
      <li tabindex="2">Prenota</li>
      <li tabindex="3"><a href="#"> Visualizza ordini</a></li>
      <li><a href="menuCena.php" tabindex="4">Chiama cameriere</a></li>
    </ul>
  </nav>
  <nav id="breadcrumb" tabindex="4">
    <p>Ti trovi in: Prenota</p>
  </nav>
  <main>
    <section id="allergeni">
      <h4 tabindex="6">Seleziona gli allergeni da evitare:</h4>
      <form>
        <ul id="listaAllergeni">
          <?php
          require_once '../DAO/AllergeneDAO.php';
          $allergeneDAO = new AllergeneDAO();
          $allergeni = AllergeneDAO::getAllAllergeni();
          $tabIndex_offset = 6;

          if (!empty($allergeni)) {
            foreach ($allergeni as $allergene) {
              $tabIndex_offset = $tabIndex_offset + 2;
              echo '<li tabindex="' . ($tabIndex_offset) . '">';
              echo '<input type="checkbox" id="' . $allergene["NomeAllergene"] . 'Chbox" name="allergeni[]" value="' . $allergene["NomeAllergene"] . '" aria-labelledby="' . $allergene["NomeAllergene"] . 'Label"  tabindex="0" >';
              echo '<label id="' . $allergene["NomeAllergene"] . 'Label" for="' . $allergene["NomeAllergene"] . 'Chbox" tabindex="0">' . $allergene["NomeAllergene"] . '</label>';
              echo "</li>";
            }
          }
          ?>
        </ul>
      </form>
    </section>
    <section id="PiattiMenu" class="colonne">
      <h2 tabindex="20">
        <?php echo $_SESSION['name'] . ' '; ?> ordina qui i tuoi piatti
      </h2>
      <!-- Inserisci qui il tuo menu sushi -->
      <form action="process_prenotazione.php" method="post">
        <?php
        require_once '../DAO/PiattoDAO.php';
        require_once '../DAO/CategoriaDAO.php';

        $piattoDAO = new PiattoDAO();
        $categoriaDAO = new CategoriaDAO();
        $tabIndex_offset = 20;

        $categorie = CategoriaDAO::getAllCategory();
        if (!empty($categorie)) {
          foreach ($categorie as $categoria) {
            $piatti = PiattoDAO::getPiattoByTipoCategory($categoria['Nome']);
            if (!empty($piatti)) {
              echo " <fieldset> <legend>" . $categoria['Nome'] . "</legend> <ul>";
              foreach ($piatti as $piatto) {
                $allergeniPiatto = AllergeneDAO::getAllergeniByPiatto(intval($piatto['IDPiatto']));
                $tabIndex_offset = $tabIndex_offset + 1;
                $refactorNomePiatto = str_replace(' ', '_', strtolower($piatto['NomePiatto']));
                $ariaLabel = 'Piatto: ' . $piatto['NomePiatto'] . ', Descrizione: ' . $piatto['Descrizione'];
                echo '<li class="menuItem ' . implode(" ", $allergeniPiatto) . '" tabindex="' . (10 + $tabIndex_offset) . '" aria-label="' . $ariaLabel . '">';
                echo '<div class="imageMenuItem ' . $refactorNomePiatto . '"></div>';
                echo '<div class="infoItem">';
                echo '<dl><dt class="nomePiatto" data-title="Nome Piatto">' . $piatto['NomePiatto'] . '</dt>';
                echo '<dd class="ingradienti" data-title="Descrizione ingradienti">' . $piatto['Descrizione'] . '</dd></dl>';
                echo '<label for="quantita_' . $piatto['IDPiatto'] . '">Quantità:</label> <input type="number" class="inptQuantita" id="quantita_' . $piatto['IDPiatto'] . '" name="quantita_' . $piatto['IDPiatto'] . '" value="0" min="0" max="10">';
                echo '</div>';
                echo '</li>';
              }
              echo "</ul></fieldset>";
            } else {
              echo "No piatti found.";
            }

          }
        } else {
          echo "No Categories found.";
        }
        ?>
        <input type="submit" id="submitPrenotazione" value="Invia ordine">
      </form>
    </section>
  </main>
  <script>
    function addCheckboxListeners() {
      var checkboxes = document.querySelectorAll('input[type="checkbox"]');
      checkboxes.forEach(function (checkbox) {
        checkbox.addEventListener('change', function () {
          var className = checkbox.id.replace("Chbox", "");
          document.querySelectorAll("." + className).forEach(function (element) {
            element.classList.toggle("hide", checkbox.checked);
          });
        });
      });
    }
    addCheckboxListeners();
  </script>
  <footer>
    <p>&copy; 2023 Sushi Brombeis. Tutti i diritti riservati.</p>
  </footer>
</body>

</html>