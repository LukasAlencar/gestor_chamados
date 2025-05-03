<?php
session_start();

if (!isset($_SESSION['user'])) {
    $_SESSION['error_message'] = "Você precisa fazer login para acessar esta página.";
    header("Location: ../views/login.php");
    exit();
}

$userRole = $_SESSION['user']['role'];
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Lista de Chamados</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./styles/main.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        body {
            background-color: #4b4433;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block sidebar">
                <div class="position-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <?php
                            if ($userRole == 'client') {
                                echo '<a class="nav-link" href="./client.php">Criar Chamado</a>';
                            } else if ($userRole == 'technician') {
                                echo '<a class="nav-link" href="./technician.php">Criar Chamado</a>';
                            }

                            ?>
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

                <div class="container my-5">
                    <h1 style="color: #e2cb92" class="mb-4">
                        <?php
                        if ($_SESSION['user']['role'] == 'client') {
                            echo "Meus Chamados";
                        } else if ($_SESSION['user']['role'] == 'technician') {
                            echo "Lista de Chamados";
                        }
                        ?>
                    </h1>

                    <div class="row g-4">
                        <?php
                        require_once '../controllers/TicketController.php';

                        $ticketController = new TicketController();

                        $user = $_SESSION['user'];

                        $userId = $user['user_id'];

                        $userRole = $user['role'];

                        if ($userRole == 'client') {
                            $response = $ticketController->listByUser($userId);
                        } else if ($userRole == 'technician') {
                            $response = $ticketController->listAll($userId);
                        }

                        if ($response['success']) {
                            $tickets = $response['data'];
                        } else {
                            $errorMessage = $response['message'];
                        }

                        if ($tickets) {
                            $departments = [
                                'financial' => 'Financeiro',
                                'sales' => 'Vendas',
                                'administrative' => 'Administrativo',
                                'hr' => 'Recursos Humanos',
                                'operations' => 'Operacional'
                            ];

                            $statuses = [
                                'open' => 'Aberto',
                                'closed' => 'Fechado',
                                'progress' => 'Em andamento',
                            ];

                            $urgencies = [
                                'low' => 'Baixa',
                                'medium' => 'Média',
                                'high' => 'Alta',
                            ];



                            foreach ($tickets as $ticket) {
                                $department = $departments[$ticket['department']] ?? ucfirst($ticket['department']);
                                $status = $statuses[$ticket['status']] ?? ucfirst($ticket['status']);
                                $urgency = $urgencies[$ticket['urgency']] ?? ucfirst($ticket['urgency']);
                                ?>
                                <div class="col-md-6 col-lg-4">
                                    <form class="hidden" id="formDelete<?php echo htmlspecialchars($ticket['ticket_id']); ?>"
                                        action="../controllers/ticket_router.php?action=delete" method="POST">
                                        <input type="text" name="ticket_id"
                                            value="<?php echo htmlspecialchars($ticket['ticket_id']); ?>">
                                    </form>
                                    <div class="ticket-card">
                                        <div class="ticket-header">
                                            Chamado #<?php echo htmlspecialchars($ticket['ticket_id']); ?>
                                        </div>
                                        <div class="ticket-body">
                                            <p><strong>Departamento:</strong>
                                                <?php echo $department; ?></p>
                                            <p><strong>Descrição:</strong>
                                                <?php echo htmlspecialchars($ticket['description']); ?></p>
                                            <p><strong>Urgência:</strong> <?php echo $urgency; ?>
                                            </p>
                                            <p><strong>Status:</strong> <?php echo $status; ?></p>
                                        </div>
                                        <div id='<?php echo htmlspecialchars($ticket['ticket_id']); ?>' style="display: none;"
                                            class="ticket-more">
                                            <p><strong>Data:</strong>
                                                <?php
                                                    echo htmlspecialchars(date('d/m/Y', strtotime($ticket['date'])));
                                                ?>
                                                <strong>Hora:</strong> <?php echo htmlspecialchars($ticket['time']); ?>
                                            </p>
                                            <p><strong>Usuário:</strong>
                                                <?php echo htmlspecialchars($ticket['email']); ?></p>
                                        </div>
                                        <div class="ticket-footer">
                                            <button
                                                onclick="toggleDetails('<?php echo htmlspecialchars($ticket['ticket_id']); ?>')"
                                                class="btn btn-custom btn-view">Ver Detalhes</button>
                                            <?php
                                            if ($userRole == 'technician') {
                                                ?>
                                                <button
                                                    onclick="window.location.href='./updateTicket.php?ticket_id=<?php echo htmlspecialchars($ticket['ticket_id']); ?>'"
                                                    class="btn btn-custom">Editar</button>
                                                <button
                                                    onclick="deleteTicket('<?php echo htmlspecialchars($ticket['ticket_id']); ?>', event)"
                                                    class="btn btn-danger">Remover</button>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        } else {
                            echo "<p style='color: #e2cb92'>Você ainda não possui chamados.</p>";
                        }
                        ?>
                    </div>
            </main>
        </div>
    </div>

    <script src="./scripts/tickets.js"></script>
</body>

</html>