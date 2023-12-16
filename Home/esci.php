<?php
session_destroy();
require_once "Utility/utilities.php";

$template = getTemplate('Layouts/main.html');
$logoutSectionhtml = getTemplate('Layouts/chiSiamo.html'); // Crea il tuo template HTML per la pagina di logout

$pageID = 'logoutBody';
$title = '<span lang="en">Esci</span><p> - Sushi Brombeis</p>';
$breadcrumbs = '<p>Ti trovi in:  Area Utente >> <span lang="en">Esci</span></p>';

$content = $logoutSectionhtml;

$menu = get_menu_NoLogin(); // Assicurati di aggiornare il menu per riflettere lo stato di logout
$template = str_replace('{{menu}}', $menu, $template);

echo replace_in_page($template, $title, $pageID, $breadcrumbs, 'Sushi Brombeis, Ristorante sushi via brombeis', 'Sito ufficiale del ristorante di sushi a Napoli in via brombeis.', $content, '');

?>
