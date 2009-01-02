package com.zentrack.control.events.logon
{
	import com.adobe.cairngorm.control.CairngormEvent;

	public class ConfigRequestEvent extends CairngormEvent
	{
		static public var EVENT_ID:String = "configRequest";

		public function ConfigRequestEvent() : void
		{
			super(EVENT_ID);
		}
		
	}
}