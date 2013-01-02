<?php
/**
 * This file hold class MyAlbum
 * @package BIF3
 */
// {{{ class MyAlbum
/**
 * Album de fotos con paginacion
 * <pre>
 * CREATE TABLE lasfotos (
 *   nombre varchar(100) NOT NULL default '',
 *   img varchar(25) NOT NULL default '',
 *   votos varchar(50) NOT NULL default '0',
 *   id int(4) NOT NULL auto_increment,
 *   PRIMARY KEY  (id)
 * ) TYPE=MyISAM;
 * 
 * DROP TABLE IF EXISTS lasfotos_com;
 * CREATE TABLE lasfotos_com (
 *   id int(4) NOT NULL auto_increment,
 *   com varchar(100) NOT NULL default '',
 *   nick varchar(100) NOT NULL default '',
 *   img varchar(25) NOT NULL default '',
 *   PRIMARY KEY  (id)
 * ) TYPE=MyISAM;
 * </pre>
 * @package  BIF3
 * @subpackage Widgets/Content
 * @author   Sergio Cayuqueo <linuxvarela@yahoo.com.ar>
 * @version  $Revision: 1.1 $
 */
class MyAlbum extends BifWidget {
  // {{{ function Constructor
  /**
   * @parameter $attrs Instance's attributes specified as a hash with the following keys: (in CAPS!)
   * @parameter string NUM numero de pagina
   * @parameter string CANT cantidad de fotos a mostrar por pagina
   * @parameter string DIR directorio de imagenes
   */
function MyAlbum($param = array()) {
    $this->Bifwidget($param);
    }
function innerDraw() {
    if (!$this->attributes['NUM']) {
      $n="0";
    } else {
      $n=$this->attributes['NUM'];
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
    $conta = $_SESSION['_BifApplication']->execQuery("SELECT id FROM lasfotos");
    $quants= $conta->numRows(DB_FETCHMODE_ASSOC);
    $fotos = $_SESSION['_BifApplication']->execQuery("SELECT * FROM lasfotos ORDER BY votos DESC LIMIT ".$n.", ".$cant." ");
        while ($row=$fotos->fetchRow(DB_FETCHMODE_ASSOC))
	{
           if ($linea==0){
    	        $aa ="<tr>";
		$aa1 ="";
		$linea=1;
    	    } else {
		$aa ="";
		$aa1 ="</tr>";
		$linea=0;
	    }
            $h = GetImageSize($dir."/".$row['img']);
            $h[0] = $h[0] + 10 ;
	    $h[1] = $h[1] + 10 ;
	    $this->tpl->setVariable('IWIDTH',$h[0]);
            $this->tpl->setVariable('IHEIGHT',$h[1]);
	    $this->tpl->setVariable('TR',$aa);
	    $this->tpl->setVariable('TRA',$aa1);    
	    $this->tpl->setVariable('DIR',$dir);
	    $this->tpl->setVariable('IMAGEN',$row['img']);
	    $this->tpl->setVariable('VOTOS',$row['votos']);
	    $this->tpl->parse('item');
        }
    for ($i=0; $i< $quants; $i=$i+$cant)
        {
        $a=$a+1; 
        $this->tpl->setVariable('I',$i);
        $this->tpl->setVariable('A',$a);
	$this->tpl->parse('PAGES');
        }
    $this->tpl->setVariable('QUANTS',$quants);

 }
}
// }}}
?>