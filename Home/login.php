<?php

require_once "Utility/utilities.php";

$template = getTemplate('Layouts/main.html');
$loginSectionhtml = getTemplate('Layouts/loginSection.html');


$pageID = 'loginBody';
$title = 'Login - Sushi Brombeis';
$breadcrumbs = '<p>Ti trovi in:  <a href="index.php"><span lang="en">Home</span></a>  >> <span lang="en">Login</span></p> ';





$content = $loginSectionhtml;
$errorList = array();

if (isset($_GET['Errorcode'])) {
    // Recupera il valore del parametro errorCode
    if ($_GET['Errorcode'] == "1") {
        array_push($errorList, "<p class='warning'>Utente non trovato</p> ");
    }
}
$content = str_replace('{{error}}', implode(" ", $errorList), $content);


session_start();
if (isset($_SESSION["username"])) {
    $template = str_replace('{{BottomMenu}}', str_replace('{{ListMenuBottom}}', get_bottom_menu_Login(), getTemplate('Layouts/bottomMenu.html')), $template);
    $menu = get_menu_Login();

} else {
    $menu = get_menu_NoLogin();
    $template = str_replace('{{BottomMenu}}', "", $template);
}
$template = str_replace('{{menu}}', $menu, $template);


echo replace_in_page($template, $title, $pageID, $breadcrumbs, 'Sushi Brombeis, Ristorante sushi via brombeis', 'Sito ufficiale del ristorante di sushi a Napoli in via brombeis.', $content, '');
?>