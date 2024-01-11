<?php

require_once 'ViewsUtility.php';

define("ROOT_FOLDER", "/TecWeb/Home/");

function render_page($html, $title, $id, $breadcrumbs, $keywords, $description, $content, $onload, )
{
    //Header presente in ogni pagina
    $header = file_get_contents('Layouts/header.html');
    $footer = file_get_contents('Layouts/footer.html');
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if (isset($_SESSION['adminLogged'])) {
        $footer = file_get_contents('Layouts/adminFooter.html');
    }
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

    //navbar Manager
    if (isset($_SESSION["username"])) {
        $menu = get_menu_Login();

    } elseif (isset($_SESSION['adminLogged'])) {
        $menu = get_menu_Admin();
    } else {
        $menu = get_menu_NoLogin();
    }
    $html = str_replace('{{BottomMenu}}', get_bottom_menu_by_session(), $html);
    $html = str_replace('{{menu}}', $menu, $html);

    return $html;
}

function get_bottom_menu_by_session()
{
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    $menu = "";
    if (isset($_SESSION["username"])) { //Se sei loggato come utente allora visualizza la bottom navbar e la navbar specifica per utente registrato
        $menu = str_replace('{{ListMenuBottom}}', get_bottom_menu_Login(), getTemplate('Layouts/bottomMenu.html'));
    }
    return $menu;
}

function getTemplate($templatePath)
{
    if (!file_exists($templatePath)) {
        throw new Throwable("Template file not found: $templatePath");
    }
    $template = file_get_contents($templatePath);
    if ($template === false) {
        throw new Throwable("Failed to load template file: $templatePath");
    }
    return $template;

}



/* 
    Rimpiazza {{menu}} con il menú in base alla pagina in cui si trova l'utente
*/

function get_bottom_menu_Login()
{

    $menu = '';

    // Link da inserire
    $links = ["VisualizzaOrdini.php", "Prenota.php", "prenotazione.php"];
    // Nomi delle voci di menu
    $names = ["I miei Ordini", "Ordina", "Prenota"];
    // Lingue dei link (se diverse da Italiano)
    $langs = ["", "", ""];
    // Numero dei link da mostrare (grandezza array)
    $nLinks = count($links);

    //Togliere dall'url restituito da PHP -- cambierà in base all'hosting
    $strToRemove = ROOT_FOLDER;
    $currentPage = str_replace($strToRemove, "", $_SERVER['REQUEST_URI']);

    for ($i = 0; $i < $nLinks; $i++) {
        if ($currentPage == $links[$i] || ($currentPage == '' && $links[$i] == 'index.php')) {
            $menu .= '<li class="currentLink" ' . (($langs[$i]) ? 'lang="' . $langs[$i] . '"' : '') . '><i class="ListIcon ' . str_replace(" ", "", $names[$i]) . '"></i><p>' . $names[$i] . '</p></li>';
        } else {
            $menu .= '<li><a href="' . $links[$i] . '" ' . (($langs[$i]) ? 'lang="' . $langs[$i] . '"' : '') . '><i class="ListIcon ' . str_replace(" ", "", $names[$i]) . '"></i><p>' . $names[$i] . '</p></a></li>';
        }
    }
    return $menu;
}
function get_menu_Login()
{
    $menu = '';

    // Link da inserire
    $links = ["index.php", "menuPranzo.php", "menuCena.php", "chiSiamo.php", "#footerOrganizer", "VisualizzaOrdini.php", "Prenota.php", "prenotazione.php"];
    // Nomi delle voci di menu
    $names = ["Home", "Menu pranzo", "Menu cena", "Chi Siamo", "Contatti", "I miei Ordini", "Ordina", "Prenota"];
    // Lingue dei link (se diverse da Italiano)
    $langs = ["en", "", "", "", "", "", "", ""];
    // Numero dei link da mostrare (grandezza array)
    $nLinks = count($links);

    //Togliere dall'url restituito da PHP -- cambierà in base all'hosting
    $currentPage = str_replace(ROOT_FOLDER, "", $_SERVER['REQUEST_URI']);
    $fileName = basename(parse_url($currentPage, PHP_URL_PATH));

    for ($i = 0; $i < $nLinks; $i++) {
        if ($fileName == $links[$i] || ($currentPage == '' && $links[$i] == 'index.php')) {
            $menu .= '<li class="currentLink ';
            if ($names[$i] == "I miei Ordini" || $names[$i] == "Ordina" || $names[$i] == "Prenota") {
                $menu .= 'bigScreenOnly';
            }
            $menu .= '" ' . (($langs[$i]) ? 'lang="' . $langs[$i] . '"' : '') . '> <p>' . $names[$i] . '</p></li>';
        } else {
            $menu .= '<li ';
            if ($names[$i] == "I miei Ordini" || $names[$i] == "Ordina" || $names[$i] == "Prenota") {
                $menu .= 'class="bigScreenOnly" ';
            }
            $menu .= '><a href="' . $links[$i] . '" ' . (($langs[$i]) ? 'lang="' . $langs[$i] . '"' : '') . '>' . $names[$i] . '</a></li>';
        }
    }
    #$menu .= '<li><a class="button userAreaLink" href="login.php" >Area Utente</a></li>';
    $menu .= '<li><a class="userAreaLink" href="esci.php">Esci</a></li>';

    return $menu;
}

function get_menu_NoLogin()
{

    $menu = '';

    // Link da inserire
    $links = ["index.php", "menuPranzo.php", "menuCena.php", "chiSiamo.php", "#footerOrganizer", "login.php"];
    // Nomi delle voci di menu
    $names = ["Home", "Menu pranzo", "Menu cena", "Chi Siamo", "Contatti", "Area utente"];
    // Lingue dei link (se diverse da Italiano)
    $langs = ["en", "", "", "", "", ""];
    // Numero dei link da mostrare (grandezza array)
    $nLinks = count($links);

    //Togliere dall'url restituito da PHP -- cambierà in base all'hosting
    $currentPage = str_replace(ROOT_FOLDER, "", $_SERVER['REQUEST_URI']);
    $fileName = basename(parse_url($currentPage, PHP_URL_PATH));

    for ($i = 0; $i < $nLinks; $i++) {
        if ($fileName == $links[$i] || ($currentPage == '' && $links[$i] == 'index.php')) {
            $menu .= '<li class="currentLink" ' . (($langs[$i]) ? ' lang="' . $langs[$i] . '"' : '') . '><p>' . $names[$i] . '</p></li>';
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
    $links = ["adminPanel.php", "freeTable.php"];
    // Nomi delle voci di menu
    $names = ["Pannello amministratore", "Gestione Prenotazioni"];
    // Lingue dei link (se diverse da Italiano)
    $langs = ["", ""];
    // Numero dei link da mostrare (grandezza array)
    $nLinks = count($links);

    //Togliere dall'url restituito da PHP -- cambierà in base all'hosting

    $currentPage = str_replace(ROOT_FOLDER, "", $_SERVER['REQUEST_URI']);
    $fileName = basename(parse_url($currentPage, PHP_URL_PATH));

    for ($i = 0; $i < $nLinks; $i++) {
        if ($fileName == $links[$i] || ($currentPage == '' && $links[$i] == 'index.php')) {
            $menu .= '<li class="currentLink" ' . (($langs[$i]) ? 'lang="' . $langs[$i] . '"' : '') . '><p>' . $names[$i] . '</p></li>';
        } else {
            $menu .= '<li><a href="' . $links[$i] . '" ' . (($langs[$i]) ? 'lang="' . $langs[$i] . '"' : '') . '>' . $names[$i] . '</a></li>';
        }
    }
    $menu .= '<li><a class="userAreaLink" href="esci.php" >Esci</a></li>';

    return $menu;
}

function get_menu_ext_Admin()
{
    $menu = '';

    // Link da inserire
    $links = ["index.php", "menuPranzo.php", "menuCena.php", "chiSiamo.php", "#footerOrganizer", "adminPanel.php"];
    // Nomi delle voci di menu
    $names = ["Home", "Menu pranzo", "Menu cena", "Chi Siamo", "Contatti", "Pannello amministratore"];
    // Lingue dei link (se diverse da Italiano)
    $langs = ["en", "", "", "", "", ""];
    // Numero dei link da mostrare (grandezza array)
    $nLinks = count($links);

    //Togliere dall'url restituito da PHP -- cambierà in base all'hosting
    $currentPage = str_replace(ROOT_FOLDER, "", $_SERVER['REQUEST_URI']);
    $fileName = basename(parse_url($currentPage, PHP_URL_PATH));

    for ($i = 0; $i < $nLinks; $i++) {
        if ($fileName == $links[$i] || ($currentPage == '' && $links[$i] == 'index.php')) {
            $menu .= '<li class="currentLink ';
            if ($names[$i] == "Ordini" || $names[$i] == "Ordina" || $names[$i] == "Tavolo") {
                $menu .= 'bigScreenOnly';
            }
            $menu .= '"' . (($langs[$i]) ? 'lang="' . $langs[$i] . '"' : '') . '> <p>' . $names[$i] . '</p></li>';
        } else {
            $menu .= '<li ';
            if ($names[$i] == "Ordini" || $names[$i] == "Ordina" || $names[$i] == "Tavolo") {
                $menu .= 'class="bigScreenOnly" ';
            }
            $menu .= '><a href="' . $links[$i] . '" ' . (($langs[$i]) ? 'lang="' . $langs[$i] . '"' : '') . '>' . $names[$i] . '</a></li>';
        }
    }
    #$menu .= '<li><a class="button userAreaLink" href="login.php" >Area Utente</a></li>';
    $menu .= '<li><a class="userAreaLink" href="esci.php" >Esci</a></li>';

    return $menu;
}

function sanitize_txt($txt, $keep_htlm_tags = false)
{
    $txt = trim($txt);
    if($keep_htlm_tags) {
        $txt = htmlentities($txt);
    } else {
        $txt = strip_tags($txt);
    }
    return $txt;
}

function check_password_format($password) {

    return
        strlen($password) >=5 &&
        preg_match('/[A-Z]/', $password) &&
        preg_match('/[a-z]/', $password) &&
        preg_match('/\d/', $password) &&
        preg_match('/[!@#$%^&*()_+]/', $password);
}

function check_username_format($username) {
    return
        strlen(trim($username)) > 0 && preg_match('/\w{2,}/', $username);

}

function check_firstname_or_lastname_format($firstname_or_lastname) {
    return
        strlen(trim($firstname_or_lastname)) > 0 &&
        preg_match('/^[^\d]+$/ ', $firstname_or_lastname);
}

function check_email_format($email) {
    return
        strlen(trim($email)) >= 2 &&
        preg_match('/^([\w\-\+\.]+)\@([\w\-\+\.]+)\.([\w\-\+\.]+)$/', $email);
}

function check_admin_privileges($username_or_email, $password)
{
    $user = UserDao::getUserByEmailPassword(sanitize_txt($username_or_email), sanitize_txt($password));
    $user = !empty($user) ? $user : UserDao::getUserByUsernamePassword(sanitize_txt($username_or_email), sanitize_txt($password));


    if (!empty($user) && isset($user['privilegi']) && $user['privilegi'] == 'Admin') {
        return true;
    }
    return false;
}

?>