<?php
// Verifica se il modulo è stato inviato
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera i dati dal modulo
    $username_or_email = $_POST["username_or_email"];
    $password = $_POST["password"];

    // Esempio di verifica delle credenziali (puoi personalizzarla in base alle tue esigenze)
    if (empty($username_or_email) || empty($password)) {
        echo "Compila tutti i campi del modulo.";
    } else {
        // Esempio di autenticazione (controlla se l'utente è registrato)
        // Questo è un esempio molto basico e insicuro. In un'applicazione del mondo reale, dovresti utilizzare un sistema di autenticazione sicuro.
        require_once '../../DAO/UserDAO.php';
        $userDAO = new UserDAO();
        $emailAuth = UserDAO::getUserByEmailPassword($username_or_email, $password);
        if (!empty($emailAuth)) {
            save_username_session($emailAuth['Username'], $emailAuth['Nome'], $emailAuth['Cognome']);
            header("Location: ../../Logged/NuovaPrenotazione.php");
        } else {
            $UsernameAuth = UserDAO::getUserByUsernamePassword($username_or_email, $password);
            if (!empty($UsernameAuth)) {
                save_username_session($UsernameAuth['Username'], $UsernameAuth['Nome'], $UsernameAuth['Cognome']);
                header("Location: ../../Logged/NuovaPrenotazione.php");
            } else {
                header("Location: ../login.php");
            }
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