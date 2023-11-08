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
  </header>
  <nav class="menu">
    <ul>
      <li> Home </li>
      <li> <a href="menu.html"> Menu </a> </li>
      <li> <a href="chiSiamo.html"> Chi siamo </a> </li>
      <li> <a href="contattateci.html"> Contattateci </a> </li>
    </ul>
  </nav>
  <main>
    <?php
    // Include the Database and UserDao classes
    require_once 'DAO/PiattoDAO.php';
    $piattoDAO = new PiattoDAO();
    $piatti = $piattoDAO->getAllPiatti();
    ?>
    <section id="home">
      <h2>Benvenuti al Ristorante Sushi Brombeis</h2>
      <p>
        Benvenuti nel cuore di Napoli, dove l'eleganza culinaria incontra
        l'arte del sushi. Siamo lieti di presentarvi il nostro ristorante,
        un'oasi gastronomica situata in Via Brombeis, dedicata all'autentica
        esperienza del sushi con un tocco di creatività napoletana. Da noi, il
        vostro palato sarà guidato attraverso un viaggio unico di sapori
        freschi e raffinati. I nostri chef esperti preparano con maestria
        prelibati piatti di sushi utilizzando solo ingredienti di prima
        qualità. La fusione tra la tradizione giapponese e l'ispirazione
        culinaria napoletana crea un'esperienza gastronomica eccezionale. Il
        nostro ambiente accogliente e moderno è il luogo perfetto per
        condividere momenti speciali con amici e familiari. Siamo impegnati a
        offrire un servizio caloroso e impeccabile, dove ogni dettaglio è
        curato per garantire un'esperienza indimenticabile. Siete invitati a
        unirvi a noi per assaporare il meglio del sushi nel cuore di Napoli.
        Concedetevi il lusso di una cena raffinata e lasciatevi trasportare in
        un mondo di sapori unici presso il nostro ristorante in Via Brombeis.
        Siamo pronti ad accogliervi con gusto e stile.
      </p>
    </section>

    <section id="menu" class="colonne">
      <h2 id="menuTitle">Il nostro Menu</h2>
      <!-- Inserisci qui il tuo menu sushi -->
      <dl>
        <?php

        if (!empty($piatti)) {
          foreach ($piatti as $piatto) {
            echo '<div class="menuItem">';
            echo '<div class="imageMenuItem ' . strtolower($piatto['NomePiatto']) . '"></div>';
            echo '<div class="infoItem">';
            echo '<dt class="nomePiatto">' . $piatto['NomePiatto'] . '</dt>';
            echo '<dd class="ingradienti">' . $piatto['Descrizione'] . '</dd>';
            echo '<dd class="prezzo">' . $piatto['Prezzo'] . '€</dd>';
            echo '</div>';
            echo '</div>';
          }
        } else {
          echo "No piatti found.";
        }
        ?>
        <!-- <div class="menuItem">
          <div class="imageMenuItem nighiriSalmone"></div>
          <div class="infoItem">
            <dt class="nomePiatto">Nighiri salmone</dt>
            <dd class="ingradienti">Salmone, riso</dd>
            <dd class="prezzo">4€</dd>
          </div>
        </div>
        <div class="menuItem">
          <div class="imageMenuItem nighiriTonno"></div>
          <div class="infoItem">
            <dt class="nomePiatto">Nighiri Tonno</dt>
            <dd class="ingradienti">Salmone, tonno</dd>
            <dd class="prezzo">4€</dd>
          </div>
        </div>
        <div class="menuItem">
          <div class="imageMenuItem nighiriGambero"></div>
          <div class="infoItem">
            <dt class="nomePiatto">Nighiri gambero</dt>
            <dd class="ingradienti">Salmone, gambero</dd>
            <dd class="prezzo">4€</dd>
          </div>
        </div>
        <div class="menuItem">
          <div class="imageMenuItem gunkanSalmone"></div>
          <div class="infoItem">
            <dt class="nomePiatto">gunkanSalmone</dt>
            <dd class="ingradienti">Salmone, riso</dd>
            <dd class="prezzo">4€</dd>
          </div>
        </div>
        <div class="menuItem">
          <div class="imageMenuItem gunkanTonno"></div>
          <div class="infoItem">
            <dt class="nomePiatto">gunkanTonno</dt>
            <dd class="ingradienti">Salmone, riso</dd>
            <dd class="prezzo">4€</dd>
          </div>
        </div>
        <div class="menuItem">
          <div class="imageMenuItem gunkanTonnoAlto"></div>
          <div class="infoItem">
            <dt class="nomePiatto">gunkanTonnoAlto</dt>
            <dd class="ingradienti">Salmone, riso</dd>
            <dd class="prezzo">4€</dd>
          </div>
        </div>
        <div class="menuItem">
          <div class="imageMenuItem hosomakiSalmone"></div>
          <div class="infoItem">
            <dt class="nomePiatto">hosomakiSalmone</dt>
            <dd class="ingradienti">Salmone, riso</dd>
            <dd class="prezzo">4€</dd>
          </div>
        </div>
        <div class="menuItem">
          <div class="imageMenuItem hossomakiAvocado"></div>
          <div class="infoItem">
            <dt class="nomePiatto">hossomakiAvocado</dt>
            <dd class="ingradienti">Salmone, riso</dd>
            <dd class="prezzo">4€</dd>
          </div>
        </div>
        <div class="menuItem">
          <div class="imageMenuItem hossomakiCroccante"></div>
          <div class="infoItem">
            <dt class="nomePiatto">hossomakiCroccante</dt>
            <dd class="ingradienti">Salmone, riso</dd>
            <dd class="prezzo">4€</dd>
          </div>
        </div>
        <div class="menuItem">
          <div class="imageMenuItem hossomakiSake"></div>
          <div class="infoItem">
            <dt class="nomePiatto">hossomakiSake</dt>
            <dd class="ingradienti">Salmone, riso</dd>
            <dd class="prezzo">4€</dd>
          </div>
        </div>
        <div class="menuItem">
          <div class="imageMenuItem hossomakiSpacial"></div>
          <div class="infoItem">
            <dt class="nomePiatto">hossomakiSpacial</dt>
            <dd class="ingradienti">Salmone, riso</dd>
            <dd class="prezzo">4€</dd>
          </div>
        </div>
        <div class="menuItem">
          <div class="imageMenuItem hossomakiSpacialUsa"></div>
          <div class="infoItem">
            <dt class="nomePiatto">hossomakiSpacialUsa</dt>
            <dd class="ingradienti">Salmone, riso</dd>
            <dd class="prezzo">4€</dd>
          </div>
        </div>
        <div class="menuItem">
          <div class="imageMenuItem hossomakiSpecialWasabi"></div>
          <div class="infoItem">
            <dt class="nomePiatto">hossomakiSpecialWasabi</dt>
            <dd class="ingradienti">Salmone, riso</dd>
            <dd class="prezzo">4€</dd>
          </div>
        </div>
        <div class="menuItem">
          <div class="imageMenuItem hossomakiSumagi"></div>
          <div class="infoItem">
            <dt class="nomePiatto">hossomakiSumagi</dt>
            <dd class="ingradienti">Salmone, riso</dd>
            <dd class="prezzo">4€</dd>
          </div>
        </div>
        <div class="menuItem">
          <div class="imageMenuItem il-sushi-half-650x432"></div>
          <div class="infoItem">
            <dt class="nomePiatto">il-sushi-half-650x432</dt>
            <dd class="ingradienti">Salmone, riso</dd>
            <dd class="prezzo">4€</dd>
          </div>
        </div>
        <div class="menuItem">
          <div class="imageMenuItem nighiriGambero"></div>
          <div class="infoItem">
            <dt class="nomePiatto">nighiriGambero</dt>
            <dd class="ingradienti">Salmone, riso</dd>
            <dd class="prezzo">4€</dd>
          </div>
        </div>
        <div class="menuItem">
          <div class="imageMenuItem nighiriSalmone"></div>
          <div class="infoItem">
            <dt class="nomePiatto">nighiriSalmone</dt>
            <dd class="ingradienti">Salmone, riso</dd>
            <dd class="prezzo">4€</dd>
          </div>
        </div>
        <div class="menuItem">
          <div class="imageMenuItem nighiriTonno"></div>
          <div class="infoItem">
            <dt class="nomePiatto">nighiriTonno</dt>
            <dd class="ingradienti">Salmone, riso</dd>
            <dd class="prezzo">4€</dd>
          </div>
        </div>
        <div class="menuItem">
          <div class="imageMenuItem sashimiSalmone"></div>
          <div class="infoItem">
            <dt class="nomePiatto">sashimiSalmone</dt>
            <dd class="ingradienti">Salmone, riso</dd>
            <dd class="prezzo">4€</dd>
          </div>
        </div>
        <div class="menuItem">
          <div class="imageMenuItem sashimiTonno"></div>
          <div class="infoItem">
            <dt class="nomePiatto">sashimiTonno</dt>
            <dd class="ingradienti">Salmone, riso</dd>
            <dd class="prezzo">4€</dd>
          </div>
        </div>
        <div class="menuItem">
          <div class="imageMenuItem speciale-maki-tempura-coda-gambero-650x650"></div>
          <div class="infoItem">
            <dt class="nomePiatto">speciale-maki-tempura-coda-gambero-650x650</dt>
            <dd class="ingradienti">Salmone, riso</dd>
            <dd class="prezzo">4€</dd>
          </div>
        </div>
        <div class="menuItem">
          <div class="imageMenuItem temakiTempura"></div>
          <div class="infoItem">
            <dt class="nomePiatto">temakiTempura</dt>
            <dd class="ingradienti">Salmone, riso</dd>
            <dd class="prezzo">4€</dd>
          </div>
        </div>
        <div class="menuItem">
          <div class="imageMenuItem temakiTonno"></div>
          <div class="infoItem">
            <dt class="nomePiatto">temakiTonno</dt>
            <dd class="ingradienti">Salmone, riso</dd>
            <dd class="prezzo">4€</dd>
          </div>
        </div>
        <div class="menuItem">
          <div class="imageMenuItem tempuraFruttiMare"></div>
          <div class="infoItem">
            <dt class="nomePiatto">tempuraFruttiMare</dt>
            <dd class="ingradienti">Salmone, riso</dd>
            <dd class="prezzo">4€</dd>
          </div>
        </div>
        <div class="menuItem">
          <div class="imageMenuItem tempuraGamberi"></div>
          <div class="infoItem">
            <dt class="nomePiatto">tempuraGamberi</dt>
            <dd class="ingradienti">Salmone, riso</dd>
            <dd class="prezzo">4€</dd>
          </div>
        </div>-->
      </dl>
    </section>


    <footer>
      <p>&copy; 2023 Sushi Brombeis. Tutti i diritti riservati.</p>
    </footer>
</body>

</html>