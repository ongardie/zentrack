
;;;;;;;;;;;;;;;;; !!!VERY IMPORTANT!!! ;;;;;;;;;;;;;;;;;;;;
;;;
;;;  USER NOTES:
;;;    When you edit this file for any reason other than the
;;;    initial installation, you must run "install/zen.php changed_config"
;;;    to properly configure the system
;;;
;;;    You may use any property which has been defined in this file
;;;    previously as a variable in another property's value 
;;;    by using %property_name%
;;;
;;;    Note that all settings in this file must appear under a section
;;;    heading, or there will be problems parsing.
;;;
;;;  DEVELOPER NOTES:
;;;    Do not parse this file with parse_ini_file(), use Zen::read_ini()
;;;
;;;    To add/edit the zen.ini file structure, edit 
;;;    install/defaults/zen.ini.template
;;;
;;;    Then run the merge utility to merge in your existing settings 
;;;    with the template structure
;;;
;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;


;;;;;;;;;;;;;;;;; PATH SETTINGS ;;;;;;;;;;;;;;;;;;;;;;;;
;;; path settings refer to the location of the zentrack
;;; files within the system and the website
;;; do not use trailing slashes with path settings
;;;
;;; note that during setup these paths refer to the
;;; TARGET locations, not the current locations
;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;
[paths]

;absolute path to includes directory (not web path)
;for installation, this is the target directory (where they should be installed to)
path_includes = "{$path_includes|default:"/web/zentrack/includes"}" 

;absolute path to www directory (not web path)
;for installation, this is the target directory (where they should be installed to)
path_www = "{$path_www|default:"/web/zentrack/www"}"  

;browser path to zentrack www directory (this should include the domain name)
;for installation, this is the target directory (where they should be installed to)
url_www = "{$url_www|default:"http://mysite.com/zentrack"}"

;path to the php CLI executable (i.e. C:/php/cli/php.exe or /usr/bin/php)
;if the CLI binary is in the system path, a blank is ok here
;this variable is usually needed on windows platforms
path_cli = "{$path_cli}"


;;;;;;;;;;;;;;; DATABASE SETTINGS ;;;;;;;;;;;;;;;;;;;;;;
;;; these settings will point zentrack to your database instance
;;; more database types can be found at: 
;;;   http://php.weblogs.com/ADOdb_manual#drivers
;;;   Some common choices: 
;;;     mssqlpo (sql server)
;;;     mysql
;;;     oci8po (oracle 8/9)
;;;     postgres
;;;     db2
;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;
[db]

; the type of database
; mysql, mysqlt(transaction enabled), postgres, oci8po (oracle), mssqlpo
db_type = "{$db_type|default:"mysql"}"

; domain or ip for database server, sometimes blank is good
db_host = "{$db_host|default:"localhost"}"

; the table set or instance to use for zentrack
db_instance = "{$db_instance|default:"zentrack"}" 

; username for logging into db
db_user = "{$db_user|default:"zentrack"}" 

; password for logging in, sometimes blank for postgres
db_pass = "{$db_pass|default:"zentrack"}"

; whether we should use persistent connections or not
; On improves efficiency, if your db experiences problems
; with too many open connections, or not closing connections
; when you would like, turn this off (1=on, 0=off)
db_persistent = {$db_persistent|default:"1"}

;the prefix for table names, keep in upper case, blank for none
db_prefix = "{$db_prefix|default:"ZENTRACK_"}"

;the length time to cache queries in seconds
;use blank to disable caching
cache_time = {$cache_time}

;;;;;;;;;;;;;;;;; PAGE DISPLAY ;;;;;;;;;;;;;;;;;;;;;;;;;
;;; The properties concerning how pages are displayed
;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;
[layout]

;system name to display
system_name = "{$system_name|default:"ZenTrack"}"       

;the prefix for titles displayed by browser
page_prefix = "{$page_prefix|default:"ZenTrack | "}"    

;the default title displayed by browser
page_title = "{$page_title|default:"Welcome"}"          

;which layout templates to employ
template_set = "{$template|default:"default"}"          

;which language to show by default
default_language = "{$default_language|default:"english"}"        

;;;;;;;;;;;;;;;;; DEBUGGING OUTPUT ;;;;;;;;;;;;;;;;;;;;;
;;; The debug settings are controlled in an xml file
;;; specified by debug_configfile
;;;
;;; Most users will find the default settings 
;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;
[debug]

; 1=true, 0=false, display messages on screen
debug_display = {$debug_display|default:"0"}

; name of the debug config file (must be located in dir_config)
debug_configfile = "{$debug_configfile|default:"debug.xml"}"

; name of log file, blank disables file output (must be located in dir_logs)
debug_logfile = "{$debug_logfile}"

; allows certain security settings to be overridden during development
; set to 1 if you are a developer, otherwise leave this at 0
; this SHOULD NOT be set to 1 in a production environment
develop_mode = {$develop_mode|default:0}

;;;;;;;;;;;;;;; ADVANCED SETTINGS ;;;;;;;;;;;;;;;;;;;;;;
;;; It's probably best to leave these settings "as is"
;;; unless you have been directed otherwise.
;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;

[directories]
dir_cache         = "{$dir_cache|default:"%path_includes%/cache"}"
dir_lib           = "{$dir_lib|default:"%path_includes%/lib"}"
dir_backups       = "{$dir_backups|default:"%path_includes%/backups"}"
dir_config        = "{$dir_config|default:"%path_includes%/config"}"
dir_logs          = "{$dir_logs|default:"%path_includes%/logs"}"
dir_user          = "{$dir_user|default:"%path_includes%/user"}"

dir_dbcache       = "{$dir_dbcache|default:"%dir_cache%/db"}"
dir_attachments   = "{$dir_attachments|default:"%dir_cache%/attachments"}"

dir_classes       = "{$dir_classes|default:"%dir_lib%/classes"}"
dir_templates     = "{$dir_templates|default:"%dir_lib%/templates"}"
dir_helpers       = "{$dir_helpers|default:"%dir_lib%/helpers"}"

[login requirements]
; any directories or files entered here will be excluded from login requirements
; directories should end in /, files should include the relative path 
; from the zentrack root directory
;  Examples:
;     help/               the entire help directory
;     actions/log.php     the log.php file located in subdirectory actions/
;     index.php           the index.php in the root zentrack folder
;
excluded = "{$excluded|default:"help/,styles.php"}"

; any directories or files entered here will be added to login requirements
; this, of course, overrides the excluded directive, so that you can say:
;    excluded = "help/"
;    included = "help/special.php"
; (i.e. help/ directory doesn't require login, except the special.php page)
included = "{$included}"
