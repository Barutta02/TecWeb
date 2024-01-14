<?php
try {
    require_once '../DAO/UserDAO.php';
    require_once '../Utility/utilities.php';
} catch (Throwable $th) {
    header('Location: ../500.html');
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Controlli input sul login
    if (!check_username_format($username)) {
        header('Location: ../signIn.php?MessageCode=0');
        exit(0);
    }
    if (!check_firstname_or_lastname_format(($firstname))) {
        header('Location: ../signIn.php?MessageCode=1');
        exit(0);
    }
    if (!check_firstname_or_lastname_format(($lastname))) {
        header('Location: ../signIn.php?MessageCode=2');
        exit(0);
    }
    if (!check_email_format($email)) {
        header('Location: ../signIn.php?MessageCode=3');
        exit(0);
    }
    if (!check_password_format($password)) {
        header('Location: ../signIn.php?MessageCode=4');
        exit(0);
    }

    try {
        $userDAO = new UserDAO();
        UserDAO::createUser(sanitize_txt($username, true), sanitize_txt($firstname), sanitize_txt($lastname), sanitize_txt($email), $password);
    } catch (Throwable $th) {
        header('Location: ../500.html');
        exit(0);
    }

    header("Location: ../login.php");
} else {
    // Se qualcuno tenta di accedere direttamente a questo file senza inviare il modulo, reindirizza alla pagina di registrazione
    header("Location: ../signIn.php");
    exit(0);
}
?>