<?php

//set_include_path(APPPATH.'third_party/phpsec');
//require_once APPPATH.'third_party/phpsec/Net/SFTP.php';


class PollController extends BaseController {

	public $layout = "header";

	public function index(){
		$view = View::make('polls.index');	
		$this->layout->content = $view;
	}

	public function manage(){
		$view = View::make('polls.manage');	
		$view->contacts = Contact::where('KNEEDID',"=",Session::get('user')->ID)->get();
		$this->layout->content = $view;
	}

	public function save(){
		
		$poll = Poll::create(
			array(
				'CODE' => strtoupper(str_random(6)),
				'DESCRIPTION' => strtoupper(Input::get('n_description')),
				'KNEEDID'=> Session::get('user')->ID,
				'URL' => ""
				)
			);

		       	
       	if(Input::hasFile('n_file'))
        {
            $file = Input::file('n_file');
            $option = Input::get('n_option');
            $optiondescription = Input::get('n_option_description');
            $ctr = 0;
            foreach($file as $f){
	            $att = new PollDetails;
	            $att->FILENAME = $f->getClientOriginalName();
	            $att->FILE = base64_encode(file_get_contents($f->getRealPath()));
	            //$att->FILEMIME = $f->getMimeType();
	            $att->FILESIZE = $f->getSize();
	            $att->OPTION = $option[$ctr];
	            $att->DESCRIPTION = $optiondescription[$ctr];
	            $att->POLLID = $poll->ID;
	            $att->save();
	            $ctr++;
        	}
         
        }

        $view = View::make('polls.index');	
		$this->layout->content = $view;
		
	}
}