package com.zentrack.control.commands
{
	import com.adobe.cairngorm.commands.Command;
	import com.adobe.cairngorm.control.CairngormEvent;
	import com.adobe.cairngorm.control.CairngormEventDispatcher;
	import com.zentrack.control.events.ticket.ViewTicketRequestEvent;
	import com.zentrack.control.events.ui.NewApplicationTabEvent;
	import com.zentrack.model.ModelLocator;

	public class ViewTicketRequestCommand implements Command
	{
		private var __model:ModelLocator = ModelLocator.getInstance();

		public function execute(event:CairngormEvent):void
		{
			ViewTicketRequest(event as ViewTicketRequestEvent);
		}

		public function ViewTicketRequest(event:ViewTicketRequestEvent):void {

			CairngormEventDispatcher.getInstance().dispatchEvent(
				new NewApplicationTabEvent("viewTicket", event.ticket)
			);

		}
	}
}