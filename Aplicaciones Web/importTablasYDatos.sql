-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-05-2022 a las 12:18:15
-- Versión del servidor: 10.4.22-MariaDB
-- Versión de PHP: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `letseat`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `id` int(10) NOT NULL,
  `nombre` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`id`, `nombre`) VALUES
(7, 'batidos'),
(4, 'ensaladas'),
(1, 'entrantes'),
(5, 'especial de la casa'),
(6, 'postres'),
(2, 'primeros'),
(3, 'segundos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horasreservas`
--

CREATE TABLE `horasreservas` (
  `id` int(10) NOT NULL,
  `hora` time(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `horasreservas`
--

INSERT INTO `horasreservas` (`id`, `hora`) VALUES
(1, '13:00:00.00000'),
(2, '14:00:00.00000'),
(3, '15:00:00.00000'),
(4, '20:00:00.00000'),
(5, '21:00:00.00000'),
(6, '22:00:00.00000');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(10) NOT NULL,
  `fecha` datetime NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `direccion` varchar(32) NOT NULL,
  `estado` enum('procesando','preparando','reparto','entregado') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id`, `fecha`, `id_usuario`, `direccion`, `estado`) VALUES
(3, '2022-04-29 12:04:00', 0, 'Calle de los Usuarios, 1', 'procesando'),
(4, '2022-05-29 12:05:00', 0, 'Calle de los Usuarios, 1', 'procesando'),
(5, '2022-05-29 12:21:00', 3, 'Calle de los Administradores, 1', 'procesando'),
(6, '2022-04-29 12:22:00', 0, 'Calle de los Usuarios, 1', 'procesando'),
(8, '2022-04-29 12:44:00', 0, 'Calle de los Usuarios, 1', 'procesando');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `platos`
--

CREATE TABLE `platos` (
  `id` int(10) NOT NULL,
  `foto` varchar(32) NOT NULL,
  `nombre` varchar(32) NOT NULL,
  `precio` float NOT NULL,
  `descripcion` text NOT NULL,
  `id_categoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `platos`
--

INSERT INTO `platos` (`id`, `foto`, `nombre`, `precio`, `descripcion`, `id_categoria`) VALUES
(1, 'bravas.jpg', 'bravas', 7.95, 'Las mejores patatas bravas de Madrid, con su salsita picante y un toque crujiente', 1),
(2, 'chuleton.jpg', 'chuletón de rubia gallega', 22.5, 'El mejor chuletón calidad-precio de España, premiado en el 1898 como mejor distracción para el fracaso.', 3),
(3, 'cachopo.webp', 'cachopo', 17, 'El auténtico cachopo asturiano, sin escatimar en cantidades, con muuucho queso fundido y un jamón serrano que le va como anillo al dedo', 3),
(4, 'batidoChocolate.jpg', 'batido de chocolate', 4.01, 'Te quedarás con ganas de pedir más, y no será por la cantidad!!', 7),
(5, 'ensaladaCesar.webp', 'ensalada césar', 9.99, 'La ensalada favorita del célebre asesino Marco Bruto, quien la califica como \r\n\"La mejor ensalada del Imperio, me hace sentir fino y elegante, a la par que sano; justo lo que necesitaba para complementar a alguien como yo\"', 4),
(6, 'poke.jpg', 'poke vegetariano', 39.99, 'Lo que está de moda, te estafamos pero no mucho, prometemos que la cantidad te llenará un poco.', 4),
(7, 'torta.jpg', 'torta de la casa', 8.99, 'No la regalamos porque no nos dejan.\r\nTe la llevamos a la mesa y te la servimos bien dada.\r\nAcompañada con helado de vainilla y un vaso de leche.', 6),
(8, 'coulant.jpg', 'coulant de chocolate', 4.95, 'Coulant de chocolate, o fondant, o volcano, o soffiato, o como mierdas se llame en tu restaurante pijo de referencia', 6),
(9, 'sopa.jpg', 'sopa', 3.95, 'La mejor sopa calidad precio. La clave está en muy poca calidad y un buen precio.\r\nLa elaboramos con nuestra mejor agua del grifo de Madrid y con las sobras de la nevera. \r\nDisfruta de la sopa avalada por Mateo como \"la mejor del restaurante, además de la única\"', 2),
(10, 'chickenTenders.webp', 'naki, chicken teriyaki', 9, 'Disfruta de nuestros chicken fingers con salsa teriyaki al estilo japonés. Inicialmente creados para naki, posteriormente elaborados \"pa\' ti\"', 1),
(31, 'batidoDeFresa.jpg', 'batido de fresa', 4.99, 'Batido de fresa y avena bajo en azúcares', 7),
(32, 'cocido.jpg', 'Cocido madrileño', 14, 'El cocido típico de Madrid. Receta insuperable heredada de la abuela del propietario', 5),
(33, 'batidoOreo.jpg', 'Batido de oreo', 4.99, 'Batido de oreo, coronado con helado de nata y con trozos de galleta', 7),
(34, 'batidoCaramelo.jpg', 'Batido de caramelo', 4, 'Batido de caramelo, ¡Para los amantes del dulce dulce!', 7),
(35, 'batidoTurron.jpeg', 'Batido de turrón', 4, 'Batido de turrón con sabor a ecológico (realizado con todas las sobras de turrón de Navidad)', 7),
(36, 'batidoVainilla.jpg', 'Batido de vainilla', 3, 'Batido simple pero riquísimo, perfecto para acompañar nuestro postre de chocolate más típico.', 7),
(37, 'granizadoLimon.webp', 'Granizado de limón', 5, 'La mejor bebida para soportar el calor del verano, muy frío y refrescante', 7),
(38, 'granizadoCafe.jpg', 'Granizado de café', 5, 'Perfecto para despertarte tras una comida veraniega que te ha dejado sudando!', 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `platospedido`
--

CREATE TABLE `platospedido` (
  `id` int(11) NOT NULL,
  `id_pedido` int(11) NOT NULL,
  `id_plato` int(11) NOT NULL,
  `num` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `platospedido`
--

INSERT INTO `platospedido` (`id`, `id_pedido`, `id_plato`, `num`) VALUES
(1, 3, 4, 3),
(2, 4, 1, 1),
(3, 4, 32, 1),
(4, 5, 6, 1),
(5, 5, 8, 1),
(6, 6, 3, 1),
(7, 6, 9, 1),
(8, 8, 31, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservas`
--

CREATE TABLE `reservas` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `nPersonas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `reservas`
--

INSERT INTO `reservas` (`id`, `id_usuario`, `fecha`, `nPersonas`) VALUES
(3, 0, '2022-05-22 13:00:00', 9),
(4, 3, '2022-05-23 13:00:00', 7),
(29, 0, '2022-06-08 13:00:00', 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `restaurante`
--

CREATE TABLE `restaurante` (
  `id` int(10) NOT NULL,
  `capacidad` int(10) NOT NULL,
  `franjasHoras` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `restaurante`
--

INSERT INTO `restaurante` (`id`, `capacidad`, `franjasHoras`) VALUES
(1, 20, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `contrasenia` varchar(255) NOT NULL,
  `rol` enum('Administrador','Propietario','Empleado','Usuario') NOT NULL,
  `email` varchar(32) NOT NULL,
  `direccion` varchar(64) NOT NULL,
  `telefono` int(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `contrasenia`, `rol`, `email`, `direccion`, `telefono`) VALUES
(0, 'user1', '$2y$10$sp5xF5tyD4gCVgnEb7HKieKrjCN2w9YBRti78zuyxJZseAZYwfgsO', 'Usuario', 'user1@gmail.com', 'Calle de los Usuarios, 1', 111111111),
(1, 'propietario', '$2y$10$2I0h3KvjlWCoUBK79lpW2uEUCfA7Z1mkrbn96m/kgAulS4zchmhhW', 'Propietario', 'prop1@gmail.com', 'Calle de los Propietarios, 1', 123456789),
(3, 'admin', '$2y$10$6iI6aeQSz7ll2537X8aGt.KTxUg8aZWAGYYuLlO9uQ8jblRW2L2la', 'Administrador', 'admin1@gmail.com', 'Calle de los Administradores, 1', 987654321),
(4, 'empleado1', '$2y$10$hzP7fmSv56h25.2hxsD/ZO3dGCrIBtKUlfWGrpN.J9Fd0KHLijopK', 'Empleado', 'empleado1@gmail.com', 'Calle de los Empleados, 1', 111111111),
(5, 'empleado2', '$2y$10$IpcBjAW30203/9S87CLYCuMLAkHznU4A8bixRUx5y66QTTPOAxPVS', 'Empleado', 'empleado2@gmail.com', 'Calle de los Empleados, 2', 222222222),
(6, 'empleado3', '$2y$10$Hq07gk0uW7xYGUmppvg9J.qcZS3GHyd/u6BlPvAnp4dnXDjac5jtG', 'Empleado', 'empleado3@gmail.com', 'Calle de los Empleados, 3', 333333333),
(7, 'user2', '$2y$10$jubKBgCXGpB8jsE5asUFv.XFPvG4sMWPar8wo95MQfD6ZyhyP4EA2', 'Usuario', 'user2@gmail.com', 'Calle de los Usuarios, 2', 222222222);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `valoraciones`
--

CREATE TABLE `valoraciones` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_plato` int(11) NOT NULL,
  `valoracion` int(11) NOT NULL,
  `descripcion` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `valoraciones`
--

INSERT INTO `valoraciones` (`id`, `id_usuario`, `id_plato`, `valoracion`, `descripcion`) VALUES
(1, 0, 31, 4, 'Delicioso, lo pediría 40 veces más'),
(2, 0, 4, 5, 'A mis hijos les ha encantado!!\r\n'),
(3, 0, 6, 3, 'Sano y pero no muy rico, no se puede pedir más'),
(4, 0, 2, 2, 'Regular la verdad'),
(5, 0, 7, 1, 'Ni a mi perro se lo daría...'),
(6, 7, 7, 2, 'Estaba insípida, como comer cartón'),
(7, 7, 2, 4, 'Parecía mantequilla!!'),
(8, 7, 6, 4, 'Se nota que es sano y no está nada mal');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `horasreservas`
--
ALTER TABLE `horasreservas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario` (`id_usuario`);

--
-- Indices de la tabla `platos`
--
ALTER TABLE `platos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categoria` (`id_categoria`);

--
-- Indices de la tabla `platospedido`
--
ALTER TABLE `platospedido`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pedido` (`id_pedido`),
  ADD KEY `id_plato` (`id_plato`);

--
-- Indices de la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`id_usuario`);

--
-- Indices de la tabla `restaurante`
--
ALTER TABLE `restaurante`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indices de la tabla `valoraciones`
--
ALTER TABLE `valoraciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_plato` (`id_plato`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `horasreservas`
--
ALTER TABLE `horasreservas`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `platos`
--
ALTER TABLE `platos`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT de la tabla `platospedido`
--
ALTER TABLE `platospedido`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `reservas`
--
ALTER TABLE `reservas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `restaurante`
--
ALTER TABLE `restaurante`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `valoraciones`
--
ALTER TABLE `valoraciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `platos`
--
ALTER TABLE `platos`
  ADD CONSTRAINT `platos_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categoria` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `platospedido`
--
ALTER TABLE `platospedido`
  ADD CONSTRAINT `platospedido_ibfk_1` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `platospedido_ibfk_2` FOREIGN KEY (`id_plato`) REFERENCES `platos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD CONSTRAINT `reservas_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `valoraciones`
--
ALTER TABLE `valoraciones`
  ADD CONSTRAINT `valoraciones_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `valoraciones_ibfk_2` FOREIGN KEY (`id_plato`) REFERENCES `platos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
