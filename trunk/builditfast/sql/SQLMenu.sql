
DROP TABLE IF EXISTS menu;
CREATE TABLE menu (
  nombre varchar(100) NOT NULL default '',
  url varchar(100) NOT NULL default '',
  id int(4) NOT NULL auto_increment,
  habilitado tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (id)
) TYPE=MyISAM;
