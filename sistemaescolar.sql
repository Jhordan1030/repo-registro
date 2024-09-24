-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-09-2024 a las 19:10:59
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sistemaescolar`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administrador`
--

CREATE TABLE `administrador` (
  `id_admin` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `contraseña` varchar(255) NOT NULL,
  `rol` enum('superadmin','admin') DEFAULT 'admin'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `administrador`
--

INSERT INTO `administrador` (`id_admin`, `nombre`, `correo`, `contraseña`, `rol`) VALUES
(1, 'Juan Pérez', 'superadmin@colegio.com', '5f4dcc3b5aa765d61d8327deb882cf99', 'superadmin');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `docente`
--

CREATE TABLE `docente` (
  `id_docente` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `contraseña` varchar(255) NOT NULL,
  `nivel_asignado` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `docente`
--

INSERT INTO `docente` (`id_docente`, `nombre`, `usuario`, `correo`, `contraseña`, `nivel_asignado`) VALUES
(1, 'juan', 'juan', 'juan@docente.com', '81dc9bdb52d04dc20036dbd8313ed055', '1'),
(3, 'marco Pérez', 'marco', 'marco@docente.com', '81dc9bdb52d04dc20036dbd8313ed055', '2');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudiante`
--

CREATE TABLE `estudiante` (
  `id_estudiante` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `contraseña` varchar(255) NOT NULL,
  `nivel_matricula` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estudiante`
--

INSERT INTO `estudiante` (`id_estudiante`, `nombre`, `usuario`, `correo`, `contraseña`, `nivel_matricula`) VALUES
(1, 'Jhordan', 'Huera', 'jhordan@estududiante.com', '81dc9bdb52d04dc20036dbd8313ed055', '1'),
(2, 'María López', 'maria', 'maria@estudiante.com', '81dc9bdb52d04dc20036dbd8313ed055', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materias`
--

CREATE TABLE `materias` (
  `id_materia` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `id_nivel` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `materias`
--

INSERT INTO `materias` (`id_materia`, `nombre`, `descripcion`, `id_nivel`) VALUES
(1, 'Introducción a la Programación', 'Fundamentos básicos de la programación', 1),
(2, 'Matemáticas Discretas', 'Lógica matemática aplicada a la informática', 1),
(3, 'Introducción a Bases de Datos', 'Conceptos iniciales sobre bases de datos', 1),
(4, 'Algoritmos y Estructuras de Datos', 'Estudio de algoritmos y su eficiencia', 2),
(5, 'Programación Orientada a Objetos', 'Conceptos avanzados de programación', 2),
(6, 'Base de Datos Relacionales', 'Diseño y modelado de bases de datos relacionales', 2),
(7, 'Sistemas Operativos', 'Funcionamiento de sistemas operativos', 3),
(8, 'Desarrollo Web I', 'Introducción al desarrollo de aplicaciones web', 3),
(9, 'Redes de Computadoras', 'Fundamentos de redes y protocolos de comunicación', 3),
(10, 'Desarrollo Web II', 'Aplicaciones avanzadas en la web', 4),
(11, 'Ingeniería de Software', 'Ciclo de vida de desarrollo de software', 4),
(12, 'Base de Datos NoSQL', 'Introducción a bases de datos no relacionales', 4),
(13, 'Programación Avanzada', 'Patrones de diseño y buenas prácticas', 5),
(14, 'Arquitectura de Software', 'Diseño y arquitectura de sistemas de software', 5),
(15, 'Ciberseguridad', 'Seguridad en entornos informáticos', 5),
(16, 'Inteligencia Artificial', 'Introducción a IA y machine learning', 6),
(17, 'Desarrollo de Aplicaciones Móviles', 'Creación de aplicaciones para dispositivos móviles', 6),
(18, 'Cloud Computing', 'Computación en la nube y sus aplicaciones', 6),
(19, 'DevOps', 'Integración continua y entrega de software', 7),
(20, 'Análisis de Datos', 'Estudio y procesamiento de grandes volúmenes de datos', 7),
(21, 'Proyectos de Software I', 'Desarrollo de proyectos reales en equipos', 7),
(22, 'Proyectos de Software II', 'Finalización y entrega de proyectos de software', 8),
(23, 'Auditoría de Sistemas', 'Auditoría y análisis de sistemas de información', 8),
(24, 'Tesis de Grado', 'Trabajo de investigación para titulación', 8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `matriculas`
--

CREATE TABLE `matriculas` (
  `id_matricula` int(11) NOT NULL,
  `id_estudiante` int(11) DEFAULT NULL,
  `id_nivel` int(11) DEFAULT NULL,
  `id_materia` int(11) DEFAULT NULL,
  `estado` enum('habilitada','deshabilitada') DEFAULT 'habilitada'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `niveles`
--

CREATE TABLE `niveles` (
  `id_nivel` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `niveles`
--

INSERT INTO `niveles` (`id_nivel`, `nombre`) VALUES
(1, 'Primero de Software'),
(2, 'Segundo de Software'),
(3, 'Tercero de Software'),
(4, 'Cuarto de Software'),
(5, 'Quinto de Software'),
(6, 'Sexto de Software'),
(7, 'Séptimo de Software'),
(8, 'Octavo de Software');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notas`
--

CREATE TABLE `notas` (
  `id_nota` int(11) NOT NULL,
  `id_estudiante` int(11) DEFAULT NULL,
  `id_materia` int(11) DEFAULT NULL,
  `calificacion` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `notas`
--

INSERT INTO `notas` (`id_nota`, `id_estudiante`, `id_materia`, `calificacion`) VALUES
(1, 1, 1, 10),
(2, 2, 1, 5),
(3, 2, 2, 10);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administrador`
--
ALTER TABLE `administrador`
  ADD PRIMARY KEY (`id_admin`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- Indices de la tabla `docente`
--
ALTER TABLE `docente`
  ADD PRIMARY KEY (`id_docente`),
  ADD UNIQUE KEY `usuario` (`usuario`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- Indices de la tabla `estudiante`
--
ALTER TABLE `estudiante`
  ADD PRIMARY KEY (`id_estudiante`),
  ADD UNIQUE KEY `usuario` (`usuario`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- Indices de la tabla `materias`
--
ALTER TABLE `materias`
  ADD PRIMARY KEY (`id_materia`),
  ADD KEY `id_nivel` (`id_nivel`);

--
-- Indices de la tabla `matriculas`
--
ALTER TABLE `matriculas`
  ADD PRIMARY KEY (`id_matricula`),
  ADD KEY `id_estudiante` (`id_estudiante`),
  ADD KEY `id_nivel` (`id_nivel`),
  ADD KEY `id_materia` (`id_materia`);

--
-- Indices de la tabla `niveles`
--
ALTER TABLE `niveles`
  ADD PRIMARY KEY (`id_nivel`);

--
-- Indices de la tabla `notas`
--
ALTER TABLE `notas`
  ADD PRIMARY KEY (`id_nota`),
  ADD KEY `id_estudiante` (`id_estudiante`),
  ADD KEY `id_materia` (`id_materia`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `administrador`
--
ALTER TABLE `administrador`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `docente`
--
ALTER TABLE `docente`
  MODIFY `id_docente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `estudiante`
--
ALTER TABLE `estudiante`
  MODIFY `id_estudiante` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `materias`
--
ALTER TABLE `materias`
  MODIFY `id_materia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `matriculas`
--
ALTER TABLE `matriculas`
  MODIFY `id_matricula` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `niveles`
--
ALTER TABLE `niveles`
  MODIFY `id_nivel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `notas`
--
ALTER TABLE `notas`
  MODIFY `id_nota` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `materias`
--
ALTER TABLE `materias`
  ADD CONSTRAINT `materias_ibfk_1` FOREIGN KEY (`id_nivel`) REFERENCES `niveles` (`id_nivel`);

--
-- Filtros para la tabla `matriculas`
--
ALTER TABLE `matriculas`
  ADD CONSTRAINT `matriculas_ibfk_1` FOREIGN KEY (`id_estudiante`) REFERENCES `estudiante` (`id_estudiante`),
  ADD CONSTRAINT `matriculas_ibfk_2` FOREIGN KEY (`id_nivel`) REFERENCES `niveles` (`id_nivel`),
  ADD CONSTRAINT `matriculas_ibfk_3` FOREIGN KEY (`id_materia`) REFERENCES `materias` (`id_materia`);

--
-- Filtros para la tabla `notas`
--
ALTER TABLE `notas`
  ADD CONSTRAINT `notas_ibfk_1` FOREIGN KEY (`id_estudiante`) REFERENCES `estudiante` (`id_estudiante`),
  ADD CONSTRAINT `notas_ibfk_2` FOREIGN KEY (`id_materia`) REFERENCES `materias` (`id_materia`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
