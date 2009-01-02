package com.zentrack.valueObjects
{
	import com.adobe.cairngorm.vo.ValueObject;

	public class LogEntry implements ValueObject
	{
		public var logID:int       = -1;
		public var ticketID:int    = -1;
		public var user:String     = "";
		public var binID:int       = -1;
		public var createTime:Date;
		public var action:String   = "";
		public var hours:int       = -1;
		public var entry:String    = "";
		public var summary:String  = "";

		public function LogEntry(
			inLogID:int       = -1,
			inTicketID:int    = -1,
			inUser:String     = "",
			inBinID:int       = -1,
			inCreateTime:Date = null,
			inAction:String   = "",
			inHours:int       = -1,
			inEntry:String    = "",
			inSummary:String  = ""
		) : void {

			logID      = inLogID;
			ticketID   = inTicketID;
			user       = inUser;
			binID      = inBinID;
			createTime = inCreateTime;
			action     = inAction;
			hours      = inHours;
			entry      = inEntry;
			summary    = inSummary;

		}

	}
}