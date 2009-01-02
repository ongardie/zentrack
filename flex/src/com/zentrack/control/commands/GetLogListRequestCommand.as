package com.zentrack.control.commands
{
	import com.adobe.cairngorm.commands.Command;
	import com.adobe.cairngorm.control.CairngormEvent;
	import com.adobe.cairngorm.control.CairngormEventDispatcher;
	import com.zentrack.control.delegates.GetLogListDelegate;
	import com.zentrack.control.events.data.GetLogListRequestEvent;
	import com.zentrack.control.events.ui.LogsUpdatedEvent;
	import com.zentrack.model.ModelLocator;
	import com.zentrack.valueObjects.LogEntry;
	import com.zentrack.valueObjects.Ticket;
	import com.zentrack.valueObjects.User;
	
	import mx.collections.ArrayCollection;
	import mx.controls.Alert;
	import mx.rpc.Responder;
	import mx.rpc.events.FaultEvent;
	import mx.rpc.events.ResultEvent;

	public class GetLogListRequestCommand implements Command
	{
		private var __model:ModelLocator = ModelLocator.getInstance();
		private var currentTicket:Ticket;

		public function execute(event:CairngormEvent):void
		{
			var logListEvent:GetLogListRequestEvent = event as GetLogListRequestEvent;
			currentTicket = logListEvent.ticket;

			var responder:Responder = new Responder(onResults_loadLogs, onFault_showError);
			var delegate:GetLogListDelegate = new GetLogListDelegate(responder);
			delegate.loadLogs(currentTicket.ticketID);
		}

		private function onFault_showError(event:FaultEvent) : void {
			Alert.show("Protocol Error: " + event.message);
		}

		private function convertDate(inDateMS : String) : Date {
			// To convert milliseconds to Flex Date you need to 
			// multiply the unixtime value by 1000
			return inDateMS == null ? null : new Date(int(inDateMS)*1000);
		}

		private function formatUser(userID : int) : String {
			var retVal:String = "Anonymous";

			if (userID == 0) retVal = "System User";

			if (__model.userList[userID] != null) {
				var user:User = __model.userList[userID];
				
				retVal = user.firstName + " " + user.lastName;
			}
			
			return retVal;
		}

		private function onResults_loadLogs(event:ResultEvent):void {
			var newLogAC:ArrayCollection = new ArrayCollection();

			if (event.result.success == "1") {
				for each (var logEntry:XML in event.result.results.log) {

					var newLogEntry:LogEntry = new LogEntry(
						logEntry.lid,
						logEntry.ticket_id,
						formatUser(logEntry.user_id),
						logEntry.bin_id,
						convertDate(logEntry.created),
						logEntry.action,
						logEntry.hours,
						logEntry.entry
					);

					newLogAC.addItem(newLogEntry);
				}

				currentTicket.setLogEntries(newLogAC);
				CairngormEventDispatcher.getInstance().dispatchEvent(new LogsUpdatedEvent());

			} else {
				Alert.show("Request Failed: " + event.result.message);
			}
		}
	}
}