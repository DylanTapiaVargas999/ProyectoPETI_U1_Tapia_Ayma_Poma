-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         10.4.27-MariaDB - mariadb.org binary distribution
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.4.0.6659
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
  `id_empresa` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_afrontar`),
  KEY `id_empresa` (`id_empresa`),
  CONSTRAINT `afrontar_ibfk_1` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id_empresa`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Volcando datos para la tabla bd_plan.afrontar: ~0 rows (aproximadamente)

-- Volcando estructura para tabla bd_plan.amenaza
CREATE TABLE IF NOT EXISTS `amenaza` (
  `id_amenaza` int(11) NOT NULL AUTO_INCREMENT,
  `amenaza` varchar(255) NOT NULL,
  `id_empresa` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_amenaza`),
  KEY `id_empresa` (`id_empresa`),
  CONSTRAINT `amenaza_ibfk_1` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id_empresa`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Volcando datos para la tabla bd_plan.amenaza: ~0 rows (aproximadamente)

-- Volcando estructura para tabla bd_plan.corregir
CREATE TABLE IF NOT EXISTS `corregir` (
  `id_corregir` int(11) NOT NULL AUTO_INCREMENT,
  `corregir` varchar(255) NOT NULL,
  `id_empresa` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_corregir`),
  KEY `id_empresa` (`id_empresa`),
  CONSTRAINT `corregir_ibfk_1` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id_empresa`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Volcando datos para la tabla bd_plan.corregir: ~0 rows (aproximadamente)

-- Volcando estructura para tabla bd_plan.debilidad
CREATE TABLE IF NOT EXISTS `debilidad` (
  `id_debilidad` int(11) NOT NULL AUTO_INCREMENT,
  `debilidad` varchar(255) NOT NULL,
  `id_empresa` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_debilidad`),
  KEY `id_empresa` (`id_empresa`),
  CONSTRAINT `debilidad_ibfk_1` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id_empresa`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Volcando datos para la tabla bd_plan.debilidad: ~0 rows (aproximadamente)

-- Volcando estructura para tabla bd_plan.empresa
CREATE TABLE IF NOT EXISTS `empresa` (
  `id_empresa` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `correo` varchar(255) NOT NULL,
  `clave` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_empresa`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Volcando datos para la tabla bd_plan.empresa: ~0 rows (aproximadamente)

-- Volcando estructura para tabla bd_plan.estrategia
CREATE TABLE IF NOT EXISTS `estrategia` (
  `id_estrategia` int(11) NOT NULL AUTO_INCREMENT,
  `estrategia` varchar(255) NOT NULL,
  `id_empresa` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_estrategia`),
  KEY `id_empresa` (`id_empresa`),
  CONSTRAINT `estrategia_ibfk_1` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id_empresa`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Volcando datos para la tabla bd_plan.estrategia: ~0 rows (aproximadamente)

-- Volcando estructura para tabla bd_plan.explotar
CREATE TABLE IF NOT EXISTS `explotar` (
  `id_explotar` int(11) NOT NULL AUTO_INCREMENT,
  `explotar` varchar(255) NOT NULL,
  `id_empresa` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_explotar`),
  KEY `id_empresa` (`id_empresa`),
  CONSTRAINT `explotar_ibfk_1` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id_empresa`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Volcando datos para la tabla bd_plan.explotar: ~0 rows (aproximadamente)

-- Volcando estructura para tabla bd_plan.fortaleza
CREATE TABLE IF NOT EXISTS `fortaleza` (
  `id_fortaleza` int(11) NOT NULL AUTO_INCREMENT,
  `fortaleza` varchar(255) NOT NULL,
  `id_empresa` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_fortaleza`),
  KEY `id_empresa` (`id_empresa`),
  CONSTRAINT `fortaleza_ibfk_1` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id_empresa`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Volcando datos para la tabla bd_plan.fortaleza: ~0 rows (aproximadamente)

-- Volcando estructura para tabla bd_plan.mantener
CREATE TABLE IF NOT EXISTS `mantener` (
  `id_mantener` int(11) NOT NULL AUTO_INCREMENT,
  `mantener` varchar(255) NOT NULL,
  `id_empresa` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_mantener`),
  KEY `id_empresa` (`id_empresa`),
  CONSTRAINT `mantener_ibfk_1` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id_empresa`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Volcando datos para la tabla bd_plan.mantener: ~0 rows (aproximadamente)

-- Volcando estructura para tabla bd_plan.mision
CREATE TABLE IF NOT EXISTS `mision` (
  `id_mision` int(11) NOT NULL AUTO_INCREMENT,
  `mision` varchar(255) NOT NULL,
  `id_empresa` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_mision`),
  KEY `id_empresa` (`id_empresa`),
  CONSTRAINT `mision_ibfk_1` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id_empresa`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Volcando datos para la tabla bd_plan.mision: ~0 rows (aproximadamente)

-- Volcando estructura para tabla bd_plan.objetivo_especifico
CREATE TABLE IF NOT EXISTS `objetivo_especifico` (
  `id_especifico` int(11) NOT NULL AUTO_INCREMENT,
  `objetivo` varchar(255) NOT NULL,
  `id_general` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_especifico`),
  KEY `id_general` (`id_general`),
  CONSTRAINT `objetivo_especifico_ibfk_1` FOREIGN KEY (`id_general`) REFERENCES `objetivo_general` (`id_general`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Volcando datos para la tabla bd_plan.objetivo_especifico: ~0 rows (aproximadamente)

-- Volcando estructura para tabla bd_plan.objetivo_general
CREATE TABLE IF NOT EXISTS `objetivo_general` (
  `id_general` int(11) NOT NULL AUTO_INCREMENT,
  `objetivo` varchar(255) NOT NULL,
  `id_empresa` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_general`),
  KEY `id_empresa` (`id_empresa`),
  CONSTRAINT `objetivo_general_ibfk_1` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id_empresa`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Volcando datos para la tabla bd_plan.objetivo_general: ~0 rows (aproximadamente)

-- Volcando estructura para tabla bd_plan.oportunidad
CREATE TABLE IF NOT EXISTS `oportunidad` (
  `id_oportunidad` int(11) NOT NULL AUTO_INCREMENT,
  `oportunidad` varchar(255) NOT NULL,
  `id_empresa` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_oportunidad`),
  KEY `id_empresa` (`id_empresa`),
  CONSTRAINT `oportunidad_ibfk_1` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id_empresa`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Volcando datos para la tabla bd_plan.oportunidad: ~0 rows (aproximadamente)

-- Volcando estructura para tabla bd_plan.producto
CREATE TABLE IF NOT EXISTS `producto` (
  `id_producto` int(11) NOT NULL,
  `producto` int(11) NOT NULL,
  `id_empresa` int(11) NOT NULL,
  `tcm20-21` float DEFAULT NULL,
  `tcm21-22` float DEFAULT NULL,
  `tcm22-23` float DEFAULT NULL,
  `tcm23-24` float DEFAULT NULL,
  `tcm24-25` float DEFAULT NULL,
  `CP_1` int(11) DEFAULT NULL,
  `CP_2` int(11) DEFAULT NULL,
  `CP_3` int(11) DEFAULT NULL,
  `CP_4` int(11) DEFAULT NULL,
  `CP_5` int(11) DEFAULT NULL,
  `CP_6` int(11) DEFAULT NULL,
  `CP_7` int(11) DEFAULT NULL,
  `CP_8` int(11) DEFAULT NULL,
  `CP_9` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_producto`),
  KEY `FK__empresa` (`id_empresa`),
  CONSTRAINT `FK__empresa` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id_empresa`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Volcando datos para la tabla bd_plan.producto: ~0 rows (aproximadamente)

-- Volcando estructura para tabla bd_plan.unidad_estrategia
CREATE TABLE IF NOT EXISTS `unidad_estrategia` (
  `id_unidad_estrategia` int(11) NOT NULL,
  `unidad_estrategia` varchar(50) DEFAULT NULL,
  `id_empresa` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_unidad_estrategia`),
  KEY `FK_unidad_estrategia_empresa` (`id_empresa`),
  CONSTRAINT `FK_unidad_estrategia_empresa` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id_empresa`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Volcando datos para la tabla bd_plan.unidad_estrategia: ~0 rows (aproximadamente)

-- Volcando estructura para tabla bd_plan.valores
CREATE TABLE IF NOT EXISTS `valores` (
  `id_valor` int(11) NOT NULL AUTO_INCREMENT,
  `valor` varchar(255) NOT NULL,
  `id_empresa` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_valor`),
  KEY `id_empresa` (`id_empresa`),
  CONSTRAINT `valores_ibfk_1` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id_empresa`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Volcando datos para la tabla bd_plan.valores: ~0 rows (aproximadamente)

-- Volcando estructura para tabla bd_plan.vision
CREATE TABLE IF NOT EXISTS `vision` (
  `id_vision` int(11) NOT NULL AUTO_INCREMENT,
  `vision` varchar(255) NOT NULL,
  `id_empresa` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_vision`),
  KEY `id_empresa` (`id_empresa`),
  CONSTRAINT `vision_ibfk_1` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id_empresa`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Volcando datos para la tabla bd_plan.vision: ~0 rows (aproximadamente)

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
