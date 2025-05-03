<?php
require_once "../config/database.php";

class Ticket
{
    private $conn;
    private $ticket_id;
    private $user_id;
    private $description;
    private $department;
    private $date;
    private $time;
    private $urgency;
    private $status;

    public function __construct($ticket_id = null, $user_id = null, $description = null, $department = null, $date = null, $time = null, $urgency = null, $status = null)
    {
        $this->conn = Database::getConnection();

        if ($ticket_id !== null && $user_id !== null && $description !== null && $department !== null && $date !== null && $time !== null && $urgency !== null && $status !== null) {
            $this->ticket_id = $ticket_id;
            $this->user_id = $user_id;
            $this->description = $description;
            $this->department = $department;
            $this->date = $date;
            $this->time = $time;
            $this->urgency = $urgency;
            $this->status = $status;
        }
    }

    public function save()
    {
        try {
            $stmt = $this->conn->prepare("INSERT INTO tickets (user_id, description, department, date, time, urgency, status) VALUES (:user_id, :description, :department, :date, :time, :urgency, :status)");
            $stmt->bindParam(':user_id', $this->user_id, PDO::PARAM_INT);
            $stmt->bindParam(':description', $this->description, PDO::PARAM_STR);
            $stmt->bindParam(':department', $this->department, PDO::PARAM_STR);
            $stmt->bindParam(':date', $this->date, PDO::PARAM_STR);
            $stmt->bindParam(':time', $this->time, PDO::PARAM_STR);
            $stmt->bindParam(':urgency', $this->urgency, PDO::PARAM_STR);
            $stmt->bindParam(':status', $this->status, PDO::PARAM_STR);

            return $stmt->execute();
        } catch (PDOException $e) {
            echo '<pre>';
            var_dump($e);
            echo '</pre>';
            die();
        }
    }

    public function getTicketByUserId($user_id)
    {
        try {
            $stmt = $this->conn->prepare("SELECT  tickets.*, users.email FROM tickets INNER JOIN users ON tickets.user_id = users.user_id WHERE tickets.user_id = :user_id ORDER BY tickets.ticket_id DESC;");
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return null;
        }
    }
    public function getTicketById($ticket_id)
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM tickets WHERE ticket_id = :ticket_id");
            $stmt->bindParam(':ticket_id', $ticket_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return null;
        }
    }

    public function updateTicketStatus($ticket_id, $status)
    {
        try {
            $stmt = $this->conn->prepare("UPDATE tickets SET status = :status WHERE ticket_id = :ticket_id");
            $stmt->bindParam(':ticket_id', $ticket_id, PDO::PARAM_INT);
            $stmt->bindParam(':status', $status, PDO::PARAM_STR);
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    public function deleteTicket($ticket_id)
    {
        try {
            $stmt = $this->conn->prepare("DELETE FROM tickets WHERE ticket_id = :ticket_id");
            $stmt->bindParam(':ticket_id', $ticket_id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getAllTickets()
    {
        try {
            $stmt = $this->conn->prepare(
        "SELECT 
                    tickets.*,
                    users.email
                FROM 
                    tickets
                INNER JOIN 
                    users ON tickets.user_id = users.user_id
                ORDER BY 
                    tickets.ticket_id DESC;
            ");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return null;
        }
    }

    public function updateTicket($ticket_id, $description, $department, $date, $time, $urgency, $status)
    {
        try {

            $stmt = $this->conn->prepare("UPDATE tickets SET description = :description, department = :department, date = :date, time = :time, urgency = :urgency, status = :status WHERE ticket_id = :ticket_id");
            $stmt->bindParam(':ticket_id', $ticket_id, PDO::PARAM_INT);
            $stmt->bindParam(':description', $description, PDO::PARAM_STR);
            $stmt->bindParam(':department', $department, PDO::PARAM_STR);
            $stmt->bindParam(':date', $date, PDO::PARAM_STR);
            $stmt->bindParam(':time', $time, PDO::PARAM_STR);
            $stmt->bindParam(':urgency', $urgency, PDO::PARAM_STR);
            $stmt->bindParam(':status', $status, PDO::PARAM_STR);

            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    public function lastInsertId()
    {
        $stmt = $this->conn->prepare("SELECT MAX(ticket_id) as last_id FROM tickets");
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $lastId = $row['last_id'] ?? 0; 

        return $lastId;
    }
}
?>