
CREATE DATABASE crud_db;

USE crud_db;

CREATE TABLE empleados (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(50) NOT NULL,
  edad INT NOT NULL
);

USE crud_db;

INSERT INTO empleados (nombre, edad) VALUES ('Juan Perez', 30);
INSERT INTO empleados (nombre, edad) VALUES ('María López', 25);
INSERT INTO empleados (nombre, edad) VALUES ('Pedro Ramirez', 28);
INSERT INTO empleados (nombre, edad) VALUES ('Laura Martinez', 35);
INSERT INTO empleados (nombre, edad) VALUES ('Carlos Gómez', 40);