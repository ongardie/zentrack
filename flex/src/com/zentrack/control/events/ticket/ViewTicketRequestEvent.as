package com.zentrack.control.events.ticket
{
	import com.adobe.cairngorm.control.CairngormEvent;
	import com.zentrack.valueObjects.Ticket;

	public class ViewTicketRequestEvent extends CairngormEvent
	{
		static public var EVENT_ID:String = "viewTicketRequest";
		public var ticket:Ticket;

		public function ViewTicketRequestEvent(inTicket:Ticket) : void {

			super(EVENT_ID);
			ticket = inTicket;

		}
		
	}
}