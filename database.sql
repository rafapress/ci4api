-- Criar banco de dados
CREATE DATABASE IF NOT EXISTS ci4apidb
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE ci4apidb;

-- Criar tabela users sem UNIQUE no email
CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(150) NOT NULL,
  email VARCHAR(150) NOT NULL,
  phone VARCHAR(50),
  cpf VARCHAR(20),
  rg VARCHAR(20),
  address VARCHAR(255),
  number VARCHAR(20),
  district VARCHAR(100),
  city VARCHAR(100),
  fu CHAR(2),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Inserir registros para testes
INSERT INTO users (name, email, phone, cpf, rg, address, number, district, city, fu)
VALUES
  ('Juliano Alves', 'juliano.alves@email.com', '(19) 97888.3499', '123.456.789-00', 'MG-12.345.678', 'Rua das Flores', '123', 'Centro', 'Campinas', 'SP'),
  ('Maria Silva', 'maria.silva@email.com', '(11) 91234.5678', '987.654.321-00', 'SP-98.765.432', 'Av. Paulista', '1000', 'Bela Vista', 'São Paulo', 'SP'),
  ('Carlos Pereira', 'carlos.pereira@email.com', '(21) 99876.5432', '111.222.333-44', 'RJ-11.222.333', 'Rua do Mercado', '45', 'Centro', 'Rio de Janeiro', 'RJ'),
  ('Juliano Alves 2', 'juliano.alves@email.com', '(19) 90000.0000', '555.666.777-88', 'MG-55.666.777', 'Rua das Palmeiras', '456', 'Jardim', 'Campinas', 'SP');
