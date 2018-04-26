# Remote Auth

Remote auth is a library for laravel api authentication or remote auth user management in web application. Its a token base authentication system that provide many functionality like blocking user between date and get login date of each valid user without any database interaction. Remote auth validate token in two way normally valid check or two way auth check let see it below.

## Getting Started

The library is designed on the focus on easly setup by any one like stratup member or expert.

### Prerequisites

You need to composer package manager for instaiig this package and their dependancy.

### Installing

Follow below step for instaiing package into laravel package


```
composer require support/remote-auth
```
Then add below line into provider array in ```config/app.php``` file

```
Support\RemoteAuth\JSRServiceProvider::class,
```

Then add into aliash array into ```config/app.php``` file.

```
'Remote' => Support\RemoteAuth\Facades\Remote::class,
```

And then publish package into laravel app.
```
php artisan vendor:publish
```
This command create ```RemoteAuth.php``` file in ```config``` folder. You can enable disable option of package using this file.
i suggest to developer also run below command for avoid probleam in feature.
```
php artisan key:generate
php artisan config:cache

```

Then run following command for creating moddleware.
```
php artisan make:middleware RemoteAuth
```
And then past below code into file
```
<?php

namespace App\Http\Middleware;

use Closure;
use Remote;

class RemoteAuth
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
        }else if($user = Remote::verify($request->header('Authorization'))){
          
            /*if valid then user data bind with request*/
            $request->r_user = $user;
        
        }else {
            
            /*if token is invalid the return invalid token error*/
            return response()->json(array('invalid token'));
        }
        
        return $next($request);
    }
}

```
### Important
If you use above middleware then you get authenticate user into request class instance like as below

```
 public function get_detail(Request $request){
    
   //get user
   $user = $request->r_user;
   //token
   $token = $request->r_token;
   
   dd($user); //dump $user variable
 }
```
If double_verify is true in ```config\RemoteAuth.php``` then is return user recoard.

```
User {#209
  #fillable: array:3 [
    0 => "name"
    1 => "email"
    2 => "password"
  ]
  #hidden: array:2 [
    0 => "password"
    1 => "remember_token"
  ]
  #connection: "mysql"
  #table: null
  #primaryKey: "id"
  #keyType: "int"
  +incrementing: true
  #with: []
  #withCount: []
  #perPage: 15
  +exists: true
  +wasRecentlyCreated: false
  #attributes: array:7 [
    "id" => 1
    "name" => "ravi bhanderi"
    "email" => "ravi@gmail.com"
    "password" => "$2y$10$hMutgh3AmEdiQbIVosxqS.cdYun4T8f1MK.hjLgrUtFlH3z9axNO6"
    "remember_token" => "yS3eixwdIGjYqFBwcAvBy09ZyDiXfAQubojNdlogZoa4rbCSQwxJlXVHyp8v"
    "created_at" => "2017-10-08 18:25:16"
    "updated_at" => "2017-10-08 18:25:16"
  ]
  #original: array:7 [
    "id" => 1
    "name" => "ravi bhanderi"
    "email" => "ravi@gmail.com"
    "password" => "$2y$10$hMutgh3AmEdiQbIVosxqS.cdYun4T8f1MK.hjLgrUtFlH3z9axNO6"
    "remember_token" => "yS3eixwdIGjYqFBwcAvBy09ZyDiXfAQubojNdlogZoa4rbCSQwxJlXVHyp8v"
    "created_at" => "2017-10-08 18:25:16"
    "updated_at" => "2017-10-08 18:25:16"
  ]
  #changes: []
  #casts: []
  #dates: []
  #dateFormat: null
  #appends: []
  #dispatchesEvents: []
  #observables: []
  #relations: []
  #touches: []
  +timestamps: true
  #visible: []
  #guarded: array:1 [
    0 => "*"
  ]
  #rememberTokenName: "remember_token"
}
```

If double_verify is false in ```config\RemoteAuth.php```. Then it return user identifire(id) and login date
```
array:2 [
  "identifire" => 1
  "login_date" => Carbon @1524373176 {#186
    date: 2018-04-22 04:59:36.389266 UTC (+00:00)
  }
]
```

Now finally your api authentication is ready now regitered your middleware into your ```kernal.php``` file as your use. Generally people use route middleware so i registered them into ```kernal.php``` as route middleware.

```
 protected $routeMiddleware = [
     ...
     ...
     ...
     remote_auth' =>  \App\Http\Middleware\RemoteAuth::class
  ];
```

Use middleware to create authentication route group this type of route consider after login functionallity.

```
Route::group(['middleware'=>'remote_auth'],function(){

        //route list 
});
```

### General Funcrion

You need to use remote auth before using into controller.
```
use Remote;


//get the current user
Remote::user($token);

//login by credential
$token = Remote::attempt(array('email'=>'ravibhanderi14@gmail.com','password'=>'123456'));

//login by id
Remote::byId($id); //id of user

//from user model object
Remote:fromUser($user); //$user is a record of user must be instance of eloquent

//verify token is valid or invalid. Function return user if token is valid and double_verification is on otherwise 
return identifire and logindate in array. You can on off double_verification using config\RemoteAuth.php.

Remote::verify($token);

```

### Config file options

Remote auth config file is like as below. its located in ```config\RemoteAuth.php``` after publishing vendor. and lower version of laravel you can create itself. current version of laravel is 5.5
```
<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Cache Store
    |--------------------------------------------------------------------------
    |
        this is define token validate time in minute
    |
    */

    /*if you want to token neverinvalid  just comment below line other wise provide time into minute */

    'valid' => 60, /* menute */

    /*=============================================
    =      define invlid token beetween two date =
    ------ date should be format in yyyy/dd/mm------

    ex. if you want to stop access of api login or register user between specific date
    =============================================*/
                                                                                                                                                                                                                                                                                                                        
    'stop_login' => false,

    /* date format should be yyyy/mm/dd */
    'to_date' => null , 
    'from_date' => null,
    /*=====  End  ======*/
    /*want to autheticate date with model object*/
    'login_date' => true,
    /*Verify payload with a data base record. Becuase some time after generating
    token user deleted from database. If token is generated and after some time user
    deleted from database. What happen user have their authentication token so if a double_verify is on then user check with also           database otherwise remote-auth verify only token is valid*/ 
    'double_verify' => true,
    /**/  
    
];

```

