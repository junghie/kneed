<?php

class SubscriptionController extends BaseController {

public $layout = "header";
	

	public function index(){
		$view = View::make('subscriptions.index');	
		$reportname = Input::get('reportname');
		if(!empty($reportname)){
			$view->subscriptions = Subscription::where("KEYWORDID","=",Input::get('reportname'))->get();
			$view->keyword = Keyword::find($reportname);
		}
		$this->layout->content = $view;
	}

	public function contact_index(){
		$view = View::make('contacts.index');
		$this->layout->content = $view;
	}

	public function contact_manage(){
		$view = View::make('contacts.manage');	
		$view->contacts = Contact::where('KNEEDID',"=",Session::get('user')->ID)->get();
		$this->layout->content = $view;
	}

	public function contact_group(){
		$view = View::make('contacts.groups');	
		$view->contacts = Contact::where('KNEEDID',"=",Session::get('user')->ID)->get();
		$this->layout->content = $view;
	}


	public function contact_group_save(){

		Log::info('Log message GROUP SAVE', Input::all());	

		$groups = Input::get('group');
		$keyword = Keyword::create(
			array(
				'KEYWORD' => strtoupper(Input::get('keyword')) . '-GROUP',
				'MESSAGE' => "",
				'KNEEDID'=> Session::get('user')->ID,
				'ISGROUP' => 1
				)
			);

		//foreach number insert into subscription table
		foreach($groups as $msisdn){
				Subscription::create(
					array(
							"KEYWORDID" => $keyword->ID,
							"MSISDN"  => $msisdn
						)
				);
		}
       
		return Response::json(array('flash' => Lang::get('notification.success'), 
			'data'=> Input::all(), 'title' => Lang::get('notification.success')),200);
	}

	public function contact_save(){
		Contact::create(
			array(
				'FIRSTNAME' => strtoupper(Input::get('firstname')),
				'LASTNAME' => strtoupper(Input::get('lastname')),
				'MSISDN'   => strtoupper(Input::get('msisdn')),
				'KNEEDID'=> Session::get('user')->ID
				)
			);

       
		return Response::json(array('flash' => Lang::get('notification.success'), 
			'data'=> Input::all(), 'title' => Lang::get('notification.success')),200);
	}

	public function brodcast_sms(){
		$view = View::make('subscriptions.brodcast');	
		$this->layout->content = $view;	
	}

	public function brodcast_save(){
		//if($v->passes){
		//$parts = explode('/', Input::get('schedule'));
		$date  = Input::get('schedule');//"$parts[2]-$parts[0]-$parts[1]";
		BrodcastSms::create(
			array(
				'KEYWORDID' => strtoupper(Input::get('id')),
				'MESSAGE' => Input::get('datasrc'),
				'STATUS' => 'PENDING',
				'KNEEDID'=> Session::get('user')->ID,
				'SCHEDULE' => $date,
				'REPEAT' => Input::get('repeat'),		
				)
			);

       
		return Response::json(array('flash' => Lang::get('notification.success'), 
			'data'=> Input::all(), 'title' => Lang::get('notification.success')),200);
	}


	public function brodcastSmsManage(){
		$view = View::make('subscriptions.brodcast-manage');	
		$view->brodcastsms = BrodcastSms::join('keywords','brodcastsms.KEYWORDID', '=', 'keywords.ID')->where('brodcastsms.KNEEDID',"=",Session::get('user')->ID)->select('keywords.KEYWORD','brodcastsms.*')->get();
		$this->layout->content = $view;
	}


}
