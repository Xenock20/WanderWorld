-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-11-2023 a las 20:47:36
-- Versión del servidor: 8.0.33
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `wanderworld`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t_comentarios`
--

CREATE TABLE `t_comentarios` (
  `id_comentario` int NOT NULL,
  `id_publicacion` int NOT NULL,
  `id_perfil` int NOT NULL,
  `contenido` longtext NOT NULL,
  `fecha_comentario` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `t_comentarios`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t_followings`
--

CREATE TABLE `t_followings` (
  `id_following` int NOT NULL,
  `id_usuario_seguidor` int NOT NULL,
  `id_usuario_seguido` int NOT NULL,
  `fecha_seguimiento` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `t_followings`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t_fotos`
--

CREATE TABLE `t_fotos` (
  `id_foto` int NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `tipo_mime` varchar(100) NOT NULL,
  `imagen` longblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `t_fotos`
--
INSERT INTO `t_fotos` (`id_foto`, `nombre`, `tipo_mime`, `imagen`)
VALUES (
    1,
    'profile',
    'image/jpeg', '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');
-- --------------------------------------------------------
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t_likes`
--

CREATE TABLE `t_likes` (
  `id_like` int NOT NULL,
  `id_publicacion` int NOT NULL,
  `id_usuario` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `t_likes`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t_mapas`
--

CREATE TABLE `t_mapas` (
  `id_mapa` int NOT NULL,
  `latitud` decimal(10,6) NOT NULL,
  `longitud` decimal(10,6) NOT NULL,
  `id_publicacion` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t_perfil`
--

CREATE TABLE `t_perfil` (
  `id_perfil` int NOT NULL,
  `id_usuario` int NOT NULL,
  `id_foto` int NOT NULL DEFAULT '1',
  `nombre_completo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `comentario_boolean` tinyint NOT NULL DEFAULT '0',
  `info` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `t_perfil`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t_publicaciones`
--

CREATE TABLE `t_publicaciones` (
  `id_publicacion` int NOT NULL,
  `id_usuario` int NOT NULL,
  `contenido` longtext NOT NULL,
  `fecha_publicacion` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `t_publicaciones`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t_usuarios`
--

CREATE TABLE `t_usuarios` (
  `id_usuario` int NOT NULL,
  `correo` varchar(100) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `fecha_registro` timestamp NOT NULL,
  `pais` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `t_usuarios`
--

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `t_comentarios`
--
ALTER TABLE `t_comentarios`
  ADD PRIMARY KEY (`id_comentario`),
  ADD KEY `id_perfil` (`id_perfil`),
  ADD KEY `id_publicacion` (`id_publicacion`);

--
-- Indices de la tabla `t_followings`
--
ALTER TABLE `t_followings`
  ADD PRIMARY KEY (`id_following`),
  ADD KEY `id_usuario_seguido` (`id_usuario_seguido`),
  ADD KEY `id_usuario_seguidor` (`id_usuario_seguidor`);

--
-- Indices de la tabla `t_fotos`
--
ALTER TABLE `t_fotos`
  ADD PRIMARY KEY (`id_foto`);

--
-- Indices de la tabla `t_likes`
--
ALTER TABLE `t_likes`
  ADD PRIMARY KEY (`id_like`),
  ADD KEY `id_publicacion` (`id_publicacion`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `t_mapas`
--
ALTER TABLE `t_mapas`
  ADD PRIMARY KEY (`id_mapa`),
  ADD KEY `id_publicacion` (`id_publicacion`);

--
-- Indices de la tabla `t_perfil`
--
ALTER TABLE `t_perfil`
  ADD PRIMARY KEY (`id_perfil`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_foto` (`id_foto`);

--
-- Indices de la tabla `t_publicaciones`
--
ALTER TABLE `t_publicaciones`
  ADD PRIMARY KEY (`id_publicacion`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `t_usuarios`
--
ALTER TABLE `t_usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `t_comentarios`
--
ALTER TABLE `t_comentarios`
  MODIFY `id_comentario` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `t_followings`
--
ALTER TABLE `t_followings`
  MODIFY `id_following` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `t_fotos`
--
ALTER TABLE `t_fotos`
  MODIFY `id_foto` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `t_likes`
--
ALTER TABLE `t_likes`
  MODIFY `id_like` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `t_mapas`
--
ALTER TABLE `t_mapas`
  MODIFY `id_mapa` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `t_perfil`
--
ALTER TABLE `t_perfil`
  MODIFY `id_perfil` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `t_publicaciones`
--
ALTER TABLE `t_publicaciones`
  MODIFY `id_publicacion` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `t_usuarios`
--
ALTER TABLE `t_usuarios`
  MODIFY `id_usuario` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `t_comentarios`
--
ALTER TABLE `t_comentarios`
  ADD CONSTRAINT `t_comentarios_ibfk_1` FOREIGN KEY (`id_perfil`) REFERENCES `t_perfil` (`id_perfil`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `t_comentarios_ibfk_2` FOREIGN KEY (`id_publicacion`) REFERENCES `t_publicaciones` (`id_publicacion`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Filtros para la tabla `t_followings`
--
ALTER TABLE `t_followings`
  ADD CONSTRAINT `t_followings_ibfk_1` FOREIGN KEY (`id_usuario_seguido`) REFERENCES `t_usuarios` (`id_usuario`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `t_followings_ibfk_2` FOREIGN KEY (`id_usuario_seguidor`) REFERENCES `t_usuarios` (`id_usuario`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Filtros para la tabla `t_likes`
--
ALTER TABLE `t_likes`
  ADD CONSTRAINT `t_likes_ibfk_1` FOREIGN KEY (`id_publicacion`) REFERENCES `t_publicaciones` (`id_publicacion`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `t_likes_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `t_usuarios` (`id_usuario`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Filtros para la tabla `t_mapas`
--
ALTER TABLE `t_mapas`
  ADD CONSTRAINT `t_mapas_ibfk_1` FOREIGN KEY (`id_publicacion`) REFERENCES `t_publicaciones` (`id_publicacion`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Filtros para la tabla `t_perfil`
--
ALTER TABLE `t_perfil`
  ADD CONSTRAINT `t_perfil_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `t_usuarios` (`id_usuario`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `t_perfil_ibfk_2` FOREIGN KEY (`id_foto`) REFERENCES `t_fotos` (`id_foto`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Filtros para la tabla `t_publicaciones`
--
ALTER TABLE `t_publicaciones`
  ADD CONSTRAINT `t_publicaciones_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `t_usuarios` (`id_usuario`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

-- Primero, elimina la restricción actual
ALTER TABLE t_mapas DROP FOREIGN KEY t_mapas_ibfk_1;

-- Luego, agrega la restricción con ON DELETE CASCADE
ALTER TABLE t_mapas ADD CONSTRAINT t_mapas_ibfk_1
    FOREIGN KEY (id_publicacion)
    REFERENCES t_publicaciones (id_publicacion)
    ON DELETE CASCADE;

    -- Primero, elimina la restricción actual en t_comentarios
ALTER TABLE t_comentarios DROP FOREIGN KEY t_comentarios_ibfk_2;

-- Luego, agrega la restricción con ON DELETE CASCADE
ALTER TABLE t_comentarios ADD CONSTRAINT t_comentarios_ibfk_2
    FOREIGN KEY (id_publicacion)
    REFERENCES t_publicaciones (id_publicacion)
    ON DELETE CASCADE;

-- Primero, elimina la restricción actual en t_likes
ALTER TABLE t_likes DROP FOREIGN KEY t_likes_ibfk_1;

-- Luego, agrega la restricción con ON DELETE CASCADE
ALTER TABLE t_likes ADD CONSTRAINT t_likes_ibfk_1
    FOREIGN KEY (id_publicacion)
    REFERENCES t_publicaciones (id_publicacion)
    ON DELETE CASCADE;



/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;