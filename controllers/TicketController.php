<?php
require_once '../models/Ticket.php'; // ajuste o caminho se necessário

class TicketController
{
    private function generateUuidV4()
    {
        $data = random_bytes(16);

        $data[6] = chr((ord($data[6]) & 0x0f) | 0x40);
        $data[8] = chr((ord($data[8]) & 0x3f) | 0x80);

        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }
    public function create($data)
    {
        $ticket = new Ticket(
            $this->generateUuidV4(),
            $data['user_id'],
            $data['description'],
            $data['department'],
            $data['date'],
            $data['time'],
            $data['urgency'],
            'open'
        );

        if ($ticket->save()) {
            return ['success' => true, 'message' => 'Ticket criado com sucesso.'];
        } else {
            return ['success' => false, 'message' => 'Erro ao criar o ticket.'];
        }
    }

    public function listAll()
    {
        $ticket = new Ticket();
        $tickets = $ticket->getAllTickets();

        if ($tickets !== null) {
            return ['success' => true, 'data' => $tickets];
        } else {
            return ['success' => false, 'message' => 'Erro ao buscar tickets.'];
        }
    }

    public function listByUser($user_id)
    {
        $ticket = new Ticket();
        $tickets = $ticket->getTicketByUserId($user_id);

        if ($tickets !== null) {
            return ['success' => true, 'data' => $tickets];
        } else {
            return ['success' => false, 'message' => 'Erro ao buscar tickets do usuário.'];
        }
    }

    public function getById($ticket_id)
    {
        $ticket = new Ticket();
        $ticketData = $ticket->getTicketById($ticket_id);

        if ($ticketData !== null) {
            return ['success' => true, 'data' => $ticketData];
        } else {
            return ['success' => false, 'message' => 'Ticket não encontrado.'];
        }
    }

    public function updateStatus($ticket_id, $status)
    {
        $ticket = new Ticket();

        if ($ticket->updateTicketStatus($ticket_id, $status)) {
            return ['success' => true, 'message' => 'Status atualizado com sucesso.'];
        } else {
            return ['success' => false, 'message' => 'Erro ao atualizar status do ticket.'];
        }
    }

    public function updateTicket($data)
    {
        $ticket = new Ticket();

        if (
            $ticket->updateTicket(
                $data['ticket_id'],
                $data['description'],
                $data['department'],
                $data['date'],
                $data['time'],
                $data['urgency'],
                $data['status']
            )
        ) {
            return ['success' => true, 'message' => 'Ticket atualizado com sucesso.'];
        } else {
            return ['success' => false, 'message' => 'Erro ao atualizar ticket.'];
        }
    }

    public function delete($ticket_id)
    {
        $ticket = new Ticket();

        if ($ticket->deleteTicket($ticket_id)) {
            return ['success' => true, 'message' => 'Ticket deletado com sucesso.'];
        } else {
            return ['success' => false, 'message' => 'Erro ao deletar ticket.'];
        }
    }

    public function getlastId()
    {
        $ticket = new Ticket();

        $lastId = $ticket->lastInsertId();

        return ['success' => true, 'message' => 'Sucesso ao buscar último id.', 'id' => $lastId];
    }
}
?>