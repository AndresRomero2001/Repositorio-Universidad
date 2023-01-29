-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 12, 2022 at 07:39 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.28

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `letseat`
--

--
-- Dumping data for table `categoria`
--

INSERT INTO `categoria` (`id`, `nombre`) VALUES
(7, 'batidos'),
(4, 'ensaladas'),
(1, 'entrantes'),
(5, 'especial de la casa'),
(6, 'postres'),
(2, 'primeros'),
(3, 'segundos');

--
-- Dumping data for table `horasreservas`
--

INSERT INTO `horasreservas` (`id`, `hora`) VALUES
(1, '13:00:00.00000'),
(2, '14:00:00.00000'),
(3, '15:00:00.00000'),
(4, '20:00:00.00000'),
(5, '21:00:00.00000'),
(6, '22:00:00.00000');

--
-- Dumping data for table `pedidos`
--

INSERT INTO `pedidos` (`id`, `fecha`, `id_usuario`, `direccion`, `estado`) VALUES
(3, '2022-04-29 12:04:00', 0, 'Calle de los Usuarios, 1', 'procesando'),
(4, '2022-05-29 12:05:00', 0, 'Calle de los Usuarios, 1', 'procesando'),
(5, '2022-05-29 12:21:00', 3, 'Calle de los Administradores, 1', 'entregado'),
(6, '2022-04-29 12:22:00', 0, 'Calle de los Usuarios, 1', 'procesando'),
(8, '2022-04-29 12:44:00', 0, 'Calle de los Usuarios, 1', 'procesando'),
(9, '2022-05-12 18:52:00', 8, 'asd', 'reparto'),
(10, '2022-05-12 19:04:00', 3, 'Calle de los Administradores, 1', 'preparando'),
(11, '2022-05-12 19:07:00', 3, 'Calle de los Administradores, 1', 'procesando');

--
-- Dumping data for table `platos`
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

--
-- Dumping data for table `platospedido`
--

INSERT INTO `platospedido` (`id`, `id_pedido`, `id_plato`, `num`) VALUES
(1, 3, 4, 3),
(2, 4, 1, 1),
(3, 4, 32, 1),
(4, 5, 6, 1),
(5, 5, 8, 1),
(6, 6, 3, 1),
(7, 6, 9, 1),
(8, 8, 31, 5),
(9, 9, 4, 1),
(10, 9, 7, 1),
(11, 9, 32, 1),
(12, 10, 1, 1),
(13, 10, 5, 1),
(14, 10, 8, 1),
(15, 10, 9, 1),
(16, 11, 1, 1);

--
-- Dumping data for table `reservas`
--

INSERT INTO `reservas` (`id`, `id_usuario`, `fecha`, `nPersonas`) VALUES
(3, 0, '2022-05-23 13:00:00', 19),
(29, 0, '2022-06-08 13:00:00', 7),
(33, 8, '2023-10-02 13:00:00', 9),
(34, 3, '2022-08-04 14:00:00', 5);

--
-- Dumping data for table `restaurante`
--

INSERT INTO `restaurante` (`id`, `capacidad`, `franjasHoras`) VALUES
(1, 30, 0);

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `contrasenia`, `rol`, `email`, `direccion`, `telefono`) VALUES
(0, 'user1', '$2y$10$sp5xF5tyD4gCVgnEb7HKieKrjCN2w9YBRti78zuyxJZseAZYwfgsO', 'Usuario', 'user1@gmail.com', 'Calle de los Usuarios, 1', 111111111),
(1, 'propietario', '$2y$10$2I0h3KvjlWCoUBK79lpW2uEUCfA7Z1mkrbn96m/kgAulS4zchmhhW', 'Propietario', 'prop1@gmail.com', 'Calle de los Propietarios, 1', 123456789),
(3, 'admin', '$2y$10$6iI6aeQSz7ll2537X8aGt.KTxUg8aZWAGYYuLlO9uQ8jblRW2L2la', 'Administrador', 'admin1@gmail.com', 'Calle de los Administradores, 1', 987654321),
(4, 'empleado1', '$2y$10$hzP7fmSv56h25.2hxsD/ZO3dGCrIBtKUlfWGrpN.J9Fd0KHLijopK', 'Empleado', 'empleado1@gmail.com', 'Calle de los Empleados, 1', 111111111),
(5, 'empleado2', '$2y$10$IpcBjAW30203/9S87CLYCuMLAkHznU4A8bixRUx5y66QTTPOAxPVS', 'Empleado', 'empleado2@gmail.com', 'Calle de los Empleados, 2', 222222222),
(6, 'empleado3', '$2y$10$Hq07gk0uW7xYGUmppvg9J.qcZS3GHyd/u6BlPvAnp4dnXDjac5jtG', 'Empleado', 'empleado3@gmail.com', 'Calle de los Empleados, 3', 333333333),
(7, 'user2', '$2y$10$jubKBgCXGpB8jsE5asUFv.XFPvG4sMWPar8wo95MQfD6ZyhyP4EA2', 'Usuario', 'user2@gmail.com', 'Calle de los Usuarios, 2', 222222222),
(8, 'asd', '$2y$10$qcdEILwFD1w4ZjCs9lqvJuTljguTiTUJs1stjQiKvWmzF4HeKun5W', 'Usuario', 'asd1@gmail.com', 'asd', 123123123),
(9, 'asd123', '$2y$10$iTyM2i1cCKL.fgJYsaU/W.5jWjx16.diu6FU8cddc6SJnz0w59zam', 'Empleado', 'asd2@gmail.com', 'asd', 123123123),
(11, 'asd3', '$2y$10$s.MM.fC1ESxjg3NeNercl.mt67BxzNrSrv6RgT0BRwoPoInFB/Jfe', 'Empleado', 'asd3@gmail.com', 'asd', 123123123);

--
-- Dumping data for table `valoraciones`
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
SET FOREIGN_KEY_CHECKS=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
