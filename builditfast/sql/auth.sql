CREATE TABLE `auth` (
  `username` varchar(250) NOT NULL default '',
  `password` varchar(250) NOT NULL default '',
  `keys`     varchar(250) NOT NULL default '',
  `level`    int(6)  NOT NULL  default '10',
  `habilitado` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`username`)
) TYPE=MyISAM;
