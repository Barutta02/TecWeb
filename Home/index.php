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
$breadcrumbs = '<p tabindex="0">Ti trovi in: <span lang="en" aria-current="page">Home</span></p> ';

//Sezione di presentazione del ristorante
try {
    $templatePres = getTemplate('Layouts/presentationSection.html');
} catch (Throwable $th) {
    $templatePres = get_error_msg();
}

$content = '';
$content .= $templatePres;

session_start();
if (isset($_SESSION["username"])) {
    $template = str_replace('{{BottomMenu}}', str_replace('{{ListMenuBottom}}', get_bottom_menu_Login(), getTemplate('Layouts/bottomMenu.html')), $template);
    $menu = get_menu_Login();
} elseif (isset($_SESSION['adminLogged'])) {
    $menu = get_menu_Admin();
    $template = str_replace('{{BottomMenu}}', "", $template);
} else {
    $menu = get_menu_NoLogin();
    $template = str_replace('{{BottomMenu}}', "", $template);
}
$template = str_replace('{{menu}}', $menu, $template);


echo replace_in_page($template, $title, $pageID, $breadcrumbs, 'Sushi Brombeis, Ristorante sushi via Brombeis, piatti sushi, sushi Napoli', 'Sito ufficiale del ristorante di sushi a Napoli in via brombeis.', $content, '');
?>