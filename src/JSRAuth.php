<?php
/**
 * Created by PhpStorm.
 * User: ravi
 * Date: 22-02-2018
 * Time: 18:21
 */

namespace Support\RemoteAuth;
use Illuminate\Support\Facades\Crypt;
use Support\RemoteAuth\Auth\AuthInterface;
use Illuminate\Http\Request;

class JSRAuth extends Authentication
{
 
	/* intigrate with laravel authetivation layer reference*/
	protected $auth;

	/* authentication object creation */	
	function __construct(AuthInterface $auth){

		$this->auth = $auth;
	}	

	/* attempt login */
	public function attempt(array $array) {

	   if(! $this->auth->byCredentials($array)) {

	   	   return false;
	   }
	   
	   $key = $this->get_ancript($this->auth->user()->getKey());
	   return $key;
	}

	/*return user from token*/
	public function user($token)
	{
		$auth = $this->get_decript($token);
		if($auth) {

			if($this->auth->byId($auth['identifire'])) {

			    $remote_user = $this->auth->user();
			    if($this->login_date()) {

				   $remote_user->login_date = $auth['login_date'];
				   return $remote_user;
			    }
			    return $remote_user;
			}

		}
		
		return false;
	}

   /*return token from user object*/
	public function fromUser($modelObject = null)
	{
		if(empty($modelObject)) {

			return false;
		}

		$key = $this->get_ancript($modelObject->getKey());

		if(empty($key)) {

			return false;
		}

	    $this->get_ancript($key);
	    return $key;

	}

	/*get user login by id*/
   public  function byId($id) {

   	   return $this->get_ancript($id);
   }

   /*check token is valid or not*/
   public function verify($token)  {
   	 
   	  $auth = $this->get_decript($token);

   	  if(! $this->stopLogin($auth['login_date']) || $this->token_expire($auth['login_date'])) {

   	  		return false;
   	  }

   	  if($this->double_verify()){

   	  	 if($this->auth->byId($auth['identifire'])) {

			    $remote_user = $this->auth->user();
			    if($this->login_date()) {

				   $remote_user->login_date = $auth['login_date'];
				   return $remote_user;
			    }
			    return $remote_user;
		 }
   	  }

   	  return $auth;
   }
}