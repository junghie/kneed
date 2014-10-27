<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class SendSmsAppDaemon extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'sendsms:process';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Sendsms process';

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
			$smpppndg = SmppPndg::get();

			foreach($smpppndg as $pndg){

					if($pndg->TYPE == "SEND"){			


					SmppPull::create(
							array(
								"MSISDN" => $pndg->MSISDN,
								"MESSAGE" => $pndg->MESSAGE,
								"REFERENCEID" => $pndg->REFERENCEID,
								"KNEEDID" => $pndg->KNEEDID,
								"TYPE" => $pndg->TYPE,
								"SMSCOST" => $pndg->SMSCOST,
								"REQUESTID" => $pndg->REQUESTID,
								"STATUS" => "SENT"
								)
						);


						$ids = MobileIds::find($pndg->KNEEDID);
						if($pndg->SMSCOST > 0){
							$msgcount = strip_tags($pndg->MESSAGE);
							$count = ceil(count($msgcount)/140);
							$fee = $count * $pndg->SMSCOST;

							if($ids->CREDIT < $fee){
								SmppPull::where("REFERENCEID","=",$pndg->REFERENCEID)->update(array('STATUS' => "FAILED NOT ENOUGH BALANCE"));
							}

							$ids->CREDIT = $ids->CREDIT - $fee;
							$ids->save();	
							SmppPull::where("REFERENCEID","=",$pndg->REFERENCEID)->update(array('TOTALCOST' => $fee));

						}

						ChikkaApi::sendsms(array(
								"message_type" => "SEND",
								"mobile_number" => $pndg->MSISDN,
								"shortcode" => ChikkaApi::getShortCode(),
								"message_id" => $pndg->REFERENCEID,
								"message" => strip_tags($pndg->MESSAGE),
								"client_id" => ChikkaApi::getClientId(),
								"secret_key" => ChikkaApi::getSecretKey()
							)
						);
					}else{
						$ids = MobileIds::find($pndg->KNEEDID);


						SmppPull::create(
								array(
									"MSISDN" => $pndg->MSISDN,
									"MESSAGE" => $pndg->MESSAGE,
									"REFERENCEID" => $pndg->REFERENCEID,
									"KNEEDID" => $pndg->KNEEDID,
									"TYPE" => $pndg->TYPE,
									"SMSCOST" => "FREE",
									"REQUESTID" => $pndg->REQUESTID,
									"STATUS" => "SENT"
									)
							);

						
						if($pndg->SMSCOST > 0){
							$profit = $pndg->SMSCOST * .30;
							$ids->COMMISSION = $ids->COMMISSION + $profit;
							$ids->save();	
						}

						SmppHits::where("REFERENCEID","=",$pndg->REFERENCEID)->update(array('AMOUNT' => $profit));

						ChikkaApi::sendreply(
									array(
										"message_type" => "REPLY",
										"mobile_number" => $pndg->MSISDN,
										"shortcode" => ChikkaApi::getShortCode(),
										"message_id" => $pndg->REFERENCEID,
										"message" => strip_tags($pndg->MESSAGE),
										"request_id" => $pndg->REQUESTID,
										"request_cost" => $pndg->SMSCOST,
										"client_id" => ChikkaApi::getClientId(),
										"secret_key" => ChikkaApi::getSecretKey()
									)
							);


					}

					SmppPndg::where("ID","=",$pndg->ID)->delete();
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