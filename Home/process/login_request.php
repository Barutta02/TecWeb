<?php
try {
    require_once '../DAO/UserDAO.php';
    require_once '../DAO/PrenotazioneDAO.php';
    require_once '../Utility/utilities.php';
} catch (Throwable $th) {
    header('Location: ../500.html');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username_or_email = $_POST["username_or_email"];
    $password = $_POST["password"];

    if (empty($username_or_email) || empty($password)) {
        header("Location: ../login.php?MessageCode=1");
    } else {
        try {
            if (check_admin_privileges($username_or_email, $password) == true) {
                session_start();
                session_destroy();
                session_start();
                $_SESSION['adminLogged'] = 1;
                header("Location: ../adminPanel.php");
                exit();
            }

            $userDAO = new UserDAO();
            $emailAuth = UserDAO::getUserByEmailPassword(sanitize_txt($username_or_email), sanitize_txt($password));
            if (!empty($emailAuth)) {
                session_start();
                session_destroy();
                save_username_session($emailAuth['username'], $emailAuth['nome'], $emailAuth['cognome']);
                header("Location: ../prenotazione.php");
            } else {
                $UsernameAuth = UserDAO::getUserByUsernamePassword(sanitize_txt($username_or_email), sanitize_txt($password));
                if (!empty($UsernameAuth)) {
                    session_start();
                    session_destroy();
                    save_username_session($UsernameAuth['username'], $UsernameAuth['nome'], $UsernameAuth['cognome']);
                    header("Location: ../prenotazione.php");
                } else {
                    header("Location: ../login.php?MessageCode=1");
                    exit();
                }
            }
        } catch (Throwable $th) {
            header('Location: ../500.html');
            exit();
        }
    }
} else {
    // Se qualcuno tenta di accedere direttamente a questo file senza inviare il modulo, reindirizza alla pagina di login
    header("Location:  ../login.php");
    exit();
}
function save_username_session($username, $name, $surname)
{
    session_start();
    $_SESSION['username'] = $username;
    $_SESSION['name'] = $name;
    $_SESSION['surname'] = $surname;
    hasAlreadyPrenotate($_SESSION['username']);
}

//COntrolla che non ci sia una prenotazione dell'utente attiva e in caso la recupera
function hasAlreadyPrenotate($username)
{
    $prenotation = PrenotazioneDAO::getActivePrenotationByUsername($username);
    if (!empty($prenotation)) {
        $_SESSION['data_prenotazione_inCorso'] = $prenotation['data_ora'];
        header("Location: ../prenotazione.php?MessageCode=10");
        exit();
    }
}

?>