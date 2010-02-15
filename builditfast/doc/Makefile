#
# Makefile para conversion de documentacion DocBook
# Formatos predefinidos HTML PDF TXT
#

all: api user phpdoc

api:
	docbook2html -o api-html api-doc.sgml
	docbook2txt -o api-txt api-doc.sgml
	docbook2pdf api-doc.sgml
user:
	docbook2html -o html manual-es_AR.sgml
	docbook2txt -o user-txt manual-es_AR.sgml
	docbook2pdf manual-es_AR.sgml

phpdoc:
	phpdoc -d tutorials,../Widgets -t API  -o HTML:Smarty:PHP 
