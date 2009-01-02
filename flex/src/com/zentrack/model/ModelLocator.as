package com.zentrack.model
{
	import com.zentrack.valueObjects.User;
	
	import flash.utils.Timer;
	
	import mx.collections.ArrayCollection;
	import mx.managers.IBrowserManager;
	
	[Bindable]
	public class ModelLocator {
		static private var __instance:ModelLocator = null;

		public var bm:IBrowserManager;

		/**
		 * This string holds the root url/script to the Zentrack API. It is set from
		 * the FlashVars in the HTML file.
		 */
		public var apiLocation:String;

		/**
		 * This is the interval between dashboard ticket refreshes in milliseconds
		 */
		public var refreshInterval:int = 300000;

		/**
		 * The Timer object controlling the auto refresh
		 */
		public var refreshTimer:Timer;

		/**
		 * This string holds the version of the Zentrack API, it
		 * is acquired from the "config" call to the API.
		 */
		public var apiVersion:String;

		public var encryptedPassword:String;

		/**
		 * This string holds a welcome message. Typically, this would be used
		 * on the log on screen of the application.
		 */

		public var welcomeText:String = 
			"Welcome to the DPD Help Desk. If you are " + 
			"an authorized user, please log in below."

		/**
		 * This object holds the users general information
		 */

		public var userInfo:User;

		/**
		 * This string is used to store a summary message describing the
		 * general status of the current users tickets in natural language format.
		 */ 

		public var summaryText:String;

		/**
		 * This is the list of Bin names from Zentrack extracted through
		 * the "config" API call
		 */
		public var bins:Array;

		/**
		 * This is the list of Type names from Zentrack extracted through
		 * the "config" API call
		 */
		public var types:Array;

		/**
		 * This is the list of Priority names from Zentrack extracted through
		 * the "config" API call
		 */
		public var priorities:Array;

		/**
		 * This is the list of Task names from Zentrack extracted through
		 * the "config" API call
		 */
		public var tasks:Array;

		/**
		 * This is the list of System names from Zentrack extracted through
		 * the "config" API call
		 */
		public var systems:Array;

		/**
		 * This is the list of Action names from Zentrack extracted through
		 * the "config" API call
		 */
		public var actions:Array;

		/**
		 * This is the list of Ticket Field names from Zentrack extracted through
		 * the "config" API call.
		 */
		public var ticketFields:ArrayCollection; //todo

		/**
		 * This is the time/date format for fields in the ticket detail
		 * screen
		 */
		public const ticketDetailDateFormat:String = "YYYY/MM/DD L:NN A";

		/**
		 * This is the time/date format for log entries in the ticket detail
		 * screen
		 */
		public const ticketDetailLogDateFormat:String = "YYYY/MM/DD L:NN A";

		/**
		 * This is the index used to control navigation through the main part
		 * of the application ViewStack/pages.
		 * 
		 * 0 = LogOn Page
		 * 1 = Main Application Page 
		 */
		public var applicationState:uint = 0;

		public const VIEWING_LOGON_SCREEN : Number = 0;
		public const VIEWING_APPLICATION_SCREEN : Number = 1;

		/**
		 * This is the index used to control navigation through the tabs in
		 * the Main Application Page
		 */
		public var applicationTabIndex:uint = 0;

		public const VIEWING_DASHBOARD : Number = 0;

		/**
		 * A constant representing the "All Depots" functionality used
		 * by DPD
		 */
		public const allDepots:int = 1;

		/**
		 * Maximum number of tickets to be returned by ticket list query
		 */
		public const ticketLimit:int = 1000;

		/**
		 * All users
		 */
		public var userList:Array;

		/**
		 * A list of log entries
		 */
		public var recentLogs:ArrayCollection = new ArrayCollection ();

		/**
		 * A list of the current users open tickets
		 */
		public var userOpenTickets:ArrayCollection = new ArrayCollection();

		public var allDepotOpenTickets:ArrayCollection = new ArrayCollection();

		public var allTickets:Array = new Array();

		static public function getInstance() : ModelLocator	{
			if (__instance == null) {
				__instance = new ModelLocator();
			}
			return __instance;
		}
	}
}