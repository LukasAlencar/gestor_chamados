<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastre-se</title>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <link rel="stylesheet" href="../public/styles/login.css">
</head>

<body>
    <section class="vh-100">
        <div class="container-fluid h-100">
            <div style="color: white" class="row d-flex justify-content-center align-items-center h-100">
                <div class="w-50">
                    <img src="../public/images/draw.webp" class="img-fluid" alt="Sample image">
                </div>
                <div style="background-color: #99BDF8"
                    class="h-100 w-50 d-flex justify-content-center align-items-center">
                    <form action="../controllers/RegisterController.php" method="POST">
                        <h3 class="fw-bold mb-3">Cadastre-se</h3>
                        <?php
                            session_start();
                            if (isset($_SESSION['error_message'])) {
                                echo '<div style="color: #f54966" class=" text-start mb-2">' . $_SESSION['error_message'] . '</div>';
                                unset($_SESSION['error_message']);
                            }
                        ?>
                        <div data-mdb-input-init class="form-outline mb-4">
                            <input type="text" name="email" id="email"
                                class="form-control form-control-lg fs-6" placeholder="Insira seu melhor E-mail" />
                        </div>
                        <div data-mdb-input-init class="form-outline mb-3">
                            <input type="password" name="password" id="password"
                                class="form-control form-control-lg fs-6" placeholder="Insira a senha" />
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" checked value="client" type="radio" name="role" id="flexRadioDefault1">
                            <label class="form-check-label" for="flexRadioDefault1">
                                Cliente
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" value="technician" type="radio" name="role" id="flexRadioDefault2"
                                >
                            <label class="form-check-label" for="flexRadioDefault2">
                                Técnico
                            </label>
                        </div>
                        <div class="text-center text-lg-start mt-2 pt-2 w-100">
                            <button type="submit" data-mdb-button-init data-mdb-ripple-init
                                class="btn btn-danger btn-md w-100"
                                style="padding-left: 1.5rem; padding-right: 1.5rem;">Cadastrar</button>
                            <p class="small fw-bold mt-2 pt-1 mb-0">Já tem uma conta? <a href="login.php"
                                    class="link-danger">Entrar</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</body>

</html>