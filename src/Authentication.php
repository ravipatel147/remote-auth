<?php

/**
* SKY/JSR configuaration
*/

namespace Support\Remote;

use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Log;

class Authentication
{
	
  /*get model reference for two step auth*/
 	public static function get_model() {

		$model = config('JSRAuth.MODEL');

		if(empty($model)) {

			$model = 'App\User';
		}
		return new $model;
	}

	/*check two step auth is on or off*/
	public static function verify_two_stage() {

		return config('JSRAuth.TWO_STAGE') == 'TRUE' ? TRUE :FALSE;
	}

	/*verify of user on live database*/
	public static function verify_auth(array $array)
	{
		$model = self::get_model();
		return $model->where($array)->first();
	}

	/*verify of user on live database*/
	public static function verify_primary($key)
	{
		$model = self::get_model();
		$auth_user =  $model->find($key);
		return $auth_user;
	}

	/* get ancription of id */
	public static function get_ancript($key)
	{
		$key = encrypt($key);
		return $key .'&' .encrypt(Carbon::now());
	}

	/* get ancription of id */
	public static function get_decript($key)
	{
		$date =substr($key,strpos($key,'&') + 1);
		$primary = substr($key,0,strpos($key,'&'));

		if(empty($date) || empty($primary)) {

			return false;
		}

		$date = decrypt($date);
		$primary = decrypt($primary);
		$auth = self::verify_primary($primary);

		if(empty($auth)) {

			return false;
		}

		$auth->loginDate = $date;
		return $auth;
	}

	/* check stop login is true or false with recepected validation check */
	public static function stopLogin($modelObject = null)
	{
		$allow_login = true;
		
		if(config('JSRAuth.STOP_LOGIN') == true) {


			$date = empty($modelObject) ? Carbon::now() : $modelObject->loginDate;
			$toDate = config('JSRAuth.TO_DATE');
			$fromDate = config('JSRAuth.FROM_DATE');
            $date = strtotime($date);

			if(! empty($toDate)) {

				$toDate = strtotime($toDate);

				if($toDate <= $date) {

					$allow_login = false;
				}
				
			}

			if(! empty($fromDate)) {
           	
           		$fromDate = strtotime($fromDate);

           		if($date <= $fromDate && $allow_login == false) {

           			$allow_login = false;

           		} else {

           			$allow_login = true;
           		}

			}
			
		}

		return $allow_login;
	}
}