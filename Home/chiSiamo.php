<?php
try {
    require_once "Utility/utilities.php";

    $template = getTemplate('Layouts/main.html');
} catch (Throwable $th) {
    header('Location: 500.html');
    exit(0);
}

$pageID = 'chiSiamoID';
$title = "Chi siamo - Sushi Brombeis";
$breadcrumbs = '<p>Ti trovi in: <a href="index.php"><span lang="en">Home</span></a> >> Chi siamo</p> ';


//Sezione di presentazione del ristorante
try {
    $templatePres = getTemplate('Layouts/chiSiamo.html');
} catch (Throwable $th) {
    $templatePres = get_error_msg();
}

$content = '';
$content .= $templatePres;


echo render_page($template, $title, $pageID, $breadcrumbs, 'Siamo Sushi Brombeis, Ristorante sushi via brombeis, sushi chef', 'Sito ufficiale del ristorante di sushi a Napoli in via brombeis.', $content, '');
?>