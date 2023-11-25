<!DOCTYPE html>
<html lang="it">
<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: ../Registration/login.php");
}
if (!isset($_SESSION["data_prenotazione_inCorso"])) {
    header("Location: NuovaPrenotazione.php");
}
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
            <li tabindex="2"><a href="Prenota.php"> Prenota </a></li>
            <li tabindex="3">Visualizza ordini</li>
        </ul>
    </nav>
    <nav id="breadcrumb" tabindex="4">
        <p>Ti trovi in: Visualizza ordini</p>
    </nav>
    <main>

        <section id="ordiniOdierni" class="containerPlatesViewer">
            <h2 tabindex="20">
                <?php echo $_SESSION['name'] . ' '; ?> questi sono i piatti che hai ordinato oggi
            </h2>
            <!-- Inserisci qui il tuo menu sushi -->
            <?php
            require_once '../DAO/OrdineDAO.php';

            $ordineDAO = new OrdineDAO();
            $tabIndex_offset = 20;
            $piatti = OrdineDAO::getOrdineByPrenotazione($_SESSION['username'], $_SESSION['data_prenotazione_inCorso']);
            if (!empty($piatti)) {
                echo "<ul>";
                foreach ($piatti as $piatto) {
                    $tabIndex_offset = $tabIndex_offset + 1;
                    $refactorNomePiatto = str_replace(' ', '_', strtolower($piatto['NomePiatto']));
                    $ariaLabel = 'Piatto: ' . $piatto['NomePiatto'] . ', Descrizione: ' . $piatto['Descrizione'];

                    echo '<li class="menuItem oldOrders" tabindex="' . (10 + $tabIndex_offset) . '" aria-label="' . $ariaLabel . '">';
                    echo '<div class="imageMenuItem ' . $refactorNomePiatto . '"></div>';
                    echo '<div class="infoItem">';
                    echo '<dl><dt class="nomePiatto" data-title="Nome Piatto">' . $piatto['NomePiatto'] . '</dt>';
                    echo '<dd class="ingradienti" data-title="Descrizione ingradienti">' . $piatto['Descrizione'] . '</dd>';
                    echo '<dd  data-title="Quantità">Quantità: <p class="bold inline">' . $piatto['Quantita'] . '</p></dd>';
                    echo '<dd data-title="Consegnato">Consegnato: <p class="bold inline">' . (($piatto['isConsegnato'] == true) ? "Si" : "No") . '</p></dd></dl>';
                    echo '</div>';
                    echo '</li>';
                }
                echo "</ul>";
            } else {
                echo "Devi ancora effettuare ordinazioni oggi " . $_SESSION['name'] . '.';
            }
            ?>
        </section>

        <!--QUI CREO UNA SEZIONE PER OGNI VECCHIA PRENOTAZIONE CON DENTRO TUTTI I PASTI DI QUELLA PRENOTAZIONE-->
        <?php
        require_once '../DAO/PrenotazioneDAO.php';
        $prenotazioneDAO = new PrenotazioneDAO();
        $tabIndex_offset = 20;
        $prenotazioniPassate = PrenotazioneDAO::getOldPrenotazioniByUsername($_SESSION['username'], $_SESSION['data_prenotazione_inCorso']);


        if (!empty($prenotazioniPassate)) {
            foreach ($prenotazioniPassate as $prenotazione) {
                $ordini = OrdineDAO::getOrdineByPrenotazione($_SESSION['username'], $prenotazione["DataPrenotazione"]);
                if (!empty($ordini)) {
                    echo '<section class="containerPlatesViewer"> <h3>     Questi sono i piatti che hai ordinato in data ' . $prenotazione["DataPrenotazione"] . '</h3>';
                    echo "<ul>";
                    foreach ($ordini as $piatto) {
                        $tabIndex_offset = $tabIndex_offset + 1;
                        $refactorNomePiatto = str_replace(' ', '_', strtolower($piatto['NomePiatto']));
                        $ariaLabel = 'Piatto: ' . $piatto['NomePiatto'] . ', Descrizione: ' . $piatto['Descrizione'];

                        echo '<li class="menuItem oldOrders" tabindex="' . (10 + $tabIndex_offset) . '" aria-label="' . $ariaLabel . '">';
                        echo '<div class="imageMenuItem ' . $refactorNomePiatto . '"></div>';
                        echo '<div class="infoItem">';
                        echo '<dl><dt class="nomePiatto" data-title="Nome Piatto">' . $piatto['NomePiatto'] . '</dt>';
                        echo '<dd class="ingradienti" data-title="Descrizione ingradienti">' . $piatto['Descrizione'] . '</dd>';
                        echo '<dd class="quantitaOrdine" data-title="Quantità">Quantità: <p class="bold inline">' . $piatto['Quantita'] . '</p></dd></dl>';
                        echo '</div>';
                        echo '</li>';
                    }
                    echo "</ul></section>";
                }

            }
        }
        ?>
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