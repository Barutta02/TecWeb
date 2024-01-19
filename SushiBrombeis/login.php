<?php
try {
    require_once "Utility/utilities.php";

    $template = getTemplate('Layouts/main.html');
} catch (Throwable $th) {
    header('Location: 500.html');
    exit(0);
}


try {
    $loginSectionhtml = getTemplate('Layouts/loginSection.html');
} catch (Throwable $th) {
    $loginSectionhtml = get_error_msg();
}

$pageID = 'loginBody';
$title = 'Login - Sushi Brombeis';
$breadcrumbs = '<p>Ti trovi in:  <a href="index.php"><span lang="en">Home</span></a>  &gt;&gt; <span lang="en">Login</span></p> ';

$content = $loginSectionhtml;
$errorList = array();

if (isset($_GET['MessageCode'])) {
    switch ($_GET['MessageCode']) {
        case 1:
            array_push($errorList, "<p class='warning'>Utente non trovato</p> ");
            break;
        default:
            array_push($errorList, "<p class='warning'>Errore sconosciuto!</p> ");
    }
}
$content = str_replace('{{error}}', implode(" ", $errorList), $content);

echo render_page($template, $title, $pageID, $breadcrumbs, 'Sushi Brombeis, Ristorante sushi via brombeis', 'Accedi al sito ufficiale del ristorante di sushi a Napoli in via brombeis. Prenota il tuo tavolo e vieni a trovarci!', $content, 'setLoginChecks();addOnBlur();');
?>