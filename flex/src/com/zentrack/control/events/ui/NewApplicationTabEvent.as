package com.zentrack.control.events.ui
{
	import com.adobe.cairngorm.control.CairngormEvent;
	import com.zentrack.valueObjects.Ticket;

	public class NewApplicationTabEvent extends CairngormEvent
	{
		static public var EVENT_ID:String = "newApplicationTabCreated";
		public var tabType:String;
		public var ticket:Ticket;

		public function NewApplicationTabEvent(inTabType:String, inTicket:Ticket) : void {
			tabType = inTabType;
			ticket  = inTicket;

			super(EVENT_ID);
		}
	}
}