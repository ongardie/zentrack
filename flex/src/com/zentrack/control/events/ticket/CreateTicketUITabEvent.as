package com.zentrack.control.events.ticket
{
	import com.adobe.cairngorm.control.CairngormEvent;
	import com.zentrack.valueObjects.Ticket;

	public class CreateTicketUITabEvent extends CairngormEvent
	{
		static public var EVENT_ID:String = "createTicketUITab";

		public function CreateTicketUITabEvent() : void {

			super(EVENT_ID);

		}
		
	}
}