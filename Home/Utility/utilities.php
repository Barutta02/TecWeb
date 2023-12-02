<?php


define("ROOT_FOLDER", "/Home/");


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
function get_menu_NoLogin()
{

    $menu = '';

    // Link da inserire
    $links = ["index.php", "menuPranzo.php", "menuCena.php", "chiSiamo.php", "contattaci.php"];
    // Nomi delle voci di menu
    $names = ["Home", "Menu pranzo", "Menu cena", "Chi Siamo", "Contatti"];
    // Lingue dei link (se diverse da Italiano)
    $langs = ["en", "", "", "", ""];
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
    $menu .= '<li><a class="button userAreaLink" href="login.php" >Area Utente</a></li>';
    return $menu;
}

function get_menu_Login()
{

    $menu = '';

    // Link da inserire
    $links = ["Prenota.php", "VisualizzaOrdini.php","NuovaPrenotazione.php"];
    // Nomi delle voci di menu
    $names = ["Prenota", "Visualizza ordini","Gestisci prenotazione"];
    // Lingue dei link (se diverse da Italiano)
    $langs = ["", "",""];
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
    $links = ["AdminPanel.php", "#" ];
    // Nomi delle voci di menu
    $names = ["Pannello amministratore", "Tavoli occupati"];
    // Lingue dei link (se diverse da Italiano)
    $langs = ["", ""];
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
/*
    Restituisce il blocco nella productRow usato in Home, Categorie e Categoria
    $category indica se si trova nella pagina categoria o no
*/
function get_product_tile($product, $category)
{

    $content = '<article> 
        <header>
            <img src="' . getThumbnail($product['immagine']) . '" alt="">';
    if (!$category)
        $content .= '<h3>' . parse_lang($product['nome']) . '</h3>';
    else
        $content .= '<h2>' . parse_lang($product['nome']) . '</h2>';
    $content .= '</header>
        <p>' . get_short_product_text($product['descrizione']) . '</p>
        <a href="prodotto.php?id=' . $product['id'] . '"  class="button" title="Vedi prodotto ' . parse_lang($product['nome'], true) . '">Scopri di più</a>
    </article>';

    return $content;

}

/*
    Restituisce il testo usato nel blocco prodotto in productRow 
*/
function get_short_product_text($text)
{

    $limit = 150;

    if (strlen($text) < $limit)
        return parse_lang($text);
    else {

        //Sottostringa fino a $limit o spazio 
        $spacePos = strpos($text, ' ', $limit);
        if ($spacePos)
            $shortText = substr($text, 0, $spacePos);
        else
            $shortText = substr($text, 0, $limit);

        $openMatches = [];

        $openLang = preg_match_all('/(\[)([a-z]{2})(\])/', $shortText, $openMatches);
        $closedLang = preg_match_all('/\[\/.{2}\]/', $shortText);

        if ($openLang != $closedLang) {

            $fullMatches = $openMatches[0];
            $lastMatch = count($fullMatches);

            return parse_lang($shortText . str_replace("[", "[/", $fullMatches[$lastMatch - 1])) . '...';
        } else {
            return parse_lang($shortText) . '...';
        }

    }


}

/*
    Pulisce la stringa per l'iunserimento in database rimuovendo tag indesiderati, 
    spazi superflui e limitando il rischio di attacchi
    Se permetto dei tag non devo inibirli con htmlentities
*/
function sanitize($input, $allowed_tags)
{
    $input = strip_tags($input, $allowed_tags);
    if (!$allowed_tags)
        $input = htmlentities($input, ENT_QUOTES, 'UTF-8');
    $input = stripslashes($input);
    $input = trim($input);
    return $input;
}

/*
    Ritorna il path per il thumbanail
*/
function getThumbnail($file)
{
    $fileType = strtolower(pathinfo($file, PATHINFO_EXTENSION));
    return str_replace("." . $fileType, "", $file) . '-thumb.' . $fileType;
}

function getDBConnectionError(bool $back)
{
    return '<p class="error">I sistemi sono momentaneamente fuori servizio. Ci scusiamo per il disagio.
    Torna alla <a href="' . ($back ? '../' : '') . 'index.php">Home</a> o riprova più tardi.
    Se il problema persiste contatta l\'amministratore.</p>
        <img class="error_image" alt="" src="' . ($back ? '../' : '') . 'images/comic_error.png">';
}

// -----------------------------------
// Funzioni per l'area amministrativa
// -----------------------------------


/* 
    Rimpiazza {{menu}} con il menú amministratore in base alla pagina in cui si trova l'amministratore
*/
function get_admin_menu()
{

    $menu = '<ul>';

    // Link da inserire
    $links = ["index.php", "categorie.php", "marche.php", "utenti.php", "recensioni.php", "faqs.php"];
    // Nomi delle voci di menu
    $names = ["Prodotti", "Categorie", "Marche", "Utenti", "Recensioni", "FAQ"];
    // Lingue dei link (se diverse da Italiano)
    $langs = ["", "", "", "", "", "en"];
    // Numero dei link da mostrare (grandezza array)
    $nLinks = count($links);

    //Togliere dall'url restituito da PHP -- cambierà in base all'hosting 
    $strToRemove = ROOT_FOLDER . "admin/";
    $currentPage = str_replace($strToRemove, "", $_SERVER['REQUEST_URI']);

    for ($i = 0; $i < $nLinks; $i++) {
        if ($currentPage == $links[$i] || ($currentPage == '' && $links[$i] == 'index.php')) {
            $menu .= '<li id="currentLink" ' . (($langs[$i]) ? 'lang="' . $langs[$i] . '"' : '') . '>' . $names[$i] . '</li>';
        } else {
            $menu .= '<li><a href="' . $links[$i] . '" ' . (($langs[$i]) ? 'lang="' . $langs[$i] . '"' : '') . '>' . $names[$i] . '</a></li>';
        }
    }

    if (isLoggedIn(true)) {
        $menu .= '<li><a href="logout.php" class="button">Esci</a></li>';
    } else {
        $menu = '<ul><li><a href="login.php" class="button">Accedi</a></li>';
    }

    $menu .= '</ul>';

    return $menu;

}

/* 
    Verifica e carica l'immagine
*/
function upload_file($field, $testOnly)
{

    if ($field['name'] == "")
        return false;

    $targetDir = '../uploads/';
    $path = $targetDir . $field['name'];
    $fileType = strtolower(pathinfo($path, PATHINFO_EXTENSION));

    //Accetta solo immagini
    if (!getimagesize($field['tmp_name'])) {
        return false;
    }

    //Aggiungi il timestamp (unico per costruzione) al file se esiste già
    while (file_exists($path)) {
        $name = str_replace("." . pathinfo($field['name'], PATHINFO_EXTENSION), "", $field['name']);
        $name .= time();
        $path = $targetDir . $name . '.' . $fileType;
    }

    //Accetta solo file jp(e)g o png
    if ($fileType != "jpg" && $fileType != "png" && $fileType != "jpeg") {
        return false;
    }

    if (!$testOnly) {
        if (move_uploaded_file($field["tmp_name"], $path)) {

            createThumbnail($path);

            return str_replace('../', '', $path);
        } else {
            return false;
        }
    } else {
        //Non ha ritornato prima, quindi ha passato i test
        return true;
    }

}

/* 
    Crea immagine miniatura dato file caricato
*/
function createThumbnail($file)
{

    $w = 300;
    $h = 300;

    $fileType = strtolower(pathinfo($file, PATHINFO_EXTENSION));

    $newName = str_replace("." . $fileType, "", $file) . '-thumb.' . $fileType;

    list($width, $height) = getimagesize($file);
    $ratio = $width / $height;

    if ($w / $h > $ratio) {
        $newwidth = $h * $ratio;
        $newheight = $h;
    } else {
        $newheight = $w / $ratio;
        $newwidth = $w;
    }

    switch ($fileType) {
        case 'jpg':
        case 'jpeg':
            $image = imagecreatefromjpeg($file);
            break;

        case 'png';
            $image = imagecreatefrompng($file);
            break;
    }

    $imgResized = imagescale($image, $newwidth, $newheight);

    switch ($fileType) {
        case 'jpg':
        case 'jpeg':
            imagejpeg($imgResized, $newName);
            break;

        case 'png';
            imagepng($imgResized, $newName);
            break;
    }

}

/*
    Controlla se l'utente è collegato e se è amministratore
*/
function isLoggedIn(bool $isAdmin)
{

    if (isset($_SESSION['user'])) {

        $connection = new DBAccess();

        if ($connection->open_connection()) {

            $id = $_SESSION['user'];

            $users = $connection->exec_select_query("SELECT id,admin FROM utente WHERE id=$id");

            if (count($users) > 0) {

                $user = $users[0];

                if ($isAdmin) {
                    return $user['admin'] == 1; //ritorna true se esiste ed è admin
                } else {
                    return true; //ritorna true se esiste
                }

            } else {
                return false; //utente non esiste
            }

        } else {
            return false; //non è possibile collegarsi al DB
        }

    } else {
        return false; //nessuna sessione attiva
    }

}

/*
    Mostra errore di mancata autenticazione
*/
function getAdminLoggedOutError()
{
    return '<h1>Area riservata</h1>
    <p class="message errorMsg" role="alert">Attenzione: non disponi dei privilegi necessari per accede a questa pagina.</p>';
}

// -----------------------------------
// Funzioni per l'area utente
// -----------------------------------

/* 
    Rimpiazza {{menu}} con il menú amministratore in base alla pagina in cui si trova l'utente
*/
function get_user_menu()
{

    $menu = '';

    $menu .= '<li><a href="../index.php" class="button">Torna al sito</a></li>';

    // Link da inserire
    $links = ["index.php", "profilo.php"];
    // Nomi delle voci di menu
    $names = ["Recensioni", "Profilo"];
    // Lingue dei link (se diverse da Italiano)
    $langs = ["", ""];
    // Numero dei link da mostrare (grandezza array)
    $nLinks = count($links);

    //Togliere dall'url restituito da PHP -- cambierà in base all'hosting 
    $strToRemove = ROOT_FOLDER . "area-utente/";
    $currentPage = str_replace($strToRemove, '', $_SERVER['REQUEST_URI']);

    if (isLoggedIn()) {
        for ($i = 0; $i < $nLinks; $i++) {
            if ($currentPage == $links[$i] || ($currentPage == '' && $links[$i] == 'index.php')) {
                $menu .= '<li id="currentLink" ' . (($langs[$i]) ? 'lang="' . $langs[$i] . '"' : '') . '>' . $names[$i] . '</li>';
            } else {
                $menu .= '<li><a href="' . $links[$i] . '" ' . (($langs[$i]) ? 'lang="' . $langs[$i] . '"' : '') . '>' . $names[$i] . '</a></li>';
            }
        }
        $menu .= '<li><a href="logout.php" class="button">Esci</a></li>';
    } else {
        $menu .= '<li><a href="registrazione.php" class="button">Registrati</a></li>';
        $menu .= '<li><a href="login.php" class="button">Accedi</a></li>';
    }


    return $menu;

}

?>