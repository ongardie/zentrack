package com.zentrack.control.events.data
{
	import com.adobe.cairngorm.control.CairngormEvent;

	public class GetUserListRequestEvent extends CairngormEvent
	{
		static public var EVENT_ID:String = "getUserListRequest";

		public function GetUserListRequestEvent()
		{
			super(EVENT_ID);
		}
		
	}
}