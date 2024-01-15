-- MariaDB dump 10.19  Distrib 10.4.24-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: delipan
-- ------------------------------------------------------
-- Server version	10.4.24-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `boleta`
--

DROP TABLE IF EXISTS `boleta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `boleta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha_emision` date NOT NULL,
  `hora_emision` time NOT NULL,
  `metodo_pago` varchar(10) NOT NULL,
  `monto_total` decimal(8,2) NOT NULL,
  `empleado` varchar(100) NOT NULL,
  `estado` bit(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `boleta`
--

LOCK TABLES `boleta` WRITE;
/*!40000 ALTER TABLE `boleta` DISABLE KEYS */;
/*!40000 ALTER TABLE `boleta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categoria_producto`
--

DROP TABLE IF EXISTS `categoria_producto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categoria_producto` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `categoria` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categoria_producto`
--

LOCK TABLES `categoria_producto` WRITE;
/*!40000 ALTER TABLE `categoria_producto` DISABLE KEYS */;
INSERT INTO `categoria_producto` VALUES (1,'panes'),(2,'abarrotes');
/*!40000 ALTER TABLE `categoria_producto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `denominacion`
--

DROP TABLE IF EXISTS `denominacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `denominacion` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `denominacion` decimal(5,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `denominacion`
--

LOCK TABLES `denominacion` WRITE;
/*!40000 ALTER TABLE `denominacion` DISABLE KEYS */;
INSERT INTO `denominacion` VALUES (1,0.10),(2,0.20),(3,0.50),(4,1.00),(5,2.00),(6,5.00),(7,10.00),(8,20.00),(9,50.00),(10,100.00),(11,200.00);
/*!40000 ALTER TABLE `denominacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detalle_boleta`
--

DROP TABLE IF EXISTS `detalle_boleta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `detalle_boleta` (
  `id_boleta` int(11) NOT NULL,
  `codigo_producto` varchar(4) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `monto_parcial` decimal(8,2) NOT NULL,
  KEY `codigo_producto` (`codigo_producto`),
  KEY `id_boleta` (`id_boleta`),
  CONSTRAINT `detalle_boleta_ibfk_1` FOREIGN KEY (`id_boleta`) REFERENCES `boleta` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `detalle_boleta_ibfk_2` FOREIGN KEY (`codigo_producto`) REFERENCES `producto` (`codigo`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detalle_boleta`
--

LOCK TABLES `detalle_boleta` WRITE;
/*!40000 ALTER TABLE `detalle_boleta` DISABLE KEYS */;
/*!40000 ALTER TABLE `detalle_boleta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detalle_reclamo`
--

DROP TABLE IF EXISTS `detalle_reclamo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `detalle_reclamo` (
  `id_reclamo` int(11) NOT NULL,
  `codigo_producto` varchar(4) NOT NULL,
  `cantidad` int(11) NOT NULL,
  KEY `id_reclamo` (`id_reclamo`,`codigo_producto`),
  KEY `codigo_producto` (`codigo_producto`),
  CONSTRAINT `detalle_reclamo_ibfk_1` FOREIGN KEY (`id_reclamo`) REFERENCES `reclamo` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `detalle_reclamo_ibfk_2` FOREIGN KEY (`codigo_producto`) REFERENCES `producto` (`codigo`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detalle_reclamo`
--

LOCK TABLES `detalle_reclamo` WRITE;
/*!40000 ALTER TABLE `detalle_reclamo` DISABLE KEYS */;
/*!40000 ALTER TABLE `detalle_reclamo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detalle_reporte_boletas`
--

DROP TABLE IF EXISTS `detalle_reporte_boletas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `detalle_reporte_boletas` (
  `id_reporte` int(11) NOT NULL,
  `id_boleta` int(11) NOT NULL,
  `monto_parcial` decimal(8,2) NOT NULL,
  KEY `id_reporte` (`id_reporte`),
  KEY `id_boleta` (`id_boleta`),
  CONSTRAINT `detalle_reporte_boletas_ibfk_1` FOREIGN KEY (`id_boleta`) REFERENCES `boleta` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `detalle_reporte_boletas_ibfk_2` FOREIGN KEY (`id_reporte`) REFERENCES `reporte_boletas` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detalle_reporte_boletas`
--

LOCK TABLES `detalle_reporte_boletas` WRITE;
/*!40000 ALTER TABLE `detalle_reporte_boletas` DISABLE KEYS */;
/*!40000 ALTER TABLE `detalle_reporte_boletas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detalle_reporte_caja`
--

DROP TABLE IF EXISTS `detalle_reporte_caja`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `detalle_reporte_caja` (
  `id_reporte` int(11) NOT NULL,
  `id_denominacion` tinyint(4) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `monto_parcial` decimal(8,2) NOT NULL,
  KEY `id_reporte` (`id_reporte`),
  KEY `id_denominacion` (`id_denominacion`) USING BTREE,
  CONSTRAINT `detalle_reporte_caja_ibfk_1` FOREIGN KEY (`id_reporte`) REFERENCES `reporte_caja` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `detalle_reporte_caja_ibfk_2` FOREIGN KEY (`id_denominacion`) REFERENCES `denominacion` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detalle_reporte_caja`
--

LOCK TABLES `detalle_reporte_caja` WRITE;
/*!40000 ALTER TABLE `detalle_reporte_caja` DISABLE KEYS */;
/*!40000 ALTER TABLE `detalle_reporte_caja` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grupo_privilegio`
--

DROP TABLE IF EXISTS `grupo_privilegio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `grupo_privilegio` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `grupo` varchar(50) NOT NULL,
  `icono` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grupo_privilegio`
--

LOCK TABLES `grupo_privilegio` WRITE;
/*!40000 ALTER TABLE `grupo_privilegio` DISABLE KEYS */;
INSERT INTO `grupo_privilegio` VALUES (1,'ventas','<i class=\"fa-solid fa-file-invoice-dollar\"></i>'),(2,'inventario','<i class=\"fa-solid fa-box\"></i>'),(3,'usuario','<i class=\"fa-solid fa-users-gear\"></i>');
/*!40000 ALTER TABLE `grupo_privilegio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pregunta_seguridad`
--

DROP TABLE IF EXISTS `pregunta_seguridad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pregunta_seguridad` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `pregunta` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pregunta_seguridad`
--

LOCK TABLES `pregunta_seguridad` WRITE;
/*!40000 ALTER TABLE `pregunta_seguridad` DISABLE KEYS */;
INSERT INTO `pregunta_seguridad` VALUES (1,'¿Primer nombre de tu madre?'),(2,'¿Color favorito?'),(3,'¿Mes de tu cumpleaños?'),(4,'¿Cuántos hermanos tienes?'),(5,'¿Ciudad de nacimiento?'),(6,'¿Nombre de tu primera mascota?'),(7,'¿Animal favorito?'),(8,'¿En qué año terminaste la secundaria?'),(9,'¿Película favorita?'),(10,'¿Nombre de tu abuelo paterno?');
/*!40000 ALTER TABLE `pregunta_seguridad` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `privilegio`
--

DROP TABLE IF EXISTS `privilegio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `privilegio` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `ruta` varchar(100) NOT NULL,
  `archivo_ajax` varchar(50) NOT NULL,
  `archivo_css` varchar(50) NOT NULL,
  `id_grupo` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_grupo` (`id_grupo`),
  CONSTRAINT `privilegio_ibfk_1` FOREIGN KEY (`id_grupo`) REFERENCES `grupo_privilegio` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `privilegio`
--

LOCK TABLES `privilegio` WRITE;
/*!40000 ALTER TABLE `privilegio` DISABLE KEYS */;
INSERT INTO `privilegio` VALUES (1,'Emitir boleta','../salesModule/IndexEmitirBoleta.php','GetEmitirBoletaData.js','styles_formEmitirBoleta.css',1),(2,'Atender boleta','../salesModule/IndexAtenderBoleta.php','GetAtenderBoletaData.js','styles_formAtenderBoleta.css',1),(3,'Cierre de caja','../salesModule/IndexCierreCaja.php','GetCierreCajaData.js','styles_formCierreCaja.css',1),(4,'Atención al reclamo','../salesModule/IndexAtencionReclamo.php','GetAtencionReclamoData.js','styles_formAtencionReclamo.css',1),(5,'Informe de inventario','../salesModule/IndexInformeInventario.php','GetInformeInventarioData.js','styles_formInformeInventario.css',2),(6,'Informe de mercadería recepcionada','../salesModule/IndexInformeMercaderiaRecepcionada.php','GetInformeMercaderiaRecepcionadaData.js','styles_formInformeMercaderiaRecepcionada.css',2),(7,'Gestionar usuarios','../userModule/IndexGestionarUsuarios.php','GetGestionarUsuariosData.js','styles_formGestionarUsuarios.css',3);
/*!40000 ALTER TABLE `privilegio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `producto`
--

DROP TABLE IF EXISTS `producto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `producto` (
  `codigo` varchar(4) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `stock` int(11) NOT NULL,
  `precio` decimal(8,2) NOT NULL,
  `id_categoria` tinyint(4) NOT NULL,
  `minimo` tinyint(4) NOT NULL,
  `estado` bit(1) NOT NULL,
  PRIMARY KEY (`codigo`),
  KEY `id_categoria` (`id_categoria`),
  CONSTRAINT `producto_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categoria_producto` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `producto`
--

LOCK TABLES `producto` WRITE;
/*!40000 ALTER TABLE `producto` DISABLE KEYS */;
INSERT INTO `producto` VALUES ('A001','Salchicha Huachana',40,3.00,2,5,''),('A002','Jamonada Suiza de pollo',16,3.00,2,6,''),('A003','Jamonada Suiza especial',15,3.50,2,6,''),('A004','Chicharrón de prensa Suiza',12,4.00,2,6,''),('A005','Jamonada San Fernando de pollo',45,1.60,2,12,''),('A006','Jamonada San Fernando de pavita',12,2.00,2,3,''),('A007','Chicharrón de prensa San Fernando',24,3.20,2,6,''),('A008','Jamonada Cerdeña Tradicional',48,1.50,2,10,''),('A009','Chicharrón de prensa Cerdeña',36,3.00,2,10,''),('A010','Mantequilla Gloria 90 gr',0,6.50,2,4,''),('A011','Mantequilla Swis 90 gr',10,3.00,2,4,''),('A012','Mantequilla Laive 100 gr',9,6.50,2,4,''),('A013','Mantequilla Sello de Oro 90 gr',24,3.00,2,6,''),('A014','Mantequilla Sello de Oro 45 gr',36,1.50,2,12,''),('A015','Leche Gloria en bolsa',8,5.50,2,3,''),('A016','Leche Bonlé en bolsa',8,5.00,2,3,''),('A017','Leche Vigor en bolsa',8,5.00,2,3,''),('A018','Leche La Preferida en bolsa',8,4.50,2,3,''),('A019','Queso Edam Laive 90 gr',12,6.00,2,3,''),('A020','Queso fundido Bonlé 136 gr',12,7.00,2,4,''),('A021','Pack jamón sandwich y queso Edam San Fernando 180 gr',6,7.50,2,3,''),('P001','Pan francés',29,0.25,1,20,''),('P002','Pan Ciabatta',130,0.25,1,72,''),('P003','Pan Caracol',150,0.25,1,48,''),('P004','Pan Colisa',144,0.25,1,48,''),('P005','Pan de maíz',0,0.25,1,10,''),('P006','Pan de yema redondo',48,0.25,1,12,''),('P007','Pan de yema largo',24,0.25,1,10,''),('P008','Pan Chapla',48,0.25,1,12,''),('P009','Pan de manjar',24,0.50,1,8,'');
/*!40000 ALTER TABLE `producto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reclamo`
--

DROP TABLE IF EXISTS `reclamo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reclamo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha_registro` date NOT NULL,
  `hora_registro` time NOT NULL,
  `detalles` varchar(500) NOT NULL,
  `id_boleta` int(11) NOT NULL,
  `empleado` varchar(100) NOT NULL,
  `reembolso` decimal(8,2) DEFAULT NULL,
  `tipo_reclamo` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tipo_reclamo` (`tipo_reclamo`),
  CONSTRAINT `reclamo_ibfk_1` FOREIGN KEY (`tipo_reclamo`) REFERENCES `tipo_reclamo` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reclamo`
--

LOCK TABLES `reclamo` WRITE;
/*!40000 ALTER TABLE `reclamo` DISABLE KEYS */;
/*!40000 ALTER TABLE `reclamo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reporte_boletas`
--

DROP TABLE IF EXISTS `reporte_boletas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reporte_boletas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha_registro` date NOT NULL,
  `hora_registro` time NOT NULL,
  `empleado` varchar(100) NOT NULL,
  `monto_total` decimal(8,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reporte_boletas`
--

LOCK TABLES `reporte_boletas` WRITE;
/*!40000 ALTER TABLE `reporte_boletas` DISABLE KEYS */;
/*!40000 ALTER TABLE `reporte_boletas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reporte_caja`
--

DROP TABLE IF EXISTS `reporte_caja`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reporte_caja` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha_registro` date NOT NULL,
  `hora_registro` time NOT NULL,
  `empleado` varchar(100) NOT NULL,
  `monto_total` decimal(8,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reporte_caja`
--

LOCK TABLES `reporte_caja` WRITE;
/*!40000 ALTER TABLE `reporte_caja` DISABLE KEYS */;
/*!40000 ALTER TABLE `reporte_caja` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reporte_cierre_caja`
--

DROP TABLE IF EXISTS `reporte_cierre_caja`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reporte_cierre_caja` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha_registro` date NOT NULL,
  `hora_registro` time NOT NULL,
  `empleado` varchar(100) NOT NULL,
  `reporte_boletas` int(11) NOT NULL,
  `reporte_caja` int(11) NOT NULL,
  `descuadre` decimal(8,2) NOT NULL,
  `razon` varchar(500) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `reporte_caja` (`reporte_caja`),
  KEY `reporte_boletas` (`reporte_boletas`) USING BTREE,
  CONSTRAINT `reporte_cierre_caja_ibfk_1` FOREIGN KEY (`reporte_boletas`) REFERENCES `reporte_boletas` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `reporte_cierre_caja_ibfk_2` FOREIGN KEY (`reporte_caja`) REFERENCES `reporte_caja` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reporte_cierre_caja`
--

LOCK TABLES `reporte_cierre_caja` WRITE;
/*!40000 ALTER TABLE `reporte_cierre_caja` DISABLE KEYS */;
/*!40000 ALTER TABLE `reporte_cierre_caja` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipo_reclamo`
--

DROP TABLE IF EXISTS `tipo_reclamo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipo_reclamo` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_reclamo`
--

LOCK TABLES `tipo_reclamo` WRITE;
/*!40000 ALTER TABLE `tipo_reclamo` DISABLE KEYS */;
INSERT INTO `tipo_reclamo` VALUES (1,'Cambio'),(2,'Reembolso');
/*!40000 ALTER TABLE `tipo_reclamo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuario` (
  `login` varchar(20) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellidos` varchar(50) NOT NULL,
  `dni` varchar(8) NOT NULL,
  `contraseña` varchar(255) NOT NULL,
  `estado` bit(1) NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`login`),
  UNIQUE KEY `dni` (`dni`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario_pregunta_respuesta`
--

DROP TABLE IF EXISTS `usuario_pregunta_respuesta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuario_pregunta_respuesta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dni` varchar(8) NOT NULL,
  `id_pregunta` tinyint(4) NOT NULL,
  `respuesta` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `login` (`dni`),
  KEY `id_pregunta` (`id_pregunta`),
  CONSTRAINT `usuario_pregunta_respuesta_ibfk_2` FOREIGN KEY (`id_pregunta`) REFERENCES `pregunta_seguridad` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `usuario_pregunta_respuesta_ibfk_3` FOREIGN KEY (`dni`) REFERENCES `usuario` (`dni`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario_pregunta_respuesta`
--

LOCK TABLES `usuario_pregunta_respuesta` WRITE;
/*!40000 ALTER TABLE `usuario_pregunta_respuesta` DISABLE KEYS */;
/*!40000 ALTER TABLE `usuario_pregunta_respuesta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario_privilegio`
--

DROP TABLE IF EXISTS `usuario_privilegio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuario_privilegio` (
  `login` varchar(20) NOT NULL,
  `id_privilegio` tinyint(4) NOT NULL,
  PRIMARY KEY (`login`,`id_privilegio`),
  KEY `login` (`login`),
  KEY `id_privilegio` (`id_privilegio`),
  CONSTRAINT `usuario_privilegio_ibfk_1` FOREIGN KEY (`login`) REFERENCES `usuario` (`login`) ON UPDATE CASCADE,
  CONSTRAINT `usuario_privilegio_ibfk_2` FOREIGN KEY (`id_privilegio`) REFERENCES `privilegio` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario_privilegio`
--

LOCK TABLES `usuario_privilegio` WRITE;
/*!40000 ALTER TABLE `usuario_privilegio` DISABLE KEYS */;
/*!40000 ALTER TABLE `usuario_privilegio` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-01-15 10:53:31
