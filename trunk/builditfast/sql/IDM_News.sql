CREATE TABLE `noticias` (
  `id` int(11) NOT NULL auto_increment,
  `Titulo` varchar(250) NOT NULL default '',
  `Fecha` int(14) NOT NULL default '0',
  `Imagen` varchar(250) default NULL,
  `Resumen` varchar(250) NOT NULL default '',
  `Contenido` text NOT NULL,
  `habilitado` tinyint(1) NOT NULL default '1',
  `PalabrasClaves` varchar(250) default NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=10 ;
