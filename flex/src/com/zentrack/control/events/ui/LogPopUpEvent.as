package com.zentrack.control.events.ui
{
	import com.adobe.cairngorm.control.CairngormEvent;

	public class LogPopUpEvent extends CairngormEvent
	{
		static public var EVENT_ID:String = "logPopUp";

		public function LogPopUpEvent() : void
		{
			super(EVENT_ID);
		}
	}
}