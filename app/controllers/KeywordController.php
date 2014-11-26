<?php

//set_include_path(APPPATH.'third_party/phpsec');
//require_once APPPATH.'third_party/phpsec/Net/SFTP.php';


class KeywordController extends BaseController {

	public $layout = "header";

	public function index(){
		$accounttype = Session::get('user')->ACCOUNTTYPEID;
		$view = View::make('keywords.index');	

		$view->count = Session::get('accounttypes')[$accounttype]->KEYWORDLIMIT + Session::get('user')->ADDITIONALKEYWORD;
		$view->keywordcount = Keyword::where('KNEEDID',"=",Session::get('user')->ID)
							->where('ISGROUP','=','0')->get()->count();


		$this->layout->content = $view;
	}


	public function index_update(){
		$view = View::make('keywords.update');	
		$this->layout->content = $view;
	}

	public function index_delete(){
		$view = View::make('keywords.delete');	
		$this->layout->content = $view;
	}

	public function save(){

		$v = Keyword::validate(Input::all());
		$accounttype = Session::get('user')->ACCOUNTTYPEID;
		$count = Session::get('accounttypes')[$accounttype]->KEYWORDLIMIT +  Session::get('user')->ADDITIONALKEYWORD;
		$keywordcount = Keyword::where('KNEEDID',"=",Session::get('user')->ID)->where('ISGROUP','=','0')->get()->count();

		if($keywordcount > $count){
			return Response::json(array('flash' => Lang::get('notification.error'), 
			'data'=> Lang::get('notification.exceedlimit') , 'title' => Lang::get('notification.error')),200);	
		}

		if(count(strip_tags(base64_decode(Input::get('datasrc')))) > 140) {
			return Response::json(array('flash' => Lang::get('notification.error'), 
			'data'=> Lang::get('notification.error_welcome_message_length') , 'title' => Lang::get('notification.error')),200);	
		}

		if($v->passes()){
		Keyword::create(
			array(
				'KEYWORD' => strtoupper(Input::get('KEYWORD')),
				'MESSAGE' => Input::get('datasrc'),
				'KNEEDID'=> Session::get('user')->ID
				)
			);

       
		return Response::json(array('flash' => Lang::get('notification.success'), 
			'data'=> $accounttype . ' ' . $count . ' ' . $keywordcount, 'title' => Lang::get('notification.success')),200);
		}

		return Response::json(array('flash' => Lang::get('notification.error'), 
			'data'=> $v->getMessageBag()->toArray(), 'title' => Lang::get('notification.error')),200);
	}

	public function update(){
		$reportname = Input::get('reportname');
		$script = Keyword::find(Input::get('id'));
		$script->MESSAGE = Input::get('datasrc');
		$script->save();

		return Response::json(array('flash' => Lang::get('notification.success_deallocation'), 
			'data'=> Input::all(), 'title' => Lang::get('notification.success')),200);
	}

	public function delete(){
		$reportname = Input::get('reportname');
		$script = Keyword::find(Input::get('id'))->delete();
		return Response::json(array('flash' => Lang::get('notification.success_deallocation'), 
			'data'=> Input::all(), 'title' => Lang::get('notification.success')),200);
	}

	public function getKeyword(){
		$group = Input::get('group');
		if($group < 2){
			$data = Keyword::where('KNEEDID',"=",Session::get('user')->ID)
			->where('ISGROUP','=',$group)->get()->toJson();
			return $data;	
			die();
		}

		$data = Keyword::where('KNEEDID',"=",Session::get('user')->ID)->get()->toJson();
		return $data;
	}


	public function report(){
		$view = View::make('reports.keywords');	
		//$view->keywords = Keyword::where('KNEEDID',"=",Session::get('user')->ID)->get();
		$view->keywords = DB::select(DB::raw("SELECT a.KEYWORD,a.MESSAGE, b.SUBCOUNT FROM kneed_keywords a
									LEFT JOIN (SELECT COUNT(*) SUBCOUNT, KEYWORDID FROM kneed_subscriptions GROUP BY KEYWORDID) b
									ON a.ID = b.KEYWORDID WHERE ISGROUP = 0 AND KNEEDID = '" . Session::get('user')->ID . "'"));
		$this->layout->content = $view;
	}

	public function buy(){
		$view = View::make('keywords.buy');
		$this->layout->content = $view;
	}

	public function keyword_purchase(){
		$password = Input::get('password');
		if(!Hash::check($password,Session::get('user')->PASSWORD)){
		      //return error oldpassword not match
		      return Response::json(array('flash' => Lang::get('notification.invalid_password'), 'data'=> Input::all(), 'title' => Lang::get('notification.error')),200);
		 }

		$ids = MobileIds::find(Session::get('user')->ID);
		$keyword_prices = "0";
		 foreach(Session::get('keywordpackage') as $package){
		 	if($package->package == Input::get('n_package'))
		 		$keyword_prices = $package->amount;
		 };
		$credit = $ids->CREDIT;
		$ids->CREDIT = $ids->CREDIT - $keyword_prices;
		$ids->ADDITIONALKEYWORD = $ids->ADDITIONALKEYWORD + ($keyword_prices / 10);
		$ids->save();	
		
		Transaction::create(
				array(
					"KNEEDID" =>Session::get('user')->ID,
					"TRANSACTIONTYPE" => "PURCHASE",
					"AMOUNT" => $keyword_prices,
					"BALANCEBEFORE" => $credit,
					"BALANCEAFTER" => $credit - $keyword_prices,
					"EXTENDEDDATA" => "KEYWORD",
					"REFERENCEID" => Common::getreferenceid()
					)
				);
		
		return Response::json(array('flash' => Lang::get('notification.success'), 
			'data'=> $keyword_prices, 'title' => Lang::get('notification.success')),200);
	}
}