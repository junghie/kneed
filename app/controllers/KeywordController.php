<?php

//set_include_path(APPPATH.'third_party/phpsec');
//require_once APPPATH.'third_party/phpsec/Net/SFTP.php';


class KeywordController extends BaseController {

	public $layout = "header";

	public function index(){
		$view = View::make('keywords.index');	
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
		$count = Session::get('accounttypes')[$accounttype]->KEYWORDLIMIT;
		$keywordcount = Keyword::where('KNEEDID',"=",Session::get('user')->ID)->get()->count();

		if($keywordcount > $count){
			return Response::json(array('flash' => Lang::get('notification.error'), 
			'data'=> Lang::get('notification.exceedlimit') . '- contact support' , 'title' => Lang::get('notification.error')),200);	
		}

		//if($v->passes){
		Keyword::create(
			array(
				'KEYWORD' => strtoupper(Input::get('reportname')),
				'MESSAGE' => Input::get('datasrc'),
				'KNEEDID'=> Session::get('user')->ID
				)
			);

       
		return Response::json(array('flash' => Lang::get('notification.success'), 
			'data'=> $accounttype . ' ' . $count . ' ' . $keywordcount, 'title' => Lang::get('notification.success')),200);
		//}

		//return Response::json(array('flash' => Lang::get('notification.success'), 
		//	'data'=> $v, 'title' => Lang::get('notification.success')),500);
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
		$data = Keyword::where('KNEEDID',"=",Session::get('user')->ID)->get()->toJson();
		return $data;
	}


	public function report(){
		$view = View::make('reports.keywords');	
		//$view->keywords = Keyword::where('KNEEDID',"=",Session::get('user')->ID)->get();
		$view->keywords = DB::select(DB::raw("SELECT a.KEYWORD,a.MESSAGE, b.SUBCOUNT FROM kneed_keywords a
									LEFT JOIN (SELECT COUNT(*) SUBCOUNT, KEYWORDID FROM kneed_subscriptions) b
									ON a.ID = b.KEYWORDID WHERE KNEEDID = '" . Session::get('user')->ID . "'"));
		$this->layout->content = $view;
	}
}