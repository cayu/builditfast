VERSION=CVS
NAME=bif3-site
PREFIX=/var/www/html

# Por ahora sólo tenemos clean
clean:
# Esto es para eliminar los archivos de backup
	rm -f `find -name "*~"`

mrproper: clean
# Esto es para eliminar los archivos creados por el CVS
	rm -rf `find -name "CVS"`
	rm -rf `find |grep -F "#"` 

install:
# Crea el directorio BIF3 en /usr/local
	mkdir -p ${PREFIX}/${NAME}-${VERSION}
	cp -f -a * ${PREFIX}/${NAME}-${VERSION}
	ln -f -s ${PREFIX}/${NAME}-${VERSION} ${PREFIX}/${NAME}
