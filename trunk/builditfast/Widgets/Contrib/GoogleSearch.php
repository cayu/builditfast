<?php
/**
 * This file hold class GoogleSearch
 * @package BIF3
 */
// {{{ class GoogleSearch
/**
 * Google API BIF implementation
 * 
 * @package  BIF3
 * @subpackage Widgets/Content
 * @author   Sergio Cayuqueo <linuxvarela@yahoo.com.ar>
 * @version  $Revision: 1.1.2.3 $
 */
    class GoogleSearch extends BifWidget {
  /** {{{ function Constructor
   * @parameter $attrs Instance's attributes specified as a hash with the following keys: (in CAPS!)
   * @parameter string QUERY criterios de la busqueda a realizar
   * @parameter string PAGE numero de pagina de la busqueda
   * @parameter string KEY clave de google API
   * @parameter string LANG lenguaje de la busqueda
   */
	function __construct($attrs = array()) {
	    parent::__construct($attrs);
	    }
        function innerDraw() {
    
	    $REQ=$this->attributes['QUERY'];
	    $pg=$this->attributes['PAGE'];
	    if (!$this->attributes['KEY']){
	    $this->attributes['KEY']='';
	    }
	    if (!$this->attributes['LANG']){
	    $this->attributes['LANG']='';
	    }
	    $google_key = $this->attributes['KEY'];  //GOOGLE API KEY	    
	    $Res_Country = $this->attributes['LANG'];//RESTRICT LANGUAGE

	    if (isset($REQ) && trim($REQ)!="") {
	      $pTime = explode(" ",microtime());
	      $pTime1 = $pTime[1] + $pTime[0];
	      $TREQ = chop(stripslashes(urldecode($REQ)));
	      $REQ = $REQ;

	    if (isset($pg) && $pg > 1) { 
	      $linknum = (($pg-1)*10); $linkT = 10 + $linknum; 
	      }
	  else {  
	      $linknum = 0; $linkT = 10 + $linknum; 
	      }

	    $soapclient = new SoapClient("http://api.google.com/GoogleSearch.wsdl");	
	    $options = array('key' => $google_key,'q'   => $REQ,'start' => $linknum,
	     'maxResults' => 10,'filter' => false,'restrict' => '',
	     'safeSearch' => false,'lr' => $Res_Country,'ie' => '','oe' => '');
	    $result = $soapclient->__soapcall("DoGoogleSearch", $options);
	    $tres = $result->estimatedTotalResultsCount;
	    $PlinkT_tmp = explode(".",$tres/10);
	    $PlinkT = $PlinkT_tmp[0];
	    $tmp = $linkT-9;

	   if($linkT>$tres) { 
	      $linkT=$tres; 
	      }
	   if($tmp>$tres) {
	      $tmp=$tres; $num=0; 
	      }
	  else { 
	      $num=$tmp; 
	      }
	  if ($tres<1000 && !isset($pg) && $tres>=0) {
    	      $soptions = array('key' => $google_key,'phrase'   => $REQ);
              $sresult = $soapclient->__soapcall("doSpellingSuggestion", $soptions);
          if (!is_array($sresult) && trim($sresult)!="") { 
	      $sresult = '<p><font color="red">Did you mean?</font> <a href="'.$PHP_SELF.'?REQ='.$sresult.'">'.$sresult.'</a></p>'; 
	  }
	 else { 
	      $sresult='<br>'; 
	  }
		} else { 
		    $sresult='<br>'; 
		    }
	
	  if ($tres>0) {
	      $linkhtml='';
		  foreach ($result->resultElements as $value) {
		    if ($value->title=="") { $value->title=$value->URL; }
		          $value->title;
		          $value->snippet;
		          $value->URL;
			  $num;
		          $this->tpl->setVariable('TITLE',$value->title);
		          $this->tpl->setVariable('DESCRIPTION',$value->snippet);
		          $this->tpl->setVariable('URL',$value->URL);      
		          $this->tpl->setVariable('NUM',$num);
		          $this->tpl->parse('RESULTS');
		          $num++;
		          unset($result);
			  }

          if ($PlinkT>0) {
	      $Pages=0; $SET='';
		  if(!isset($pg)) { 
			$pg=''; 
			}
		  while ($Pages < $PlinkT) {
			 $Pages++;
			    if ($pg=="" && $SET != 1 || $Pages == $pg) { 
			            $pagehtml = ''.$Pages.'';
				    $SET = 1;
				}
			        else { 
		    		    $pagehtml .= ' <a href="?REQ='.urlencode($TREQ).'&pg='.$Pages.'">'.$Pages.'</a> ';
			        }
    
			    if ($Pages==$pg+10 || $pg>=100) { 
			    break; 
				}
		      }
	  }
        $this->tpl->setVariable('PAGES',$pagehtml);
        $this->tpl->parse('PAGES');

      } elseif ($tres=='0') {
        $linkhtml = & new BifWarning(array('TEXT' => '<center><BR>I&apos;m sorry but your search $TREQ returned no results.<BR></center>'));
        $tres=0;
        $tmp=0;
        $linkT=0;	
      } else {
        $linkhtml = & new BifWarning(array('TEXT' => '<center><BR>ERROR - Google didn&apos;t send a proper responce.<BR></center>'));
        $tres=0;
        $tmp=0;
        $linkT=0;	
      }
       $pTime = explode(" ",microtime());
       $pTime2 = $pTime[1] + $pTime[0];
       $pTime = ($pTime2 - $pTime1);
       $pTime = sprintf ("%.2f", $pTime);
       $this->tpl->setVariable('STARTLINK',$tmp);
       $this->tpl->setVariable('ENDLINK',$linkT);
       $this->tpl->setVariable('TOTAL',$tres);
       $this->tpl->setVariable('SPELL',$sresult);
       $this->tpl->setVariable('RESULTS',$linkhtml);
       $this->tpl->setVariable('KEYWORD',$TREQ);
       $this->tpl->setVariable('TIME',$pTime);
       $this->tpl->parse('SEARCH');
		}
        }
}
?>