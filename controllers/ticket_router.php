<?php
require_once './TicketController.php';
session_start();

$controller = new TicketController();

$action = $_GET['action'] ?? $_POST['action'] ?? '';

switch ($action) {
    case 'create':
        $data = $_POST;
        $result = $controller->create($data);
        if ($result['success']) {
            $_SESSION['success_message'] = $result['message'];
            $_SESSION['error_message'] = '';
        } else {
            $_SESSION['error_message'] = $result['message'];
            $_SESSION['success_message'] = '';

        }
        header('Location: ../views/ticketsList.php');
        break;

    case 'list':
        $result = $controller->listAll();
        break;

    case 'getById':
        $ticket_id = $_GET['ticket_id'];
        $result = $controller->getById($ticket_id);
        break;

    case 'updateStatus':
        $ticket_id = $_POST['ticket_id'];
        $status = $_POST['status'];
        $result = $controller->updateStatus($ticket_id, $status);
        header('Location: ../views/ticketsList.php');
        break;

    case 'update':
        $data = $_POST;
        $result = $controller->updateTicket($data);
        header('Location: ../views/ticketsList.php');
        break;

    case 'delete':
        $ticket_id = $_POST['ticket_id'];
        $result = $controller->delete($ticket_id);
        header('Location: ../views/ticketsList.php');
        break;

    case 'getLastId':
        $result = $controller->getlastId();
        break;

    default:
        header('Location: ../views/ticketsList.php');
        break;
}
?>