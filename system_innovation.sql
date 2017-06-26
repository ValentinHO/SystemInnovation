-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-02-2017 a las 19:41:18
-- Versión del servidor: 5.7.9
-- Versión de PHP: 5.6.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;

--
-- Base de datos: `system_innovation`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `markers`
--

DROP TABLE IF EXISTS `markers`;
CREATE TABLE IF NOT EXISTS `markers` (
  `si_id` int(11) NOT NULL AUTO_INCREMENT,
  `si_m_id` int(11) DEFAULT NULL,
  `si_lat` double DEFAULT NULL,
  `si_lon` double DEFAULT NULL,
  PRIMARY KEY (`si_id`),
  KEY `si_m_id` (`si_m_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `markers`
--

INSERT INTO `markers` (`si_id`, `si_m_id`, `si_lat`, `si_lon`) VALUES
(1, 1, 19.8430842, -98.976166),
(2, 2, 19.8431372, -98.9775118),
(3, 10, 19.8426931, -98.9775829),
(4, 11, 19.665678347, -98.43213456),
(7, 14, 234567, 234567);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mechanics`
--

DROP TABLE IF EXISTS `mechanics`;
CREATE TABLE IF NOT EXISTS `mechanics` (
  `si_id` int(11) NOT NULL AUTO_INCREMENT,
  `si_m_name` varchar(50) NOT NULL,
  `si_m_lastname` varchar(50) NOT NULL,
  `si_phone` varchar(15) NOT NULL,
  PRIMARY KEY (`si_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `mechanics`
--

INSERT INTO `mechanics` (`si_id`, `si_m_name`, `si_m_lastname`, `si_phone`) VALUES
(1, 'Pancho', 'Perez Jolote', '4455667799'),
(2, 'Alan', 'Legaria', '2200994403'),
(10, 'Miguel', 'Dominguez', '5566432789'),
(11, 'El nuevo', 'nuevo', '3254434565'),
(14, 'Jose Luis', 'Garcia Jimenez', '4455678890');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reports`
--

DROP TABLE IF EXISTS `reports`;
CREATE TABLE IF NOT EXISTS `reports` (
  `si_id` int(11) NOT NULL AUTO_INCREMENT,
  `si_m_id` int(11) NOT NULL,
  `si_service` int(11) NOT NULL,
  `si_one_star` int(11) NOT NULL,
  `si_two_star` int(11) NOT NULL,
  `si_three_star` int(11) NOT NULL,
  `si_four_star` int(11) NOT NULL,
  `si_five_star` int(11) NOT NULL,
  `fec_last_solicited` timestamp NOT NULL,
  PRIMARY KEY (`si_id`),
  KEY `si_m_id` (`si_m_id`),
  KEY `si_service` (`si_service`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `reports`
--

INSERT INTO `reports` (`si_id`, `si_m_id`, `si_service`, `si_one_star`, `si_two_star`, `si_three_star`, `si_four_star`, `si_five_star`, `fec_last_solicited`) VALUES
(1, 1, 1, 5, 0, 0, 0, 8, '2017-02-04 20:27:06'),
(2, 2, 7, 4, 0, 0, 6, 0, '2017-02-05 23:22:44'),
(4, 10, 12, 4, 0, 0, 8, 0, '2017-02-05 23:18:00'),
(5, 1, 3, 0, 0, 0, 0, 9, '2017-02-12 17:22:23');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `services`
--

DROP TABLE IF EXISTS `services`;
CREATE TABLE IF NOT EXISTS `services` (
  `si_id` int(11) NOT NULL AUTO_INCREMENT,
  `si_service` varchar(150) NOT NULL,
  PRIMARY KEY (`si_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `services`
--

INSERT INTO `services` (`si_id`, `si_service`) VALUES
(1, 'Cambio de llantas'),
(2, 'Cambio de aceite y filtros'),
(3, 'Reparación y rectificación de motores'),
(4, 'Cambio de correas de distribución'),
(5, 'Reparación y carga de aire acondicionado'),
(6, 'Suspensión, alineación y balanceo'),
(7, 'Limpiado y calibración de inyectores electrónicos'),
(8, 'Frenos'),
(9, 'Carburación'),
(10, 'Reparación de alternadores'),
(11, 'Afinación completa'),
(12, 'Cambio de bujías');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `service_mechanic`
--

DROP TABLE IF EXISTS `service_mechanic`;
CREATE TABLE IF NOT EXISTS `service_mechanic` (
  `si_id` int(11) NOT NULL AUTO_INCREMENT,
  `service_id` int(11) NOT NULL,
  `mechanic_id` int(11) NOT NULL,
  PRIMARY KEY (`si_id`),
  KEY `service_id` (`service_id`),
  KEY `mechanic_id` (`mechanic_id`)
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `service_mechanic`
--

INSERT INTO `service_mechanic` (`si_id`, `service_id`, `mechanic_id`) VALUES
(6, 6, 2),
(7, 7, 2),
(8, 8, 2),
(9, 9, 2),
(10, 10, 2),
(11, 5, 10),
(12, 3, 10),
(13, 11, 10),
(14, 12, 10),
(15, 1, 10),
(16, 3, 14),
(17, 5, 14),
(18, 8, 14),
(19, 11, 14),
(95, 1, 1),
(96, 2, 1),
(97, 7, 11),
(98, 8, 11),
(99, 9, 11),
(100, 11, 11);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tips`
--

DROP TABLE IF EXISTS `tips`;
CREATE TABLE IF NOT EXISTS `tips` (
  `si_folio` int(11) NOT NULL AUTO_INCREMENT,
  `si_t_name` varchar(100) NOT NULL,
  `si_description` text NOT NULL,
  PRIMARY KEY (`si_folio`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tips`
--

INSERT INTO `tips` (`si_folio`, `si_t_name`, `si_description`) VALUES
(1, 'Cambio de llantas', 'Paso 1: Hacer esto.\nPaso 2: Hacer aquello.\nPaso 3: Hacer esto otro.\nPaso 4: Finalmente haz esto.'),
(3, 'Cambio de aceite', 'Paso 1: Abra el cofre.\r\nPaso 2: Visualice.\r\nPaso 3: Cambie aceite.'),
(4, 'otro tip', 'paso 1: aqui\r\npaso 2: asi\r\npaso 3:aca');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `si_id` int(11) NOT NULL AUTO_INCREMENT,
  `si_username` varchar(30) NOT NULL,
  `si_password` varchar(50) NOT NULL,
  `si_firstname` varchar(50) NOT NULL,
  `si_lastname` varchar(50) NOT NULL,
  PRIMARY KEY (`si_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`si_id`, `si_username`, `si_password`, `si_firstname`, `si_lastname`) VALUES
(1, 'admin', 'Admin123456.', 'Administrador', 'del Sistema');

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `markers`
--
ALTER TABLE `markers`
  ADD CONSTRAINT `markers_ibfk_1` FOREIGN KEY (`si_m_id`) REFERENCES `mechanics` (`si_id`);

--
-- Filtros para la tabla `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `reports_ibfk_1` FOREIGN KEY (`si_m_id`) REFERENCES `mechanics` (`si_id`),
  ADD CONSTRAINT `reports_ibfk_2` FOREIGN KEY (`si_service`) REFERENCES `services` (`si_id`);

--
-- Filtros para la tabla `service_mechanic`
--
ALTER TABLE `service_mechanic`
  ADD CONSTRAINT `service_mechanic_ibfk_1` FOREIGN KEY (`service_id`) REFERENCES `services` (`si_id`),
  ADD CONSTRAINT `service_mechanic_ibfk_2` FOREIGN KEY (`mechanic_id`) REFERENCES `mechanics` (`si_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
