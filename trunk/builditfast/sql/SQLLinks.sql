
# Estructura de tabla para tabla `links`
# Sergio Cayuqueo <linuxvarela@yahoo.com.ar>
# Dentro de un .bif seria 
# <SQLLinks QUERY="SELECT * FROM links WHERE habilitado=1"/>
# En PHP directo 
# $links = & new SQLLinks(array('QUERY'=>'SELECT * FROM links WHERE habilitado=1'));
# Administrar esta tabla con IDM_links

DROP TABLE IF EXISTS links;
CREATE TABLE links (
  nombre varchar(100) NOT NULL default '',
  url varchar(100) NOT NULL default '',
  descripcion varchar(255) NOT NULL,
  id int(4) NOT NULL auto_increment,
  habilitado tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (id)
) TYPE=MyISAM;
