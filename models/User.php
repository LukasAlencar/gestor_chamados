<?php
require_once "../config/database.php";

class User
{
    private $conn;
    private $email;
    private $password;
    private $role;

    public function __construct($email = null, $password = null, $role = null)
    {
        $this->conn = Database::getConnection();

        if ($email !== null && $password !== null && $role !== null) {
            $this->email = $email;
            $this->password = $password;
            $this->role = $role;
        }
    }

    public static function emailExists($email) {
        $conn = Database::getConnection();
        try {
            $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            $count = $stmt->fetchColumn();
            return $count > 0;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function save() {
        try {
            $stmt = $this->conn->prepare("INSERT INTO users (email, password, role) VALUES (:email, :password, :role)");
            $stmt->bindParam(':email', $this->email, PDO::PARAM_STR);
            $stmt->bindParam(':password', $this->password, PDO::PARAM_STR);
            $stmt->bindParam(':role', $this->role, PDO::PARAM_STR);

            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getUserByemail($email)
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return null;
        }
    }

    public function incrementFailedAttempts($email)
    {
        try {
            $stmt = $this->conn->prepare("UPDATE users SET failed_attempts = failed_attempts + 1 WHERE email = :email");
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
        } catch (PDOException $e) {
        }
    }

    public function resetFailedAttempts($email)
    {
        try {
            $stmt = $this->conn->prepare("UPDATE users SET failed_attempts = 0 WHERE email = :email");
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
        } catch (PDOException $e) {
        }
    }
}
?>
