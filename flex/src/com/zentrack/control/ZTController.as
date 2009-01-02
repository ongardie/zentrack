package com.zentrack.control
{
	import com.adobe.cairngorm.control.FrontController;
	import com.zentrack.control.commands.*;
	import com.zentrack.control.events.data.GetLogListRequestEvent;
	import com.zentrack.control.events.data.GetRecentLogListRequestEvent;
	import com.zentrack.control.events.data.GetTicketListRequestEvent;
	import com.zentrack.control.events.data.GetUserListRequestEvent;
	import com.zentrack.control.events.logon.*;
	import com.zentrack.control.events.ticket.*;

	public class ZTController extends FrontController
	{
		public function ZTController()
		{
			addCommand(LogOnRequestEvent.EVENT_ID,            LogOnRequestCommand);
			addCommand(ConfigRequestEvent.EVENT_ID,           ConfigRequestCommand);
			addCommand(GetUserListRequestEvent.EVENT_ID,      GetUserListRequestCommand);
			addCommand(LogOffRequestEvent.EVENT_ID,           LogOffRequestCommand);
			addCommand(CreateTicketRequestEvent.EVENT_ID,     CreateTicketRequestCommand);
			addCommand(CreateTicketUITabEvent.EVENT_ID,       CreateTicketUITabCommand);
			addCommand(CreateLogRequestEvent.EVENT_ID,        CreateLogRequestCommand);
			addCommand(RemoveTicketUITabEvent.EVENT_ID,       RemoveTicketUITabCommand);
			addCommand(ViewTicketRequestEvent.EVENT_ID,       ViewTicketRequestCommand);
			addCommand(GetTicketListRequestEvent.EVENT_ID,    GetTicketListRequestCommand);
			addCommand(GetLogListRequestEvent.EVENT_ID,       GetLogListRequestCommand);
			addCommand(GetRecentLogListRequestEvent.EVENT_ID, GetRecentLogListRequestCommand);
		}
	}
}