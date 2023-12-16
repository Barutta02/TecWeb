<?php

require_once "Utility/utilities.php";

$template = getTemplate('Layouts/main.html');
$loginSectionhtml = getTemplate('Layouts/loginSection.html');


$pageID = 'loginBody';
$title = "Login - Sushi Brombeis";
$breadcrumbs = '<p>Ti trovi in:  Area Utente >> <span lang="en">Login</span></p> ';




$content = $loginSectionhtml;

$menu = get_menu_NoLogin();
$template = str_replace('{{menu}}', $menu, $template);

if (isset($_SESSION["username"])) {
    $template = str_replace('{{BottomMenu}}', str_replace('{{ListMenuBottom}}', get_bottom_menu_Login(), getTemplate('Layouts/bottomMenu.html')), $template);
} else {
    $template = str_replace('{{BottomMenu}}', "", $template);
}


echo replace_in_page($template, $title, $pageID, $breadcrumbs, 'Sushi Brombeis, Ristorante sushi via brombeis', 'Sito ufficiale del ristorante di sushi a Napoli in via brombeis.', $content, '');
?>