<?

  include("../header.php");
  
  $expand_reports = 1;
  $section = "Reports";
  $system_name = $zen->settings["system_name"];
  if( $_SESSION["login_level"] < $zen->settings["level_reports"] ) {
     $page_tile = "Access Error";    
     $msg = "<p class='hot'>You do not have permission to view the reports.</p>\n"; 
     include("$libDir/nav.php");     
     include("$libDir/footer.php");
     exit;
  }

  $report_params = array("report_name"    => "text",
			 "report_type"    => "string",
			 "date_selector"  => "string",
			 "date_value"     => "int",
			 "date_range"     => "string",
			 "date_low"       => "int",
			 "chart_title"    => "text",
			 "chart_subtitle" => "text",
			 "chart_add_ttl"  => "int",
			 "chart_add_avg"  => "int",
			 "chart_type"     => "string",
			 "chart_options"  => "array",
			 "chart_combine"  => "int",
			 "data_set"       => "array",
			 "text_output"    => "int",
			 );
  $required_report_params = array("report_type","date_selector","date_range","date_value","chart_title","chart_type","text_output","data_set","chart_options");

  $option_names = array(
			"activity" => "Log Activity",
			"count" => "Ticket Count",
			"hours_actual" => "Hours Worked",
			"hours_estimated" => "Hours Estimated",
			"time" => "Time Elapsed"
			);
?>
