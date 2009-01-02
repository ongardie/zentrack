package com.zentrack.control.events.ticket
{
	import com.adobe.cairngorm.control.CairngormEvent;
	import com.zentrack.valueObjects.Ticket;

	public class RemoveTicketUITabEvent extends CairngormEvent
	{
		static public var EVENT_ID:String = "removeTicketUITab";

		public function RemoveTicketUITabEvent() : void {

			super(EVENT_ID);

		}
		
	}
}