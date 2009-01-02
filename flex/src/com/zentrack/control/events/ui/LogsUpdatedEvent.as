package com.zentrack.control.events.ui
{
	import com.adobe.cairngorm.control.CairngormEvent;

	public class LogsUpdatedEvent extends CairngormEvent
	{
		static public var EVENT_ID:String = "logListUpdated";

		public function LogsUpdatedEvent() : void
		{
			super(EVENT_ID);
		}
	}
}