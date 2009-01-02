package com.zentrack.control.delegates
{
	import com.adobe.cairngorm.business.ServiceLocator;
	import com.zentrack.model.ModelLocator;
	import com.zentrack.valueObjects.LogEntry;
	
	import mx.rpc.AsyncToken;
	import mx.rpc.Responder;
	import mx.rpc.http.HTTPService;

	/**
	 * This class is used to as a proxy between the GetTicketRequestCommand
	 *  and the ServiceLocator. In theory, this class deals with any potential
	 * caching that is required.
	 */
	public class CreateLogDelegate
	{
		private var __locator:ServiceLocator=ServiceLocator.getInstance();
		private var __service:HTTPService;
		private var __responder:Responder;
		private var __model:ModelLocator = ModelLocator.getInstance();

		public function CreateLogDelegate(responder:Responder) : void {
			__service   = __locator.getHTTPService("tickets");
			__responder = responder;
		}

		public function sendLogCreateRequest(newLog:LogEntry) : void {
			var parameters:Object = new Object();
			parameters.user    = __model.userInfo.userName;
			parameters.encpass = __model.userInfo.passphrase;
			parameters.action  = "log";

			parameters.bin   = newLog.binID;
			parameters.id    = newLog.ticketID;
			parameters.text  = newLog.entry;

			var token:AsyncToken = __service.send(parameters);
			token.addResponder(__responder);
		}
	}
}