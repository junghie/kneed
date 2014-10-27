<?php

class AuthController extends BaseController {

	/*
	 *http://localhost:8001/api/auth/signup/
	 *%7B%20%22msisdn%22:%20%22639224638559%22,%20%22firstname%22:%20%22firstname%22,%20%22lastname%22:%20%22arizala%22,%20%22email%22:%22arizalareugie@gmail.com%22,%22password%22:%22test%22%7D
	 */
	public function signup($json)
	{

		$request = json_decode($json);
		$authcode = str_random(6);
		//TO DO CHECK MSISDN IF AUTHENTICATED DELETE IF NOT


		MobileIds::create(
			array(
					"MSISDN" => $request->msisdn,
					"USERNAME" => $request->msisdn,
					"FIRSTNAME" => $request->firstname,
					"LASTNAME" => $request->lastname,
					"EMAIL" => $request->email,
					"PASSWORD" => Hash::make($request->password),
					"AUTHCODE" => Crypt::encrypt($authcode),					
				)
			);

		/*$response = ChikkaApi::sendsms(
				array(
							"message_type" => "SEND",
							"mobile_number" => "639224638550",
							"shortcode" => ChikkaApi::getShortCode(),
							"message_id" => "12345678901234567890123456789012",
							"message" => "AUTHCODE : " . $authcode,
							"client_id" => ChikkaApi::getClientID(),
							"secret_key" => ChikkaApi::getSecretKey()
						)
				);*/
		

		return Response::json(array('flash' => Lang::get('notification.success') . ':' . $response, 
			'data'=> $json),200);	
	}

	/*
	 *http://localhost:8001/api/auth/signup/
	 *{"msisdn":"639224638559","password":"test","secretid":"","clientid":""}
	 */
	public function login($json){
		$request = json_decode($json);
		$ids = MobileIds::where("MSISDN", "=", $request->msisdn)->get()[0];
		$app = Apps::Check($request->secretid,$request->clientid)[0];
		if(!Common::validate($request)){
			return Response::json(array('flash' => Lang::get('notification.success'), 
			'data'=> $json),401);	
		}

		if(!Common::validateUser($request)){
			return Response::json(array('flash' => Lang::get('notification.success'), 
			'data'=> $json),401);	
		}

		Common::logHistory(
				array(
					"KNEEDID" => $ids->ID,
					"APPID" => $app->ID,
					"LOG" => "LOGIN",
					"MESSAGE" => Lang::get('notification.login')
					)
			);

		return Response::json(array('flash' => Lang::get('notification.success'), 
			'data'=> $ids->toJson()),200);	
	}


	/*
	 *http://localhost:8001/api/auth/signup/
	 *{"msisdn":"639224638559", "password":"","secretid":"","clientid":"","firstname":"","lastname":"","email":""}
	 */
	public function updateinfo($json){
		$request = json_decode($json);
		$app = Apps::Check($request->secretid,$request->clientid)[0];
		if(!Common::validate($request)){
			return Response::json(array('flash' => Lang::get('notification.success'), 
			'data'=> $json),401);	
		}

		$ids = MobileIds::where("MSISDN", "=", $request->msisdn)
		    			->where("PASSWORD","=",Crypt::encrypt($request->password))
		    			->get()[0];

		$ids->FIRSTNAME =  $request->firstname;
		$ids->LASTNAME  =  $request->lastname;
		$ids->EMAIL     =  $request->email;
		$ids->save();

		Common::logHistory(
				array(
					"KNEEDID" => $ids->ID,
					"APPID" => $app->ID,
					"LOG" => "UPDATEINFO",
					"MESSAGE" => Lang::get('notification.updateinfo')
					)
			);


		return Response::json(array('flash' => Lang::get('notification.success'), 
			'data'=> $json),200);	

	}

	/*
	 *http://localhost:8001/api/auth/signup/
	 *{"msisdn":"639224638559","secretid":"Mpos_AQRzeLvAgi6A","clientid":"Mpos_tcOyz8zgxGEl","authcode":"jdGHE1"}
	 */
	public function checkauth($json){
		$request = json_decode($json);
		$ids = MobileIds::where("MSISDN", "=", $request->msisdn)->get()[0];
		$app = Apps::Check($request->secretid,$request->clientid)[0];
	
		if(!Common::validate($request)){
			return Response::json(array('flash' => Lang::get('notification.failed'), 
			'data'=> $json),401);	
		}

		$request->id = $ids->ID;
		
		if(!Common::validateAuthCode($request)){
			return Response::json(array('flash' => Lang::get('notification.failedauth'), 
			'data'=> $json),401);	
		}

		AuthCodes::where('KNEEDID', '=', $ids->ID)
				    ->where('AUTHCODE', '=', $request->authcode)
					->update(array('ISUSED' => 1));

		Common::logHistory(
				array(
					"KNEEDID" => $ids->ID,
					"APPID" => $app->ID,
					"LOG" => "CHECKAUTH",
					"MESSAGE" => Lang::get('notification.checkauth')
					)
			);

		return Response::json(array('flash' => Lang::get('notification.success'), 
			'data'=> $ids->toJson()),200);	

	}


	/*
	 *http://localhost:8001/api/auth/signup/
	 *{"msisdn":"639224638559","secretid":"Mpos_AQRzeLvAgi6A","clientid":"Mpos_tcOyz8zgxGEl"}
	 */
	public function getauthcode($json){
		$request = json_decode($json);
		$ids = MobileIds::where("MSISDN", "=", $request->msisdn)->get()[0];
		$authcode = str_random(6);
		$app = Apps::Check($request->secretid,$request->clientid)[0];

		if(!Common::validate($request)){
			return Response::json(array('flash' => Lang::get('notification.success'), 
			'data'=> $json),401);	
		}

		AuthCodes::create(
				array(
					"KNEEDID" => $ids->ID,
					"AUTHCODE" => $authcode
				)
			);

		Common::logHistory(
				array(
					"KNEEDID" => $ids->ID,
					"APPID" => $app->ID,
					"LOG" => "GETAUTH",
					"MESSAGE" => Lang::get('notification.getauth')
					)
			);

		return Response::json(array('flash' => Lang::get('notification.success'), 
			'data'=> $authcode),200);	

	}


	public function userlogin()
  {
  	
    if(Auth::attempt(array('msisdn' => Input::get('username'), 'password' => Input::get('password'))))
    {
      //return Response::json(Auth::user());
      
      if(Auth::user()->ISENABLED != 1){
        $arr = array('flash' => 'Username is Expired');
        return View::make('login', $arr);  
      }

      Session::put('user',Auth::user());
      Session::regenerateToken();
      
      //to do get modules
      
      return Redirect::to('home');

    } else {
      //return Response::json(array('flash' => 'Invalid username or password'), 500);
      $arr = array('flash' => 'Invalid username or password');

      return View::make('login', $arr);
    }
  }

  public function logout()
  {
    Auth::logout();
    Session::flush();
    $arr = array('flash' => 'Logged Out!');
    return View::make('login', $arr);
  }

  public function changepassword(){
    $oldpassword = Input::get('oldpassword');
    $newpassword = Input::get('newpassword');
    $confirmpassword = Input::get('confirmpassword');
    $user = Auth::user();

    if($newpassword != $confirmpassword){
      //return password not match
      return Response::json(array('flash' => Lang::get('notification.error'), 'data'=> Input::all(), 'title' => Lang::get('notification.error')),200);
    }

    if(!Hash::check($oldpassword,$user->PASSWORD)){
      //return error oldpassword not match
      return Response::json(array('flash' => Lang::get('notification.error'), 'data'=> Input::all(), 'title' => Lang::get('notification.error')),200);
    }
    // authenticated user    
    $user->PASSWORD = Hash::make($newpassword);
    // finally we save the authenticated user
    $user->save();

    return Response::json(array('flash' => Lang::get('notification.success'), 'data'=> Input::all(), 'title' => Lang::get('notification.success')),200);
  }

}
