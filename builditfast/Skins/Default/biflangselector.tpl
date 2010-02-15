<form>
  <select name="bif_lang" onchange="top.location.href='?bif_lang=' +  this.form.bif_lang.options[this.form.bif_lang.selectedIndex].value">
<!-- BEGIN OPTIONS -->
    <option {SELECTED} value="{VALUE}">{LANG}</option>
<!-- END OPTIONS -->
  </select>
</form>