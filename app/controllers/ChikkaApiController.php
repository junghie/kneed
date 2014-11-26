<?php

class ChikkaApiController extends BaseController {

	const REPLY_AMOUNT = "FREE";
	const SEND_AMOUNT = "FREE";
	const STOP_AMOUNT = "FREE";
	const VOTE_AMOUNT = "FREE";

	public static function getReplyAmount(){ return self::REPLY_AMOUNT; }
	public static function getSendAmount(){ return self::SEND_AMOUNT; }
	public static function getVoteAmount(){ return self::VOTE_AMOUNT; }
	public static function getStopAmount(){ return self::STOP_AMOUNT; }

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

			$referenceid = Common::getreferenceid();
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
								"SMSCOST" => $this->getVoteAmount(),
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
				'message'=> "FAILED",200));	
			}

		}elseif($message[0] == "VOTE"){

			$poll = Poll::where("CODE","=",$message[1])->get()[0];
			if(!empty($poll->ID)){
				$referenceid = str_random(32);
				SmppHits::create(array(
									"MSISDN" => Input::get('mobile_number'),
									"MESSAGE" => Input::get('message'),
									"REFERENCEID" => $referenceid,
									"KNEEDID" => $poll->KNEEDID,
									"REQUEST" => json_encode(Input::all())
									));

				//get vote
				
				$polldetails = PollDetails::where("POLLID","=",$poll->ID)->where("OPTION","=",$message[2])->get();
				
				if($polldetails->count() >= 1){
					PollDetails::where("POLLID","=",$poll->ID)
								 ->where("OPTION","=",$message[2])
								 ->update(array("VOTES" => $polldetails[0]->VOTES + 1));
				}


				SmppPndg::create(
								array(
									"MSISDN" => Input::get('mobile_number'),
									"MESSAGE" => "THANK YOU FOR VOTING" ,
									"REFERENCEID" => $referenceid,
									"KNEEDID" => $poll->KNEEDID,
									"TYPE"  => "REPLY",
									"SMSCOST" => $this->getStopAmount(),
									"REQUESTID" => Input::get('request_id')
									)
							);

				//send message
				return Response::json(array('status' => 'ok', 
				'message'=> "SUCCESS" ,200));
			}else{
				$referenceid = str_random(32);
				ChikkaApi::sendreply(
									array(
										"message_type" => "REPLY",
										"mobile_number" => Input::get('mobile_number'),
										"shortcode" => ChikkaApi::getShortCode(),
										"message_id" => $referenceid,
										"message" => "TEST",
										"request_id" => Input::get('request_id'),
										"request_cost" => $this->getReplyAmount(),
										"client_id" => ChikkaApi::getClientId(),
										"secret_key" => ChikkaApi::getSecretKey()
									)
							);
				return Response::json(array('status' => 'ok', 
				'message'=> "FAILED",200));	
			}

		}else{

			$message = explode("_",strtoupper(Input::get('message')));
			$keyword = $message[0];
			$obj = Keyword::where("KEYWORD", "=", $keyword)->where("ISGROUP","=","0")->get();	

			$firstname = (empty($mesage[1])) ? "" : $message[1];
			$lastname =  (empty($mesage[2])) ? "" : $message[2];
			$location  = (empty($mesage[3])) ? "" : $message[3];
			$birthdate = (empty($mesage[4])) ? date('Y-m-d') : $message[4];

			if($obj->count() > 0){

			$obj = $obj[0];

			Subscription::create(
					array(
							"KEYWORDID" => $obj->ID,
							"MSISDN"  => $msisdn
							"FIRSTNAME" => $message[1],
							"LASTNAME" => $message[2],
							"LOCATION" => $message[3],
							"BIRTHDATE" => $message[4]
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
				'message'=> "FAILED" ,200));	
			}
			
		}

		return Response::json(array('status' => 'ok', 
			'message'=> 'accepted' ,200));	

	}	

}
