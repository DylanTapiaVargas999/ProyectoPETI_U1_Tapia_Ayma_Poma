-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         10.4.32-MariaDB - mariadb.org binary distribution
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.6.0.6765
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para bd_plan
CREATE DATABASE IF NOT EXISTS `bd_plan` /*!40100 DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci */;
USE `bd_plan`;

-- Volcando estructura para tabla bd_plan.afrontar
CREATE TABLE IF NOT EXISTS `afrontar` (
  `id_afrontar` int(11) NOT NULL AUTO_INCREMENT,
  `afrontar` varchar(255) NOT NULL,
  `codigo` varchar(10) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_afrontar`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `afrontar_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla bd_plan.amenaza
CREATE TABLE IF NOT EXISTS `amenaza` (
  `id_amenaza` int(11) NOT NULL AUTO_INCREMENT,
  `amenaza` varchar(255) NOT NULL,
  `codigo` varchar(10) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_amenaza`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `amenaza_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla bd_plan.corregir
CREATE TABLE IF NOT EXISTS `corregir` (
  `id_corregir` int(11) NOT NULL AUTO_INCREMENT,
  `corregir` varchar(255) NOT NULL,
  `codigo` varchar(10) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_corregir`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `corregir_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla bd_plan.debilidad
CREATE TABLE IF NOT EXISTS `debilidad` (
  `id_debilidad` int(11) NOT NULL AUTO_INCREMENT,
  `debilidad` varchar(255) NOT NULL,
  `codigo` varchar(10) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_debilidad`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `debilidad_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla bd_plan.estrategia
CREATE TABLE IF NOT EXISTS `estrategia` (
  `id_estrategia` int(11) NOT NULL AUTO_INCREMENT,
  `estrategia` varchar(255) NOT NULL,
  `codigo` varchar(10) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_estrategia`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `estrategia_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla bd_plan.explotar
CREATE TABLE IF NOT EXISTS `explotar` (
  `id_explotar` int(11) NOT NULL AUTO_INCREMENT,
  `explotar` varchar(255) NOT NULL,
  `codigo` varchar(10) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_explotar`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `explotar_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla bd_plan.fortaleza
CREATE TABLE IF NOT EXISTS `fortaleza` (
  `id_fortaleza` int(11) NOT NULL AUTO_INCREMENT,
  `fortaleza` varchar(255) NOT NULL,
  `codigo` varchar(10) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_fortaleza`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `fortaleza_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla bd_plan.mantener
CREATE TABLE IF NOT EXISTS `mantener` (
  `id_mantener` int(11) NOT NULL AUTO_INCREMENT,
  `mantener` varchar(255) NOT NULL,
  `codigo` varchar(10) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_mantener`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `mantener_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla bd_plan.mision
CREATE TABLE IF NOT EXISTS `mision` (
  `id_mision` int(11) NOT NULL AUTO_INCREMENT,
  `mision` varchar(255) NOT NULL,
  `codigo` varchar(10) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_mision`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `mision_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla bd_plan.objetivo_especifico
CREATE TABLE IF NOT EXISTS `objetivo_especifico` (
  `id_especifico` int(11) NOT NULL AUTO_INCREMENT,
  `objetivo` varchar(255) NOT NULL,
  `codigo` varchar(10) NOT NULL,
  `id_general` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_especifico`),
  KEY `id_general` (`id_general`),
  CONSTRAINT `objetivo_especifico_ibfk_1` FOREIGN KEY (`id_general`) REFERENCES `objetivo_general` (`id_general`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla bd_plan.objetivo_general
CREATE TABLE IF NOT EXISTS `objetivo_general` (
  `id_general` int(11) NOT NULL AUTO_INCREMENT,
  `objetivo` varchar(255) NOT NULL,
  `codigo` varchar(10) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_general`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `objetivo_general_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla bd_plan.oportunidad
CREATE TABLE IF NOT EXISTS `oportunidad` (
  `id_oportunidad` int(11) NOT NULL AUTO_INCREMENT,
  `oportunidad` varchar(255) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `codigo` varchar(10) NOT NULL,
  PRIMARY KEY (`id_oportunidad`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `oportunidad_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla bd_plan.plan_estrategico
CREATE TABLE IF NOT EXISTS `plan_estrategico` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(10) NOT NULL DEFAULT '0',
  `titulo` varchar(200) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK__usuario` (`id_usuario`),
  CONSTRAINT `FK__usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla bd_plan.uen
CREATE TABLE IF NOT EXISTS `uen` (
  `id_uen` int(11) NOT NULL AUTO_INCREMENT,
  `uen` varchar(255) NOT NULL,
  `codigo` varchar(10) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_uen`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `uen_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla bd_plan.usuario
CREATE TABLE IF NOT EXISTS `usuario` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(255) DEFAULT NULL,
  `correo` varchar(255) NOT NULL,
  `clave` varchar(255) NOT NULL,
  `rol` varchar(20) DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_correo` (`correo`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla bd_plan.valores
CREATE TABLE IF NOT EXISTS `valores` (
  `id_valor` int(11) NOT NULL AUTO_INCREMENT,
  `valor` varchar(255) NOT NULL,
  `codigo` varchar(10) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_valor`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `valores_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla bd_plan.vision
CREATE TABLE IF NOT EXISTS `vision` (
  `id_vision` int(11) NOT NULL AUTO_INCREMENT,
  `vision` varchar(255) NOT NULL,
  `codigo` varchar(10) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_vision`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `vision_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- La exportación de datos fue deseleccionada.

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
