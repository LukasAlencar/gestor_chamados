<?php
session_start();
if (!isset($_SESSION['user'])) {
    $_SESSION['error_message'] = "Você precisa fazer login para acessar esta página.";
    header("Location: ../views/login.php");
    exit();
} else if ($_SESSION['user']['role'] !== 'technician') {
    header("Location: " . 'client.php');
    exit();
}

require_once '../controllers/TicketController.php';

$ticketController = new TicketController();

$ticket = $ticketController->getById($_GET['ticket_id']);

if ($ticket['success']) {
    $ticket = $ticket['data'];
} else {
    header("Location: ./ticketsList.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar chamado</title>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="./styles/main.css">
</head>

<body style="">

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block sidebar">
                <div class="position-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="#criar-chamado">
                                Criar Chamado
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./ticketsList.php">
                                Ver Chamados
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link logout" href="../controllers/LogoutController.php">
                                Sair
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Conteúdo Principal -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <form action="../controllers/ticket_router.php?action=update" method="POST" class="p-4">
                    <div class="mb-3">
                        <label for="ticket_id" class="form-label">Chamado ID</label>
                        <input type="text" class="form-control custom-input" value="<?php echo $ticket['ticket_id'] ?>"
                            id="ticket_id" name="ticket_id" readonly placeholder="Gerado automaticamente">
                    </div>

                    <div class="mb-3">
                        <label for="user_id" class="form-label">Usuário ID</label>
                        <input type="text" value="<?php echo $ticket['user_id'] ?>"
                            class="form-control custom-input" id="user_id" name="user_id" required readonly>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Descrição</label>
                        <textarea class="form-control custom-textarea" id="description" name="description" rows="3"
                            required><?php echo htmlspecialchars($ticket['description']); ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="department" class="form-label">Departamento</label>
                        <select class="form-select custom-select" id="department" name="department" required>
                            <option value="">Selecione o departamento</option>
                            <option value="sales" <?php echo ($ticket['department'] == 'sales') ? 'selected' : ''; ?>>
                                Vendas</option>
                            <option value="operations" <?php echo ($ticket['department'] == 'operations') ? 'selected' : ''; ?>>Operacional</option>
                            <option value="financial" <?php echo ($ticket['department'] == 'financial') ? 'selected' : ''; ?>>Financeiro</option>
                            <option value="hr" <?php echo ($ticket['department'] == 'hr') ? 'selected' : ''; ?>>Recursos
                                Humanos</option>
                            <option value="administrative" <?php echo ($ticket['department'] == 'administrative') ? 'selected' : ''; ?>>Administrativo</option>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="date" class="form-label">Data</label>
                            <input type="date" value="<?php echo $ticket['date'] ?>" class="form-control custom-input"
                                id="date" name="date" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="time" class="form-label">Hora</label>
                            <input type="time" value="<?php echo $ticket['time'] ?>" class="form-control custom-input"
                                id="time" name="time" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="urgency" class="form-label">Urgência</label>
                        <select class="form-select custom-select" 
                            id="urgency" name="urgency" required>
                            <option value="">Selecione a urgência</option>
                            <option value="low" <?php echo ($ticket['urgency'] == 'low') ? 'selected' : ''; ?>>Baixa</option>
                            <option value="medium" <?php echo ($ticket['urgency'] == 'medium') ? 'selected' : ''; ?>>Média</option>
                            <option value="high" <?php echo ($ticket['urgency'] == 'high') ? 'selected' : ''; ?>>Alta</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select custom-select"
                            id="status" name="status" required>
                            <option value="">Selecione o status</option>
                            <option value="open" <?php echo ($ticket['status'] == 'open') ? 'selected' : ''; ?>>Aberto</option>
                            <option value="closed" <?php echo ($ticket['status'] == 'closed') ? 'selected' : ''; ?>>Fechado</option>
                            <option value="progress" <?php echo ($ticket['status'] == 'progress') ? 'selected' : ''; ?>>Em andamento</option>
                        </select>
                    </div>

                    <button type="submit" class="custom-btn btn btn-primary ">Editar Chamado</button>
                </form>

            </main>
        </div>
    </div>
    <script>

    </script>
</body>

</html>