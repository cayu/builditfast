  <table {WIDTH} {BORDER} {CELLSPACING} {CELLPADDING} {ALIGN}>
    <tr height="25" {BGCOLOR}>
      <td width="10%"></td>
      <td width="60%">
	<div align="left"><b><font color="#666666">{TITLE}</font></b></div>
      </td>
      <td width="20%" align="right">
	<a {HREF}>{TEXT}</a>
      </td>
      <td width="10%"></td>
    </tr>
    <tr>
      <td width="10%"></td>
      <td class="contenido" bgcolor="#FFFFFF" colspan=3>
	<font color="#666666">
	  <br>
	    <!-- BEGIN CHILD -->
	    {CHILD}
	    <!-- END CHILD -->
	</font>
      </td>
    </tr>
  </table>