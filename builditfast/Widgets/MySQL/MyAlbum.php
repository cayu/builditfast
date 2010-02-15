<?php
/**
 * This file hold class MyAlbum
 * @package BIF3
 */
// {{{ class MyAlbum
/**
 * Album de fotos con paginacion y columnas dinamicas
 * <pre>
 * CREATE TABLE lasfotos (
 *   nombre varchar(100) NOT NULL default '',
 *   img varchar(25) NOT NULL default '',
 *   votos varchar(50) NOT NULL default '0',
 *   id int(4) NOT NULL auto_increment,
 *   PRIMARY KEY  (id)
 * ) TYPE=MyISAM;
 * 
 * @package  BIF3
 * @subpackage Widgets/MySQL
 * @author   Sergio Cayuqueo <linuxvarela@yahoo.com.ar>
 * @version  $Revision: 1.1.2.4 $
 */
class MyAlbum extends BifWidget {
  // {{{ function Constructor
  /**
   * @parameter $attrs Instance's attributes specified as a hash with the following keys: (in CAPS!)
   * @parameter string NUM numero de pagina
   * @parameter string CANT cantidad de fotos a mostrar por pagina
   * @parameter string COLS cantidad columnas por pagina
   * @parameter string DIR directorio de imagenes
   * @parameter string SORT modo de ordenar el ORDER BY id que se DESC o ASC
   */
function __construct($param = array()) {
    parent::__construct($param);
    }
function innerDraw() {
  if ($this->attributes['COLS']) {
        $numcols=$this->attributes['COLS'];
  } else {
    $numcols="2";

      }
    if (!$this->attributes['NUM']) {
      $n="0";
    } else {
      $n=$this->attributes['NUM'];
    }

    if (!$this->attributes['SORT']) {
      $sort="ASC";
    } else {
      $sort=$this->attributes['SORT'];
    }    
    if (!$this->attributes['CANT']) {
      $cant="6";
        } else {
      $cant=$this->attributes['CANT'];
    }
    if (!$this->attributes['DIR']) {
      $dir="images";
        } else {
      $dir=$this->attributes['DIR'];
    }
    if ($this->attributes['ALBUM']) {
	$WHERE = " WHERE album='".$this->attributes['ALBUM']."' ";
    }
    $conta = $_SESSION['_BifApplication']->execQuery("SELECT id FROM images");
    $quants= $conta->numRows(DB_FETCHMODE_ASSOC);
    $fotos = $_SESSION['_BifApplication']->execQuery("SELECT * FROM images ".$WHERE." ORDER BY id ".$sort." LIMIT ".$n.", ".$cant." ");

  for ($i = 1 ; $row = $fotos->fetchRow(DB_FETCHMODE_ASSOC) ; $i++)  {
     $mod = $i % $numcols;
         if ($mod == 1) $this->tpl->setVariable('TR1','<tr>');
	    $this->tpl->setVariable('TD1',"<td>");
	    $this->tpl->setVariable('TD2',"</td>");
         if ($mod == 0) $this->tpl->setVariable('TR2','</tr>');
		$keys = array_keys($row);
	    	foreach($keys as $key) {
		    $this->tpl->setVariable($key,$row[$key]);         
		 }
	    $this->tpl->setVariable('DIR',$dir);		 
	 $this->tpl->parse('item');
	    }
	 if ($mod <> 0) $this->tpl->setVariable('TD','</tr>');
	while ($row=$fotos->fetchRow(DB_FETCHMODE_ASSOC)){
            $h = GetImageSize($dir."/".$row['img']);
	    print_R($dir."/".$row['img']);
            $h[0] = $h[0] + 10 ;
	    $h[1] = $h[1] + 10 ;
	    echo $row['img'];
	    $this->tpl->setVariable('IWIDTH',$h[0]);
            $this->tpl->setVariable('IHEIGHT',$h[1]);
	    $this->tpl->parse('item');
        }
 for ($i=0; $i< $quants; $i=$i+$cant)
   {
       $a=$a+1;
       if ($n==$i){
       $this->tpl->setVariable('I',$i);
       $this->tpl->setVariable('A','<b>'.$a.'</b>');
       $this->tpl->parse('PAGES');
       } else {
       $this->tpl->setVariable('I',$i);
       $this->tpl->setVariable('A',$a);
       $this->tpl->parse('PAGES');
           }
     }

    $this->tpl->setVariable('QUANTS',$quants);

 }
}
// }}}
?>
