-- Crear la tabla Ámbitos
CREATE TABLE Ambito (
    id_ambito TINYINT UNSIGNED NOT NULL,
    nombre VARCHAR(50) NOT NULL,
    PRIMARY KEY (id_ambito)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- Crear la tabla Pregunta
CREATE TABLE Pregunta (
    id_pregunta TINYINT UNSIGNED NOT NULL AUTO_INCREMENT,
    pregunta VARCHAR(100) NOT NULL,
    id_ambito TINYINT UNSIGNED NOT NULL,
    num_respuesta_correcta TINYINT UNSIGNED NULL, 
    PRIMARY KEY (id_pregunta),
    CONSTRAINT fk_pregunta_ambito FOREIGN KEY (id_ambito) REFERENCES Ambito(id_ambito) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- Crear la tabla Respuesta
CREATE TABLE Respuesta (
    id_pregunta TINYINT UNSIGNED NOT NULL,
    num_respuesta TINYINT UNSIGNED NOT NULL,
    texto_respuesta VARCHAR(50) NOT NULL,
    PRIMARY KEY (id_pregunta, num_respuesta),
    CONSTRAINT fk_respuesta_pregunta FOREIGN KEY (id_pregunta) REFERENCES Pregunta(id_pregunta) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- Agregar la clave foránea a la tabla 'pregunta'
ALTER TABLE Pregunta
ADD CONSTRAINT fk_pregunta_respuesta FOREIGN KEY (id_pregunta, num_respuesta_correcta) REFERENCES Respuesta(id_pregunta, num_respuesta)
ON DELETE CASCADE ON UPDATE CASCADE;


-- Primera inserción de datos masiva

-- Inserción de datos en la tabla Ámbitos
INSERT INTO Ambito (id_ambito, nombre) VALUES
(1, 'Participacion democratica'),
(2, 'Justicia Social'),
(3, 'Desarrollo Humano y Sostenible'),
(4, 'Interculturalidad e inclusipn'),
(5, 'Equidad de genero y coeducacion');

-- Inserción masiva de preguntas
INSERT INTO Pregunta (pregunta, id_ambito) VALUES
('Pregunta 1', 1),
('Pregunta 2', 2),
('Pregunta 3', 1),
('Pregunta 4', 2),
('Pregunta 5', 1),
('Pregunta 6', 2),
('Pregunta 7', 1),
('Pregunta 8', 2),
('Pregunta 9', 1),
('Pregunta 10', 2);

-- Inserción masiva de respuestas
INSERT INTO Respuesta (id_pregunta, num_respuesta, texto_respuesta) VALUES
    -- Respuestas para Pregunta 1
    (1, 1, 'Respuesta 1 Pregunta 1'),
    (1, 2, 'Respuesta 2 Pregunta 1'),
    (1, 3, 'Respuesta 3 Pregunta 1'),
    
    -- Respuestas para Pregunta 2
    (2, 1, 'Respuesta 1 Pregunta 2'),
    (2, 2, 'Respuesta 2 Pregunta 2'),
    (2, 3, 'Respuesta 3 Pregunta 2'),

    -- Respuestas para Pregunta 3
    (3, 1, 'Respuesta 1 Pregunta 3'),
    (3, 2, 'Respuesta 2 Pregunta 3'),
    (3, 3, 'Respuesta 3 Pregunta 3'),

    -- Respuestas para Pregunta 4
    (4, 1, 'Respuesta 1 Pregunta 4'),
    (4, 2, 'Respuesta 2 Pregunta 4'),
    (4, 3, 'Respuesta 3 Pregunta 4'),

    -- Respuestas para Pregunta 5
    (5, 1, 'Respuesta 1 Pregunta 5'),
    (5, 2, 'Respuesta 2 Pregunta 5'),
    (5, 3, 'Respuesta 3 Pregunta 5'),

    -- Respuestas para Pregunta 6
    (6, 1, 'Respuesta 1 Pregunta 6'),
    (6, 2, 'Respuesta 2 Pregunta 6'),
    (6, 3, 'Respuesta 3 Pregunta 6'),

    -- Respuestas para Pregunta 7
    (7, 1, 'Respuesta 1 Pregunta 7'),
    (7, 2, 'Respuesta 2 Pregunta 7'),
    (7, 3, 'Respuesta 3 Pregunta 7'),

    -- Respuestas para Pregunta 8
    (8, 1, 'Respuesta 1 Pregunta 8'),
    (8, 2, 'Respuesta 2 Pregunta 8'),
    (8, 3, 'Respuesta 3 Pregunta 8'),

    -- Respuestas para Pregunta 9
    (9, 1, 'Respuesta 1 Pregunta 9'),
    (9, 2, 'Respuesta 2 Pregunta 9'),
    (9, 3, 'Respuesta 3 Pregunta 9'),

    -- Respuestas para Pregunta 10
    (10, 1, 'Respuesta 1 Pregunta 10'),
    (10, 2, 'Respuesta 2 Pregunta 10'),
    (10, 3, 'Respuesta 3 Pregunta 10');

-- Actualizar la columna num_respuesta_correcta para que siempre sea 1
UPDATE Pregunta
SET num_respuesta_correcta = 1;

--Mostrar correcta
SELECT Pregunta.pregunta, Respuesta.texto_respuesta
FROM Pregunta
INNER JOIN Respuesta ON Pregunta.num_respuesta_correcta = Respuesta.num_respuesta AND Pregunta.id_pregunta = Respuesta.id_pregunta;

--transaccion para que se deshagan los cambios si hay un error, procedimiento almacenado para la serie de consultas 'exec'
