package com.zentrack.control.commands
{
	import com.adobe.cairngorm.commands.Command;
	import com.adobe.cairngorm.control.CairngormEvent;
	import com.zentrack.control.events.logon.LogOffRequestEvent;
	import com.zentrack.model.ModelLocator;

	public class LogOffRequestCommand implements Command
	{
		private var __model:ModelLocator = ModelLocator.getInstance();

		public function execute(event:CairngormEvent):void
		{
			logOffRequest(event as LogOffRequestEvent);
		}

		private function logOffRequest(event:LogOffRequestEvent):void {
			__model.applicationState = 0; // Log off

			//todo
			// if no arguements are required here, could delete the event parameter
		}
	}
}