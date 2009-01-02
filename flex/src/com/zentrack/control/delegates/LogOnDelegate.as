package com.zentrack.control.delegates
{
	import com.adobe.cairngorm.business.ServiceLocator;
	import com.adobe.crypto.MD5;
	import com.zentrack.model.ModelLocator;
	
	import mx.rpc.AsyncToken;
	import mx.rpc.Responder;
	import mx.rpc.http.HTTPService;

	/**
	 * This class is a logon proxy
	 */
	public class LogOnDelegate
	{
		private var __locator:ServiceLocator=ServiceLocator.getInstance();
		private var __service:HTTPService;
		private var __responder:Responder;
		private var __model:ModelLocator = ModelLocator.getInstance();

		public function LogOnDelegate(responder:Responder) : void {
			__service   = __locator.getHTTPService("tickets");
			__responder = responder;
		}

		public function sendLogOnCredentials(inUsername:String, inPassword:String) : void {
			// I need to make this prettier
			// TODO
			__model.encryptedPassword = MD5.hash(inPassword);

			var parameters:Object  = new Object();
			parameters.user    = inUsername;
			parameters.encpass = __model.encryptedPassword;
			parameters.action  = "authenticate";

			var token:AsyncToken = __service.send(parameters);
			token.addResponder(__responder);
		}
	}
}