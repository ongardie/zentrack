package com.zentrack.control.events.data
{
	import com.adobe.cairngorm.control.CairngormEvent;

	public class GetRecentLogListRequestEvent extends CairngormEvent
	{
		static public var EVENT_ID:String = "getRecentLogListRequest";

		public function GetRecentLogListRequestEvent()
		{
			super(EVENT_ID);
		}
		
	}
}