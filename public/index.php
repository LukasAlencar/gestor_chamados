<?php
    require_once "../config/database.php";
    require_once "../models/User.php";
    require_once "../controllers/LoginController.php";

    $controller = new LoginController();
    $controller->index();
?>