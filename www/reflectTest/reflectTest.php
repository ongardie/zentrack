<html>
<head>
<title>Reflection Test</title>
<LINK REL=StyleSheet HREF="stylesheet.css" TYPE="text/css">
</head>              
<body bgcolor='#FFFFFF' text='#000000' link='#000066' vlink='#006666'>
<?{

  /*
  **
  **  Version: 1.0
  **  Author: Michael Richardson
  **  Created: 6/13/01
  **  Email: postmaster@phpzen.net
  **  URL: http://www.phpzen.net
  **
  **  Usage: This script is used to examine the contents
  **  Of php, perl, java, or jsp pages.
  **
  **  New pages may be added by simply adding a field to
  **  The pulldown menu, and copying/editing one of the data
  **  Files with the proper expressions to search for
  **  
  **  If problems are encountered with include files not being
  **  found, then check the $rootDir and $includePath directives.
  **  The includePath may be set to multiple directories by seperating
  **  the values with a | symbol.
  **
  */ 
  
  
  /*
  **
  **  SET THESE VARIABLES, "" is acceptable
  **
  */
   
   $script_types_supported = array(
				   "PHP",
				   "PERL",
				   "JSP"
				   );
  
  
  //$rootDir = "/web/phpzen/sub/zengraph/";
  $rootDir = "/web/phpzen/sub/devtrack/";
    //if there is a root directory that the scripts are contained in, then use this
    //this is the root directory documents can be served from
    //if blank, any script can be retrieved from the server.. use with caution!
    //do not make this script publicly accessible unless you carefully
    //configure it to protect your site, and set the rootDir to a proper location
    //trailing slash required
  //$includePath = "/web/phpzen/sub/zengraph/includes/|/web/phpzen/sub/zengraph/www/";
  $includePath = "/web/phpzen/sub/devtrack/includes/|/web/phpzen/sub/devtrack/www/";
    //if included files are found in another directory, you can specify that here.
    //multiple directories can be added using a | to seperate them
    //if a variable appears at the beginning of included files
    //(such as $includeDirectory) you can place that value here as well
    //trailing slash required
  
  /*
  **
  **  NOTHING ELSE TO CONFIGURE
  **
  */
  

  $file = strip_tags($file);
  $file = ereg_replace("^".$rootDir, "", $file);
  
  if( (!$s_d 
       && !$s_s 
       && !$s_g 
       && !$s_i 
       && !$s_f 
       && !$s_sys 
       && !$s_v)
       || $hlp ) {
   
      $s_i =             
      $s_f = 
      $s_d = 
      $s_v = 1;  //set these to 1 if no preferences given
       
   } else {
     //preserves checked options while clicking page links
     $prefstring = "s_s=$s_s&s_g=$s_g&s_i=$s_i&s_f=$s_f&s_sys=$s_sys&s_d=$s_d&s_v=$s_v";
   }
  
   /*
   **
   **  THE SUBMISSION FORM
   **
   */

   include("./submissionForm.php");

  /*
  **
  **  THE FUNCTIONS
  **
  */
   
   include("./functions.php");
   
  /*
  **
  **  THE MEAT
  **
  */

  if( $file ) {
     $filename = $rootDir . $file;
     if( file_exists($filename) ) {
	
	if( $src ) {
	   
	   //show the source of the file, instead of printing analysis
	   
	   print "<a href='$SCRIPT_NAME?file=$file&$prefstring'>Return to Analysis</a><P>\n";				
	   print "<hr width=400 align=left color=teal><P>\n";				
	   show_source($filename);				
	   print "<P><hr width=400 align=left color=teal><P>\n";
	   
	} else {
	   
	   
	   /*
	    **  INITIALIZE PROCESSING VARS
	    */
	   
	   //function matching string
	   //arrays (unset for security)
	   unset($params);
	   unset($p_comments);
	   unset($p_vars);
	   unset($p_globals);
	   unset($p_sessions);
	   unset($p_includes);
	   unset($p_syscalls);
	   //strings (emptied for security)
	   $p_title = '';
	   $p_author = '';
	   $p_version = '';
	   $p_email = '';
	   $p_modified = '';
	   $p_url = '';
	   //sysvars, set for use 
	   $next = '';
	   $in = 0;
	   $head = 1;
	   
	   /*
	    **  GET CONTENTS AND PROCESS
	    */
	   
	   
	   $fileContents = file($filename); 
	   $q = "\"'";
	   for($i = 0; $i < count($fileContents); $i++) {
	      $fileContents[$i] = trim(stripslashes($fileContents[$i]));
	   }
	   
	   if( !$match_open )
	     $in = 1;
	   
	   for($i = 0; $i < count($fileContents); $i++) {
	      $fc = $fileContents[$i];
	      unset($matches);
	      unset($x);
	      trim($fc);
	      
	      //if open tag, then we are in php source
	      if( $match_open && ereg($match_open, $fc) ) {
		 $in = 1;
	      }
	      //if close tag, then we are done with php source
	      if( $match_close && ereg($match_close, $fc) ) {
		 $in = 0;
	      }         
	      
	      if( $head )
		$p_header_line++;
	      
	      if( $head && $in ) {
		 //check to see if header is done
		 if( $fc != "" && !ereg("^".$match_open,$fc) && !ereg("^".$match_long_comment, $fc) )
		   $head = 0;
		 else if( $fc == "" && $head == 2 )
		   $head = 0;
		 else if( $fc == "" )
		   $head = 2;
	      }
	      
	      if( $s_d && $head && $in ) {
		 //examine header contents
		 
		 if( $match_author && eregi($match_author, $fc, $matches) )
		   $p_author = htmlspecialchars($matches[2]);
		 else if( $match_email && eregi($match_email, $fc, $matches) )
		   $p_email = htmlspecialchars($matches[3]);
		 else if( $match_url && eregi($match_url, $fc, $matches) )
		   $p_url = htmlspecialchars($matches[3]);
		 else if( $match_version && eregi($match_version, $fc, $matches) )
		   $p_version = htmlspecialchars($matches[3]);
		 else if( $match_created && eregi($match_created, $fc, $matches) )
		   $p_modified = htmlspecialchars($matches[3]);
		 else if( !ereg("^([".$match_comment_symbol." ]*)$", $fc) ) {
		    if( $match_open )
		      $p_comments[] = htmlspecialchars(ereg_replace("^(".$match_open."|[".$match_comment_symbol." ])+", "", $fc));
		    else {
		       print "comment symbols[ $match_comment_symbol ]<br>\n";//debug
		       $p_comments[] = htmlspecialchars(preg_replace("|^[".$match_comment_symbol."]+|", "", $fc));
		    }
		 }
		 
	      } else if( !$in ) {
		 //in html code, so take a look at it
		 
		 //look for <title>*</title>
		 if( $match_title && eregi($match_title, $fc, $matches) )
		   $p_title = $matches[1];
		 //look for javascript and stylesheet includes
		 else if( $match_javascript && eregi($match_javascript, $fc, $matches) )
		   $p_scripts[] = array($matches[1],$i,'Javascript');
		 //<LINK REL=StyleSheet HREF="aural.css" TYPE="text/css" MEDIA=aural>
		 else if( $match_stylesheet && eregi($match_stylesheet, $fc, $matches) )
		   $p_scripts[] = array($matches[1],$i,'Stylesheet'); 
		 
	      } else if( $in ) {
		 //look for includes, sessions, defines, and variables
		 
		 if( $s_s && $match_session && eregi($match_session, $fc, $matches) && !$p_sessions["$matches[2]"] ) {
		    $p_sessions["$matches[2]"] = array( $i, getComments($i), $matches[1], $matches[3] );
		 } else if( $s_g && $match_define && ereg($match_define, $fc, $matches) && !$p_globals["$matches[2]"] ) {
		    if( !$matches[3] )
		      $matches[3] = "<font color='#999999'>null</font>";
		    else
		      $matches[3] = htmlspecialchars($matches[3]);
		    $p_globals["$matches[2]"] = array( $matches[3], $i, getComments($i) );
		    
		 } else if( $s_f && $in && $match_java_function && eregi($match_java_function, $fc, $matches) ) {
		    //^((public +|static +|private +|protected +|final +|void +)+) +([a-zA-Z0-9_. ]+)\([^)]*\)?
		    $x = explode(",", $matches[4]);
		    if( is_array($x) ) {
		       for( $j = 0; $j < count($x); $j++ ) {
			  if( $match_var_symbol )
			    $x[$j] = ereg_replace($match_var_symbol, "", trim($x[$j]));
			  else
			    $x[$j] = trim($x[$j]);
		       }						  
		    }
		    $params["$matches[3]"] = array(
						   $x,
						   $i, 
						   getComments($i),
						   $matches[1]
						   );				  
		 } else if( $s_f && $in && $match_function && eregi($match_function, $fc, $matches) ) {
		    //found a function, so add it to the list
		    
		    $x = explode(",", $matches[3]);
		    if( is_array($x) ) {
		       for( $j = 0; $j < count($x); $j++ ) {
			  if( eregi("=", $x[$j]) ) {
			     $y = trim( ereg_replace("[$]", "", $x[$j]));
			     if( $match_function_default )
			       $x[$j] = htmlspecialchars(ereg_replace($match_function_default, "\\1 [\\2]", $y ));
			     else
			       $x[$j] = htmlspecialchars($y);
			  } else {
			      if( $match_var_symbol )
			       $x[$j] = ereg_replace($match_var_symbol, "", trim($x[$j]));
			     else
			       $x[$j] = trim($x[$j]);
			  }
		       }
		    }
		    $params["$matches[2]"] = array(
						   $x,
						   $i, 
						   getComments($i)
						   );				  
		    
		 } else if( $s_v && $match_var && eregi($match_var, $fc, $matches) && !$p_vars["$matches[2]"] ) {
		    if( $matches[3] == "" ) {
		       $matches[3] = "&nbsp;";
		    } else {
		       $matches[3] = htmlspecialchars($matches[3]);
		    }
		    $p_vars["$matches[2]"] = array( $matches[3], $i, getComments($i), $matches[0] );
		 } else if( $s_sys && $match_short_syscall && eregi($match_short_syscall, $fc, $matches) ) {
		    $p_syscalls[] = array( $matches[1], $i, getComments($i) );             
		 } else if( $s_sys && $match_syscall && eregi($match_syscall, $fc, $matches) ) {
		    if( $matches[3] )
		      $matches[2] .= $matches[3];
		    $p_syscalls[] = array( $matches[2], $i, getComments($i) );             
		 }
		 
	      }
	      
	   }

   
	    
   /*
    **  PRINT RESULTS
    */
   
	    
   ?>
     &nbsp;<P>
     <b><font size=4 color="#000099"><?=$file?></font></b>
     </p>
     <P>
     <?
			    
     if( $s_d )
       print "<a href='#details'>Details</a>&nbsp;|&nbsp;";
   if( $s_s )
     print "<a href='#sessions'>Sessions</a>&nbsp;|&nbsp;";
   if( $s_g )
     print "<a href='#globals'>Globals</a>&nbsp;|&nbsp;";
   if( $s_sys )
     print "<a href='#syscalls'>System Calls</a>&nbsp;|&nbsp;";
   if( $s_i )
     print "<a href='#includes'>Includes</a>&nbsp;|&nbsp;";
   if( $s_f )
     print "<a href='#functions'>Functions</a>&nbsp;|&nbsp;";
   if( $s_v )
     print "<a href='#vars'>Variables</a>&nbsp;|&nbsp;";
   print "<a href='$SCRIPT_NAME?src=1&file=$file&$prefstring'>Show Source</a>\n";
   ?> 
     
     <? if( $s_d ) { ?>
                                          
       </p><P>&nbsp;<a name='details'></a>
       <P>
       <hr align=left width=400 color='teal'>
       <b>Page Details</b>
       <hr align=left width=400 color='teal'>
       <ul>
       <?
       
         if( $p_title )
           print "Title: ".$p_title."<br>\n";
         if( $p_version )
           print "Version: ".$p_version."<br>\n";
         if( $p_modified )
           print "Modified: ".$p_modified."<br>\n";
         if( $p_author )
           print "Author: ".$p_author."<br>\n";
         if( $p_email )
           print "Contact: <a href='mailto:$p_email'>$p_email</a><br>";
         if( $p_url )
           print "Website: <a href='$p_url'>$p_url</a>";
         if( is_array($p_comments) ) {
           print "<P><i>\n";  
           foreach($p_comments as $c)
             print $c . "<br>\n";
           print "</i>\n";
         }
         
         if( !$p_title && !$p_version && !$p_modified && !$p_author && !$p_url && !is_array($p_comments) )
				print "<font color='#999999'>No page details specified.</font>";

      ?> 
      </ul>
       <P><a href='#top'>top</a><P>&nbsp;<a name='includes'></a>
      
      <? 
       } 
       if( $s_i ) { 
      ?> 
       
       <hr align=left width=400 color='teal'>
       <b>Included Files</b>
       <hr align=left width=400 color='teal'>
       <ul>
       <?
         if( !getIncludes($filename) ) {
           print "<font color='#999999'>No includes found</font>";
         }       
			 
       ?>
       </ul>
       <P><a href='#top'>top</a><P>&nbsp;<a name='sessions'></a>
       
       <? 
         } 
         if( $s_s ) { 
       ?>
       
       <hr align=left width=400 color='teal'>
       <b>Session Information</b>
			<hr align=left width=400 color='teal'>
       <ul>
       <?
         if( is_array($p_sessions) ) {
           print "<table bgcolor='#EEEEEE' width=600><tr>";
			  print "<td class='titleCell'>Name</td>";
			  if( $match_class_casting ) {
				  print "<td class='titleCell'>Type</td>";
				  print "<td class='titleCell'>Value</td>";
			  }
			  print "<td class='titleCell'>Line</td>";
			  print "<td class='titleCell'>Comments</td></tr>\n";
           ksort($p_sessions);
           unset($color);
           foreach($p_sessions as $k=>$v) {
             $color = ($color == '#FFFFFF')? "#DFDFDF" : "#FFFFFF";
             print "<tr bgcolor='$color'>\n";
             print "<td class='nameCell'>$k</td>\n";
				 if( $match_class_casting ) {
					 print "<td class='valueCell'>$v[2]</td>";
					 print "<td class='valueCell'>$v[3]</td>";
			    }
             print "<td class='lineCell'>$v[0]</td>\n";
             print "<td class='commentCell'>$v[1]</td>\n";
             print "</tr>\n"; 
           }
           print "</table>\n";
         } else {
           print "<font color='#999999'>No session variables found.</font>";
         }
       ?>
       </ul>
       <P><a href='#top'>top</a><P>&nbsp;<a name='globals'></a>
			
       <? 
         } 
         if( $s_g ) { 
       ?>
       
       <hr align=left width=400 color='teal'>
       <b>Global Variables</b>
			<hr align=left width=400 color='teal'>
       <ul>
       <?
         if( is_array($p_globals) ) {
           print "<table bgcolor='#EEEEEE' width=600><tr><td class='titleCell'>Name</td><td class='titleCell'>Value</td><td class='titleCell'>Line</td><td class='titleCell'>Comments</td></tr>\n";
           ksort($p_globals);
           unset($color);
           foreach($p_globals as $k=>$v) {
             $color = ($color == '#FFFFFF')? "#DFDFDF" : "#FFFFFF";
             print "<tr bgcolor='$color'>\n";
             print "<td class=nameCell>$k</td>";
             print "<td class=valueCell>$v[0]</td>";
             print "<td class=numberCell>$v[1]</td>";
             print "<td class=commentCell>$v[2]</td>\n";
             print "</tr>\n";
           }
           print "</table>\n";
         } else {
           print "<font color='#999999'>No global variables found.</font>";
         }
       ?>  
       </ul>
       <P><a href='#top'>top</a><P>&nbsp;<a name='syscalls'></a>     
			
       <? 
         } 
         if( $s_sys ) { 
       ?>
       
       <hr align=left width=400 color='teal'>
       <b>System Calls (shell commands)</b>
			<hr align=left width=400 color='teal'>
       <ul>
       <?
         if( is_array($p_syscalls) ) {
           print "<table bgcolor='#EEEEEE' width=600><tr><td class='titleCell'>Command</td><td class='titleCell'>Line</td><td class='titleCell'>Comments</td></tr>\n";         
           unset($color);
           foreach($p_syscalls as $v) {
             $color = ($color == '#FFFFFF')? "#DFDFDF" : "#FFFFFF";
             print "<tr bgcolor='$color'>\n";
             print "<td class='nameCell'>$v[0]</td>";
             print "<td class='lineCell'>$v[1]</td>";
             print "<td class='commentCell'>$v[2]</td>\n";
             print "</tr>\n";
           }
           print "</table>\n";
         } else {
           print "<font color='#999999'>No system calls found.</font>";
         }
       ?>
       </ul>
        <P><a href='#top'>top</a><P>&nbsp;<a name='functions'></a>
		
      <? 
       } 
       if( $s_f ) { 
      ?>
    	
	    <hr align=left width=400 color='teal'>
	    <b>Functions:</b>
	    <hr align=left width=400 color='teal'>
	    <ul>
	    <?
	    
	    if( is_array($params) ) {
	       $sorted_keys = array_keys($params);
	       natcasesort($sorted_keys);
	       $c = count($params);
	       //headings
	       print "<table bgcolor='#EEEEEE' width=600><tr>";
	       print "<td class=\"titleCell\">Name</td>";
	       if( $match_java_function )
		 print "<td class='titleCell'>Modifiers</td>";
	       print "<td class='titleCell'>Parameters</td>";
	       print "<td class='titleCell'>Line</td>";
	       print "<td class='titleCell'>Comments</td></tr>\n";
	       unset($color);
	       //content
	       foreach($sorted_keys as $k) {
		  $p = $params["$k"];
		  $color = ($color == '#FFFFFF')? "#DFDFDF" : "#FFFFFF";         
		  $next = strtoupper(substr($k, 0, 1));
		  if( $c > 10 && $next != $last  ) {
		     //print the new letter
		     print "<tr><td colspan=4 class='subTitle'>$next</td></tr>\n";                     
		     $last = $next;
		  }
		  //print the contents
		  print "<tr bgcolor='$color'>\n";
		  print "<td class='nameCell' valign=top>$k</td>";
		  if( $match_java_function )
		    print "<td class='valueCell' valign=top>".ereg_replace(" ", "<br>", $p[3])."</td>";
		  print "<td class='valueCell' valign=top>\n";
		  if( is_array($p[0]) ) {
		     $i = 0;
		     foreach($p[0] as $v) {
			print ($i > 0)? "<br>".$v : $v;
			$i++;
		     }
		  } 
		  print "</td>";
		  print "<td class='lineCell' valign=top>$p[1]</td>";
		  print "<td class='commentCell' valign=top>$p[2]</td>\n";
		  print "</tr>\n";           
	       }
	       print "</table>\n";
	    } else {
	       print "<font color='#999999'>No page details specified.</font>";
	    }
	  
	  ?>
	    </ul>
	    <P><a href='#top'>top</a>&nbsp;<a name='vars'></a>
	    
	    <? 
            } 
	    if( $s_v ) { 
	       ?>
		 
		 <hr align=left width=400 color='teal'>
		 <b>Page Variables</b>
		 <hr align=left width=400 color='teal'>
		 <ul>
		 <i>Only the first use of each variable is logged</i>
		 <P>
		 <?
		 if( is_array($p_vars) ) {
		    $sorted_keys = array_keys($p_vars);
		    natcasesort($sorted_keys);
		    $c = count($p_vars);
		    //heading
		    print "<table bgcolor='#EEEEEE' width=600><tr>";
		    print "<td class='titleCell'>Name</td>";
		    if( $match_class_casting )
		      print "<td class='titleCell'>Type</td>";
		    print "<td class='titleCell'>Value</td>";
		    print "<td class='titleCell'>Line</td>";
		    print "<td class='titleCell'>Comments</td></tr>\n";                  
		    unset($color);
		    unset($last);
		    //content
		    foreach($sorted_keys as $k) {
		       $v = $p_vars["$k"];
		       
		       //foreach($p_vars as $k=>$v) { //old
		       $next = strtoupper(substr($k, 0, 1));
		       if( $c > 10 && $next != $last  ) {
			  //print the new letter
			  print "<tr><td colspan=4 class='subTitle'>$next</td></tr>\n";                     
			  $last = $next;
		       }           
		       $color = ($color == '#FFFFFF')? "#DFDFDF" : "#FFFFFF";
		       print "<tr bgcolor='$color'>\n";
		       print "<td class=nameCell>$k</td>";
		       if( $match_class_casting )
			 print "<td class='nameCell'>$v[3]</td>";
		       print "<td class=valueCell>$v[0]</td>";
		       print "<td class=numberCell>$v[1]</td>";
		       print "<td class=commentCell>$v[2]</td>\n";
		       print "</tr>\n";
		    }
		    print "</table>\n";
		 } else {
		    print "<font color='#999999'>No variables found.</font>";
		 }
	       ?>  
		 </ul>
		 <P><a href='#top'>top</a>&nbsp;
	       
	       </ul>
		 <?
       
	    }
	    
	 }
	 
      } else {
	 
	 /*
	  **  PAGE NOT FOUND: PRINT ERROR
	  */
	 
	 print "<b><font color='#660000'>That file could not be found ($filename)</font></b>\n";
      }
   }
   
   
}?>

</body>
</html>
