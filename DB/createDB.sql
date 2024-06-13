-- Criação do Banco de Dados
CREATE DATABASE IF NOT EXISTS pedido_camisas;
USE pedido_camisas;

-- Criação da Tabela Clientes
CREATE TABLE IF NOT EXISTS clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    telefone VARCHAR(20) NOT NULL,
    email VARCHAR(100) NOT NULL
);

-- Criação da Tabela Pedidos
CREATE TABLE IF NOT EXISTS pedidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cliente_id INT NOT NULL,
    quantidade INT NOT NULL,
    FOREIGN KEY (cliente_id) REFERENCES clientes(id)
);

-- Criação da Tabela Modelos de Camisas
CREATE TABLE IF NOT EXISTS modelos_camisas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pedido_id INT NOT NULL,
    modelo VARCHAR(50) NOT NULL,
    tamanho VARCHAR(5) NOT NULL,
    FOREIGN KEY (pedido_id) REFERENCES pedidos(id)
);
