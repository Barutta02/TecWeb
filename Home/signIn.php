<?php

require_once "Utility/utilities.php";

$templatePath = 'Layouts/main.html';
$signInSection = 'Layouts/signInSection.html';
if (!file_exists($templatePath)) {
  die("Template file not found: $templatePath");
}
$template = file_get_contents($templatePath);
if ($template === false) {
  die("Failed to load template file: $templatePath");
}

$pageID = 'signInBody';
$title = "SignIn - Sushi Brombeis";
$breadcrumbs = '<p>Ti trovi in:  Area Utente >> <span lang="en">SignIn</span></p> ';

$signInSectionhtml = file_get_contents($signInSection);
if ($signInSectionhtml === false) {
  die("Failed to load template file: $signInSection");
}

$content = $signInSectionhtml;

$menu = '';
$template = str_replace('{{menu}}', $menu, $template);


echo replace_in_page($template, $title, $pageID, $breadcrumbs, 'Sushi Brombeis, Ristorante sushi via brombeis', 'Sito ufficiale del ristorante di sushi a Napoli in via brombeis.', $content, 'ciaoo');
?>