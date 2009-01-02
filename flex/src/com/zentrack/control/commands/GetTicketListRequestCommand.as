package com.zentrack.control.commands
{
	import com.adobe.cairngorm.commands.Command;
	import com.adobe.cairngorm.control.CairngormEvent;
	import com.zentrack.control.delegates.GetTicketListDelegate;
	import com.zentrack.model.ModelLocator;
	import com.zentrack.valueObjects.Ticket;
	import com.zentrack.valueObjects.User;
	
	import mx.collections.ArrayCollection;
	import mx.controls.Alert;
	import mx.rpc.Responder;
	import mx.rpc.events.FaultEvent;
	import mx.rpc.events.ResultEvent;

	public class GetTicketListRequestCommand implements Command
	{
		private var __model:ModelLocator = ModelLocator.getInstance();

		public function execute(event:CairngormEvent):void
		{
			var responder:Responder = new Responder(onResults_loadTickets, onFault_showError);
			var delegate:GetTicketListDelegate = new GetTicketListDelegate(responder);
			delegate.loadTickets();
		}

		private function onFault_showError(event:FaultEvent) : void {
			Alert.show("Protocol Error: " + event.message);
		}

		private function convertDate(inDateMS : String) : Date {
			// To convert milliseconds to Flex Date you need to 
			// multiply the unixtime value by 1000
			return inDateMS == null ? null : new Date(int(inDateMS)*1000);
		}

		private function formatUserName(userID:String) : String {
			var retVal:String = "";
			if (userID != "") {
				var user:User = __model.userList[userID];
				if (user.firstName != "") retVal = user.firstName + " "; 
				if (user.lastName != " ") retVal = user.lastName;
			}
			
			return retVal;
		}

		private function onResults_loadTickets(event:ResultEvent):void {
			__model.userOpenTickets     = new ArrayCollection();
			__model.allDepotOpenTickets = new ArrayCollection;

			if (event.result.success == "1") {
				for each (var ticket:XML in event.result.results.ticket) {

					var newTicket:Ticket = new Ticket(
						Number(ticket.id.toString()),
						ticket.title,
						ticket.description,
						Number(ticket.bin_id),
						__model.bins[ticket.bin_id], // set this using config structure
						ticket.status,
						__model.systems[ticket.system_id],
						__model.types[ticket.type_id],
						formatUserName(ticket.owner_id),
						formatUserName(ticket.creator_id),
						convertDate(ticket.otime),
						convertDate(ticket.ctime),
						convertDate(ticket.deadline),
						convertDate(ticket.start_date)
					);

					__model.allTickets[newTicket.ticketID] = newTicket;

					if (ticket.status == 'CLOSED') continue;

					if (ticket.bin_id == __model.userInfo.homeBinID) {
						__model.userOpenTickets.addItem(newTicket);
					} else {
						__model.allDepotOpenTickets.addItem(newTicket);
					}
				}

				var summaryText:String = "Welcome " + __model.userInfo.userName +
					"<br><br>There are " + __model.userOpenTickets.length +
					" of your tickets being worked on for the " +
					__model.userInfo.homeBinName + " depot.<br><br>" + 
					"There are " + __model.allDepotOpenTickets.length +
					" other tickets open that affect all depots";
					
				__model.summaryText = summaryText;
			} else {
				Alert.show("Request Failed: " + event.result.message);
			}
		}
	}
}