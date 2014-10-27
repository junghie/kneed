<?php

class ChikkaApiController extends BaseController {

	const REPLY_AMOUNT = "2.50";
	const SEND_AMOUNT = ".65";
	const STOP_AMOUNT = "2.50";

	public static function getReplyAmount(){ return self::REPLY_AMOUNT; }
	public static function getSendAmount(){ return self::SEND_AMOUNT; }

	public function notification()
	{
		Log::info('Log message', Input::all());	

		SmppPull::where("REFERENCEID","=", Input::get('message_id'))->update(array('STATUS','=',Input::get('status')));

		return Response::json(array('status' => 'ok', 
			'message'=> 'accepted' ,200));	

	}


	/*
	message_type=incoming
	&mobile_number=639181234567
	&shortcode=29290123456
	&request_id=5048303030534D415254303030303032393230303032303030303030303133323030303036333933393932333934303030303030313331313035303735383137
	&message=This+is+a+test+message×tamp=1383609498.44
	*/
	public function messageReceiver()
	{
		Log::info('Log message', Input::all());	
		$message = explode(" ",strtoupper(Input::get('message')));
		$msisdn  = Input::get('mobile_number');

		if($message[0] == "STOP"){
			$keyword = $message[1];
			$obj = Keyword::where("KEYWORD", "=", $keyword)->where("ISGROUP","=","0")->get();

			if($obj->count() > 0){
			
			$obj = $obj[0];

			Subcription::where("MSISDN", "=", $msisdn)
						->where("KEYWORDID", "=", $obj->ID)
						->delete();

			$referenceid = str_random(32);
			SmppHits::create(array(
								"MSISDN" => Input::get('mobile_number'),
								"MESSAGE" => Input::get('message'),
								"REFERENCEID" => $referenceid,
								"KNEEDID" => $obj->KNEEDID,
								"REQUEST" => json_encode(Input::all())
								));
			SmppPndg::create(
							array(
								"MSISDN" => Input::get('mobile_number'),
								"MESSAGE" => "STOP SUCCESFULLY " . $keyword ,
								"REFERENCEID" => $referenceid,
								"KNEEDID" => $obj->KNEEDID,
								"TYPE"  => "REPLY",
								"SMSCOST" => $this->getStopAmount(),
								"REQUESTID" => Input::get('request_id')
								)
						);

			//send message
			return Response::json(array('status' => 'ok', 
			'message'=> base64_decode($obj->MESSAGE) ,200));	
			elseif($message[0] == "VOTE"){
			
			$referenceid = str_random(32);
			SmppHits::create(array(
								"MSISDN" => Input::get('mobile_number'),
								"MESSAGE" => Input::get('message'),
								"REFERENCEID" => $referenceid,
								"KNEEDID" => $obj->KNEEDID,
								"REQUEST" => json_encode(Input::all())
								));

			//get vote
			$poll = Poll::where("CODE","=",$message[1])->get();
			$polldetails = PollDetails::where("POLLID","=",$poll->ID)->where("OPTION","=",$message[2])->get();

			if($polldetails->count() >= 1){
				PollDetails::where("POLLID","=",$poll->id)
							 ->where("OPTION","=",$message[2])
							 ->update(array("VOTES" => $polldetails->VOTES + 1));
			}


			SmppPndg::create(
							array(
								"MSISDN" => Input::get('mobile_number'),
								"MESSAGE" => "STOP SUCCESFULLY " . $keyword ,
								"REFERENCEID" => $referenceid,
								"KNEEDID" => $obj->KNEEDID,
								"TYPE"  => "REPLY",
								"SMSCOST" => $this->getStopAmount(),
								"REQUESTID" => Input::get('request_id')
								)
						);

			//send message
			return Response::json(array('status' => 'ok', 
			'message'=> base64_decode($obj->MESSAGE) ,200));

			}else{
				$referenceid = str_random(32);
				ChikkaApi::sendreply(
									array(
										"message_type" => "REPLY",
										"mobile_number" => Input::get('mobile_number'),
										"shortcode" => ChikkaApi::getShortCode(),
										"message_id" => $referenceid,
										"message" => "KEYWORD : " . $keyword . " NOT AVAILABLE",
										"request_id" => Input::get('request_id'),
										"request_cost" => $this->getReplyAmount(),
										"client_id" => ChikkaApi::getClientId(),
										"secret_key" => ChikkaApi::getSecretKey()
									)
							);
				return Response::json(array('status' => 'ok', 
				'message'=> base64_decode($obj->MESSAGE) ,200));	
			}

		}else{

			$keyword = $message[0];
			$obj = Keyword::where("KEYWORD", "=", $keyword)->where("ISGROUP","=","0")->get();	

			if($obj->count() > 0){

			$obj = $obj[0];

			Subscription::create(
					array(
							"KEYWORDID" => $obj->ID,
							"MSISDN"  => $msisdn
						)
				);
			$referenceid = str_random(32);
			SmppHits::create(array(
								"MSISDN" => Input::get('mobile_number'),
								"MESSAGE" => Input::get('message'),
								"REFERENCEID" => $referenceid,
								"KNEEDID" => $obj->KNEEDID,
								"REQUEST" => json_encode(Input::all())
								));
			SmppPndg::create(
							array(
								"MSISDN" => Input::get('mobile_number'),
								"MESSAGE" => base64_decode($obj->MESSAGE),
								"REFERENCEID" => $referenceid,
								"KNEEDID" => $obj->KNEEDID,
								"TYPE"  => "REPLY",
								"SMSCOST" => $this->getReplyAmount(),
								"REQUESTID" => Input::get('request_id')
								)
						);
			//send message

			return Response::json(array('status' => 'ok', 
			'message'=> base64_decode($obj->MESSAGE) ,200));	

		   }else{
				$referenceid = str_random(32);
				ChikkaApi::sendreply(
									array(
										"message_type" => "REPLY",
										"mobile_number" => Input::get('mobile_number'),
										"shortcode" => ChikkaApi::getShortCode(),
										"message_id" => $referenceid,
										"message" => "KEYWORD : " . $keyword . " NOT AVAILABLE",
										"request_id" => Input::get('request_id'),
										"request_cost" => $this->getReplyAmount(),
										"client_id" => ChikkaApi::getClientId(),
										"secret_key" => ChikkaApi::getSecretKey()
									)
							);
				return Response::json(array('status' => 'ok', 
				'message'=> base64_decode($obj->MESSAGE) ,200));	
			}
			
		}

		return Response::json(array('status' => 'ok', 
			'message'=> 'accepted' ,200));	

	}	

}
