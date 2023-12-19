<?php

require_once 'ViewsUtility.php';

define("ROOT_FOLDER", "/TecWeb/Home/");


/*
    Rimpiazza i placeholder del template html del sito
*/
function replace_in_page($html, $title, $id, $breadcrumbs, $keywords, $description, $content, $onload)
{
    //Header presente in ogni pagina
    $header = file_get_contents('Layouts/header.html');

    $footer = file_get_contents('Layouts/footer.html');

    $html = str_replace('{{onload}}', $onload, $html);

    $html = str_replace('{{header}}', $header, $html);

    $html = str_replace('{{title}}', $title, $html);
    $html = str_replace('{{keywords}}', $keywords, $html);
    $html = str_replace('{{description}}', $description, $html);
    $html = str_replace('{{pageID}}', $id, $html);
    $html = str_replace('{{breadcrumbs}}', $breadcrumbs, $html);
    $html = str_replace('{{content}}', $content, $html);

    //Footer presente in ogni pagina
    $html = str_replace('{{footer}}', $footer, $html);

    return $html;
}

function getTemplate($templatePath)
{
    if (!file_exists($templatePath)) {
        die("Template file not found: $templatePath");
    }
    $template = file_get_contents($templatePath);
    if ($template === false) {
        die("Failed to load template file: $templatePath");
    }
    return $template;

}


/*
    Rimpiazza i placeholder del template html dell'area utente
    Senza keywords e descrizione
*/
function replace_in_user_page(string $html, string $title, string $id, string $breadcrumbs, string $content, string $onload)
{

    //Header presente in ogni pagina
    $header = file_get_contents('../layouts/header.html');
    $html = str_replace('{{onload}}', $onload, $html);
    $html = str_replace('{{header}}', $header, $html);
    $html = str_replace('{{title}}', $title, $html);
    $html = str_replace('{{pageID}}', $id, $html);
    $html = str_replace('{{breadcrumbs}}', $breadcrumbs, $html);
    $html = str_replace('{{content}}', $content, $html);

    //Footer presente in ogni pagina
    $footer = file_get_contents('../layouts/footer.html');
    $footer = str_replace("privacy.html", "../privacy.html", $footer);
    $html = str_replace('{{footer}}', $footer, $html);

    return $html;
}

/*
    Rimpiazza i codici per la lingua con tag span
    [en]...[/en]
*/
function parse_lang(string $string, bool $delete)
{

    if ($delete) {
        $replaceStart = '';
        $replaceEnd = '';
    } else {
        $replaceStart = '<span lang="${2}">';
        $replaceEnd = '</span>';
    }

    //Rimpiazza i tag di fine con </span>
    $string = preg_replace('/\[\/.{2}\]/', $replaceEnd, $string);

    //Rimpiazza i tag di inizio con <span lang="xx">
    $string = preg_replace('/(\[)([a-z]{2})(\])/', $replaceStart, $string);

    return $string;

}

/*
    Rimpiazza i codici per l'abbreviazione con tag span
    _cm|centrimetri_
*/
function parse_abbr(string $string, bool $delete)
{

    if ($delete) {
        $replace = '';
    } else {
        $replace = '<abbr title="${2}">${1}</abbr>';
    }

    return preg_replace('/_(.*?)\|(.*?)_/', $replace, $string);
}


/* 
    Rimpiazza {{menu}} con il menú in base alla pagina in cui si trova l'utente
*/

function get_bottom_menu_Login()
{

    $menu = '';

    // Link da inserire
    $links = ["VisualizzaOrdini.php", "Prenota.php", "NuovaPrenotazione.php"];
    // Nomi delle voci di menu
    $names = ["Ordini", "Prenota", "Tavolo"];
    // Lingue dei link (se diverse da Italiano)
    $langs = ["", "", ""];
    // Numero dei link da mostrare (grandezza array)
    $nLinks = count($links);

    //Togliere dall'url restituito da PHP -- cambierà in base all'hosting
    $strToRemove = ROOT_FOLDER;
    $currentPage = str_replace($strToRemove, "", $_SERVER['REQUEST_URI']);

    for ($i = 0; $i < $nLinks; $i++) {
        if ($currentPage == $links[$i] || ($currentPage == '' && $links[$i] == 'index.php')) {
            $menu .= '<li id="currentLink" ' . (($langs[$i]) ? 'lang="' . $langs[$i] . '"' : '') . '><i class="ListIcon ' . str_replace(" ", "", $names[$i]) . '""></i><p>' . $names[$i] . '</p></li>';
        } else {
            $menu .= '<li><a href="' . $links[$i] . '" ' . (($langs[$i]) ? 'lang="' . $langs[$i] . '"' : '') . '><i class="ListIcon ' . str_replace(" ", "", $names[$i]) . '""></i><p>' . $names[$i] . '</p></a></li>';
        }
    }
    return $menu;
}
function get_menu_Login()
{

    $menu = '';

    // Link da inserire
    $links = ["index.php", "menuPranzo.php", "menuCena.php", "chiSiamo.php", "contattaci.php", "VisualizzaOrdini.php", "Prenota.php", "NuovaPrenotazione.php"];
    // Nomi delle voci di menu
    $names = ["Home", "Menu pranzo", "Menu cena", "Chi Siamo", "Contatti", "Ordini", "Prenota", "Tavolo"];
    // Lingue dei link (se diverse da Italiano)
    $langs = ["en", "", "", "", "", "", "", ""];
    // Numero dei link da mostrare (grandezza array)
    $nLinks = count($links);

    //Togliere dall'url restituito da PHP -- cambierà in base all'hosting 
    $strToRemove = ROOT_FOLDER;
    $currentPage = str_replace($strToRemove, "", $_SERVER['REQUEST_URI']);

    for ($i = 0; $i < $nLinks; $i++) {
        if ($currentPage == $links[$i] || ($currentPage == '' && $links[$i] == 'index.php')) {
            $menu .= '<li ';
            if ($names[$i] == "Ordini" || $names[$i] == "Prenota" || $names[$i] == "Tavolo") {
                $menu .= 'class="bigScreenOnly"';
            }
            $menu .= 'id="currentLink" ' . (($langs[$i]) ? 'lang="' . $langs[$i] . '"' : '') . '>' . $names[$i] . '</li>';
        } else {
            $menu .= '<li ';
            if ($names[$i] == "Ordini" || $names[$i] == "Prenota" || $names[$i] == "Tavolo") {
                $menu .= 'class="bigScreenOnly"';
            }
            $menu .= '><a href="' . $links[$i] . '" ' . (($langs[$i]) ? 'lang="' . $langs[$i] . '"' : '') . '>' . $names[$i] . '</a></li>';
        }
    }
    #$menu .= '<li><a class="button userAreaLink" href="login.php" >Area Utente</a></li>';
    $menu .= '<li><a class="button userAreaLink" href="esci.php" >Esci</a></li>';

    return $menu;
}


function get_menu_NoLogin()
{

    $menu = '';

    // Link da inserire
    $links = ["index.php", "menuPranzo.php", "menuCena.php", "chiSiamo.php", " #", "login.php"];
    // Nomi delle voci di menu
    $names = ["Home", "Menu pranzo", "Menu cena", "Chi Siamo", "Contatti", "Area utente"];
    // Lingue dei link (se diverse da Italiano)
    $langs = ["", "", "", "", "", ""];
    // Numero dei link da mostrare (grandezza array)
    $nLinks = count($links);

    //Togliere dall'url restituito da PHP -- cambierà in base all'hosting 
    $strToRemove = ROOT_FOLDER;
    $currentPage = str_replace($strToRemove, "", $_SERVER['REQUEST_URI']);

    for ($i = 0; $i < $nLinks; $i++) {
        if ($currentPage == $links[$i] || ($currentPage == '' && $links[$i] == 'index.php')) {
            $menu .= '<li id="currentLink" ' . (($langs[$i]) ? 'lang="' . $langs[$i] . '"' : '') . '>' . $names[$i] . '</li>';
        } else {
            $menu .= '<li><a href="' . $links[$i] . '" ' . (($langs[$i]) ? 'lang="' . $langs[$i] . '"' : '') . '>' . $names[$i] . '</a></li>';
        }
    }
    return $menu;
}

function get_menu_Admin()
{
    $menu = '';

    // Link da inserire
    $links = ["index.php", "menuPranzo.php", "menuCena.php", "chiSiamo.php", "contattaci.php", "AdminPanel.php", "freeTable.php"];
    // Nomi delle voci di menu
    $names = ["Home", "Menu pranzo", "Menu cena", "Chi Siamo", "Contatti", "Pannello amministratore", "Gestione Prenotazioni"];
    // Lingue dei link (se diverse da Italiano)
    $langs = ["", "", "", "", "", "", ""];
    // Numero dei link da mostrare (grandezza array)
    $nLinks = count($links);

    //Togliere dall'url restituito da PHP -- cambierà in base all'hosting 
    $strToRemove = ROOT_FOLDER;
    $currentPage = str_replace($strToRemove, "", $_SERVER['REQUEST_URI']);

    for ($i = 0; $i < $nLinks; $i++) {
        if ($currentPage == $links[$i] || ($currentPage == '' && $links[$i] == 'index.php')) {
            $menu .= '<li id="currentLink" ' . (($langs[$i]) ? 'lang="' . $langs[$i] . '"' : '') . '>' . $names[$i] . '</li>';
        } else {
            $menu .= '<li><a href="' . $links[$i] . '" ' . (($langs[$i]) ? 'lang="' . $langs[$i] . '"' : '') . '>' . $names[$i] . '</a></li>';
        }
    }
    $menu .= '<li><a class="button userAreaLink" href="esci.php" >Esci</a></li>';

    return $menu;
}



?>