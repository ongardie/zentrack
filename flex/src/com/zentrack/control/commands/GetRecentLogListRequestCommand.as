package com.zentrack.control.commands
{
	import com.adobe.cairngorm.commands.Command;
	import com.adobe.cairngorm.control.CairngormEvent;
	import com.zentrack.control.delegates.GetRecentLogListDelegate;
	import com.zentrack.control.events.data.GetRecentLogListRequestEvent;
	import com.zentrack.model.ModelLocator;
	import com.zentrack.valueObjects.LogEntry;
	import com.zentrack.valueObjects.User;
	
	import mx.collections.ArrayCollection;
	import mx.controls.Alert;
	import mx.rpc.Responder;
	import mx.rpc.events.FaultEvent;
	import mx.rpc.events.ResultEvent;

	public class GetRecentLogListRequestCommand implements Command
	{
		private var __model:ModelLocator = ModelLocator.getInstance();

		public function execute(event:CairngormEvent):void
		{
			var logListEvent:GetRecentLogListRequestEvent = event as GetRecentLogListRequestEvent;

			var responder:Responder = new Responder(onResults_loadLogs, onFault_showError);
			var delegate:GetRecentLogListDelegate = new GetRecentLogListDelegate(responder);
			delegate.loadLogs();
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
					var formattedUser:String = formatUser(logEntry.user_id);

					// Format the summary string
					var summary:String = logEntry.entry;
					if (summary.match(/^[\w|\r|\n]*$/) || summary == null) summary = "<BLANK>";
					var newLinePattern:RegExp = /(\n|\r)/g;
					summary = summary.replace(newLinePattern, " ");
					summary = "Ticket #" + logEntry.ticket_id + " " +
						formattedUser + " - " +
						logEntry.action + " - '" +
						summary.substr(0, 70);
					if (summary.length > 70) summary += "...";
					summary += "'";

					var newLogEntry:LogEntry = new LogEntry(
						logEntry.lid,
						logEntry.ticket_id,
						formattedUser,
						logEntry.bin_id,
						convertDate(logEntry.created),
						logEntry.action,
						logEntry.hours,
						logEntry.entry,
						summary
					);

					newLogAC.addItem(newLogEntry);
				}

				__model.recentLogs = (newLogAC);

			} else {
				Alert.show("Request Failed: " + event.result.message);
			}
		}
	}
}