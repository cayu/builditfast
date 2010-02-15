DROP TABLE IF EXISTS lasfotos;
CREATE TABLE lasfotos (
  nombre varchar(100) NOT NULL default '',
  img varchar(25) NOT NULL default '',
  id int(4) NOT NULL auto_increment,
  PRIMARY KEY  (id)
) TYPE=MyISAM;

