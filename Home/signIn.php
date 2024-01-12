<?php
try {
    require_once "Utility/utilities.php";
} catch (Throwable $th) {
    header('Location: 500.html');
    exit(0);
}

try {
    $template = getTemplate('Layouts/main.html');
    $signInSectionhtml = getTemplate('Layouts/signInSection.html');
} catch (Throwable $th) {
    header('Location: 500.html');
    exit(0);
}

$pageID = 'signInBody';
$title = "SignIn - Sushi Brombeis";
$breadcrumbs = '<p>Ti trovi in:  <a href="index.php"><span lang="en">Home</span></a>  >> <span lang="en">SignIn</span></p> ';
$content = $signInSectionhtml;



echo render_page($template, $title, $pageID, $breadcrumbs, 'Registrazione per ordinare Sushi Brombeis, Ristorante sushi via brombeis', 'Accedi al sito ufficiale del miglior ristorante di sushi a Napoli in via Brombeis e poi vieni a trovarci!', $content, 'setSignInChecks();addOnBlur();');
?>