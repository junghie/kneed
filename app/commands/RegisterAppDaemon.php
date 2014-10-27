<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class RegisterAppDaemon extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'app:register';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Register Application. sample : app:register --name="Mpos" --description="Payment Gateway"';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		//sytax
		//
		$name = $this->option('name'); 
        $description = $this->option('description');
        $appid = $name . "_" . str_random(12);
        $secretid = $name . "_" . str_random(12);

        Apps::create(array(
        		"NAME" => $name,
        		"DESCRIPTION" => $description,
        		"APPID" => $appid,
        		"SECRETID" => $secretid
        	));
 
        $this->line(" {$name} : {$description} ");
        $this->line(" APPID : {$appid} ");
        $this->line(" Secretid : {$secretid} ");
		
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			array('name', InputArgument::OPTIONAL, 'An example argument.',null),
			array('description', InputArgument::OPTIONAL, 'An example test.',null),
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			array('name', null, InputOption::VALUE_OPTIONAL, 'An example option.', null),
			array('description', null, InputOption::VALUE_OPTIONAL, 'An example option.', null),
		);
	}
}