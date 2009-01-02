package com.zentrack.control.events.logon
{
	import com.adobe.cairngorm.control.CairngormEvent;

	public class LogOnRequestEvent extends CairngormEvent
	{
		static public var EVENT_ID:String = "logOnRequest";
		public var userName:String = "";
		public var password:String = "";

		public function LogOnRequestEvent(inUserName:String, inPassword:String) : void
		{
			super(EVENT_ID);

			userName = inUserName;
			password = inPassword;
		}
		
	}
}