package com.zentrack.control.events.data
{
	import com.adobe.cairngorm.control.CairngormEvent;

	public class GetTicketListRequestEvent extends CairngormEvent
	{
		static public var EVENT_ID:String = "getTicketListRequest";

		public function GetTicketListRequestEvent()
		{
			super(EVENT_ID);
		}
		
	}
}