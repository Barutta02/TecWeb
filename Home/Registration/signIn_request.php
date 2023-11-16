<?php
// Verifica se il modulo è stato inviato
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera i dati dal modulo
    $username = $_POST["username"];
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Esempio di validazione (puoi personalizzarla in base alle tue esigenze)
    if (empty($username) || empty($firstname) || empty($lastname) || empty($email) || empty($password)) {
        echo "Compila tutti i campi del modulo.";
    } else {
        require_once '../DAO/UserDAO.php';
        $userDAO = new UserDAO();
        $userDAO->createUser($username, $firstname, $lastname, $email, $password);
        echo "Registrazione avvenuta con successo.";
        header("Location: login.php");
    }
} else {
    // Se qualcuno tenta di accedere direttamente a questo file senza inviare il modulo, reindirizza alla pagina di registrazione
    header("Location: signIn.php");
    exit();
}
?>