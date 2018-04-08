<h4><b>Remote Auth</b><h4><hr>

<ol>
  <li> For instaling remote auth run this command on cmd <br><br>
        <code>composer require support/remote-auth</code><br>
  </li>
  <li>Place provider and aliase in app.php file in config folder</li>
  <br>
  <li>Setup middleware for api authentication handling.create middleware name as api middleware and past code below.<br> <br>
    
    <pre><?php

namespace App\Http\Middleware;

use Closure;
use Remote;

class Api
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /*check token is received or not*/
        if(empty($request->header('Authorization'))){

            return response()->json(array('token is required'));

        /*check token is valid or not*/
        }else if($user = Remote::user($request->header('Authorization'))){
          
            /*if valid then user data bind with request*/
            $request->r_user = $user;
            +
        }else {
            
            /*if token is invalid the return invalid token error*/
            return response()->json(array('invalid token'));
        }
        
        return $next($request);
    }
}
 </pre> 
 <br><br>Registere your moddleware into <code>kernal.php</code><br>
 <pre> 'api_auth' =>  \App\Http\Middleware\Api::class,
</pre>
 
  </li>
   <li> Create route group and write all api route that need authentication, like this <br><br>
    
   <pre>Route::group(['prefix'=>'api','middleware'=>'api_auth'],function(){
     
      //write your route here
}); <pre>
</li>
</ol>  

<p>Now you get authenticate user in Request class object in controller likwe this.
<br>
  <br>
  
</p>

