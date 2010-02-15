# Sergio Cayuqueo <sergio@linuxv.com.ar>
# TitleBoxLink Version MySQL
DROP TABLE IF EXISTS sqltitleboxlink;
CREATE TABLE sqltitleboxlink (
  title varchar(100) NOT NULL default '',
  href varchar(100) NOT NULL default '',
  descripcion varchar(255) NOT NULL,
  text varchar(255) NOT NULL,
  id int(4) NOT NULL auto_increment,
  habilitado tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (id)
) TYPE=MyISAM;

