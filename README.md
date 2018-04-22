# Remote Auth

Remote auth is a library for laravel api authentication or remote auth user management in web application. Its a token base authentication system that provide many functionality like blocking user between date and get login date of each valid user without any database interaction. Remote auth valid user in two way normally valid check or two way auth check let see it below.

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
if you use above middleware then you get authenticate user into request class instance like as below
```
 public function get_detail(Request $request){
    
   //get user
   $user = $request->r_user;
   //token
   $token = $request->r_token;
 }
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

//verify token is valid or invalid. Function return user if token is valid and double_verification is on otherwise return identifire and logindate in array. You can on off double_verification using config\RemoteAuth.php.

Remote::verify($token);

```

```
Give an example
```

### And coding style tests

Explain what these tests test and why

```
Give an example
```

## Deployment

Add additional notes about how to deploy this on a live system

## Built With

* [Dropwizard](http://www.dropwizard.io/1.0.2/docs/) - The web framework used
* [Maven](https://maven.apache.org/) - Dependency Management
* [ROME](https://rometools.github.io/rome/) - Used to generate RSS Feeds

## Contributing

Please read [CONTRIBUTING.md](https://gist.github.com/PurpleBooth/b24679402957c63ec426) for details on our code of conduct, and the process for submitting pull requests to us.

## Versioning

We use [SemVer](http://semver.org/) for versioning. For the versions available, see the [tags on this repository](https://github.com/your/project/tags). 

## Authors

* **Billie Thompson** - *Initial work* - [PurpleBooth](https://github.com/PurpleBooth)

See also the list of [contributors](https://github.com/your/project/contributors) who participated in this project.

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details

## Acknowledgments

* Hat tip to anyone who's code was used
* Inspiration
* etc
