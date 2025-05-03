-- Cria o banco de dados
CREATE DATABASE IF NOT EXISTS support_system
  DEFAULT CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE support_system;

-- Cria a tabela 'users'
CREATE TABLE IF NOT EXISTS users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    role ENUM('technician', 'client') NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Cria a tabela 'tickets'
CREATE TABLE IF NOT EXISTS tickets (
    ticket_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    description TEXT NOT NULL,
    department ENUM('administrative', 'financial', 'hr', 'sales', 'operations') NOT NULL,
    date DATE NOT NULL,
    time VARCHAR(10) NOT NULL,
    urgency ENUM('low', 'medium', 'high') NOT NULL,
    status ENUM('open', 'closed', 'progress') NOT NULL DEFAULT 'open',
    FOREIGN KEY (user_id) REFERENCES users(user_id)
      ON DELETE CASCADE
      ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
