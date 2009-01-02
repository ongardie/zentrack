package com.zentrack.control.delegates
{
	import com.adobe.cairngorm.business.ServiceLocator;
	import com.zentrack.model.ModelLocator;
	import com.zentrack.valueObjects.Ticket;
	
	import mx.rpc.AsyncToken;
	import mx.rpc.Responder;
	import mx.rpc.http.HTTPService;

	/**
	 * This class is used to as a proxy between the GetTicketRequestCommand
	 *  and the ServiceLocator. In theory, this class deals with any potential
	 * caching that is required.
	 */
	public class CreateTicketDelegate
	{
		private var __locator:ServiceLocator=ServiceLocator.getInstance();
		private var __service:HTTPService;
		private var __responder:Responder;
		private var __model:ModelLocator = ModelLocator.getInstance();

		public function CreateTicketDelegate(responder:Responder) : void {
			__service   = __locator.getHTTPService("tickets");
			__responder = responder;
		}

		public function sendTicketCreateRequest(newTicket:Ticket) : void {
			var parameters:Object = new Object();
			parameters.user    = __model.userInfo.userName;
			parameters.encpass = __model.userInfo.passphrase;
			parameters.bin     = __model.userInfo.homeBinName;
			parameters.action  = "create";

			parameters.title       = newTicket.summary;
			parameters.description = newTicket.description;
			parameters.creator_id  = __model.userInfo.userID;
			parameters.bin_id      = __model.userInfo.homeBinName;

			// todo: update with configurable defaults
			parameters.priority  = 1;
			parameters.system_id = 1;
			parameters.type_id   = 2;

			var token:AsyncToken = __service.send(parameters);
			token.addResponder(__responder);
		}
	}
}