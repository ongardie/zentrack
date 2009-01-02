package com.zentrack.control.events.data
{
	import com.adobe.cairngorm.control.CairngormEvent;
	import com.zentrack.valueObjects.Ticket;

	public class GetLogListRequestEvent extends CairngormEvent
	{
		static public var EVENT_ID:String = "getLogListRequest";
		public var ticket:Ticket;

		public function GetLogListRequestEvent(inTicket : Ticket)
		{
			ticket = inTicket;
			super(EVENT_ID);
		}

	}
}