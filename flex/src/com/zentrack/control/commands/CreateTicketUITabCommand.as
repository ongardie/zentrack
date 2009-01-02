package com.zentrack.control.commands
{
	import com.adobe.cairngorm.commands.Command;
	import com.adobe.cairngorm.control.CairngormEvent;
	import com.adobe.cairngorm.control.CairngormEventDispatcher;
	import com.zentrack.control.events.ticket.CreateTicketUITabEvent;
	import com.zentrack.control.events.ui.NewApplicationTabEvent;
	import com.zentrack.model.ModelLocator;

	public class CreateTicketUITabCommand implements Command
	{
		private var __model:ModelLocator = ModelLocator.getInstance();

		public function execute(event:CairngormEvent):void
		{
			CreateTicketUITab(event as CreateTicketUITabEvent);
		}

		public function CreateTicketUITab(event:CreateTicketUITabEvent):void {

			CairngormEventDispatcher.getInstance().dispatchEvent(
				new NewApplicationTabEvent("newTicket", null)
			);

		}
	}
}