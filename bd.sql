-- Creación de la base de datos
CREATE DATABASE SistemaEscolar;
USE SistemaEscolar;

-- Creación de la tabla Administrador con el rol de superadmin o admin
CREATE TABLE Administrador (
    id_admin INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    correo VARCHAR(100) UNIQUE NOT NULL,
    contraseña VARCHAR(255) NOT NULL,
    rol ENUM('superadmin', 'admin') DEFAULT 'admin'
);

-- Creación de la tabla Docente
CREATE TABLE Docente (
    id_docente INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    usuario VARCHAR(50) UNIQUE NOT NULL,
    correo VARCHAR(100) UNIQUE NOT NULL,
    contraseña VARCHAR(255) NOT NULL,
    nivel_asignado VARCHAR(50) NOT NULL
);

-- Creación de la tabla Estudiante
CREATE TABLE Estudiante (
    id_estudiante INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    usuario VARCHAR(50) UNIQUE NOT NULL,
    correo VARCHAR(100) UNIQUE NOT NULL,
    contraseña VARCHAR(255) NOT NULL,
    nivel_matricula VARCHAR(50) NOT NULL
);

-- Creación de la tabla Materias
CREATE TABLE Materias (
    id_materia INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT
);

-- Creación de la tabla Niveles para los niveles de enseñanza
CREATE TABLE Niveles (
    id_nivel INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL
);

-- Creación de la tabla Matriculas para matricular estudiantes en materias
CREATE TABLE Matriculas (
    id_matricula INT AUTO_INCREMENT PRIMARY KEY,
    id_estudiante INT,
    id_materia INT,
    FOREIGN KEY (id_estudiante) REFERENCES Estudiante(id_estudiante),
    FOREIGN KEY (id_materia) REFERENCES Materias(id_materia)
);

-- Creación de la tabla Notas para registrar calificaciones de estudiantes
CREATE TABLE Notas (
    id_nota INT AUTO_INCREMENT PRIMARY KEY,
    id_estudiante INT,
    id_materia INT,
    calificacion DECIMAL(5, 2) NOT NULL,
    FOREIGN KEY (id_estudiante) REFERENCES Estudiante(id_estudiante),
    FOREIGN KEY (id_materia) REFERENCES Materias(id_materia)
);

-- Inserción de un superadministrador de ejemplo
INSERT INTO Administrador (nombre, correo, contraseña, rol) 
VALUES ('Juan Pérez', 'superadmin@colegio.com', MD5('password'), 'superadmin');

-- Inserción de los niveles de enseñanza de software
INSERT INTO Niveles (nombre) 
VALUES 
('Primero de Software'),
('Segundo de Software'),
('Tercero de Software'),
('Cuarto de Software'),
('Quinto de Software'),
('Sexto de Software'),
('Séptimo de Software'),
('Octavo de Software');

-- Inserción de materias por nivel de software
INSERT INTO Materias (nombre, descripcion) 
VALUES 
-- Primero de Software
('Introducción a la Programación', 'Fundamentos básicos de la programación'),
('Matemáticas Discretas', 'Lógica matemática aplicada a la informática'),
('Introducción a Bases de Datos', 'Conceptos iniciales sobre bases de datos'),
-- Segundo de Software
('Algoritmos y Estructuras de Datos', 'Estudio de algoritmos y su eficiencia'),
('Programación Orientada a Objetos', 'Conceptos avanzados de programación'),
('Base de Datos Relacionales', 'Diseño y modelado de bases de datos relacionales'),
-- Tercero de Software
('Sistemas Operativos', 'Funcionamiento de sistemas operativos'),
('Desarrollo Web I', 'Introducción al desarrollo de aplicaciones web'),
('Redes de Computadoras', 'Fundamentos de redes y protocolos de comunicación'),
-- Cuarto de Software
('Desarrollo Web II', 'Aplicaciones avanzadas en la web'),
('Ingeniería de Software', 'Ciclo de vida de desarrollo de software'),
('Base de Datos NoSQL', 'Introducción a bases de datos no relacionales'),
-- Quinto de Software
('Programación Avanzada', 'Patrones de diseño y buenas prácticas'),
('Arquitectura de Software', 'Diseño y arquitectura de sistemas de software'),
('Ciberseguridad', 'Seguridad en entornos informáticos'),
-- Sexto de Software
('Inteligencia Artificial', 'Introducción a IA y machine learning'),
('Desarrollo de Aplicaciones Móviles', 'Creación de aplicaciones para dispositivos móviles'),
('Cloud Computing', 'Computación en la nube y sus aplicaciones'),
-- Séptimo de Software
('DevOps', 'Integración continua y entrega de software'),
('Análisis de Datos', 'Estudio y procesamiento de grandes volúmenes de datos'),
('Proyectos de Software I', 'Desarrollo de proyectos reales en equipos'),
-- Octavo de Software
('Proyectos de Software II', 'Finalización y entrega de proyectos de software'),
('Auditoría de Sistemas', 'Auditoría y análisis de sistemas de información'),
('Tesis de Grado', 'Trabajo de investigación para titulación');
