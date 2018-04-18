<?php

/**
* SKY/JSR configuaration
*/

namespace Support\RemoteAuth;

use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Log;
use Illuminate\Auth\AuthManager;
use Illuminate\Contracts\Encryption\DecryptException;

class Authentication
{

	public function config($key)
	{
		return config('RemoteAuth.'.$key);
	}

	/* get ancription of id */
	public  function get_ancript($key)
	{
		$key = encrypt($key);
		return $key .'&' .encrypt(Carbon::now());
	}

	/* get ancription of id */
	public  function get_decript($key)
	{
		$date =substr($key,strpos($key,'&') + 1);
		$primary = substr($key,0,strpos($key,'&'));

		if(empty($date) || empty($primary)) {

			return false;
		}
        
        try{

			$date = decrypt($date);
			$primary = decrypt($primary);

         } catch(DecryptException $e) {
		  
		    return false;
		}

		 $auth = array();
		 $auth['identifire'] = $primary;
		 $auth['login_date'] = $date;
		 
		return $auth;
	}

	/* check stop login is true or false with recepected validation check */
	public  function stopLogin($login_date = null)
	{
		$allow_login = true;
		
		if($this->config('stop_login') == true) {

			$date = empty($login_date) ? Carbon::now() : $login_date;
			$from_date = $this->config('from_date');
			$to_date = $this->config('to_date');
            $date = strtotime($date);

		    if(! empty($from_date) && trim($from_date) != '') {

				$from_date = strtotime($from_date);

				if($from_date <= $date) {

					$allow_login = false;
				}else{
					$allow_login = true;
				}
			}else {

				$allow_login = false;
			}
			if(! empty($to_date) && trim($to_date) != '') {
           	    
           		$to_date = strtotime($to_date);

           		if($date <= $to_date && $allow_login == false) {

           			$allow_login = false;

           		} 
			}
		}
		return $allow_login;
	}

	public function login_date()
	{
	   return $this->config('login_date') === true ? true : false;
	}

	public function double_verify()
	{
	   return $this->config('double_verify') === true ? true : false;
	}

	public function token_expire($date)
	{
		$valid_time = $this->config('valid');

		if(empty($valid_time)){
			return false;
		}

		$time = strtotime($date);
		$current_time = time();
		$valid_time += $time;
	    if($current_time <= $valid_time) {
            
	    	return false;
	    }

	    return true;
	}


}