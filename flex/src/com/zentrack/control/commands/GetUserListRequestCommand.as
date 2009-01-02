package com.zentrack.control.commands
{
	import com.adobe.cairngorm.commands.Command;
	import com.adobe.cairngorm.control.CairngormEvent;
	import com.zentrack.control.delegates.GetUserListDelegate;
	import com.zentrack.control.events.data.GetRecentLogListRequestEvent;
	import com.zentrack.control.events.data.GetTicketListRequestEvent;
	import com.zentrack.model.ModelLocator;
	import com.zentrack.valueObjects.User;
	
	import mx.controls.Alert;
	import mx.rpc.Responder;
	import mx.rpc.events.FaultEvent;
	import mx.rpc.events.ResultEvent;

	public class GetUserListRequestCommand implements Command
	{
		private var __model:ModelLocator = ModelLocator.getInstance();

		public function execute(event:CairngormEvent):void
		{
			var responder:Responder = new Responder(onResults_loadUsers, onFault_showError);
			var delegate:GetUserListDelegate = new GetUserListDelegate(responder);
			delegate.loadUsers();
		}

		private function onFault_showError(event:FaultEvent) : void {
			Alert.show("Protocol Error: " + event.message);
		}

		private function onResults_loadUsers(event:ResultEvent):void {
			__model.userList = new Array();

			if (event.result.success == "1") {
				for each (var user:XML in event.result.results.user) {

					var newUser:User = new User(
						Number(user.id),
						user.login,
						user.access_level,
						'',
						user.lname, // set this using config structure
						user.fname,
						user.initials,
						user.email,
						user.notes,
						user.homebin,
						__model.bins[user.homebin],
						user.active
					);

					__model.userList[user.user_id] = newUser;

				}

				new GetTicketListRequestEvent().dispatch();
				new GetRecentLogListRequestEvent().dispatch();

			} else {
				Alert.show("Request Failed: " + event.result.message);
			}
		}
	}
}