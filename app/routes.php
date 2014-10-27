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

Route::get('test',function(){

					/*ChikkaApi::sendsms(array(
							"message_type" => "SEND",
							"mobile_number" => "639196113756",
							"shortcode" => ChikkaApi::getShortCode(),
							"message_id" => '12345678901234567890123456789013',
							"message" => "TEST MESSAGE ITO ULIT",
							"client_id" => ChikkaApi::getClientId(),
							"secret_key" => ChikkaApi::getSecretKey()
						)
					);*/
//message_type=REPLY&mobile_number=639324572856&shortcode=292908299&message_id=uzVHiwaLMCY66Y08XkUbblww2lm4i45z&message=<p>SEND MONEY P2P</p>&request_id=5048303030303053554E303030303239323930303031303030303030303037393030303036333933323435373238353630303030313331303134313431363531&request_cost=FREE&client_id=367364d5f1d02327797c660d2ee94bc76ce56cba9b46fcd28acf448adecb6945&secret_key=f0a1c1fb0a8576908bb191e2051c14f9ce37ae8709e48d7231efa928b5691df5

				ChikkaApi::sendreply(
									array(
										"message_type" => "REPLY",
										"mobile_number" => "639324572856",
										"shortcode" => ChikkaApi::getShortCode(),
										"message_id" => "OIEgkAtxhXiTtsv7PK9meDC3Lw3ZuOn3",
										"message" => "<p>SEND MONEY P2P</p>",
										"request_id" => "5048303030303053554E303030303239323930303031303030303030303038333030303036333933323435373238353630303030313331303134313433363433",
										"request_cost" => "FREE",
										"client_id" => ChikkaApi::getClientId(),
										"secret_key" => ChikkaApi::getSecretKey()
									)
							);
});

Route::get('/', function()
{
	if(!(isset(Session::get('user')->MSISDN))){
		return View::make('login');
	}else{
		return Redirect::to('/home');	
	}
});


Route::post('userlogin','AuthController@userlogin');
Route::get('logout','AuthController@logout');

Route::post('signup', function(){

			$authcode = str_random(6);
			MobileIds::create(
			array(
					"MSISDN" => strtoupper(Input::get('username')),
					"USERNAME" => strtoupper(Input::get('username')),
					"EMAIL" => strtoupper(Input::get('email')),
					"PASSWORD" => Hash::make(Input::get('password')),
					"AUTHCODE" => Crypt::encrypt($authcode),
					"CREDIT" => SystemInfo::GetProperty("OPT_FREE_CREDIT"),					
				)
			);

			$arr = array('flash' => 'Successfull Signup <a href="/">Login</a>');

      		return View::make('signup', $arr);
});

Route::get('signup', function(){
	if(!(isset(Session::get('user')->MSISDN))){
		return View::make('signup');
	}else{
		return Redirect::to('/home');	
	}
});


Route::get('polls/{id}', function($id){
	if(!(isset(Session::get('user')->MSISDN))){
		return View::make('signup');
	}else{
		return Redirect::to('/home');	
	}
});


Route::group(array("before"=>array("auth","updatevars")), function(){
	
	Route::any('home','HomeController@index');
	Route::any('keywords','KeywordController@index');
	Route::any('packages','HomeController@packages');
	Route::any('keywords-update','KeywordController@index_update');
	Route::any('keywords-delete','KeywordController@index_delete');
	Route::any('keywords-getlist','KeywordController@getkeyword');

	Route::any('subscriptions','SubscriptionController@index');
	Route::any('contacts','SubscriptionController@contact_index');
	Route::any('contacts-manage','SubscriptionController@contact_manage');
	Route::any('contacts-group','SubscriptionController@contact_group');

	Route::get('polls-create','PollController@index');
	Route::post('polls-create','PollController@save');
	Route::any('polls-manage','PollController@manage');

	Route::any('brodcastsms','SubscriptionController@brodcast_sms');
	Route::any('brodcastsms-manage','SubscriptionController@brodcastSmsManage');

	Route::any('push-brodcast-message','SubscriptionController@brodcast_save');
	Route::any('push-keyword-update','KeywordController@update');
	Route::any('push-keyword-add','KeywordController@save');

	Route::any('push-contact-update','SubscriptionController@contact_update');
	Route::any('push-contact-add','SubscriptionController@contact_save');
	Route::any('push-group-add','SubscriptionController@contact_group_save');

	Route::any('report-keyword','KeywordController@report');
	Route::any('report-mo','HomeController@mobileOriginatedReport');
	Route::any('report-mt','HomeController@mobileTerminatedReport');
}

);

Route::group(array("prefix" =>"api"),function(){

	Route::any('auth/login/{json}','AuthController@login');
	Route::any('auth/signup/{json}','AuthController@signup');
	Route::any('auth/updateinfo/{json}','AuthController@updateinfo');
	Route::any('auth/checkauth/{json}','AuthController@checkauth');
	Route::any('auth/getauthcode/{json}','AuthController@getauthcode');

	Route::any('data/history/{json}','DataController@history');
	Route::any('data/details/{json}','DataController@details');

	Route::post('chikka/notification/receiver','ChikkaApiController@notification');
	Route::post('chikka/message/receiver','ChikkaApiController@messageReceiver');	

});
