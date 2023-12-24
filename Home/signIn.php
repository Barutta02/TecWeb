<?php

require_once "Utility/utilities.php";


$template = getTemplate('Layouts/main.html');
$signInSectionhtml = getTemplate('Layouts/signInSection.html');


$pageID = 'signInBody';
$title = "SignIn - Sushi Brombeis";
$breadcrumbs = '<p>Ti trovi in:  <a href="index.php"><span lang="en">Home</span></a>  >> <span lang="en">SignIn</span></p> ';



$content = $signInSectionhtml;

session_start();
if (isset($_SESSION["username"])) {
    $template = str_replace('{{BottomMenu}}', str_replace('{{ListMenuBottom}}', get_bottom_menu_Login(), getTemplate('Layouts/bottomMenu.html')), $template);
    $menu = get_menu_Login();

} else {
    $menu = get_menu_NoLogin();
    $template = str_replace('{{BottomMenu}}', "", $template);
}
$template = str_replace('{{menu}}', $menu, $template);

echo replace_in_page($template, $title, $pageID, $breadcrumbs, 'Registrazione per ordinare Sushi Brombeis, Ristorante sushi via brombeis', 'Sito ufficiale del ristorante di sushi a Napoli in via brombeis.', $content, '');
?>