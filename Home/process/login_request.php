<?php
// Verifica se il modulo è stato inviato
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera i dati dal modulo
    $username_or_email = $_POST["username_or_email"];
    $password = $_POST["password"];

    // Esempio di verifica delle credenziali (puoi personalizzarla in base alle tue esigenze)
    if (empty($username_or_email) || empty($password)) {
        header("Location: ../login.php?Errorcode=1");
    } else {
        if ($username_or_email == 'Admin' && $password == 'Admin') {
            header("Location: ../adminPanel.php");
            session_destroy();
            session_start();
            $_SESSION['adminLogged'] = 1;
            exit(); // Ensure that no further code is executed after the redirect
        }

        try {
            // Esempio di autenticazione (controlla se l'utente è registrato)
            // Questo è un esempio molto basico e insicuro. In un'applicazione del mondo reale, dovresti utilizzare un sistema di autenticazione sicuro.
            require_once '../DAO/UserDAO.php';
            require_once '../Utility/utilities.php';
            $userDAO = new UserDAO();
            $emailAuth = UserDAO::getUserByEmailPassword(sanitize_txt($username_or_email), sanitize_txt($password));
            if (!empty($emailAuth)) {
                session_destroy();
                save_username_session($emailAuth['username'], $emailAuth['nome'], $emailAuth['cognome']);
                header("Location: ../prenotazione.php");
            } else {
                $UsernameAuth = UserDAO::getUserByUsernamePassword(sanitize_txt($username_or_email), sanitize_txt($password));
                if (!empty($UsernameAuth)) {
                    session_destroy();
                    save_username_session($UsernameAuth['username'], $UsernameAuth['nome'], $UsernameAuth['cognome']);
                    header("Location: ../prenotazione.php");
                } else {
                    header("Location: ../login.php?Errorcode=1");
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
    // Save the username in the session
    $_SESSION['username'] = $username;
    $_SESSION['name'] = $name;
    $_SESSION['surname'] = $surname;

}
?>