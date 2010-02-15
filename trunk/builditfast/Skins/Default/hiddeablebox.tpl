<script type="text/javascript">
<!--
function toggleBox(szDivID) // 1 visible, 0 hidden
{
	var obj = document.getElementById(szDivID + "text");
        obj.style.display = (obj.style.display == "none") ? "block" : "none";
	var obj = document.getElementById(szDivID + "btna");
        obj.style.display = (obj.style.display == "none") ? "inline" : "none";
	var obj = document.getElementById(szDivID + "btnb");
        obj.style.display = (obj.style.display == "none") ? "inline" : "none";
}
// -->
</script>
<table width="100%" class="recuadro" style="background-color: #ffffff;">
<tr>
<td onClick="toggleBox('{ID}');">
<img style="display:inline" ID="{ID}btna" src="Skins/Default/images/btnclosed.png" alt="&gt; "/>
<img style="display:none"  ID="{ID}btnb" src="Skins/Default/images/btnopened.png" alt="v "/>
<b>{TEXT}</b>
</td>
</tr>
<tr>
<td>
<div style="display:none" ID="{ID}text">
     <!-- BEGIN CHILD -->{CHILD}<!-- END CHILD -->
</div>
</td>
</tr>
</table>