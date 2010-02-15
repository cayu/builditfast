<!-- BEGIN VIEWBLOCK -->
<form method="POST" action="{ACTION}">
<table border="1" width="100%">
  <tr>
    <td>SimpleWiki View: {WIKIWORD} <b>|</b> {EDIT} <b>|</b>
  {GOTOINDEX} <b>|</b> Go: <input type="text" size="16" name="wikiword">
  <b>|</b> {GOTOLIST} <b>|</b> {GOTODIFF}</td>
  </tr>
  <tr>
    <td>
{CONTENT}
    </td>
  </tr>
  <tr>
    <td>
      <i>Last edited on {LASTEDITED}</i>
    </td>
  </tr>
</table>
</form>
<!-- END VIEWBLOCK -->
<!-- BEGIN EDITBLOCK -->
<FORM action="{ACTION}" method="POST">
  <INPUT type="hidden" name="lockcode" value="{LOCKCODE}">
  <table width="100%" border="1">
    <TR>
      <TD>SimpleWiki Edit: {WIKIWORD} <b>|</b> <INPUT type="submit"
  name="save" value="Save"> <INPUT type="submit" name="cancel" value="Cancel"></TD>
    </TR>
    <tr>
      <TD><textarea rows="20" cols="80" name="newcontent">{CONTENT}</textarea></TD>
    </tr>
    <tr>
      <td><i>You have {LOCKTIME} to edit this page until the lock is released.</i></td>
    </tr>
  </table>
</FORM>
<!-- END EDITBLOCK -->
<!-- BEGIN WARNINGBLOCK -->
<FORM action="{ACTION}" method="POST">
  <table width="100%" border="1">
    <TR>
      <TD>SimpleWiki Warning: {WIKIWORD} <b>|</b> <INPUT type="submit"
  name="ok" value="OK"></TD>
    </TR>
    <tr>
      <TD>{WARNING}</TD>
    </tr>
  </table>
</FORM>
<!-- END WARNINGBLOCK -->
<!-- BEGIN LISTBLOCK -->
<table border="1" width="100%">
  <tr><td>SimpleWiki List: Last modified wiki words first <b>|</b> {GOTOINDEX}</td></tr>
  <tr>
    <td><ul>
<!-- BEGIN WIKIENTRY -->
      <li>{WIKIFILE}</li>
<!-- END WIKIENTRY -->
    </ul></td>
  </tr>
</table>
<!-- END LISTBLOCK -->
<!-- BEGIN REVISIONBLOCK -->
<table border="1" width="100%">
  <tr>
    <td>SimpleWiki Diff: {WIKIWORD} <b>|</b> {GOTOINDEX}
  </tr>
<!-- BEGIN REVENTRY -->
  <tr>
    <td>
From: {REVFROM} - To: {REVTO}
    </td>
  </tr>
  <tr>
    <td>
<tt>{REVINFO}</tt>
    </td>
  </tr>
<!-- END REVENTRY -->
</table>
<!-- END REVISIONBLOCK -->