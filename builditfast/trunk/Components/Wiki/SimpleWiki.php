<?php
/* Copyright (c) 2002,2003 Lunix Soluciones
 * This file is part of Build It Fast (BIF).
 * Build It Fast is distributed under the terms of
 * the GNU General Public License (GNU GPL)
 */ 

/* description
A very simple wiki component, to add wiki functionality to your BIF3 website.
Author: Lucas Di Pentima <lucas@lunix.com.ar>
*/
/* parameters
1ST: path to the content directory
2ND: filename for default WikiPage - defaults to 'IndexPage'
3RD: lock timeout in seconds
4TH: max seconds old that a WikiPage is considered to be 'new'
*/

class SimpleWiki extends Component {
  /* Parameters */
  var $content_dir;
  var $default_index;

  /* Actual wiki view */
  var $content;
  var $actualWikiView;
  
  /* WikiWord regex */
  var $wikiword_regex;

  /* Lock timeout (seconds) */
  var $lock_timeout;

  /* Age a WikiWord is considered new (seconds) */
  var $wiki_age_new;

  /* code visualization flag */
  var $is_code = false;

  function __construct($id, $attrs = array()) {
    parent::__construct($id, $attrs);
  }

  /*****************************************************************/
  /*********************** PUBLIC FUNCTIONS ************************/
  /*****************************************************************/

  function publicInit() {
    $this->content_dir = $this->attributes[0];

    /* Check if path dir is correct */
    if(!(is_dir($this->content_dir) and is_writeable($this->content_dir)
	 and is_readable($this->content_dir))) {
      $w = &new BifWarning(array('TEXT'=>"ERROR: Directory '".$this->content_dir."'doesn't exists, isn't a directory or isn't accesable, please check the first parameter at component ".$this->logicalId));
      $this->actualView = $w->draw();
      return;
    }

    /* Check for RCS directory, create it otherwise */
    if(! is_dir($this->content_dir.'/RCS')) {
      mkdir($this->content_dir.'/RCS', 0777);
    }

    /* Default index page name */
    if(isset($this->attributes[1])) {
      $this->default_index = $this->attributes[1];
    } else {
      $this->default_index = 'IndexPage';
    }

    /* Lock Timeout (1 hour default) */
    if(isset($this->attributes[2])) {
      $this->lock_timeout = $this->attributes[2];
    } else {
      $this->lock_timeout = 3600; /* seconds (1 hour) */
    }

    /* Newness age (1 week default) */
    if(isset($this->attributes[3])) {
      $this->wiki_age_new = $this->attributes[3];
    } else {
      $this->wiki_age_new = 604800; /* seconds (1 week) */
    }    

    /* Check if default index exists, create a default one. */
    $idx = $this->content_dir.'/'.$this->default_index;
    if(! file_exists($idx)) {
      $fh = fopen($idx, 'w');
      fwrite($fh, "---++ BIF SimpleWiki Default Index Page\nThis component is ready to work, you can start editing this page and creating new wiki word.\nMake sure you've RCS installed on your system so that the versioning feature works properly.");
      fclose($fh);
    }

    /* WikiWord detection regex */
    $this->wikiword_regex = "\b[A-Z]+[a-z]+[A-Z]+[A-Za-z0-9]*\b";

    $this->content = $this->default_index;
    
    $this->updateView();
  } /* End publicInit() */
  
  /* Loads a new WikiWord */
  function publicView() {
    $ww = $_SESSION['_BifApplication']->getParameter('wikiword');
    if($this->isWikiWord($ww)) {
      $this->content = $ww;
    }
    $this->updateView();
  } /* End publicView() */

  /* Shows an edit form */
  function publicEdit() {
    $wiki_word = $_SESSION['_BifApplication']->getParameter('wikiword');
    $version = $_SESSION['_BifApplication']->getParameter('version');
    if($this->isWikiWord($wiki_word)) {
      $wiki_file = $this->getWikiFileName($wiki_word);
      
      if(is_file($wiki_file) and is_readable($wiki_file) 
	 and is_writeable($wiki_file)) {
	
	/* Set up lock */
	$lock_code = $this->getLockCode();
	$locked = $this->getLock($wiki_file, $lock_code);
	
	/* Set up new template */
	$this->tpl = &new HTML_Template_SIGMA;
	$this->tpl->loadTemplateFile(dirname(__FILE__).'/SimpleWiki.tpl');

	if(! $locked) {
	  /* Load file contents */
	  $fh = fopen($wiki_file, 'r');
	  $c = fread($fh, filesize($wiki_file));
	  fclose($fh);
	
	  /* Set vars */
	  $this->tpl->setVariable('ACTION', '?action='.$this->logicalId.'.Save&wikiword='.$wiki_word);
	  $this->tpl->setVariable('LOCKCODE', $lock_code);
	  $this->tpl->setVariable('WIKIWORD', '<b>'.$wiki_word.'</b>');
	  $this->tpl->setVariable('CONTENT', $c);
	  $this->tpl->setVariable('LOCKTIME', $this->lock_timeout.' seconds');

	  $this->tpl->parse('EDITBLOCK');
	  
	} else {
	  /* WikiWord file is locked, make a warning */
	  $this->tpl->setVariable('ACTION', '?action='.$this->logicalId.'.View&wikiword='.$wiki_word);
	  $this->tpl->setVariable('WIKIWORD', '<b>'.$wiki_word.'</b>');
	  $this->tpl->setVariable('WARNING', "<br><b>The WikiWord '$wiki_word' is being edited by another user, please come back in ".(filemtime($this->getLockFileName($wiki_file))+$this->lock_timeout-time())." seconds.</b><br><br>");
	  $this->tpl->parse('WARNINGBLOCK');
	}

	$this->actualView = $this->tpl->get();
      }
    }
  } /* End publicEdit() */

  /* List wikiwords */
  function publicList() {
    $dh = opendir($this->content_dir.'/');
    $list = array();
    /* Set up new template */
    $this->tpl = &new HTML_Template_SIGMA;
    $this->tpl->loadTemplateFile(dirname(__FILE__).'/SimpleWiki.tpl');
    
    /* Render wiki index link */
    $this->tpl->setVariable('GOTOINDEX', 'Go: <a href="?action='.$this->logicalId.'.View&wikiword='.$this->default_index.'">'.$this->default_index.'</a>');

    while(false !== ($file = readdir($dh))) {
      if($file != '.' && $file != '..') {
	if($this->isWikiWord($file)) {
	  $list[$file] = filemtime($this->getWikiFileName($file));
	}
      }
    }
    /* Sort array: newer editions first */
    arsort($list);

    /* Render new and old wikiwords */
    foreach($list as $ww => $timestamp) {
      if((time() - filemtime($this->getWikiFileName($ww))) <  $this->wiki_age_new) {
	$this->tpl->setVariable('WIKIFILE', $this->convertFromWikiFormat($ww.' -- _Last edited on '.date("F d Y H:i", $timestamp).'_ -- *new!*'));
	$this->tpl->parse('WIKIENTRY');	
      } else {
	$this->tpl->setVariable('WIKIFILE', $this->convertFromWikiFormat($ww.' -- _Last edited on '.date("F d Y H:i", $timestamp).'_'));
      }
      $this->tpl->parse('WIKIENTRY');
    }

    $this->tpl->parse('LISTBLOCK');
    closedir($dh);
    $this->actualView = $this->tpl->get();
  } /* End publicList() */

  function publicDiff() {
    $versions = array();
    exec('rlog '.$this->getWikiFileName($this->content).' | grep "^revision " | awk \'{print $2}\'', $versions, $err);

    /* Set up new template */
    $this->tpl = &new HTML_Template_SIGMA;
    $this->tpl->loadTemplateFile(dirname(__FILE__).'/SimpleWiki.tpl');

    if(count($versions) > 1) {
      for($i = 0; $i < count($versions)-1; $i++) {
	$output = array();
	exec('rcsdiff -r'.$versions[$i].' -r'.$versions[$i+1].' '.$this->getWikiFileName($this->content), $output, $err);
	$revinfo = "";
	foreach($output as $line) {
	  $revinfo .= $line."<br>";
	}
	$this->tpl->setVariable('REVFROM', $versions[$i]);
	$this->tpl->setVariable('REVTO', '<a href="?action='.$this->logicalId.'.RecoverVersion&wikiword='.$this->content.'&version='.$versions[$i+1].'">'.$versions[$i+1].'</a>');
	$this->tpl->setVariable('REVINFO', $revinfo);
	$this->tpl->parse('REVENTRY');
      }
    } else {
      /* If there aren't two or more versions yet... */
      $this->tpl->setVariable('REVFROM', '???');
      $this->tpl->setVariable('REVTO', '???');
      $this->tpl->setVariable('REVINFO', '<b>This is the first version of the page, I don\'t have another version to compare with.</b>');
      $this->tpl->parse('REVENTRY');
    }
    
    $this->tpl->setVariable('WIKIWORD', '<b><a href="?action='.$this->logicalId.'.View&wikiword='.$this->content.'">'.$this->content.'</a></b>');
    $this->tpl->setVariable('GOTOINDEX', 'Go: <a href="?action='.$this->logicalId.'.View&wikiword='.$this->default_index.'">'.$this->default_index.'</a>');
    $this->tpl->parse('REVISIONBLOCK');

    $this->actualView = $this->tpl->get();
  } /* End publicDiff() */

  /* Saves new content */
  function publicSave() {
    $wiki_word = $_SESSION['_BifApplication']->getParameter('wikiword');
    $wiki_file = $this->content_dir.'/'.$wiki_word;
    $lock_file = $this->getLockFileName($wiki_file);
	
    if($this->isWikiWord($wiki_word)) {
      $lock_code = $_SESSION['_BifApplication']->getParameter('lockcode');
      $save = $_SESSION['_BifApplication']->getParameter('save');
      $newcontent = $_SESSION['_BifApplication']->getParameter('newcontent');

      /* Remove backslashes */
      $newcontent = stripcslashes($newcontent);
      
      if($save) {
	if((is_file($wiki_file) and is_readable($wiki_file) 
	    and is_writeable($wiki_file)) or (! file_exists($wiki_file))) {

	  /* If lock exists, check for ownership. */
	  if(!($this->isLocked($wiki_file)) or 
	     $this->isLockedByMe($wiki_file, $lock_code)) {

	    /* Strip HTML Tags with exceptions*/
	    $newcontent = strip_tags($newcontent, '<pre> <code>');

	    /* It's time to save new data. */
	    $fh = fopen($wiki_file, 'w');
	    fwrite($fh, "$newcontent");
	    fclose($fh);

	    /* Register new version on RCS */
	    system("ci -l $wiki_file");
	    $this->content = $wiki_word;
	  }
	}
      }
      /* clean lock file */
      $this->cleanLock($wiki_file);
    }
    $this->updateView();
  } /* End publicSave() */

  /* Creates a new WikiWord */
  function publicCreate() {
    $wiki_word = $_SESSION['_BifApplication']->getParameter('wikiword');
    $wiki_file = $this->content_dir.'/'.$wiki_word;

    /* Set up lock */
    $lock_code = $this->getLockCode();
    $locked = $this->getLock($wiki_file, $lock_code);

    /* Set up new template */
    $this->tpl = &new HTML_Template_SIGMA;
    $this->tpl->loadTemplateFile(dirname(__FILE__).'/SimpleWiki.tpl');

    if(! $locked) {
      /* Set vars */
      $this->tpl->setVariable('ACTION', '?action='.$this->logicalId.'.Save&wikiword='.$wiki_word);
      $this->tpl->setVariable('LOCKCODE', $lock_code);
      $this->tpl->setVariable('WIKIWORD', '<b>'.$wiki_word.' (new)</b>');
      $this->tpl->parse('EDITBLOCK');
    } else {
      /* WikiWord file is locked, make a warning */
      $this->tpl->setVariable('ACTION', '?action='.$this->logicalId.'.View&wikiword='.$wiki_word);
      $this->tpl->setVariable('WIKIWORD', '<b>'.$wiki_word.'</b>');
      $this->tpl->setVariable('WARNING', "<br><b>The WikiWord '$wiki_word' is being edited by another user, please come back in ".(filemtime($this->getLockFileName($wiki_file))+$this->lock_timeout-time())." seconds.</b><br><br>");
      $this->tpl->parse('WARNINGBLOCK');
    }
      
    $this->actualView = $this->tpl->get();

  } /* End publicCreate() */

  /* Recover actual WikiWord to some version */
  function publicRecoverVersion($wiki_word, $version) {
    $wiki_word = $_SESSION['_BifApplication']->getParameter('wikiword');
    $version = $_SESSION['_BifApplication']->getParameter('version');
    $wiki_file = $this->getWikiFileName($wiki_word);

    /* Extract the newest revision number */
    exec('rlog '.$wiki_file.' | grep "^revision " | awk \'{print $2}\'', $versions);
    $version_new = $versions[0];

    /* Check input data */
    if((!$this->isWikiWord($wiki_word)) or (!in_array($version, $versions))) {
      die("ouch!!: $wiki_word - $version");
    }

    if(is_file($wiki_file) and is_readable($wiki_file) 
       and is_writeable($wiki_file)) {
	
      /* Set up lock */
      $lock_code = $this->getLockCode();
      $locked = $this->getLock($wiki_file, $lock_code);
	
      if(!$locked) {
	/* Do some RCS magic */
	exec('ci '.$wiki_file);
	exec('co -l'.$version.' '.$wiki_file);
	exec('rcs -u'.$version.' '.$wiki_file);
	exec('rcs -l'.$version_new.'  '.$wiki_file);
	exec('ci -l '.$wiki_file);

	/* Release lock */
	$this->cleanLock($wiki_file);

	$this->content = $wiki_word;
	$this->updateView();
      } else {
	/* If it's locked, show warning */

	/* Set up new template */
	$this->tpl = &new HTML_Template_SIGMA;
	$this->tpl->loadTemplateFile(dirname(__FILE__).'/SimpleWiki.tpl');

	$this->tpl->setVariable('ACTION', '?action='.$this->logicalId.'.View&wikiword='.$wiki_word);
	$this->tpl->setVariable('WIKIWORD', '<b>'.$wiki_word.'</b>');
	$this->tpl->setVariable('WARNING', "<br><b>The WikiWord '$wiki_word' is being edited by another user, please come back in ".(filemtime($this->getLockFileName($wiki_file))+$this->lock_timeout-time())." seconds.</b><br><br>");
	$this->tpl->parse('WARNINGBLOCK');

	$this->actualView = $this->tpl->get();
      }
    }
  } /* End publicRecoverVersion() */


  /*****************************************************************/
  /*********************** PRIVATE FUNCTIONS ***********************/
  /*****************************************************************/

  /* Re-renders component */
  function updateView() {
    
    $this->tpl = &new HTML_Template_SIGMA;
    $this->tpl->loadTemplateFile(dirname(__FILE__).'/SimpleWiki.tpl');
    
    $this->actualWikiView = $this->parseWiki($this->content);
    $this->tpl->setVariable('WIKIWORD', '<b><a href="?action='.$this->logicalId.'.View&wikiword='.$this->content.'">'.$this->content.'</a></b>');
    $this->tpl->setVariable('CONTENT', $this->actualWikiView);
    $this->tpl->setVariable('EDIT', '<a href="?action='.$this->logicalId.'.Edit&wikiword='.$this->content.'">Edit</a>');
    $this->tpl->setVariable('GOTOINDEX', 'Go: <a href="?action='.$this->logicalId.'.View&wikiword='.$this->default_index.'">'.$this->default_index.'</a>');
    $this->tpl->setVariable('GOTOLIST', '<a href="?action='.$this->logicalId.'.List">Site Map</a>');
    $this->tpl->setVariable('GOTODIFF', '<a href="?action='.$this->logicalId.'.Diff">View Diffs</a>');
    $this->tpl->setVariable('ACTION', '?action='.$this->logicalId.'.View');
    if(is_file($this->getWikiFileName($this->content))) {
      $this->tpl->setVariable('LASTEDITED', date("F d Y H:i", filemtime($this->content_dir.'/'.$this->content)));
    } else {
      $this->tpl->setVariable('LASTEDITED', '[not yet created]');
    }
    $this->tpl->parse('VIEWBLOCK');
    
    $this->actualView = $this->tpl->get();
  } /* End updateView() */

  /* Wiki format parser */
  function parseWiki($wiki_word) {

    $wiki_file = $this->content_dir . "/". $wiki_word;

    /* If file doesn't exists or is not readable... */
    if(! (is_file($wiki_file) and is_readable($wiki_file))) {
      $contents = $this->convertFromWikiFormat('*Warning:* The wiki word you\'re trying to view doesn\'t exist. Click to create '.$wiki_word);
    } else {
      $fh = fopen($wiki_file, 'r');
      /* Line by line processing... */
      while(! feof($fh)) {
	$line = fgets($fh, 4096);
	$line = $this->convertFromWikiFormat($line);

	/* Add converted line to final content */
	$contents .= $line;
      }
      fclose($fh);
    }

    return $contents;
  } /* End parseWiki() */

  /* WikiWord detection */
  function isWikiWord($string) {
    if(preg_match("/^$this->wikiword_regex\$/", $string)) {
      return TRUE;
    } else {
      return FALSE;
    }
  } /* End isWikiWord() */

  function createLock($lock_file, $lock_code) {
    $lh = fopen($lock_file, 'w');
    fwrite($lh, $lock_code);
    fclose($lh);
  } /* End createLock() */

  function getLockFileName($wiki_file) {
    return $wiki_file.'.lck';
  } /* End getLockFileName() */

  function getWikiFileName($wiki_name) {
    return $this->content_dir.'/'.$wiki_name;
  } /* End getWikiFileName */

  /* Checks if lock file is valid, if ont gets own lock */
  function getLock($wiki_file, $lock_code) {
    $lock_file = $this->getLockFileName($wiki_file);
    $locked = FALSE;
    clearstatcache();
    if(is_file($lock_file)) {
      $locked = ((filemtime($lock_file) + $this->lock_timeout) > time());
      if(! $locked) {
	unlink($lock_file);
	$this->createLock($lock_file, $lock_code);
      }
    } else {
      $this->createLock($lock_file, $lock_code);
    }
    return $locked;
  } /* End getLock() */

  function isLocked($wiki_file) {
    return is_file($this->getLockFileName($wiki_file)) and 
      ((filemtime($this->getLockFileName($wiki_file)) + 
	$this->lock_timeout) > time());
  } /* End isLocked() */
  
  function isLockedByMe($wiki_file, $lock_code) {
    if($this->isLocked($wiki_file)) {
      $lock_file = $this->getLockFileName($wiki_file);
      
      $lh = fopen($lock_file, 'r');
      $file_code = fread($lh, filesize($lock_file));
      fclose($lh);
      
      return ($file_code == $lock_code);
    }
    return FALSE;
  } /* End isLockedByMe() */

  function getLockCode() {
    return rand(1,10000);
  } /* End getLockCode() */

  function cleanLock($wiki_file) {
    @unlink($this->getLockFileName($wiki_file));
  } /* End cleanLock() */

  /* --------- Wiki format conversions (TWiki compatible)  -------- */
  function convertFromWikiFormat($line) {
    
    /* This is for literal monospaced code visualization */
    if (ereg ('^<code>$', trim($line)) and !$this->is_code) {
      $this->is_code = true;
      return '<pre>';
    } else if (ereg ('^</code>$', trim($line)) and $this->is_code) {
      $this->is_code = false;
      return '</pre>';
    }

    if (!$this->is_code) {
      /* Line breaks */
      $line = eregi_replace("\n", "<br>", $line);
      
      /* Bold: *something* */
      $line = eregi_replace("\*([^\*.]*)\*", "<b>\\1</b>", $line);
      
      /* Bold & Italics: __something__ */
      $line = eregi_replace("\__([^_.]*)\__", "<b><i>\\1</i></b>", $line);
      
      /* Italics: _something_ */
      $line = eregi_replace("\_([^_.]*)\_", "<i>\\1</i>", $line);
      
      /* Headings: ---+ something */
      $line = eregi_replace("^---\+ (.*)", "<h1>\\1</h1>", $line);
      $line = eregi_replace("^---\+\+ (.*)", "<h2>\\1</h2>", $line);
      $line = eregi_replace("^---\+\+\+ (.*)", "<h3>\\1</h3>", $line);
      $line = eregi_replace("^---\+\+\+\+ (.*)", "<h4>\\1</h4>", $line);
      $line = eregi_replace("^---\+\+\+\+\+ (.*)", "<h5>\\1</h5>", $line);
      $line = eregi_replace("^---\+\+\+\+\+\+ (.*)", "<h6>\\1</h6>", $line);
      
      /* Fixed & Bold: ==something== */
      $line = eregi_replace("==([^=.]*)==", "<b><tt>\\1</tt></b>", $line);
      
      /* Fixed: =something= */
      $line = eregi_replace("=([^=.]*)=", "<tt>\\1</tt>", $line);
      
      /* Horizontal Line: ---------- (at least 3 dashes at beginning of line */
      $line = eregi_replace("^-{3,}", "<hr>", $line);
      
      /* List item */
      $line = eregi_replace("^   \* (.*)", "<li>\\1</li>", $line);
      
      /* Basic URL render */
      $line = ereg_replace("[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]",
			   "<a href=\"\\0\">\\0</a>", $line);
      /* WikiWord render */
      if(preg_match("/".$this->wikiword_regex."/", $line)) {
	preg_match_all("/".$this->wikiword_regex."/", $line, $wiki_words);
	foreach(array_unique($wiki_words[0]) as $word) {
	  if(file_exists($this->content_dir."/".$word)) {
	    $line = preg_replace("/\b".$word."\b/", "<a href=\"?action=".$this->logicalId.".View&wikiword=".$word."\">".$word."</a>", $line);
	  } else {
	    $line = preg_replace("/\b".$word."\b/", "<i>".$word."</i><a href=\"?action=".$this->logicalId.".Create&wikiword=".$word."\">?</a>", $line);
	  }
	}
      }
      
      /* Specific links: [[wiki syntax]] -> WikiSyntax */
      $regex = '\[\[([^].]*)\]\]';
      while (ereg ($regex, $line, $stuff)) {
	$stuff_capitalized = ucwords ($stuff[1]);
	$stuff_ww = ereg_replace (' +', '', $stuff_capitalized);
	
	if(file_exists($this->content_dir."/".$stuff_ww)) {
	  $new_stuff = '<a href="?action='.$this->logicalId.'.View&wikiword='.$stuff_ww.'">'.$stuff[1].'</a>';
	} else {
	  $new_stuff = '<i>'.$stuff[1].'</i><a href="?action='.$this->logicalId.'.Create&wikiword='.$stuff_ww.'">?</a>';
	}
	
	$line = str_replace($stuff[0], $new_stuff, $line);
      }
    }
      
    /* --------------------- end of conversions ---------------------- */
    return $line;
  }  /* End convertFromWikiFormat() */

} /* End class SimpleWiki */
?>