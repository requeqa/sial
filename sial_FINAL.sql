-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-10-2022 a las 04:19:44
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 7.4.29

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sial`
--
CREATE DATABASE IF NOT EXISTS `sial` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `sial`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bmovimiento`
--

CREATE TABLE `bmovimiento` (
  `IDMOV` int(11) NOT NULL COMMENT 'ID MOVIMIENTO|MOVIMIENTO DE ALMACEN',
  `IDDETALLE` int(255) NOT NULL COMMENT 'ID DETALLE|NUMERACION DE DETALLE DE PRODUCTO DE MOVIMIENTO',
  `IDDETVENTA` int(11) DEFAULT NULL COMMENT 'ID DETALLE VENTA|CODIGO DE DETALLE DE VENTA',
  `CODPRD` int(50) NOT NULL COMMENT 'CODIGO PRODUCTO|CODIGO DEL PRODUCTO',
  `GLOSAPRD` text DEFAULT NULL COMMENT 'GLOSA RODUCTO| GLOSA DEL PRODUCTO',
  `CANTPRD` int(11) NOT NULL COMMENT 'CANTIDAD PRODUCTO|CANTIDAD DEL PRODUCTO',
  `UNITPRD` decimal(10,2) NOT NULL COMMENT 'UNITARIO|PRECIO DEL PRODUCTO',
  `TOTUNIT` decimal(10,2) NOT NULL COMMENT 'TOTAL UNITARIO|CANTPRD X UNITPRD'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='CUERPO DE REGISTRO DE MOVIMIENTO DE ALMACEN';

--
-- RELACIONES PARA LA TABLA `bmovimiento`:
--   `CODPRD`
--       `mproducto` -> `CODPRD`
--   `IDDETVENTA`
--       `bventas` -> `DETVENTA`
--   `IDMOV`
--       `hmovimiento` -> `IDMOV`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bventas`
--

CREATE TABLE `bventas` (
  `IDVENTA` int(11) NOT NULL COMMENT 'ID VENTA|IDENTIFICACION DE NUMERO DE VENTA.',
  `DETVENTA` int(11) NOT NULL COMMENT 'DETALLE VENTA|CODIGO DE DETALLE DE VENTA.',
  `CODPRD` int(11) NOT NULL COMMENT 'CODIGO PRODUCTO|CODIGO DE PRODUCTO.',
  `GLOSAPRD` text DEFAULT NULL COMMENT 'GLOSA PRODUCTO|GLOSA DEL PRODUCTO.',
  `CODLISTPRE` int(11) NOT NULL COMMENT 'COD LISTA PRECIO|CODIGO LISTA DE PRECIO.',
  `CANTPRD` int(11) NOT NULL COMMENT 'CANTIDAD PRODUCTO|CANTIDAD PRODUCTO.',
  `PRECVENT` decimal(10,2) NOT NULL COMMENT 'PRECIO VENTA|PRECIO VENTA'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='CUERPO DE VENTAS.';

--
-- RELACIONES PARA LA TABLA `bventas`:
--   `CODPRD`
--       `mproducto` -> `CODPRD`
--   `IDVENTA`
--       `hventas` -> `IDVENTA`
--   `CODLISTPRE`
--       `tlistprecio` -> `CODLISTPRE`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dlistprecio`
--

CREATE TABLE `dlistprecio` (
  `CODLISTPRE` int(50) NOT NULL COMMENT 'COD LISTA PRECIO|CODIGO DE LISTA DE PRECIO',
  `DETPRECIO` int(200) NOT NULL COMMENT 'DETALLE PRECIO|ENUMERACION DE DETALLE DE PRECIO DE VENTA.',
  `CODPRD` int(200) NOT NULL COMMENT 'COD PRODUCTO|CODIGO DE PRODUCTO',
  `PRECVENT` decimal(10,2) NOT NULL COMMENT 'PRECIO VENTA|PRECIO VENTA'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='CUERPO DE LISTA DE PRECIOS';

--
-- RELACIONES PARA LA TABLA `dlistprecio`:
--   `CODLISTPRE`
--       `tlistprecio` -> `CODLISTPRE`
--   `CODPRD`
--       `mproducto` -> `CODPRD`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `hmovimiento`
--

CREATE TABLE `hmovimiento` (
  `IDMOV` int(11) NOT NULL COMMENT 'ID MOVIMIENTO|IDENTIFICACION DE MOVIMIENTO DE ALMACEN',
  `FECHA` datetime NOT NULL DEFAULT current_timestamp() COMMENT 'FECHA|FECHA DEL MOVIMIENTO',
  `DESCGLOS` text DEFAULT NULL COMMENT 'GLOSA|GLOSA DEL MOVIMIENTO',
  `OPNULO` int(11) NOT NULL COMMENT 'NULO 0, VIG 1|ESTADO DE ANULACION DEL MOVIMIENTO',
  `IDVENTA` int(11) DEFAULT NULL COMMENT 'ID VENTA|IDENTIFICACION DE NUMERO DE VENTA',
  `CODOPE` int(11) NOT NULL COMMENT 'COD OPERACION|CODIGO DEL TIPO DE OPERACION',
  `TIPMOV` int(11) NOT NULL COMMENT 'ING 1, EGR 2|SI ES INGRESO O EGRESOS (1, 2)',
  `IDSUC` int(11) NOT NULL COMMENT 'ID SUCURSAL|IDENTIFICACION DE LA SUCURSAL'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='CABECERA DE REGISTRO DE MOVIMIENTO DE ALMACEN';

--
-- RELACIONES PARA LA TABLA `hmovimiento`:
--   `CODOPE`
--       `ttipoope` -> `CODOPE`
--   `IDSUC`
--       `msucursal` -> `IDSUC`
--   `IDVENTA`
--       `hventas` -> `IDVENTA`
--   `TIPMOV`
--       `ttipomov` -> `TIPMOV`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `hventas`
--

CREATE TABLE `hventas` (
  `IDVENTA` int(255) NOT NULL COMMENT 'ID VENTA|IDENTIFICACION DE VENTA.',
  `CODLISTPRE` int(255) NOT NULL COMMENT 'COD LISTA PRECIO|CODIGO DE LISTA DE PRECIOS.',
  `OPNULO` int(255) NOT NULL DEFAULT 1 COMMENT 'NULO 0, VIG 1|NULO O VIGENTE.',
  `DESCCLIENT` text NOT NULL COMMENT 'CLIENTE|DESCRIPCION DEL CLIENTE.',
  `FECHAVENT` datetime NOT NULL DEFAULT current_timestamp() COMMENT 'FECHA VENTA|FECHA DE VENTA. '
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='CABECERA DE VENTAS.';

--
-- RELACIONES PARA LA TABLA `hventas`:
--   `CODLISTPRE`
--       `tlistprecio` -> `CODLISTPRE`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mproducto`
--

CREATE TABLE `mproducto` (
  `CODPRD` int(11) NOT NULL COMMENT 'COD PRODUCTO|CODIGO DESIGNADO PARA IDENTIFICACION DEL PRODUCTO',
  `CODPROV` varchar(100) NOT NULL,
  `NOMPROD` text NOT NULL COMMENT 'PRODUCTO|NOMBRE DEL PRODUCTO',
  `DESCPROD1` text DEFAULT NULL COMMENT 'DESCRIPCION 1|DESCRIPCION 1 DEL PRODUCTO',
  `LUGAR` text DEFAULT NULL COMMENT 'DESCRIPCION 2|DESCRIPCION 2 DEL PRODUCTO',
  `PROCEDENCIA` text NOT NULL,
  `CODUNID` int(11) NOT NULL COMMENT 'COD UNIDAD|UNIDAD DE MEDIDA',
  `CODMARC` int(11) NOT NULL COMMENT 'COD MARCA|TIPO DE MARCA',
  `VIGENCIA` int(11) NOT NULL DEFAULT 1 COMMENT 'DESCONT 0, VIG 1|SI EL PRODUCTO SE CONSIDERA VIGENTE O DESCONTINUADO',
  `MINPRD` int(100) NOT NULL DEFAULT 0 COMMENT 'MINIMO PRODUCTO|MINIMO DEL PRODCTO PARA ACTIVAR LA ALARMA',
  `CANTPRD` int(11) NOT NULL DEFAULT 0 COMMENT 'CANTIDAD PRODUCTO|CANTIDAD DEL PRODUCTO.',
  `UNITPRD` decimal(10,2) NOT NULL DEFAULT 0.00 COMMENT 'UNITARIO|COSTO UNITARIO DEL PRODUCTO.',
  `TOTUNIT` decimal(10,2) NOT NULL DEFAULT 0.00 COMMENT 'TOTAL UNITARIO|TOTAL UNITARIO DEL PRODUCTO.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='MAESTRO DE PRODUCTOS';

--
-- RELACIONES PARA LA TABLA `mproducto`:
--   `CODMARC`
--       `tmarca` -> `CODMARC`
--   `CODUNID`
--       `tmedida` -> `CODUNID`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `msucursal`
--

CREATE TABLE `msucursal` (
  `IDSUC` int(11) NOT NULL COMMENT 'ID SUCURSAL|CODIGO DE IDENTIFICACION DE SUCURSAL',
  `DESCSUC` text NOT NULL COMMENT 'SUCURSAL|DESCRIPCION DE LA SUCURSAL'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='TABLA DE PARAMETROS DE SUCURSAL';

--
-- RELACIONES PARA LA TABLA `msucursal`:
--

--
-- Volcado de datos para la tabla `msucursal`
--

INSERT INTO `msucursal` (`IDSUC`, `DESCSUC`) VALUES
(1, 'central');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ponderacion`
--

CREATE TABLE `ponderacion` (
  `IDPOND` int(250) NOT NULL COMMENT 'ID PONDERACION|IDENTIFICACION DE LA PONDERACION.',
  `CODPRD` int(250) NOT NULL COMMENT 'COD PRODUCTO|CODIGO DEL PRODUCTO.',
  `IDDETMOV` int(250) NOT NULL COMMENT 'ID MOVIMIENTO|IDENTIFICACION DEL MOVIMIENTO.',
  `CANTPRD` int(11) NOT NULL,
  `UNITPRD` decimal(10,2) NOT NULL COMMENT 'PONDERACION UNITARIO|UNITARIO PONDERADO. ',
  `PONDVIGENTE` int(10) NOT NULL COMMENT 'VIG 1, 0 NULO|1 VIGENTE, 0 NO VIGENTE.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='TABLA DE PONDERACION DE PRODUCTOS.';

--
-- RELACIONES PARA LA TABLA `ponderacion`:
--   `IDDETMOV`
--       `bmovimiento` -> `IDDETALLE`
--   `CODPRD`
--       `mproducto` -> `CODPRD`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tlistprecio`
--

CREATE TABLE `tlistprecio` (
  `CODLISTPRE` int(50) NOT NULL COMMENT 'COD LISTA PRECIO|CODIGO DE LISTA DE PRECIO',
  `DESCLISTPRE` text NOT NULL COMMENT 'LISTA PRECIO|DESCRIPCION DE LA LISTA DE PRECIO'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='TABLA DE LISTA DE PRECIOS';

--
-- RELACIONES PARA LA TABLA `tlistprecio`:
--

--
-- Volcado de datos para la tabla `tlistprecio`
--

INSERT INTO `tlistprecio` (`CODLISTPRE`, `DESCLISTPRE`) VALUES
(1, 'C/F Estandar'),
(2, 'S/F Estandar'),
(3, 'C/F Especial'),
(4, 'S/F Especial');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tmarca`
--

CREATE TABLE `tmarca` (
  `CODMARC` int(11) NOT NULL COMMENT 'COD MARCA|CODIGO ASIGNADO A LA MARCA',
  `DESCMARC` text NOT NULL COMMENT 'MARCA|DESCRIPCION DE LA MARCA'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='TABLA DE PARAMETROS DE MARCA';

--
-- RELACIONES PARA LA TABLA `tmarca`:
--

--
-- Volcado de datos para la tabla `tmarca`
--

INSERT INTO `tmarca` (`CODMARC`, `DESCMARC`) VALUES
(1, 'BOSCH'),
(2, 'DENSO'),
(3, 'otritos'),
(4, 'pollito'),
(5, 'Burrito');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tmedida`
--

CREATE TABLE `tmedida` (
  `CODUNID` int(11) NOT NULL COMMENT 'COD UNIDAD|UNIDAD DE MEDIDA',
  `ABREUNID` text NOT NULL COMMENT 'ABREVIATURA UNIDAD| ABREVIATURA DE LA UNIDAD',
  `DESCRUNI` text NOT NULL COMMENT 'UNIDAD|DESCRIPCION DE LA UNIDAD'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='TABLA DE UNIDADES DE PARAMETROS DE UNIDAD DE MEDIDA';

--
-- RELACIONES PARA LA TABLA `tmedida`:
--

--
-- Volcado de datos para la tabla `tmedida`
--

INSERT INTO `tmedida` (`CODUNID`, `ABREUNID`, `DESCRUNI`) VALUES
(1, 'PZ', 'PIEZA'),
(2, 'lt', 'Litro'),
(3, 'Oz', 'Onzas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ttipomov`
--

CREATE TABLE `ttipomov` (
  `TIPMOV` int(11) NOT NULL COMMENT 'ING 1, EGR 2|SI ES INGRESO O EGRESOS (1, 2)',
  `ABREMOV` text NOT NULL COMMENT 'ABREVIATURA MOVIMIENTO|MAXIMO 4 LETRAS',
  `DESCMOV` text NOT NULL COMMENT 'MOVIMIENTO|DESCRIPCION DEL MOVIMIENTO'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELACIONES PARA LA TABLA `ttipomov`:
--

--
-- Volcado de datos para la tabla `ttipomov`
--

INSERT INTO `ttipomov` (`TIPMOV`, `ABREMOV`, `DESCMOV`) VALUES
(1, 'ING', 'INGRESO'),
(2, 'EGR', 'EGRESO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ttipoope`
--

CREATE TABLE `ttipoope` (
  `CODOPE` int(11) NOT NULL COMMENT 'COD OPERACION|CODIGO ASIGNADO PARA IDENTIFICACION DE OPERACION',
  `ABREOPE` text NOT NULL COMMENT 'ABREVIATURA OPERACION|ABREVIATURA DE LA OPERACION',
  `DESCOPE` text NOT NULL COMMENT 'OPERACION|DESCRIPCION DE LA OPERACION',
  `TIPMOV` int(11) NOT NULL COMMENT 'ING 1, EGR 2|SI ES INGRESO O EGRESOS (1, 2)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='TABLA DE UNIDADES DE PARAMETROS DE TIPO DE OPERACION';

--
-- RELACIONES PARA LA TABLA `ttipoope`:
--   `TIPMOV`
--       `ttipomov` -> `TIPMOV`
--

--
-- Volcado de datos para la tabla `ttipoope`
--

INSERT INTO `ttipoope` (`CODOPE`, `ABREOPE`, `DESCOPE`, `TIPMOV`) VALUES
(1, 'SI', 'SALDO INICIAL', 1),
(2, 'CLO', 'COMPRA LOCAL', 1),
(3, 'IMP', 'IMPORTACION', 1),
(4, 'DEV', 'DEVOLUCION', 1),
(5, 'OTRO', 'OTRO', 1),
(6, 'VEN', 'VENTA', 2),
(7, 'RBO', 'ROBO', 2),
(8, 'PDD', 'PERDIDA', 2),
(9, 'MRM', 'MERMA', 2),
(10, 'OTR', 'OTRO', 2);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vw_productos`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vw_productos` (
`CODPRD` int(11)
,`CODPROV` varchar(100)
,`NOMPROD` text
,`DESCPROD1` text
,`LUGAR` text
,`PROCEDENCIA` text
,`DESCRUNI` text
,`DESCMARC` text
,`CANTPRD` int(11)
,`UNITPRD` decimal(10,2)
,`TOTUNIT` decimal(10,2)
,`A` decimal(32,2)
,`B` decimal(32,2)
,`C` decimal(32,2)
,`D` decimal(32,2)
);

-- --------------------------------------------------------

--
-- Estructura para la vista `vw_productos`
--
DROP TABLE IF EXISTS `vw_productos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_productos`  AS SELECT `p`.`CODPRD` AS `CODPRD`, `p`.`CODPROV` AS `CODPROV`, `p`.`NOMPROD` AS `NOMPROD`, `p`.`DESCPROD1` AS `DESCPROD1`, `p`.`LUGAR` AS `LUGAR`, `p`.`PROCEDENCIA` AS `PROCEDENCIA`, `b`.`DESCRUNI` AS `DESCRUNI`, `a`.`DESCMARC` AS `DESCMARC`, `p`.`CANTPRD` AS `CANTPRD`, `p`.`UNITPRD` AS `UNITPRD`, `p`.`TOTUNIT` AS `TOTUNIT`, sum(if(`l`.`CODLISTPRE` = 1,`l`.`PRECVENT`,0)) AS `A`, sum(if(`l`.`CODLISTPRE` = 2,`l`.`PRECVENT`,0)) AS `B`, sum(if(`l`.`CODLISTPRE` = 3,`l`.`PRECVENT`,0)) AS `C`, sum(if(`l`.`CODLISTPRE` = 4,`l`.`PRECVENT`,0)) AS `D` FROM (((`mproducto` `p` join `tmarca` `a` on(`p`.`CODMARC` = `a`.`CODMARC`)) join `tmedida` `b` on(`p`.`CODUNID` = `b`.`CODUNID`)) join `dlistprecio` `l` on(`l`.`CODPRD` = `p`.`CODPRD`)) GROUP BY 11  ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `bmovimiento`
--
ALTER TABLE `bmovimiento`
  ADD PRIMARY KEY (`IDDETALLE`),
  ADD KEY `COD_PRODUCT` (`CODPRD`),
  ADD KEY `ID_MOVIMIENTO` (`IDMOV`),
  ADD KEY `ID_DETALLE_VENTA` (`IDDETVENTA`);

--
-- Indices de la tabla `bventas`
--
ALTER TABLE `bventas`
  ADD PRIMARY KEY (`DETVENTA`),
  ADD KEY `LISTA DE PRECIOS` (`CODLISTPRE`),
  ADD KEY `IDENT_VENTA` (`IDVENTA`),
  ADD KEY `COD_PRD` (`CODPRD`);

--
-- Indices de la tabla `dlistprecio`
--
ALTER TABLE `dlistprecio`
  ADD PRIMARY KEY (`DETPRECIO`),
  ADD KEY `COD_LISTA_PRECIOS` (`CODLISTPRE`),
  ADD KEY `PRODUCTO` (`CODPRD`);

--
-- Indices de la tabla `hmovimiento`
--
ALTER TABLE `hmovimiento`
  ADD PRIMARY KEY (`IDMOV`),
  ADD KEY `ID_SUCURSAL` (`IDSUC`),
  ADD KEY `COD_OPERACION` (`CODOPE`),
  ADD KEY `TIPO_MOVIMIENTO` (`TIPMOV`),
  ADD KEY `ID_VENTA` (`IDVENTA`);

--
-- Indices de la tabla `hventas`
--
ALTER TABLE `hventas`
  ADD PRIMARY KEY (`IDVENTA`),
  ADD KEY `LIST_PRECIOS` (`CODLISTPRE`);

--
-- Indices de la tabla `mproducto`
--
ALTER TABLE `mproducto`
  ADD PRIMARY KEY (`CODPRD`),
  ADD KEY `Unidad` (`CODUNID`),
  ADD KEY `Marca` (`CODMARC`),
  ADD KEY `COD_PROVEEDOR` (`CODPROV`);

--
-- Indices de la tabla `msucursal`
--
ALTER TABLE `msucursal`
  ADD PRIMARY KEY (`IDSUC`);

--
-- Indices de la tabla `ponderacion`
--
ALTER TABLE `ponderacion`
  ADD PRIMARY KEY (`IDPOND`),
  ADD KEY `PRODUCTO_PONDERADO` (`CODPRD`),
  ADD KEY `IDENT_MOV` (`IDDETMOV`);

--
-- Indices de la tabla `tlistprecio`
--
ALTER TABLE `tlistprecio`
  ADD PRIMARY KEY (`CODLISTPRE`);

--
-- Indices de la tabla `tmarca`
--
ALTER TABLE `tmarca`
  ADD PRIMARY KEY (`CODMARC`);

--
-- Indices de la tabla `tmedida`
--
ALTER TABLE `tmedida`
  ADD PRIMARY KEY (`CODUNID`);

--
-- Indices de la tabla `ttipomov`
--
ALTER TABLE `ttipomov`
  ADD PRIMARY KEY (`TIPMOV`);

--
-- Indices de la tabla `ttipoope`
--
ALTER TABLE `ttipoope`
  ADD PRIMARY KEY (`CODOPE`),
  ADD KEY `Movimiento_Operacion` (`TIPMOV`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `bmovimiento`
--
ALTER TABLE `bmovimiento`
  MODIFY `IDDETALLE` int(255) NOT NULL AUTO_INCREMENT COMMENT 'ID DETALLE|NUMERACION DE DETALLE DE PRODUCTO DE MOVIMIENTO';

--
-- AUTO_INCREMENT de la tabla `bventas`
--
ALTER TABLE `bventas`
  MODIFY `DETVENTA` int(11) NOT NULL AUTO_INCREMENT COMMENT 'DETALLE VENTA|CODIGO DE DETALLE DE VENTA.';

--
-- AUTO_INCREMENT de la tabla `dlistprecio`
--
ALTER TABLE `dlistprecio`
  MODIFY `DETPRECIO` int(200) NOT NULL AUTO_INCREMENT COMMENT 'DETALLE PRECIO|ENUMERACION DE DETALLE DE PRECIO DE VENTA.';

--
-- AUTO_INCREMENT de la tabla `hmovimiento`
--
ALTER TABLE `hmovimiento`
  MODIFY `IDMOV` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID MOVIMIENTO|IDENTIFICACION DE MOVIMIENTO DE ALMACEN';

--
-- AUTO_INCREMENT de la tabla `hventas`
--
ALTER TABLE `hventas`
  MODIFY `IDVENTA` int(255) NOT NULL AUTO_INCREMENT COMMENT 'ID VENTA|IDENTIFICACION DE VENTA.';

--
-- AUTO_INCREMENT de la tabla `mproducto`
--
ALTER TABLE `mproducto`
  MODIFY `CODPRD` int(11) NOT NULL AUTO_INCREMENT COMMENT 'COD PRODUCTO|CODIGO DESIGNADO PARA IDENTIFICACION DEL PRODUCTO';

--
-- AUTO_INCREMENT de la tabla `msucursal`
--
ALTER TABLE `msucursal`
  MODIFY `IDSUC` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID SUCURSAL|CODIGO DE IDENTIFICACION DE SUCURSAL', AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `ponderacion`
--
ALTER TABLE `ponderacion`
  MODIFY `IDPOND` int(250) NOT NULL AUTO_INCREMENT COMMENT 'ID PONDERACION|IDENTIFICACION DE LA PONDERACION.';

--
-- AUTO_INCREMENT de la tabla `tlistprecio`
--
ALTER TABLE `tlistprecio`
  MODIFY `CODLISTPRE` int(50) NOT NULL AUTO_INCREMENT COMMENT 'COD LISTA PRECIO|CODIGO DE LISTA DE PRECIO', AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tmarca`
--
ALTER TABLE `tmarca`
  MODIFY `CODMARC` int(11) NOT NULL AUTO_INCREMENT COMMENT 'COD MARCA|CODIGO ASIGNADO A LA MARCA', AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `tmedida`
--
ALTER TABLE `tmedida`
  MODIFY `CODUNID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'COD UNIDAD|UNIDAD DE MEDIDA', AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `ttipoope`
--
ALTER TABLE `ttipoope`
  MODIFY `CODOPE` int(11) NOT NULL AUTO_INCREMENT COMMENT 'COD OPERACION|CODIGO ASIGNADO PARA IDENTIFICACION DE OPERACION', AUTO_INCREMENT=11;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `bmovimiento`
--
ALTER TABLE `bmovimiento`
  ADD CONSTRAINT `COD_PRODUCT` FOREIGN KEY (`CODPRD`) REFERENCES `mproducto` (`CODPRD`),
  ADD CONSTRAINT `ID_DETALLE_VENTA` FOREIGN KEY (`IDDETVENTA`) REFERENCES `bventas` (`DETVENTA`),
  ADD CONSTRAINT `ID_MOVIMIENTO` FOREIGN KEY (`IDMOV`) REFERENCES `hmovimiento` (`IDMOV`);

--
-- Filtros para la tabla `bventas`
--
ALTER TABLE `bventas`
  ADD CONSTRAINT `COD_PRD` FOREIGN KEY (`CODPRD`) REFERENCES `mproducto` (`CODPRD`),
  ADD CONSTRAINT `IDENT_VENTA` FOREIGN KEY (`IDVENTA`) REFERENCES `hventas` (`IDVENTA`),
  ADD CONSTRAINT `LISTA DE PRECIOS` FOREIGN KEY (`CODLISTPRE`) REFERENCES `tlistprecio` (`CODLISTPRE`);

--
-- Filtros para la tabla `dlistprecio`
--
ALTER TABLE `dlistprecio`
  ADD CONSTRAINT `COD_LISTA_PRECIOS` FOREIGN KEY (`CODLISTPRE`) REFERENCES `tlistprecio` (`CODLISTPRE`),
  ADD CONSTRAINT `PRODUCTO` FOREIGN KEY (`CODPRD`) REFERENCES `mproducto` (`CODPRD`);

--
-- Filtros para la tabla `hmovimiento`
--
ALTER TABLE `hmovimiento`
  ADD CONSTRAINT `COD_OPERACION` FOREIGN KEY (`CODOPE`) REFERENCES `ttipoope` (`CODOPE`),
  ADD CONSTRAINT `ID_SUCURSAL` FOREIGN KEY (`IDSUC`) REFERENCES `msucursal` (`IDSUC`),
  ADD CONSTRAINT `ID_VENTA` FOREIGN KEY (`IDVENTA`) REFERENCES `hventas` (`IDVENTA`),
  ADD CONSTRAINT `TIPO_MOVIMIENTO` FOREIGN KEY (`TIPMOV`) REFERENCES `ttipomov` (`TIPMOV`);

--
-- Filtros para la tabla `hventas`
--
ALTER TABLE `hventas`
  ADD CONSTRAINT `LIST_PRECIOS` FOREIGN KEY (`CODLISTPRE`) REFERENCES `tlistprecio` (`CODLISTPRE`);

--
-- Filtros para la tabla `mproducto`
--
ALTER TABLE `mproducto`
  ADD CONSTRAINT `Marca` FOREIGN KEY (`CODMARC`) REFERENCES `tmarca` (`CODMARC`),
  ADD CONSTRAINT `Unidad` FOREIGN KEY (`CODUNID`) REFERENCES `tmedida` (`CODUNID`);

--
-- Filtros para la tabla `ponderacion`
--
ALTER TABLE `ponderacion`
  ADD CONSTRAINT `IDENT_MOV` FOREIGN KEY (`IDDETMOV`) REFERENCES `bmovimiento` (`IDDETALLE`),
  ADD CONSTRAINT `PRODUCTO_PONDERADO` FOREIGN KEY (`CODPRD`) REFERENCES `mproducto` (`CODPRD`);

--
-- Filtros para la tabla `ttipoope`
--
ALTER TABLE `ttipoope`
  ADD CONSTRAINT `Movimiento_Operacion` FOREIGN KEY (`TIPMOV`) REFERENCES `ttipomov` (`TIPMOV`);
SET FOREIGN_KEY_CHECKS=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
