<?php
/**
 * Created by PhpStorm.
 * User: ravi
 * Date: 22-02-2018
 * Time: 18:21
 */

namespace Sky\JSR;
use Illuminate\Support\Facades\Crypt;

class JSRAuth extends Authentication
{
 
	

	/* authentication object creation */	
	function __construct(){

	   Parent::__construct();

	   if(Parent::stopLogin() == false) {

	   		return false;
	   }

	}	

	/* attempt login */
	public static function attempt(array $array) {

	   $auth = Parent::verify_auth($array);

	   if(empty($auth)) {

	   	   return false;
	   }
	   
	   $key = Parent::get_ancript($auth->getKey());
	   return $key;
	}

	/*return user from token*/
	public static function user($token)
	{
		$auth = Parent::get_decript($token);
		
		if(! Parent::stopLogin($auth)) {

			return false;
		}

		return $auth;
	}

   /*return token from user object*/
	public static function fromUser($modelObject = null)
	{
		if(empty($modelObject)) {

			return false;
		}

		$key = Parent::get_ancript($modelObject->getKey());

		if(empty($key)) {

			return false;
		}

	    Parent::get_ancript($key);
	    return $key;

	}
}