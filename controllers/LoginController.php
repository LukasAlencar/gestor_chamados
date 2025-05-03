<?php
require_once "../config/database.php";
require_once "../models/User.php";
session_start();

class LoginController
{
    public function index()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            $userModel = new User();
            $user = $userModel->getUserByemail($email);

            if ($user) {
                if ($user['failed_attempts'] >= 3) {
                    $_SESSION['error_message'] = "Usuário bloqueado. Entre em contato com o administrador.";
                    header("Location: ../views/login.php");
                    exit;
                }

                if ($password === $user['password']) {
                    $_SESSION['user'] = $user;
                    $userModel->resetFailedAttempts($email);

                    if ($user['role'] == 'client') {
                        header("Location: ../views/client.php");
                    } else {
                        header("Location: ../views/technician.php");
                    }
                    exit;
                } else {
                    $userModel->incrementFailedAttempts($email);
                    $_SESSION['error_message'] = "Usuário ou senha incorretos.";
                    header("Location: ../views/login.php");
                    exit;
                }
            } else {
                $_SESSION['error_message'] = "Usuário não encontrado.";
                header("Location: ../views/login.php");
                exit;
            }
        }else {
            header("Location: ../views/login.php");
        }
    }
}


$controller = new LoginController();
$controller->index();
?>
