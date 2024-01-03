<?php
try {
    require_once "Utility/utilities.php";
    $template = getTemplate('Layouts/main.html');
} catch (Throwable $th) {
    header('Location: 500.html');
    exit(0);
}

$pageID = 'homeID';
$title = "Home - Sushi Brombeis";
$breadcrumbs = '<p>Ti trovi in: <span lang="en" aria-current="page">Home</span></p> ';

//Sezione di presentazione del ristorante
try {
    $templatePres = getTemplate('Layouts/presentationSection.html');
} catch (Throwable $th) {
    $templatePres = get_error_msg();
}

$content = '';
$content .= $templatePres;


echo render_page($template, $title, $pageID, $breadcrumbs, 'Sushi Brombeis, Ristorante sushi via brombeis', 'Sito ufficiale del ristorante di sushi a Napoli in via brombeis.', $content, '');
?>