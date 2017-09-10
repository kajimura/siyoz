<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*
Route::get('/', function () {
	return view('welcome');
});
*/
Route::get('/blog/{blog_code}', 'BlogController@index')->where('blog_code', '[0-9a-z]+');
/*
//Route::get('/help/privacy', function () {
//	return view('helps.privacy');
//});
Route::get('/help/use', function () {
	return view('helps.use');
});
Route::get('/help/company', function () {
	return view('helps.company');
});
Route::get('/help/wait', function () {
	return view('helps.wait');
});
*/

//Route::get('/home', 'HomeController@index');
//Route::auth();
if (!preg_match("!^(siyoz-test|siyoz.)!", \Request::server('HTTP_HOST'))) {
	Route::get('/', 'IndexController@index');
	Route::resource('fuser', 'FuserController');
	Route::get('/prof/home', 'ProfController@home');
	Route::resource('prof', 'ProfController', ['only' => ['index', 'create', 'store', 'show', 'edit','update', 'destroy']]);
	Route::resource('flogout', 'FlogoutController', ['only' => ['index']]);
	Route::resource('meet', 'MeetController', ['only' => ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy']]);
	Route::resource('match', 'MatchController', ['only' => ['index', 'create', 'store', 'show', 'destroy']]);
	Route::get('/match/create/meet_id/{meet_id}', 'MatchController@create')->where('meet_id', '[0-9]+');
	Route::get('/appointment/indexrequest', 'AppointmentController@indexrequest');
	Route::resource('appointment', 'AppointmentController', ['only' => ['index', 'create', 'store', 'show', 'edit', 'update']]);
	Route::resource('appointmentcancel', 'AppointmentcancelController', ['only' => ['edit', 'update']]);
	Route::get('/appointment/create/match_id/{match_id}', 'AppointmentController@create')->where('match_id', '[0-9]+');
	Route::resource('message', 'MessageController', ['only' => ['index', 'create', 'store']]);
	Route::get('/message/create/match_id/{match_id}', 'MessageController@create')->where('match_id', '[0-9]+');
	Route::group(['middleware' => 'web'], function () {
	   Route::get('facebook','FacebookController@facebookLogin');
	   Route::get('facebook/callback','FacebookController@facebookCallback');
	});
	Route::get('/help/privacy', 'HelpController@privacy');
	Route::get('/help/condition', 'HelpController@condition');
	Route::get('/help/company', 'HelpController@company');
	Route::get('/help/wait', 'HelpController@wait');
	Route::get('/debug', 'DebugController@index');
} elseif (preg_match("!^(siyoz-test|siyoz.)!", \Request::server('HTTP_HOST'))
		&& preg_match("!^/apl!", \Request::server('REQUEST_URI'))) {
	Route::group(['middleware' => 'web'], function () {
	   Route::get('/apl/facebook','FacebookController@facebookLogin');
	   Route::get('/apl/facebook/callback','FacebookController@facebookCallback');
	});
	Route::get('/apl/apls', 'AplController@apls');
	Route::resource('/apl', 'AplController', ['only' => ['index', 'create', 'store', 'show', 'edit','update', 'destroy']]);
	Route::get('/apl/help/privacy', 'HelpController@privacy');
	Route::get('/apl/help/condition', 'HelpController@condition');
	Route::get('/apl/help/company', 'HelpController@company');
	Route::get('/apl/help/wait', 'HelpController@wait');
} else {
	$apl_code = "";
	if (preg_match("!^/([_\w]+)!", \Request::server('REQUEST_URI'), $matches)) {
		$apl_code = $matches[1];
	}
	Route::get('/'.$apl_code.'/', 'IndexController@index');
	//Route::get('/'.$apl_code.'/home', 'HomeController@index');
	Route::resource('/'.$apl_code.'/fuser', 'FuserController');
	Route::get('/'.$apl_code.'/prof/home', 'ProfController@home');
	Route::resource('/'.$apl_code.'/prof', 'ProfController', ['only' => ['index', 'create', 'store', 'show', 'edit','update', 'destroy']]);
	Route::resource('/'.$apl_code.'/flogout', 'FlogoutController', ['only' => ['index']]);
	Route::resource('/'.$apl_code.'/meet', 'MeetController', ['only' => ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy']]);
	Route::resource('/'.$apl_code.'/match', 'MatchController', ['only' => ['index', 'create', 'store', 'show', 'destroy']]);
	Route::get('/'.$apl_code.'/match/create/meet_id/{meet_id}', 'MatchController@create')->where('meet_id', '[0-9]+');
	Route::get('/'.$apl_code.'/appointment/indexrequest', 'AppointmentController@indexrequest');
	Route::resource('/'.$apl_code.'/appointment', 'AppointmentController', ['only' => ['index', 'create', 'store', 'show', 'edit', 'update']]);
	Route::resource('/'.$apl_code.'/appointmentcancel', 'AppointmentcancelController', ['only' => ['edit', 'update']]);
	Route::get('/'.$apl_code.'/appointment/create/match_id/{match_id}', 'AppointmentController@create')->where('match_id', '[0-9]+');
	Route::resource('/'.$apl_code.'/message', 'MessageController', ['only' => ['index', 'create', 'store']]);
	Route::get('/'.$apl_code.'/message/create/match_id/{match_id}', 'MessageController@create')->where('match_id', '[0-9]+');
	Route::group(['middleware' => 'web'], function () use ($apl_code) {
	   Route::get('/'.$apl_code.'/facebook','FacebookController@facebookLogin');
	   Route::get('/'.$apl_code.'/facebook/callback','FacebookController@facebookCallback');
	});
	Route::get('/'.$apl_code.'/help/privacy', 'HelpController@privacy');
	Route::get('/'.$apl_code.'/help/condition', 'HelpController@condition');
	Route::get('/'.$apl_code.'/help/company', 'HelpController@company');
	Route::get('/'.$apl_code.'/help/wait', 'HelpController@wait');
}
