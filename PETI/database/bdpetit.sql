-- Crear la base de datos
CREATE DATABASE IF NOT EXISTS BD_Plan;
USE BD_Plan;

-- Crear la tabla Usuario
CREATE TABLE IF NOT EXISTS `usuario` (
  `id` INT(255) NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(100) NOT NULL,
  `apellido` VARCHAR(255) DEFAULT NULL,
  `correo` VARCHAR(255) NOT NULL,
  `clave` VARCHAR(255) NOT NULL,
  `rol` VARCHAR(20) DEFAULT NULL,
  `imagen` VARCHAR(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_correo` (`correo`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Crear la tabla Misión
CREATE TABLE Mision (
    id_mision INT AUTO_INCREMENT PRIMARY KEY,
    mision VARCHAR(255) NOT NULL,
    id_usuario INT,
    FOREIGN KEY (id_usuario) REFERENCES usuario(id)
);

-- Crear la tabla Visión
CREATE TABLE Vision (
    id_vision INT AUTO_INCREMENT PRIMARY KEY,
    vision VARCHAR(255) NOT NULL,
    id_usuario INT,
    FOREIGN KEY (id_usuario) REFERENCES usuario(id)
);

-- Crear la tabla Valores
CREATE TABLE Valores (
    id_valor INT AUTO_INCREMENT PRIMARY KEY,
    valor VARCHAR(255) NOT NULL,
    id_usuario INT,
    FOREIGN KEY (id_usuario) REFERENCES usuario(id)
);

-- Crear la tabla Objetivo_general
CREATE TABLE Objetivo_general (
    id_general INT AUTO_INCREMENT PRIMARY KEY,
    objetivo VARCHAR(255) NOT NULL,
    id_usuario INT,
    FOREIGN KEY (id_usuario) REFERENCES usuario(id)
);

-- Crear la tabla Objetivo_especifico
CREATE TABLE Objetivo_especifico (
    id_especifico INT AUTO_INCREMENT PRIMARY KEY,
    objetivo VARCHAR(255) NOT NULL,
    id_general INT,
    FOREIGN KEY (id_general) REFERENCES Objetivo_general(id_general)
);

-- Crear la tabla Fortaleza
CREATE TABLE Fortaleza (
    id_fortaleza INT AUTO_INCREMENT PRIMARY KEY,
    fortaleza VARCHAR(255) NOT NULL,
    id_usuario INT,
    FOREIGN KEY (id_usuario) REFERENCES usuario(id)
);

-- Crear la tabla Debilidad
CREATE TABLE Debilidad (
    id_debilidad INT AUTO_INCREMENT PRIMARY KEY,
    debilidad VARCHAR(255) NOT NULL,
    id_usuario INT,
    FOREIGN KEY (id_usuario) REFERENCES usuario(id)
);

-- Crear la tabla Oportunidad
CREATE TABLE Oportunidad (
    id_oportunidad INT AUTO_INCREMENT PRIMARY KEY,
    oportunidad VARCHAR(255) NOT NULL,
    id_usuario INT,
    FOREIGN KEY (id_usuario) REFERENCES usuario(id)
);

-- Crear la tabla Amenaza
CREATE TABLE Amenaza (
    id_amenaza INT AUTO_INCREMENT PRIMARY KEY,
    amenaza VARCHAR(255) NOT NULL,
    id_usuario INT,
    FOREIGN KEY (id_usuario) REFERENCES usuario(id)
);

-- Crear la tabla Estrategia
CREATE TABLE Estrategia (
    id_estrategia INT AUTO_INCREMENT PRIMARY KEY,
    estrategia VARCHAR(255) NOT NULL,
    id_usuario INT,
    FOREIGN KEY (id_usuario) REFERENCES usuario(id)
);

-- Crear la tabla Corregir
CREATE TABLE Corregir (
    id_corregir INT AUTO_INCREMENT PRIMARY KEY,
    corregir VARCHAR(255) NOT NULL,
    id_usuario INT,
    FOREIGN KEY (id_usuario) REFERENCES usuario(id)
);

-- Crear la tabla Afrontar
CREATE TABLE Afrontar (
    id_afrontar INT AUTO_INCREMENT PRIMARY KEY,
    afrontar VARCHAR(255) NOT NULL,
    id_usuario INT,
    FOREIGN KEY (id_usuario) REFERENCES usuario(id)
);

-- Crear la tabla Mantener
CREATE TABLE Mantener (
    id_mantener INT AUTO_INCREMENT PRIMARY KEY,
    mantener VARCHAR(255) NOT NULL,
    id_usuario INT,
    FOREIGN KEY (id_usuario) REFERENCES usuario(id)
);

-- Crear la tabla Explotar
CREATE TABLE Explotar (
    id_explotar INT AUTO_INCREMENT PRIMARY KEY,
    explotar VARCHAR(255) NOT NULL,
    id_usuario INT,
    FOREIGN KEY (id_usuario) REFERENCES usuario(id)
);

-- Crear la tabla UEN
CREATE TABLE UEN (
    id_uen INT AUTO_INCREMENT PRIMARY KEY,
    uen VARCHAR(255) NOT NULL,
    id_usuario INT,
    FOREIGN KEY (id_usuario) REFERENCES usuario(id)
);