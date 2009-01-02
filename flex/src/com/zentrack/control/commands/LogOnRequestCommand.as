package com.zentrack.control.commands
{
	import com.adobe.cairngorm.commands.Command;
	import com.adobe.cairngorm.control.CairngormEvent;
	import com.zentrack.control.delegates.LogOnDelegate;
	import com.zentrack.control.events.logon.ConfigRequestEvent;
	import com.zentrack.control.events.logon.LogOnRequestEvent;
	import com.zentrack.model.ModelLocator;
	import com.zentrack.valueObjects.User;
	
	import mx.controls.Alert;
	import mx.rpc.Responder;
	import mx.rpc.events.FaultEvent;
	import mx.rpc.events.ResultEvent;

	public class LogOnRequestCommand implements Command
	{
		private var __model:ModelLocator = ModelLocator.getInstance();

		public function execute(event:CairngormEvent) : void
		{
  			var logonEvent:LogOnRequestEvent = event as LogOnRequestEvent;
			var responder:Responder = new Responder(onResults_logOnCheck, null);
			var delegate:LogOnDelegate = new LogOnDelegate(responder);
			delegate.sendLogOnCredentials(logonEvent.userName, logonEvent.password);
  		}

		private function onFault_showError(event:FaultEvent) : void {
			Alert.show("Protocol Error: " + event.message);
		}

		private function onResults_logOnCheck(event:ResultEvent) : void {
			var result:XMLList = event.result.results as XMLList;
			var success:String = event.result.success;

			if (success == "1") {

				__model.userInfo = new User(
					result.user_id,
					result.login,
					result.access_level,
					__model.encryptedPassword,
					result.lname,
					result.fname,
					result.initials,
					result.email,
					result.notes,
					result.homebin,
					result.homebinname,
					result.active,
					result.ip_address
				);

				// load config info
				new ConfigRequestEvent().dispatch();

				__model.applicationState = 1; // Logon
				__model.refreshTimer.start(); // Start the auto refresh timer
			} else {
				Alert.show("Logon Failed: " + event.result.message);
			}
		}
	}
}