<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class BrodcastAppDaemon extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'brodcastsms:process';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Brodcastsms process';

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
		
			$brodcastsms = BrodcastSms::where('STATUS', '=', 'PENDING')->get();

			foreach($brodcastsms as $bs){
				$subscriptions = Subscription::where('KEYWORDID','=', $bs->KEYWORDID)
											  ->where('ISENABLED', '=', '1')->get();
				foreach($subscriptions as $subs){
					$referenceid = str_random(32);
					SmppPndg::create(
							array(
								"MSISDN" => $subs->MSISDN,
								"MESSAGE" => base64_decode($bs->MESSAGE),
								"REFERENCEID" => $referenceid,
								"KNEEDID" => $bs->KNEEDID,
								"TYPE"  => "SEND",
								"SMSCOST" => ".65"
								)
						);
				}
				BrodcastSms::where("ID","=",$bs->ID)->update(array('STATUS' => 'PROCESSING'));
			}
		
    
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