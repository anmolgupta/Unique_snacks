<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
Route::get('/', function()
{
	return View::make('hello');
});

Route::any('testing',function(){
   echo "chal gaya off"; 
});


//heri i start
Route::any('login', function()
{
    return View::make('home.login'); 	
});

Route::get('login/fb',function(){
    //adding contrroller to fb
    //adding redirect to page
    
    $facebook = new Facebook(Config::get('facebook'));
    $params = array(
        'redirect_uri' => url('/login/fb/callback'),
        'scope' => 'user_friends',
    );
    return Redirect::to($facebook->getLoginUrl($params));
});

Route::get('/login/fb/callback', function(){
        
    $code = Input::get('code');
    
    if (strlen($code) == 0) 
        return Redirect::to('login')->with('message', 'There was an error communicating with Facebook');

    $facebook = new Facebook(Config::get('facebook'));
    
    $uid = $facebook->getUser();

    if ($uid == 0) 
        return Redirect::to('login')->with('message', 'There was an error');

    $me = $facebook->api('me/');
    //dd($me);    
    
    $taggable_friends = $facebook->api('me/taggable_friends?fields=name,id,picture');
    //dd($taggable_friends['data'][0]);
    /*
    $profile = Profile::whereUid($uid)->first();
    if (empty($profile)) {

        $user = new User();
        $user->name = $me['first_name'].' '.$me['last_name'];
        $user->email = $me['email'];

        $user->save();

        $profile = new Profile();
        $profile = $user->profiles()->save($profile);
    }

    $profile->access_token = $facebook->getAccessToken();
    $profile->save();
    
    Auth::attempt($user);
    */
    return View::make('home.fblogin', array(
                                                'friends' => $taggable_friends['data']
                                            )
                    );
});

Route::get('logout', function(){
    Auth::logout();
    return  Redirect::to('login')->with('message','Loggout out');
});
