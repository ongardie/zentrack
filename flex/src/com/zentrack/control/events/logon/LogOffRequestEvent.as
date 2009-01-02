package com.zentrack.control.events.logon
{
	import com.adobe.cairngorm.control.CairngormEvent;

	public class LogOffRequestEvent extends CairngormEvent
	{
		static public var EVENT_ID:String = "logOffRequest";

		public function LogOffRequestEvent() : void
		{
			super(EVENT_ID);
		}
	}
}