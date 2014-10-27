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
}
