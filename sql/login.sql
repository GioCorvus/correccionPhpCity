CREATE TABLE Tipos_usuario (
    id INT PRIMARY KEY AUTO_INCREMENT,
    tipo VARCHAR(50) NOT NULL
);

INSERT INTO Tipos_usuario (tipo) VALUES
    ('superadmin');

CREATE TABLE Usuario (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre_usuario VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL, -- Use a strong hashing algorithm to store passwords
    tipo_usuario INT,
    FOREIGN KEY (tipo_usuario) REFERENCES Tipos_usuario(id)
);