<?php

//set_include_path(APPPATH.'third_party/phpsec');
//require_once APPPATH.'third_party/phpsec/Net/SFTP.php';


class PollController extends BaseController {

	public $layout = "header";

	public function index(){
		$view = View::make('polls.index');	
		$view->keywords = Keyword::where('KNEEDID',"=",Session::get('user')->ID)->get();
		$this->layout->content = $view;
	}

	public function manage(){
		$view = View::make('polls.manage');	
		$view->polls = Poll::where('KNEEDID',"=",Session::get('user')->ID)->get();
		$this->layout->content = $view;
	}

	public function save(){
		
		$code = strtoupper(str_random(6));
		$groups = Input::get('n_contacts');
		


		$poll = Poll::create(
			array(
				'CODE' => $code,
				'DESCRIPTION' => strtoupper(Input::get('n_description')),
				'KNEEDID'=> Session::get('user')->ID,
				'URL' => "polls/" . $code,
				'ENDDATE' => Input::get('n_sched')
				)
			);

       	//if(Input::hasFile('n_file'))
        //{
            $file = Input::file('n_file');
            $option = Input::get('n_option');
            $optiondescription = Input::get('n_option_description');
            $ctr = 0;
            //foreach($file as $f){
            foreach($optiondescription as $f){
	            $att = new PollDetails;
	            //$att->FILENAME = $f->getClientOriginalName();
	            //$att->FILE = base64_encode(file_get_contents($f->getRealPath()));
	            //$att->FILEMIME = $f->getMimeType();
	            //$att->FILESIZE = $f->getSize();
	            $att->OPTION = $ctr+1;
	            $att->DESCRIPTION = $optiondescription[$ctr];
	            $att->POLLID = $poll->ID;
	            $att->VOTES = 0;
	            $att->save();
	            $ctr++;
        	}
         
        //}


		foreach($groups as $keyword){
				BrodcastSms::create(
					array(
						'KEYWORDID' => $keyword,
						'MESSAGE' => "NEW SURVEY PLEASE VISIT " .  URL::to("polls/" . $code),
						'STATUS' => 'PENDING',
						'KNEEDID'=> Session::get('user')->ID,
						'SCHEDULE' => date("Y-m-d"),
						'REPEAT' => 0,		
						)
					);
		}      	

        $view = View::make('polls.index');	
        $view->keywords = Keyword::where('KNEEDID',"=",Session::get('user')->ID)->get();
        $view->flash = 0;
		$this->layout->content = $view;
		
	}
}