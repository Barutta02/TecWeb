<?php
try {
    require_once "Utility/utilities.php";
    
    $template = getTemplate('Layouts/main.html');
} catch (Throwable $th) {
    header('Location: 500.php');
    exit(0);
}


try {
    $loginSectionhtml = getTemplate('Layouts/loginSection.html');
} catch (Throwable $th) {
    $loginSectionhtml = get_error_msg();
}

$pageID = 'loginBody';
$title = 'Login - Sushi Brombeis';
$breadcrumbs = '<p>Ti trovi in:  <a href="index.php"><span lang="en">Home</span></a>  >> <span lang="en">Login</span></p> ';

$content = $loginSectionhtml;
$errorList = array();

if (isset($_GET['Errorcode'])) {
    switch ($_GET['Errorcode']){
        case 1: 
            array_push($errorList, "<p class='warning'>Utente non trovato</p> ");
            break;
        default:
            array_push($errorList, "<p class='warning'>Errore sconosciuto!</p> ");
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


echo replace_in_page($template, $title, $pageID, $breadcrumbs, 'Sushi Brombeis, Ristorante sushi via brombeis', 'Sito ufficiale del ristorante di sushi a Napoli in via brombeis.', $content, 'setLoginChecks();addOnBlur();');
?>