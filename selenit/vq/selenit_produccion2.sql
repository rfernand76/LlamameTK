
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


CREATE TABLE `fila` (
  `fil_codigo` int(11) NOT NULL,
  `fil_nombre` varchar(30) NOT NULL,
  `fil_nemo` varchar(14) NOT NULL,
  `eje_modulo` varchar(2) NOT NULL,
  `fil_active` int(1) NOT NULL DEFAULT '1',
  `fil_ut` int(11) NOT NULL,
  `fil_ta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `jornada` (
  `jor_codigo` int(11) NOT NULL,
  `jor_fecha` date NOT NULL,
  `jor_inicio` time NOT NULL,
  `jor_fin` time DEFAULT NULL,
  `jor_estado` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `jornada_hist` (
  `joh_codigo` int(11) NOT NULL,
  `jor_codigo` int(11) NOT NULL,
  `joh_hora` time NOT NULL,
  `jor_fecha` date NOT NULL,
  `jor_inicio` time NOT NULL,
  `jor_fin` time NOT NULL,
  `jor_estado` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `modulo` (
  `mod_codigo` int(11) NOT NULL,
  `mod_modulo` varchar(2) DEFAULT NULL,
  `usu_codigo` int(11) DEFAULT NULL,
  `mod_ip` varchar(30) DEFAULT NULL,
  `mod_multiusuario` int(2) DEFAULT NULL,
  `mod_feccrea` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `parametro` (
  `par_codigo` int(11) NOT NULL,
  `par_grupo` int(11) NOT NULL,
  `par_nombre` varchar(30) NOT NULL,
  `par_tipo` int(2) NOT NULL,
  `par_valor` varchar(400) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


--
-- Estructura de tabla para la tabla `pausa`
--

CREATE TABLE `pausa` (
  `pau_codigo` int(11) NOT NULL,
  `eje_codigo` int(11) NOT NULL,
  `pau_inicio` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `pau_fin` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfil`
--

CREATE TABLE `perfil` (
  `PER_CODIGO` int(11) NOT NULL,
  `per_nombre` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `per_usu`
--

CREATE TABLE `per_usu` (
  `usu_codigo` int(11) NOT NULL,
  `per_codigo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


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

CREATE TABLE `seguimiento_hist` (
  `hse_codigo` int(11) NOT NULL,
  `seg_codigo` int(11) NOT NULL,
  `fil_codigo` int(11) NOT NULL,
  `fil_nemo` varchar(14) NOT NULL,
  `seg_numero` int(11) NOT NULL,
  `eje_codigo` int(11) NOT NULL,
  `seg_fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `seg_fecllamada` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `seg_llamado` int(1) NOT NULL,
  `seg_seguridad` int(11) NOT NULL,
  `seg_seguimiento` int(1) NOT NULL,
  `seg_fecatencion` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `seg_atendido` int(1) NOT NULL,
  `seg_fecfinatencion` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



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


CREATE TABLE `usu_fila` (
  `usu_codigo` int(11) NOT NULL,
  `fil_codigo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `visitas` (
  `id` mediumint(9) NOT NULL,
  `fecha` datetime NOT NULL,
  `ip` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


CREATE TABLE `visitas_url` (
  `id` mediumint(11) NOT NULL,
  `url` varchar(50) NOT NULL,
  `fecha` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `v_ejecutivo` (
`usu_codigo` int(11)
,`usu_nombres` varchar(30)
,`usu_paterno` varchar(30)
,`usu_materno` varchar(30)
,`usu_cargo` varchar(30)
,`usu_correo` varchar(30)
,`usu_telefono` varchar(30)
,`usu_fecnacimiento` date
,`usu_usuario` varchar(15)
,`usu_password` varchar(15)
,`seg_feccrea` timestamp
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `v_seguimiento`
--
CREATE TABLE `v_seguimiento` (
`seg_codigo` int(11)
,`fil_codigo` int(11)
,`fil_nemo` varchar(14)
,`seg_numero` int(11)
,`eje_codigo` int(11)
,`seg_fecha` timestamp
,`seg_fecllamada` timestamp
,`seg_llamado` int(11)
,`seg_seguridad` int(11)
,`seg_seguimiento` int(11)
,`seg_fecatencion` timestamp
,`seg_atendido` int(11)
,`seg_fecfinatencion` timestamp
);

-- --------------------------------------------------------

--
-- Estructura para la vista `v_ejecutivo`
--
DROP TABLE IF EXISTS `v_ejecutivo`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_ejecutivo`  AS  select `u`.`usu_codigo` AS `usu_codigo`,`u`.`usu_nombres` AS `usu_nombres`,`u`.`usu_paterno` AS `usu_paterno`,`u`.`usu_materno` AS `usu_materno`,`u`.`usu_cargo` AS `usu_cargo`,`u`.`usu_correo` AS `usu_correo`,`u`.`usu_telefono` AS `usu_telefono`,`u`.`usu_fecnacimiento` AS `usu_fecnacimiento`,`u`.`usu_usuario` AS `usu_usuario`,`u`.`usu_password` AS `usu_password`,`u`.`seg_feccrea` AS `seg_feccrea` from ((`usuario` `u` join `per_usu` `pu`) join `perfil` `p`) where ((`u`.`usu_codigo` = `pu`.`usu_codigo`) and (`pu`.`per_codigo` = `p`.`PER_CODIGO`) and (`p`.`per_nombre` = 'EJECUTIVO_ATENCION')) ;

-- --------------------------------------------------------


DROP TABLE IF EXISTS `v_seguimiento`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_seguimiento`  AS  select `seguimiento`.`seg_codigo` AS `seg_codigo`,`seguimiento`.`fil_codigo` AS `fil_codigo`,`seguimiento`.`fil_nemo` AS `fil_nemo`,`seguimiento`.`seg_numero` AS `seg_numero`,`seguimiento`.`eje_codigo` AS `eje_codigo`,`seguimiento`.`seg_fecha` AS `seg_fecha`,`seguimiento`.`seg_fecllamada` AS `seg_fecllamada`,`seguimiento`.`seg_llamado` AS `seg_llamado`,`seguimiento`.`seg_seguridad` AS `seg_seguridad`,`seguimiento`.`seg_seguimiento` AS `seg_seguimiento`,`seguimiento`.`seg_fecatencion` AS `seg_fecatencion`,`seguimiento`.`seg_atendido` AS `seg_atendido`,`seguimiento`.`seg_fecfinatencion` AS `seg_fecfinatencion` from `seguimiento` union select `seguimiento_hist`.`seg_codigo` AS `seg_codigo`,`seguimiento_hist`.`fil_codigo` AS `fil_codigo`,`seguimiento_hist`.`fil_nemo` AS `fil_nemo`,`seguimiento_hist`.`seg_numero` AS `seg_numero`,`seguimiento_hist`.`eje_codigo` AS `eje_codigo`,`seguimiento_hist`.`seg_fecha` AS `seg_fecha`,`seguimiento_hist`.`seg_fecllamada` AS `seg_fecllamada`,`seguimiento_hist`.`seg_llamado` AS `seg_llamado`,`seguimiento_hist`.`seg_seguridad` AS `seg_seguridad`,`seguimiento_hist`.`seg_seguimiento` AS `seg_seguimiento`,`seguimiento_hist`.`seg_fecatencion` AS `seg_fecatencion`,`seguimiento_hist`.`seg_atendido` AS `seg_atendido`,`seguimiento_hist`.`seg_fecfinatencion` AS `seg_fecfinatencion` from `seguimiento_hist` ;


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
-- Indices de la tabla `jornada_hist`
--
ALTER TABLE `jornada_hist`
  ADD PRIMARY KEY (`joh_codigo`);

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
  MODIFY `fil_codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=335;
--
-- AUTO_INCREMENT de la tabla `jornada`
--
ALTER TABLE `jornada`
  MODIFY `jor_codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;
--
-- AUTO_INCREMENT de la tabla `jornada_hist`
--
ALTER TABLE `jornada_hist`
  MODIFY `joh_codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=187;
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
  MODIFY `pau_codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;
--
-- AUTO_INCREMENT de la tabla `perfil`
--
ALTER TABLE `perfil`
  MODIFY `PER_CODIGO` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `seguimiento`
--
ALTER TABLE `seguimiento`
  MODIFY `seg_codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=164;
--
-- AUTO_INCREMENT de la tabla `seguimiento_hist`
--
ALTER TABLE `seguimiento_hist`
  MODIFY `hse_codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2613;
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
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;



CREATE USER 'selenit_root'@'localhost' IDENTIFIED BY 'selenit5566';
GRANT ALL PRIVILEGES ON * . * TO 'selenit_root'@'localhost';