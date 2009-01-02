package com.zentrack.control.commands
{
	import com.adobe.cairngorm.commands.Command;
	import com.adobe.cairngorm.control.CairngormEvent;
	import com.adobe.cairngorm.control.CairngormEventDispatcher;
	import com.zentrack.control.events.ticket.RemoveTicketUITabEvent;
	import com.zentrack.control.events.ui.CloseApplicationTabEvent;
	import com.zentrack.model.ModelLocator;

	public class RemoveTicketUITabCommand implements Command
	{
		private var __model:ModelLocator = ModelLocator.getInstance();

		public function execute(event:CairngormEvent):void
		{
			RemoveTicketUITab(event as RemoveTicketUITabEvent);
		}

		public function RemoveTicketUITab(event:RemoveTicketUITabEvent):void {

			CairngormEventDispatcher.getInstance().dispatchEvent(new CloseApplicationTabEvent());

		}
	}
}