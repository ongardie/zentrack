package com.zentrack.control.events.ticket
{
	import com.adobe.cairngorm.control.CairngormEvent;
	import com.zentrack.valueObjects.Ticket;
	import com.zentrack.view.components.tabs.NewTicket;

	public class CreateTicketRequestEvent extends CairngormEvent
	{
		static public var EVENT_ID:String = "createTicketRequest";
		public var ticket:Ticket;
//		public var tabToRemove:NewTicket;

		public function CreateTicketRequestEvent(newTicket:Ticket = null) : void {

			super(EVENT_ID);
			if (newTicket == null) {
				ticket = new Ticket();
			} else {
				ticket = newTicket;
			}

		}
		
	}
}