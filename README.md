# API Users - Projeto com CodeIgniter 4

Este repositório contém uma API RESTful simples para gerenciamento de usuários, construída com CodeIgniter 4, além de um front-end básico para testes das operações CRUD (Create, Read, Update, Delete).

## Banco de Dados

O banco de dados utilizado é MySQL.

## Criar o Banco de Dados e a tabela users

Execute o script "database.sql" para criar o banco `ci4apidb` e a tabela `users` com os campos necessários.

```sql
-- Criar banco de dados
CREATE DATABASE IF NOT EXISTS ci4apidb
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE ci4apidb;

-- Criar tabela users
CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(150) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
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

-- Popular dados de exemplo
-- Para inserir alguns usuários de teste, execute o seguinte:

INSERT INTO users (name, email, phone, cpf, rg, address, number, district, city, fu)
VALUES
  ('Juliano Alves', 'juliano.alves@email.com', '(19) 97888.3499', '123.456.789-00', 'MG-12.345.678', 'Rua das Flores', '123', 'Centro', 'Campinas', 'SP'),
  ('Maria Silva', 'maria.silva@email.com', '(11) 91234.5678', '987.654.321-00', 'SP-98.765.432', 'Av. Paulista', '1000', 'Bela Vista', 'São Paulo', 'SP'),
  ('Carlos Pereira', 'carlos.pereira@email.com', '(21) 99876.5432', '111.222.333-44', 'RJ-11.222.333', 'Rua do Mercado', '45', 'Centro', 'Rio de Janeiro', 'RJ');

```
## Como usar

1. Configure seu ambiente local com PHP, MySQL e CodeIgniter 4.
2. Importe o banco de dados com o script acima.
3. Configure a conexão com o banco no arquivo .env ou app/Config/Database.php do CodeIgniter, apontando para ci4apidb.
4. Execute a API.
5. Abra o arquivo index.html no navegador para testar as operações CRUD (botões de Cadastrar, Listar, Alterar e Excluir).

## Endpoints da API

| Método | Endpoint          | Descrição                 |
| ------ | ----------------- | ------------------------- |
| POST   | `/api/users`      | Cadastrar novo usuário    |
| GET    | `/api/users`      | Listar todos os usuários  |
| GET    | `/api/users/{id}` | Listar usuário pelo ID    |
| PUT    | `/api/users/{id}` | Atualizar usuário pelo ID |
| DELETE | `/api/users/{id}` | Excluir usuário pelo ID   |


## Token de Autenticação

Use o token fixo: d3f81a9e5e4a7c0f3a2d9b7c1c30f8e2 para autenticar as requisições no header Authorization: Bearer <token>.

## Suporte

Qualquer dúvida ou sugestão, abra uma issue ou entre em contato: rafapress@yahoo.com
