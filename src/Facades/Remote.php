<?php 



namespace Support\RemoteAuth\Facades;

use Illuminate\Support\Facades\Facade;

/**
* the facade interface
*/
class Remote extends Facade
{
	
	 protected static function getFacadeAccessor() {

	  return 'JSRAuth.interface';

	 }
}