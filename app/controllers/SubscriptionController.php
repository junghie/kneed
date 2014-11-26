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

	public function contact_import(){
		$view = View::make('contacts.import');
		$this->layout->content = $view;
	}

	public function contact_manage(){
		$view = View::make('contacts.manage');	
		$view->contacts = Contact::where('KNEEDID',"=",Session::get('user')->ID)->get();
		$this->layout->content = $view;
	}

	public function contact_update($id, $token){
		$view = View::make('contacts.update');	
		$view->account = Contact::where('KNEEDID',"=",Session::get('user')->ID)->where('ID', '=', $id)->get()[0];
		$this->layout->content = $view;
	}

	public function contact_group(){
		$view = View::make('contacts.groups');	
		$view->contacts = Contact::where('KNEEDID',"=",Session::get('user')->ID)->get();
		$this->layout->content = $view;
	}

	public function contact_grouplist(){
		$view = View::make('contacts.group-list');	
		$reportname = Input::get('reportname');
		
		if(!empty($reportname)){
			$view->subscriptions = Subscription::where("KEYWORDID","=",Input::get('reportname'))->get();
			$view->keyword = Keyword::find($reportname);
		}

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
		if($group[0] == "ALL"){
		//foreach number insert into subscription table
			$contact_array = Contact::where('KNEEDID','=',Session::get('user')->ID)->get();
			$contactarr = array();
			foreach($contact_array as $contact){
				array_push($contactarr,array("KEYWORDID" => $keyword->ID, "MSISDN"=>$contact->MSISDN));
			}

			DB::table('users')->insert($contactarr);
		}else{
			foreach($groups as $msisdn){
				if($msisdn == "ALL") continue;
				Subscription::create(
					array(
							"KEYWORDID" => $keyword->ID,
							"MSISDN"  => $msisdn
						)
				);
			}
		}

       
		return Response::json(array('flash' => Lang::get('notification.success'), 
			'data'=> Input::all(), 'title' => Lang::get('notification.success')),200);
	}

	public function contact_save(){
		 
		 $v = Contact::validate(Input::all());

		//to do validation and sanitize input
		if($v->passes()){
		Contact::create(
			array(
				'FIRSTNAME' => strtoupper(Input::get('firstname')),
				'LASTNAME' => strtoupper(Input::get('lastname')),
				'MSISDN'   => strtoupper(Input::get('msisdn')),
				'BIRTHDATE'   => strtoupper(Input::get('birthdate')),
				'LOCATION'   => strtoupper(Input::get('location')),
				'EMAIL'   => strtoupper(Input::get('email')),
				'COMPANY'   => strtoupper(Input::get('company')),
				'KNEEDID'=> Session::get('user')->ID
				)
			);
		return Response::json(array('flash' => Lang::get('notification.success'), 
			'data'=> Input::all(), 'title' => Lang::get('notification.success')),200);
		}

       		return Response::json(array('flash' => Lang::get('notification.error'), 
			'data'=> $v->getMessageBag()->toArray(), 'title' => Lang::get('notification.error')),200);
		
	}

	public function contact_import_save(){
		$str = str_replace("\n\r", "\n", Input::get('csvdata'));
		$v = explode("\n",$str);
		$error = [];
		//Format : MOBILENUMBER,FIRSTNAME,LASTNAME,BIRTHDATE (YYYYMMDD),LOCATION,COMPANY </p>
		$count = 0;
		foreach($v as $contacts){
			$contact = explode(",",$contacts);
			
			if(count($contact) == 7){ 

				Contact::create(
				array(
					'FIRSTNAME' => strtoupper($contact[1]),
					'LASTNAME' => strtoupper($contact[2]),
					'MSISDN'   => strtoupper($contact[0]),
					'BIRTHDATE'   => strtoupper($contact[3]),
					'LOCATION'   => strtoupper($contact[4]),
					'EMAIL'   => strtoupper($contact[6]),
					'COMPANY'   => strtoupper($contact[5]),
					'KNEEDID'=> Session::get('user')->ID
					)
				);
			}else{
				$line = $count + 1;
				$error[] = "Error on line : " . $line;
			}
			$count++;
		}
		if(count($error) == 0){
		return Response::json(array('flash' => Lang::get('notification.success'), 
			'data'=> "", 'title' => Lang::get('notification.success')),200);
		}


       		return Response::json(array('flash' => Lang::get('notification.error'), 
			'data'=> $contact, 'title' => Lang::get('notification.error')),200);
		
	}

	public function contact_update_save(){
		 
			$id = Contact::find(Input::get("id"));
			$id->FIRSTNAME = Input::get('firstname');
			$id->LASTNAME = strtoupper(Input::get('lastname'));
			$id->MSISDN = strtoupper(Input::get('msisdn'));
			$id->BIRTHDATE = strtoupper(Input::get('birthdate'));
			$id->LOCATION = strtoupper(Input::get('location'));
			$id->EMAIL = strtoupper(Input::get('email'));
			$id->COMPANY   = Input::get('company');
		
			$id->save();
		return Response::json(array('flash' => Lang::get('notification.success'), 
			'data'=> "", 'title' => Lang::get('notification.success')),200);
		
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
