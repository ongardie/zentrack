package com.zentrack.valueObjects
{
	import com.adobe.cairngorm.vo.ValueObject;

	public class User implements ValueObject
	{
		public var userID:int;
		public var userName:String;
		public var accessLevel:String;
		public var passphrase:String;
		public var lastName:String;
		public var firstName:String;
		public var initials:String;
		public var email:String;
		public var notes:String;
		public var homeBinID:int;
		public var homeBinName:String;
		public var active:int;
		public var ipAddress:String;

		public function User(
			inUserID:int,
			inUserName:String,
			inAccessLevel:String,
			inPassphrase:String,
			inLastName:String,
			inFirstName:String,
			inInitials:String,
			inEmail:String,
			inNotes:String,
			inHomeBinID:int,
			inHomeBinName:String,
			inActive:int,
			inIPAddress:String = null
		) : void {

			userID      = inUserID;
			userName    = inUserName;
			accessLevel = inAccessLevel;
			passphrase  = inPassphrase;
			lastName    = inLastName;
			firstName   = inFirstName;
			initials    = inInitials;
			email       = inEmail;
			notes       = inNotes;
			homeBinID   = inHomeBinID;
			homeBinName = inHomeBinName;
			active      = inActive;
			ipAddress   = inIPAddress;

		}
	}
}