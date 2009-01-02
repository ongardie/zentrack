package com.zentrack.control.commands
{
	import com.adobe.cairngorm.commands.Command;
	import com.adobe.cairngorm.control.CairngormEvent;
	import com.zentrack.control.delegates.CreateTicketDelegate;
	import com.zentrack.control.events.ticket.CreateTicketRequestEvent;
	import com.zentrack.model.ModelLocator;
	
	import mx.controls.Alert;
	import mx.rpc.Responder;
	import mx.rpc.events.FaultEvent;
	import mx.rpc.events.ResultEvent;

	public class CreateTicketRequestCommand implements Command
	{
		private var __model:ModelLocator = ModelLocator.getInstance();

		public function execute(event:CairngormEvent):void
		{
			var myEvent:CreateTicketRequestEvent = event as CreateTicketRequestEvent;
			var responder:Responder = new Responder(onResults_checkSuccess, onFault_checkSuccess);
			var delegate:CreateTicketDelegate = new CreateTicketDelegate(responder);
			delegate.sendTicketCreateRequest(myEvent.ticket);
		}

		public function onFault_checkSuccess(event:FaultEvent):void {
			Alert.show("Protocol Error: " + event.message);
		}

		public function onResults_checkSuccess(event:ResultEvent):void {
			var success:String = event.result.success;

			if (success != "1") {
				Alert.show("Data Error: " + event.message);
			}
		}
	}
}