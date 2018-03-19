--
-- Base de datos: `selenit_produccion`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contactos`
--

DROP database IF EXISTS `selenit_produccion`;

create database selenit_produccion;
use selenit_produccion;

CREATE TABLE `contactos` (
  `id` mediumint(11) NOT NULL,
  `producto` int(1) NOT NULL DEFAULT '0',
  `author` varchar(60) NOT NULL,
  `correo` varchar(20) NOT NULL,
  `telefono` varchar(60) NOT NULL,
  `titulo` varchar(30) NOT NULL,
  `mensaje` varchar(3000) NOT NULL,
  `fecha` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fila`
--

CREATE TABLE `fila` (
  `fil_codigo` int(11) NOT NULL,
  `fil_nombre` varchar(30) NOT NULL,
  `fil_nemo` varchar(14) NOT NULL,
  `eje_modulo` varchar(2) NOT NULL,
  `fil_active` int(1) NOT NULL DEFAULT '1',
  `fil_ut` int(11) NOT NULL,
  `fil_ta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `fila`
--

INSERT INTO `fila` (`fil_codigo`, `fil_nombre`, `fil_nemo`, `eje_modulo`, `fil_active`, `fil_ut`, `fil_ta`) VALUES
(327, 'Depto. Transito', 'A', '10', 1, 41, 16),
(341, 'B', 'B', '--', 1, 0, 0),
(342, 'C', 'C', '--', 1, 0, 0),
(343, 'D', 'D', '--', 1, 0, 0),
(344, 'E', 'E', '--', 1, 0, 0),
(345, 'F', 'F', '--', 1, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jornada`
--

CREATE TABLE `jornada` (
  `jor_codigo` int(11) NOT NULL,
  `jor_fecha` date NOT NULL,
  `jor_inicio` time NOT NULL,
  `jor_fin` time DEFAULT NULL,
  `jor_estado` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modulo`
--

CREATE TABLE `modulo` (
  `mod_codigo` int(11) NOT NULL,
  `mod_modulo` varchar(2) DEFAULT NULL,
  `usu_codigo` int(11) DEFAULT NULL,
  `mod_ip` varchar(30) DEFAULT NULL,
  `mod_multiusuario` int(2) DEFAULT NULL,
  `mod_feccrea` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `modulo`
--

INSERT INTO `modulo` (`mod_codigo`, `mod_modulo`, `usu_codigo`, `mod_ip`, `mod_multiusuario`, `mod_feccrea`) VALUES
(3, '10', 1, 'Â ', 0, '2015-04-24 21:51:54'),
(4, '2', 2, '123', 0, '2015-04-25 18:28:49'),
(5, '3', 5, '123', 0, '2015-04-24 21:52:06'),
(30, '4', 22, '', 0, '2015-04-25 16:07:11');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `parametro`
--

CREATE TABLE `parametro` (
  `par_codigo` int(11) NOT NULL,
  `par_grupo` int(11) NOT NULL,
  `par_nombre` varchar(30) NOT NULL,
  `par_tipo` int(2) NOT NULL,
  `par_valor` varchar(400) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `parametro`
--

INSERT INTO `parametro` (`par_codigo`, `par_grupo`, `par_nombre`, `par_tipo`, `par_valor`) VALUES
(1, 1, 'password_reset', 1, '1234'),
(2, 2, 'mobile_server_primary', 1, 'http://llamame.tk/'),
(3, 2, 'mobile_server_secondary', 1, 'http://llamame.tk:8888/'),
(4, 2, 'mobile_enterprisId', 1, 'CL.SEL.01'),
(5, 2, 'mobile_username', 1, 'selenit'),
(6, 2, 'mobile_password', 1, 'sel1234'),
(7, 2, 'mobile_Follow', 1, '1'),
(8, 2, 'mobile_server_display', 1, 'http://llamame.tk'),
(9, 3, 'printMode', 1, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pausa`
--

CREATE TABLE `pausa` (
  `pau_codigo` int(11) NOT NULL,
  `eje_codigo` int(11) NOT NULL,
  `pau_inicio` timestamp NULL,
  `pau_fin` timestamp NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


--
-- Estructura de tabla para la tabla `perfil`
--

CREATE TABLE `perfil` (
  `PER_CODIGO` int(11) NOT NULL,
  `per_nombre` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `perfil`
--

INSERT INTO `perfil` (`PER_CODIGO`, `per_nombre`) VALUES
(1, 'EJECUTIVO_ATENCION'),
(2, 'ADMINISTRADOR'),
(3, 'SUPERVISOR');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `per_usu`
--

CREATE TABLE `per_usu` (
  `usu_codigo` int(11) NOT NULL,
  `per_codigo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `per_usu`
--

INSERT INTO `per_usu` (`usu_codigo`, `per_codigo`) VALUES
(1, 1),
(1, 2),
(1, 3),
(2, 1),
(2, 2),
(2, 3),
(3, 1),
(3, 2),
(3, 3),
(4, 1),
(5, 1),
(5, 2),
(5, 3),
(20, 1),
(20, 2),
(20, 3),
(22, 1),
(22, 2),
(22, 3),
(23, 1),
(23, 2),
(23, 3),
(28, 1),
(28, 2),
(28, 3),
(40, 1),
(40, 2),
(40, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seguimiento`
--

CREATE TABLE `seguimiento` (
  `seg_codigo` int(11) NOT NULL,
  `fil_codigo` int(11) NOT NULL,
  `fil_nemo` varchar(14) NOT NULL,
  `seg_numero` int(11) NOT NULL,
  `eje_codigo` int(11) NOT NULL,
  `eje_modulo` varchar(2) NOT NULL,
  `seg_fecha` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `seg_fecllamada` timestamp NULL DEFAULT NULL,
  `seg_llamado` int(1) NOT NULL,
  `seg_seguridad` int(11) NOT NULL,
  `seg_seguimiento` int(1) NOT NULL,
  `seg_fecatencion` timestamp NULL DEFAULT NULL,
  `seg_atendido` int(1) NOT NULL,
  `seg_fecfinatencion` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `seguimiento`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seguimiento_hist`
--

CREATE TABLE `seguimiento_hist` (
  `hse_codigo` int(11) NOT NULL,
  `seg_codigo` int(11) NOT NULL,
  `fil_codigo` int(11) NOT NULL,
  `fil_nemo` varchar(14) NOT NULL,
  `seg_numero` int(11) NOT NULL,
  `eje_codigo` int(11) NOT NULL,
  `seg_fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `seg_fecllamada` timestamp NULL,
  `seg_llamado` int(1) NOT NULL,
  `seg_seguridad` int(11) NOT NULL,
  `seg_seguimiento` int(1) NOT NULL,
  `seg_fecatencion` timestamp NULL,
  `seg_atendido` int(1) NOT NULL,
  `seg_fecfinatencion` timestamp NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `seguimiento_hist`
--

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `usu_codigo` int(11) NOT NULL,
  `usu_nombres` varchar(30) NOT NULL,
  `usu_paterno` varchar(30) NOT NULL,
  `usu_materno` varchar(30) DEFAULT NULL,
  `usu_cargo` varchar(30) DEFAULT NULL,
  `usu_correo` varchar(30) DEFAULT NULL,
  `usu_telefono` varchar(30) DEFAULT NULL,
  `usu_fecnacimiento` date DEFAULT NULL,
  `usu_usuario` varchar(15) NOT NULL,
  `usu_password` varchar(15) DEFAULT NULL,
  `seg_feccrea` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`usu_codigo`, `usu_nombres`, `usu_paterno`, `usu_materno`, `usu_cargo`, `usu_correo`, `usu_telefono`, `usu_fecnacimiento`, `usu_usuario`, `usu_password`, `seg_feccrea`) VALUES
(5, 'Administrador', '', '', 'Administrador', 'ricardo.fernandez@selenit.cl', '95939485', '1976-11-07', 'admin', 'admin', '2015-04-25 12:42:43');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usu_fila`
--

CREATE TABLE `usu_fila` (
  `usu_codigo` int(11) NOT NULL,
  `fil_codigo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usu_fila`
--

INSERT INTO `usu_fila` (`usu_codigo`, `fil_codigo`) VALUES
(3, 1),
(3, 2),
(3, 3),
(23, 1),
(23, 2),
(23, 3),
(23, 4),
(23, 118),
(23, 119),
(23, 120),
(23, 121),
(20, 1),
(20, 2),
(20, 3),
(20, 4),
(20, 129),
(20, 130),
(20, 131),
(4, 291),
(4, 318),
(28, 287),
(28, 291),
(28, 318),
(28, 326),
(5, 327),
(5, 328),
(5, 329),
(5, 332),
(2, 327),
(2, 328),
(2, 332),
(2, 334),
(40, 327),
(40, 328),
(40, 332),
(40, 334),
(1, 327),
(1, 328),
(1, 332),
(1, 334),
(1, 336);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `visitas`
--

CREATE TABLE `visitas` (
  `id` mediumint(9) NOT NULL,
  `fecha` datetime NOT NULL,
  `ip` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `visitas`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `visitas_url`
--

CREATE TABLE `visitas_url` (
  `id` mediumint(11) NOT NULL,
  `url` varchar(50) NOT NULL,
  `fecha` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `visitas_url`
--

-- --------------------------------------------------------


-- --------------------------------------------------------

-- --------------------------------------------------------

--
-- Estructura para la vista `v_ejecutivo`
--
DROP TABLE IF EXISTS `v_ejecutivo`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_ejecutivo`  AS  select `u`.`usu_codigo` AS `usu_codigo`,`u`.`usu_nombres` AS `usu_nombres`,`u`.`usu_paterno` AS `usu_paterno`,`u`.`usu_materno` AS `usu_materno`,`u`.`usu_cargo` AS `usu_cargo`,`u`.`usu_correo` AS `usu_correo`,`u`.`usu_telefono` AS `usu_telefono`,`u`.`usu_fecnacimiento` AS `usu_fecnacimiento`,`u`.`usu_usuario` AS `usu_usuario`,`u`.`usu_password` AS `usu_password`,`u`.`seg_feccrea` AS `seg_feccrea` from ((`usuario` `u` join `per_usu` `pu`) join `perfil` `p`) where ((`u`.`usu_codigo` = `pu`.`usu_codigo`) and (`pu`.`per_codigo` = `p`.`PER_CODIGO`) and (`p`.`per_nombre` = 'EJECUTIVO_ATENCION')) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `v_seguimiento`
--
DROP TABLE IF EXISTS `v_seguimiento`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_seguimiento`  AS  select `seguimiento`.`seg_codigo` AS `seg_codigo`,`seguimiento`.`fil_codigo` AS `fil_codigo`,`seguimiento`.`fil_nemo` AS `fil_nemo`,`seguimiento`.`seg_numero` AS `seg_numero`,`seguimiento`.`eje_codigo` AS `eje_codigo`,`seguimiento`.`seg_fecha` AS `seg_fecha`,`seguimiento`.`seg_fecllamada` AS `seg_fecllamada`,`seguimiento`.`seg_llamado` AS `seg_llamado`,`seguimiento`.`seg_seguridad` AS `seg_seguridad`,`seguimiento`.`seg_seguimiento` AS `seg_seguimiento`,`seguimiento`.`seg_fecatencion` AS `seg_fecatencion`,`seguimiento`.`seg_atendido` AS `seg_atendido`,`seguimiento`.`seg_fecfinatencion` AS `seg_fecfinatencion` from `seguimiento` union select `seguimiento_hist`.`seg_codigo` AS `seg_codigo`,`seguimiento_hist`.`fil_codigo` AS `fil_codigo`,`seguimiento_hist`.`fil_nemo` AS `fil_nemo`,`seguimiento_hist`.`seg_numero` AS `seg_numero`,`seguimiento_hist`.`eje_codigo` AS `eje_codigo`,`seguimiento_hist`.`seg_fecha` AS `seg_fecha`,`seguimiento_hist`.`seg_fecllamada` AS `seg_fecllamada`,`seguimiento_hist`.`seg_llamado` AS `seg_llamado`,`seguimiento_hist`.`seg_seguridad` AS `seg_seguridad`,`seguimiento_hist`.`seg_seguimiento` AS `seg_seguimiento`,`seguimiento_hist`.`seg_fecatencion` AS `seg_fecatencion`,`seguimiento_hist`.`seg_atendido` AS `seg_atendido`,`seguimiento_hist`.`seg_fecfinatencion` AS `seg_fecfinatencion` from `seguimiento_hist` ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `contactos`
--
ALTER TABLE `contactos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `fila`
--
ALTER TABLE `fila`
  ADD PRIMARY KEY (`fil_codigo`),
  ADD UNIQUE KEY `fil_nemo` (`fil_nemo`);

--
-- Indices de la tabla `jornada`
--
ALTER TABLE `jornada`
  ADD PRIMARY KEY (`jor_codigo`),
  ADD UNIQUE KEY `jor_fecha_3` (`jor_fecha`),
  ADD KEY `jor_fecha` (`jor_fecha`,`jor_estado`),
  ADD KEY `jor_fecha_2` (`jor_fecha`);

--
-- Indices de la tabla `modulo`
--
ALTER TABLE `modulo`
  ADD PRIMARY KEY (`mod_codigo`),
  ADD UNIQUE KEY `usu_codigo` (`usu_codigo`);

--
-- Indices de la tabla `parametro`
--
ALTER TABLE `parametro`
  ADD PRIMARY KEY (`par_codigo`);

--
-- Indices de la tabla `pausa`
--
ALTER TABLE `pausa`
  ADD PRIMARY KEY (`pau_codigo`);

--
-- Indices de la tabla `perfil`
--
ALTER TABLE `perfil`
  ADD PRIMARY KEY (`PER_CODIGO`);

--
-- Indices de la tabla `per_usu`
--
ALTER TABLE `per_usu`
  ADD UNIQUE KEY `usu_codigo` (`usu_codigo`,`per_codigo`);

--
-- Indices de la tabla `seguimiento`
--
ALTER TABLE `seguimiento`
  ADD PRIMARY KEY (`seg_codigo`);

--
-- Indices de la tabla `seguimiento_hist`
--
ALTER TABLE `seguimiento_hist`
  ADD PRIMARY KEY (`hse_codigo`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`usu_codigo`),
  ADD UNIQUE KEY `usu_usuario` (`usu_usuario`);

--
-- Indices de la tabla `visitas`
--
ALTER TABLE `visitas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `contactos`
--
ALTER TABLE `contactos`
  MODIFY `id` mediumint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
--
-- AUTO_INCREMENT de la tabla `fila`
--
ALTER TABLE `fila`
  MODIFY `fil_codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=352;
--
-- AUTO_INCREMENT de la tabla `jornada`
--
ALTER TABLE `jornada`
  MODIFY `jor_codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;
--
-- AUTO_INCREMENT de la tabla `modulo`
--
ALTER TABLE `modulo`
  MODIFY `mod_codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT de la tabla `parametro`
--
ALTER TABLE `parametro`
  MODIFY `par_codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT de la tabla `pausa`
--
ALTER TABLE `pausa`
  MODIFY `pau_codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;
--
-- AUTO_INCREMENT de la tabla `perfil`
--
ALTER TABLE `perfil`
  MODIFY `PER_CODIGO` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `seguimiento`
--
ALTER TABLE `seguimiento`
  MODIFY `seg_codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=251;
--
-- AUTO_INCREMENT de la tabla `seguimiento_hist`
--
ALTER TABLE `seguimiento_hist`
  MODIFY `hse_codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2723;
--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `usu_codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;
--
-- AUTO_INCREMENT de la tabla `visitas`
--
ALTER TABLE `visitas`
  MODIFY `id` mediumint(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2544;




