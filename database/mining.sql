CREATE DATABASE mining_market;

USE mining_market;

CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    description TEXT,
    price DECIMAL(10,2),
    image VARCHAR(255)
);

CREATE TABLE contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100),
    message TEXT
);

INSERT INTO products (name, description, price, image) VALUES
('Batu Bara', 'Tambang batu bara kualitas tinggi', 5000000, 'coal.jpg'),
('Emas', 'Tambang emas murni', 15000000, 'gold.jpg'),
('Nikel', 'Tambang nikel industri', 8000000, 'nickel.jpg');