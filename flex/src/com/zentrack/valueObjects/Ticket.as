package com.zentrack.valueObjects
{
	import com.adobe.cairngorm.vo.ValueObject;
	
	import mx.collections.ArrayCollection;

	public class Ticket implements ValueObject
	{
		public var ticketID:int         = -1;
		public var summary:String       = "";
		public var description:String   = "";
		public var binID:int            = -1;
		public var bin:String           = "";
		public var status:String        = "";
		public var system:String        = "";
		public var type:String          = "";
		public var owner:String         = "";
		public var creator:String       = "";
		public var openTime:Date        = null;
		public var closeTime:Date       = null;
		public var deadlineTime:Date    = null;
		public var startDate:Date       = null;

		public var logList:ArrayCollection;

		public function Ticket(
			inTicketID:int         = -1,
			inSummary:String       = null,
			inDescription:String   = null,
			inBinID:int            = -1,
			inBin:String           = null,
			inStatus:String        = null,
			inSystem:String        = null,
			inType:String          = null,
			inOwner:String         = null,
			inCreator:String       = null,
			inOTime:Date           = null,
			inCTime:Date           = null,
			inDLTime:Date          = null,
			inSDTime:Date          = null
		) : void {

			ticketID      = inTicketID;
			summary       = inSummary;
			description   = inDescription;
			binID         = inBinID;
			bin           = inBin;
			status		  = inStatus;
			system        = inSystem;
			type          = inType;
			owner         = inOwner;
			creator       = inCreator;
			openTime      = inOTime;
			closeTime     = inCTime;
			deadlineTime  = inDLTime;
			startDate     = inSDTime;

			logList = new ArrayCollection();
		}

		public function setLogEntries(inLogAC:ArrayCollection) : void {
			logList = inLogAC;
		}

		public function getLogEntries() : ArrayCollection {
			return logList;
		}
	}
}