package com.zentrack.control.events.ui
{
	import com.adobe.cairngorm.control.CairngormEvent;

	public class CloseApplicationTabEvent extends CairngormEvent
	{
		static public var EVENT_ID:String = "applicationTabClosed";

		public function CloseApplicationTabEvent() : void
		{
			super(EVENT_ID);
		}
	}
}