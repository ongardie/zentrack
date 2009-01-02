package com.zentrack.control.commands
{
	import com.adobe.cairngorm.commands.Command;
	import com.adobe.cairngorm.control.CairngormEvent;
	import com.zentrack.control.delegates.GetConfigDelegate;
	import com.zentrack.control.events.data.GetUserListRequestEvent;
	import com.zentrack.model.ModelLocator;
	
	import mx.controls.Alert;
	import mx.rpc.Responder;
	import mx.rpc.events.FaultEvent;
	import mx.rpc.events.ResultEvent;

	public class ConfigRequestCommand implements Command
	{
		private var __model:ModelLocator = ModelLocator.getInstance();

		public function execute(event:CairngormEvent):void
		{
			var responder:Responder = new Responder(onResults_loadConfig, onFault_showError);
			var delegate:GetConfigDelegate = new GetConfigDelegate(responder);
			delegate.loadConfig();
		}

		private function onFault_showError(event:FaultEvent) : void {
			Alert.show("Protocol Error: " + event.message);
		}

		private function assignCollection(xmlList:XMLList):Array {
			var assocArray:Array = new Array();

			for each (var node:XML in xmlList) {
				assocArray[node.@id] = node.toString();
			}

			return assocArray;
		}

		private function onResults_loadConfig(event:ResultEvent):void {

			if (event.result.success == "1") {
				__model.bins       = assignCollection(event.result.results.bins.bin);
				__model.types      = assignCollection(event.result.results.types.type);
				__model.priorities = assignCollection(event.result.results.priorities.priority);
				__model.tasks      = assignCollection(event.result.results.tasks.task);
				__model.systems    = assignCollection(event.result.results.systems.system);
				__model.actions    = assignCollection(event.result.results.actions.action);

				__model.apiVersion = event.result.results.version;

				// load users
				new GetUserListRequestEvent().dispatch();

			} else {
				Alert.show("Request Failed: " + event.result.message);
			}
		}
	}
}