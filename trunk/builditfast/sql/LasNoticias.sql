# Tabla del Widget LasNoticias, para el sitio LinuxVarela
# Sergio Cayuqueo <linuxvarela@yahoo.com.ar>
#
 CREATE TABLE noticias (
 Fecha int (14) NOT NULL,
 habilitado int(4) DEFAULT '1' NOT NULL,
 Contenido TEXT NOT NULL,
 PalabrasClaves TEXT NOT NULL,
 Resumen varchar(250) NOT NULL,
 Imagen varchar(50),
 Titulo varchar(40) NOT NULL,
 Area int(11) NOT NULL DEFAULT '0',
 id int(4) DEFAULT '0' NOT NULL AUTO_INCREMENT,
 PRIMARY KEY(id)
 );


