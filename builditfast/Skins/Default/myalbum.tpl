<table {BORDER} {ALIGN} {WIDTH} {CELLSPACING} {CELLPADDING}>
<!-- BEGIN item -->{TR1}{TD1}
<table border="0" cellspacing="0" cellpadding="0">
    <tr>
	<td>
   <font face='Arial' SIZE='-1'>
   <a ONCLICK="window.open('fotos/verfoto.php?img={img}','foto',
   'width={IWIDTH},height={IHEIGHT},toolbar=no,scrollbar=no,statusbar=no');"
   TITLE="Foto" HREF="#">
   <IMG border="0" alt="{NOMBRE}" SRC="thumbnail.php?fotos/images/{img}" align="middle"></a></font>
	</td>
    </tr>
    <tr>
	<td>
	     <font size="-1">{NOMBRE}</font>
	</td>
    </tr>
    <tr>
	<td>
	Votos:{VOTOS}
	</td>
    </tr>
    <tr>
	<td>
   <a href="#" onclick="window.open('fotos/votarfoto.php?id={id}','voto',
   'width=2,height=2,toolbar=no,scrollbar=no,statusbar=no');">[Votar Foto]</a>
	</td>
    </tr>
    <tr>
	<td>
   <a href="#" onclick="window.open('fotos/vercomentarios.php?img={img}',
   'comentarios','width=260,height=460,toolbar=no,scrollbar=yes,statusbar=no');">
   [Comentarios]</a>
	</td>
    </tr>
</table>
{TD2}{TR2}
 <!-- END item -->
</table>
<hr WIDTH="70%">
<table {BORDER} {ALIGN} {WIDTH} {CELLSPACING} {CELLPADDING}>
<tr>
<td align='left'>Encontradas {QUANTS} fotos en la base de datos.</td>
<td align='right'>
<font face='Arial' SIZE='-1' COLOR='#996699'>P&aacute;ginas:</font>
<!-- BEGIN PAGES -->
<a href="?num={I}">{A}</A>
<!-- END PAGES -->
</td>
</tr>
</table>