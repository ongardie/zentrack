<?
  /*
  ** This file contains the functions used by the reflectTest script
  ** for recursively retrieving comments, includes, and for setting
  ** up properties given in the script specific config file
  */
  
  
  //this function looks for comments directly before or after 
  //the line passed in $i, allowing for 1 line break between the line
  //and the possible comments
  //if $flag is 1, the search is in reverse
  //if $flag is 2, the search goes forward
  //if $flag is 0, the search starts on $i and then looks back, then forward
  //$contents is the ongoing collection of comments found in the search
  function getComments($i, $flag = 0, $contents = '') {
     global $p_header_line;
     global $fileContents;
     global $match_long_comment;
     global $match_short_comment;
     global $match_comment_symbol;
     
     if( $i <= $p_header_line ) {
	return($contents);
     }
     
     if( $flag == 0 ) {
	//if no flag, then start by checking the line we are on
	if( $match_short_comments && ereg($match_short_comment." *(.*)$", $fileContents[$i], $matches) ) {
	   return($matches[2]);
	} else if( $contents = getComments($i - 1, 1) ) {
	   //look at previous line
	   return($contents);
	} else if( $contents = getComments($i + 1, 2) ) {
	   //look at the next line
	   return($contents);
	}
     } else if( $flag > 0 ) {
	//if flag, then check line and move on
	
	if( $flag == 1 || $flag == 3 ) {
	   if( $fileContents[$i] == '' && $flag != 3 && $fileContents[$i - 1] != '' ) {
	      //if a single blank line, check the next
	      return( getComments($i - 1, 1) );
	   } else if( eregi("^".$match_long_comment, $fileContents[$i]) ) {
	      //as long as there are comments, back track to the beginning of them
	      return( getComments($i - 1, 3) );
	   } else if( $flag == 3 ) {
	      //no more comments, so start collecting on the last line found on
	      return( getComments($i + 1, 2) );
	   } else {
	      //no conditions met, so just return what we have
	      return( $contents );
	   }                                  
	} else if( $flag == 2 ) {
	   
	   if( !$contents && $fileContents[$i] == '' && $fileContents[$i - 1] != '' ) {
	      //if this line is blank, and we haven't found
	      //comments yet, then move on
	      return( getComments($i + 1, 2) );
	   } else if( ereg($match_long_comment." *(.*)", $fileContents[$i], $matches) ) {
	      //see if there is something to add on this line
	      //if so move on
	      $matches[2] = trim($matches[2]);
	      if( $matches[2] ) {
		 $contents .= ($contents)? "<br>" : "";
		 $contents .= htmlspecialchars($matches[2]) . "\n";
	      }
	      return( getComments($i + 1, 2, $contents) );
	   } else {         
	      //no more comments, so return what we have
	      return($contents);
	   }     
	}
	
	
     } //end of getComments function
     
    if( !$contents )
       return("&nbsp;");
     
  }

  //sets the type of file to be analyzed
  //types can be added by copying an existing
  //data file and editing the expressions
  //filename should reflect value
  //in pulldown menu
  function setPageType($type) {
     global $SCRIPT_FILENAME;
     $fileDir = ereg_replace("[^/]+$", "", $SCRIPT_FILENAME);
     if( !file_exists($fileDir.$type) ) {
	$type = "PHP";
     }
     $fileContents = file($fileDir.$type);
     if( !is_array($fileContents) ) {
	die("configuration file could not be opened($fileDir/$type)");
     }
     foreach($fileContents as $fc) {
	$fc = trim($fc);
	if( trim($fc) != "" && !ereg("^//", $fc) ) {
	   $vars = explode(":", $fc, 2);
	   $n = $vars[0];
	   if( $vars[0] && $vars[1] ) {
	      $GLOBALS["$n"] = "$vars[1]";
	   }
	}
     }
  }
  setPageType($type);

  //recursively retrieves includes
  //and print them to the screen as found
  function getIncludes( $file, $flag = '', $parentFile = '' ) {
     global $rootDir;
     global $includePath;
     global $match_include;
     global $SCRIPT_NAME;
     global $prefstring;
     global $PATH;
     
     //look for the file and try to open it
     if( file_exists($file) ) {
	$fileContents = file($file); 
     } else {
	$file = ereg_replace(".*/", "", $file);
	if( $parentFile ) {
	   $pf = ereg_replace("[^/]+$", "", $parentFile);
	   if( file_exists($pf.$file) ) {
	      $file = $pf.$file;
	      $fileContents = file($file);
	   }
	}
	if( !is_array($fileContents) ) {
	   $vals = explode("|", $includePath);
	   for($i = 0; $i < count($vals); $i++) {
	      if( file_exists($vals[$i].$file) ) {
		 $file = $vals[$i].$file;
		 $fileContents = file($file);
	      }
	   }
	}
	if( !is_array($fileContents) && file_exists($rootDir.$file) ) {
	   $file = $rootDir.$file;
	   $fileContents = file($file);
	}
	if( $PATH && !is_array($fileContents) ) {
	   $x = explode(":", $PATH);
	   if( is_array($x) ) {
	      foreach($x as $y) {
		 if( file_exists($x."/".$y) ) {
		    $file = $x."/".$y;
		    $fileContents = file($file);
		 }
	      }
	   }
	}
     }
     
     if( is_array($fileContents) && eregi("^$rootDir", $file) ) {
	$i = 0;
	if( $flag ) {
	   $type = strtoupper(ereg_replace("^.*[.]", "", $file));
	   print "<a href='$SCRIPT_NAME?file=$file&type=$type&$prefstring'>".ereg_replace(".*/", "", $file)."</a>";	   
	}
	foreach($fileContents as $f) {
	   $f = stripslashes(trim($f));
	   if( eregi($match_include, $f, $matches) ) {
	      $res = 1;
	      if( $i == 0 ) {
		 print "<div style='padding-left:10px'>\n";
	      } else if( !$check && $i > 0 )
		   print "<br>\n";
	      $i++;
	      $check = getIncludes($matches[2], 1);
	   }
	}
	print ($i > 0)? "</div>\n" : "\n";   
     } else {
	if( !file_exists($file) )
	  print $file . " <font color='#999999'>(File not found/File empty)</font>";
	else
	  print $file . " <font color='#999999'>(File not viewable)</font>";
	if( $line )
	  print " <font color='#999999'>[$line]</font>";
     }
     return($res);
     
  }

?>
