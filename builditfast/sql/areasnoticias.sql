# --------------------------------------------------------

#
# Estructura de tabla para la tabla `area`
#
# Creación: 06-02-2004 a las 14:51:03
# Última actualización: 28-02-2004 a las 13:56:18
#

DROP TABLE IF EXISTS `areasnoticias`;
CREATE TABLE `areasnoticias` (
  `id` int(11) NOT NULL auto_increment,
  `Area` varchar(150) NOT NULL default '',
  `habilitado` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `Area` (`Area`)
) TYPE=MyISAM AUTO_INCREMENT=20 ;
