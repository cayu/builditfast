<center>
<table {BORDER} {ALIGN} {WIDTH} {CELLSPACING} {CELLPADDING}>
<!-- BEGIN item -->
 {TR}
  <td align="center">
   <a ONCLICK="window.open('verfoto.php?img={IMAGEN}','foto',
   'width={IWIDTH},height={IHEIGHT},toolbar=no,scrollbar=no,statusbar=no');"
   TITLE="Foto" HREF="#">
   <IMG border="0" alt="{NOMBRE}" SRC="thumbnail.php?{DIR}/{IMAGEN}"></a><br>
   <b>{NOMBRE}</b><br>
   <a href="#" onclick="window.open('votarfoto.php?id={ID}','voto',
   'width=2,height=2,toolbar=no,scrollbar=no,statusbar=no');">[Votar Foto]</a>
   <br>{VOTOS}<br>
   <a href="#" onclick="window.open('vercomentarios.php?img={IMAGEN}',
   'comentarios','width=180,height=300,toolbar=no,scrollbar=yes,statusbar=no');">
   [Comentarios]</a>
 </td>
 {TRA}
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
</center>