<?php

class HomeController extends BaseController {

public $layout = "header";
	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function showWelcome()
	{
		return View::make('hello');
	}

	public function index(){
		$view = View::make('index');	
		$view->keywords = json_encode(DB::select(DB::raw("SELECT a.KEYWORD label , IFNULL(b.SUBCOUNT,0) data FROM kneed_keywords a
									LEFT JOIN (SELECT COUNT(*) SUBCOUNT, KEYWORDID FROM kneed_subscriptions GROUP BY KEYWORDID) b
									ON a.ID = b.KEYWORDID WHERE ISGROUP = 0 AND KNEEDID = '" . Session::get('user')->ID . "'")));

		$view->contacts = json_encode(DB::select(DB::raw("SELECT a.KEYWORD label , IFNULL(b.SUBCOUNT,0) data FROM kneed_keywords a
									LEFT JOIN (SELECT COUNT(*) SUBCOUNT, KEYWORDID FROM kneed_subscriptions GROUP BY KEYWORDID) b
									ON a.ID = b.KEYWORDID WHERE ISGROUP = 1 AND KNEEDID = '" . Session::get('user')->ID . "'")));

		
		$this->layout->content = $view;
	}


	public function keywords(){
		$view = View::make('keywords.index');	
		$this->layout->content = $view;
	}

	public function packages(){
		$view = View::make('packages');	
		$this->layout->content = $view;	
	}

	public function mobileOriginatedReport(){
		$view = View::make('reports.mo');	
		$view->mos = SmppHits::where('KNEEDID',"=",Session::get('user')->ID)->get();
		$this->layout->content = $view;
	}

	public function mobileTerminatedReport(){
		$view = View::make('reports.mt');	
		$view->mts = SmppPull::where('KNEEDID',"=",Session::get('user')->ID)->get();
		$this->layout->content = $view;
	}

	public function transactions(){
		$view = View::make('reports.transactions');	
		$view->transactions = Transaction::where('KNEEDID',"=",Session::get('user')->ID)->get();
		$this->layout->content = $view;
	}


	public function change_password(){
		$password = Input::get('password');
		$newpassword = Input::get('newpassword');
		$confirmpassword = Input::get('confirmpassword');
		if(!Hash::check($password,Session::get('user')->PASSWORD)){
		      //return error oldpassword not match
		      return Response::json(array('flash' => Lang::get('notification.invalid_password'), 'data'=> Input::all(), 'title' => Lang::get('notification.error')),200);
		}

		if($newpassword != $confirmpassword){
		      //return error oldpassword not match
		      return Response::json(array('flash' => Lang::get('notification.invalid_password'), 'data'=> Input::all(), 'title' => Lang::get('notification.error')),200);
		 }



		$ids = MobileIds::find(Session::get('user')->ID);		
		$ids->PASSWORD = Hash::make($newpassword);
		$ids->save();	
		
		
		return Response::json(array('flash' => Lang::get('notification.success'), 
			'data'=> "", 'title' => Lang::get('notification.success')),200);
	}
}
