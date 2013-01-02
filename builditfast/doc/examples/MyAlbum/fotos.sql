DROP TABLE IF EXISTS lasfotos;
CREATE TABLE lasfotos (
  nombre varchar(100) NOT NULL default '',
  img varchar(25) NOT NULL default '',
  votos varchar(50) NOT NULL default '0',
  id int(4) NOT NULL auto_increment,
  PRIMARY KEY  (id)
) TYPE=MyISAM;

--
-- Dumping data for table `lasfotos`
--

INSERT INTO lasfotos (nombre, img, votos, id) VALUES ('Leo Peto Ro Flor Ailu','1.jpg','11',1);
INSERT INTO lasfotos (nombre, img, votos, id) VALUES ('Ro y sus amigos','2.jpg','9',2);
INSERT INTO lasfotos (nombre, img, votos, id) VALUES ('Gatos Borrachos','3.jpg','9',3);
INSERT INTO lasfotos (nombre, img, votos, id) VALUES ('Mas borrachos','4.jpg','10',4);

--
-- Table structure for table `lasfotos_com`
--

DROP TABLE IF EXISTS lasfotos_com;
CREATE TABLE lasfotos_com (
  id int(4) NOT NULL auto_increment,
  com varchar(100) NOT NULL default '',
  nick varchar(100) NOT NULL default '',
  img varchar(25) NOT NULL default '',
  PRIMARY KEY  (id)
) TYPE=MyISAM;

--
-- Dumping data for table `lasfotos_com`
--

INSERT INTO lasfotos_com (id, com, nick, img) VALUES (1,'Esta foto es la mejor loco!!! votenla!','Quemero','4.jpg');
INSERT INTO lasfotos_com (id, com, nick, img) VALUES (2,'  ALTA FOTO, SE NOTAN QUE ESTAN ALPEDO, GALLEGA MM','snake','1.jpg');
INSERT INTO lasfotos_com (id, com, nick, img) VALUES (3,'  Rooo que linda q sos','Seba','2.jpg');

