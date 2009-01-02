package com.zentrack.control.events.ticket
{
	import com.adobe.cairngorm.control.CairngormEvent;
	import com.zentrack.valueObjects.LogEntry;

	public class CreateLogRequestEvent extends CairngormEvent
	{
		static public var EVENT_ID:String = "createLogRequest";
		public var log : LogEntry;

		public function CreateLogRequestEvent(inLog:LogEntry) : void {

			super(EVENT_ID);

			log = inLog;
		}
		
	}
}