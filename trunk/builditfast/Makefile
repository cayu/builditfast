PREFIX=/usr
VERSION=CVS
ECHO=echo
# 
# Empty default rule, this will avoid problems
# I used mrproper in my working copy and destroyed CVS information :-/
# ndc 2003-11-26
all: help

help:
	@$(ECHO) "Tipos posibles                                   "
	@$(ECHO) "clean     : limpia los archivos *~               "
	@$(ECHO) "mrproper  : limpia archivos de backup, y del CVS "
	@$(ECHO) "	hacer esto previa a la instalacion de bif3 "
	@$(ECHO) "install   : instala bif3, y crea los enlaces     "
	@$(ECHO) "uninstall : desinstala bif3, y borra los enlaces "
	@$(ECHO) "deb       : crear el paquete debian              "
	@$(ECHO) "docs      : compilar la documentacion            "

deb: mrproper
# remove back-up files
	chmod 755 debian/rules
	fakeroot make -f debian/rules binary-indep

docs:
# remove back-up files
	cd doc && make all


clean:
# remove back-up files
	rm -f `find -name "*~"`

mrproper: clean
# remove CVS info, only use it if you are EXTREAMLLY sure
# or you are packagin'
# No usar en tu copia local del CVS, ya que destruye la informacion
# del servidor
	rm -rf `find -name "CVS"`
	rm -rf `find |grep -F "#"` 
#	rm -rf ${PREFIX}/doc/bif3-${VERSION}/doc/man

install:
# makes necesary directory 
	mkdir -p ${PREFIX}/share/bif3-${VERSION}
	mkdir -p ${PREFIX}/share/doc/bif3-${VERSION}
# copy all files in corresponding directories
	cp -f -a Makefile Base Components Public PEAR Skins Widgets tpl-cache ${PREFIX}/share/bif3-${VERSION}
	cp -f -a doc INSTALL ChangeLog* TODO DEVELOPERS package ${PREFIX}/share/doc/bif3-${VERSION}
	$(MAKE) -C ${PREFIX}/share/bif3-${VERSION} mrproper
#man pages
	mkdir -p   ${PREFIX}/man/man3
	mv ${PREFIX}/share/doc/bif3-${VERSION}/doc/man/man3/*.3  ${PREFIX}/man/man3
# Simbolic link to the latest installed version
	ln -f -s ${PREFIX}/share/bif3-${VERSION} ${PREFIX}/share/bif3

uninstall:
# Desinstala la copia existente de bif3
	rm -rf ${PREFIX}/share/bif3 ${PREFIX}/share/bif3-${VERSION} 
	rm -rf ${PREFIX}/doc/bif3 ${PREFIX}/doc/bif3-${VERSION}
	rm -rf ${PREFIX}/man/man3/bif3*
