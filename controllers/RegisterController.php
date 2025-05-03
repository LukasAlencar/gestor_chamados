<?php
require_once "../config/database.php";
require_once "../models/User.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $role = $_POST['role']; // 'Aluno' ou 'Professor'

    session_start();

    if (User::emailExists($email)) {
        echo 'Nome de usuário já existe.';
        header("Location: ../views/register.php");
        $_SESSION['error_message'] = "Nome de usuário já existe.";
        exit;
    }


    $user = new User($email, $password, $role);

    if ($user->save()) {
        header("Location: ../views/login.php");
        exit;
    } else {
        echo "Erro ao registrar usuário.";
    }
}

?>
