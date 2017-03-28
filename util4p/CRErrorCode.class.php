<?php

	class CRErrorCode
	{
		/* common */
		const SUCCESS = 0;
		const FAIL = 1;
		const NO_PRIVILEGE = 2;
		const UNKNOWN_ERROR = 3;
		const IN_DEVELOP = 4;
		const INVALID_REQUEST = 5;
		const UNKNOWN_REQUEST = 6;
		const CAN_NOT_BE_EMPTY = 7;
		const INCOMPLETE_CONTENT = 8;
		const RECORD_NOT_EXIST = 10;
		const UNABLE_TO_CONNECT_REDIS = 12;	
		const UNABLE_TO_CONNECT_MYSQL = 13;	

		/* user */
		const NOT_LOGED = 19;
		const USER_NOT_EXIST = 20;
		const USER_IS_BLOCKED = 21;

		const NEED_VERIFY = 22;
		const INVALID_PATTERN = 23;
		const RECORD_ALREADY_EXIST = 24;

		public static function getErrorMsg($errno){
			switch($errno){
				case CRErrorCode::SUCCESS:
					return 'Success!';

				case CRErrorCode::NO_PRIVILEGE:
					return 'You don\'t have privilege to do this!';

				case CRErrorCode::UNKNOWN_ERROR:
					return 'Unknown error occured!';

				case CRErrorCode::IN_DEVELOP:
					return 'In develop!';

				case CRErrorCode::UNABLE_TO_CONNECT_REDIS:
					return 'Unable to connect to Redis!';

				case CRErrorCode::UNABLE_TO_CONNECT_MYSQL:
					return 'Unable to connect to Mysql!';

				case CRErrorCode::NOT_LOGED:
					return 'You have to sign in to continue!';

				case CRErrorCode::INVALID_REQUEST:
					return 'Invalid Request!';

				case CRErrorCode::UNKNOWN_REQUEST:
					return 'Unknown Request!';

				case CRErrorCode::CAN_NOT_BE_EMPTY:
					return 'Can not be empty!';

				case CRErrorCode::FAIL:
					return 'Operation failed!';

				case CRErrorCode::RECORD_NOT_EXIST:
					return 'Record not found!';

				case CRErrorCode::USER_IS_BLOCKED:
					return 'Account have been blocked!';

				case CRErrorCode::NEED_VERIFY:
					return 'You have to verify this first!';

				case CRErrorCode::INVALID_PATTERN:
					return 'Invalid pattern!';

				case CRErrorCode::RECORD_ALREADY_EXIST:
					return 'Record has already been created!!';

				default:
					return 'Unknown error ('.$errno.')';
			}
		}
	}
