<?php
try {
    require_once "Utility/utilities.php";
} catch (Throwable $th) {
    header('Location: 500.html');
    exit();
}

//TEMPLATE comune
$templatePath = 'Layouts/main.html';
if (!file_exists($templatePath)) {
    header('Location: 500.html');
    exit();
}
$template = file_get_contents($templatePath);
if ($template === false) {
    header('Location: 500.html');
    exit();
}
$pageID = '404ID';
$title = "Error 404 - Sushi Brombeis";
$breadcrumbs = '<p>Ti trovi in: Un luogo in cui non dovresti trovarti</p> ';

//HTML statico dell'error 404
$html404 = 'Layouts/404Section.html';
if (!file_exists($html404)) {
    header('Location: 500.html');
    exit();
}
$templatePres = file_get_contents($html404);
if ($templatePres === false) {
    header('Location: 500.html');
    exit();
}

$content = '';

$content .= $templatePres;

session_start();
if (isset($_SESSION["username"])) {
    $template = str_replace('{{BottomMenu}}', str_replace('{{ListMenuBottom}}', get_bottom_menu_Login(), getTemplate('Layouts/bottomMenu.html')), $template);
    $menu = get_menu_Login();
} else {
    $menu = get_menu_NoLogin();
    $template = str_replace('{{BottomMenu}}', "", $template);
}
$template = str_replace('{{menu}}', $menu, $template);


echo render_page($template, $title, $pageID, $breadcrumbs, 'Errore 404 Sushi Brombeis, Errore 404 ristorante sushi via brombeis', 'Pagina relativa all\'errore 404 del ristorante di sushi a Napoli in via brombeis.', $content, '');
?>