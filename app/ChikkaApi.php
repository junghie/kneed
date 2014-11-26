<?php

class ChikkaApi {

	const CLIENTID = "367364d5f1d02327797c660d2ee94bc76ce56cba9b46fcd28acf448adecb6945";
	const SECRETKEY = "f0a1c1fb0a8576908bb191e2051c14f9ce37ae8709e48d7231efa928b5691df5";
	const SHORTCODE = "292908299";

	public static function getClientId(){ return self::CLIENTID; }
	public static function getSecretKey(){ return self::SECRETKEY; }
	public static function getShortCode(){ return self::SHORTCODE; }

	/*
	 *@method sendsms
	 *@param request array(
							"message_type" => "SEND",
							"mobile_number" => "639181234567",
							"shortcode" => "29290123456",
							"message_id" => "12345678901234567890123456789012",
							"message" => "Welcome to My Service!",
							"client_id" => "1e6d92a6e8794a7bb6aea67f008420e56a0272dfb21047369dc1ea0c9c8f8a19",
							"secret_key" => "502f3b2ecce940f5b750dab07bf6b222de86f6e270a6427e9a0ea6b194bb4bdc"
						);

	*/
	public static function sendsms($body){

		$query_string = "";
		
		foreach($body as $key => $frow)
		{
			$query_string .= '&'.$key.'='.$frow;
		}
		$query_string = substr($query_string, 1);
		//echo $query_string;

		$URL = "https://112.199.82.34/smsapi/request";
		$curl_handler = curl_init();
		curl_setopt($curl_handler, CURLOPT_URL, $URL);
		curl_setopt($curl_handler, CURLOPT_POST, count($body));
		curl_setopt($curl_handler, CURLOPT_POSTFIELDS, $query_string);
		curl_setopt($curl_handler, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($curl_handler, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl_handler, CURLOPT_SSL_VERIFYHOST, false);

		$response = curl_exec($curl_handler);
		curl_close($curl_handler);
		return $response;
	}


	/*
	 *@method sendsms
	 *@param request array(
							"message_type" => "REPLY",
							"mobile_number" => "639181234567",
							"shortcode" => "29290123456",
							"message_id" => "12345678901234567890123456789012",
							"message" => "Welcome to My Service!",
							"request_id" => "receive message request id",
							"request_count" => "FREE",
							"client_id" => "1e6d92a6e8794a7bb6aea67f008420e56a0272dfb21047369dc1ea0c9c8f8a19",
							"secret_key" => "502f3b2ecce940f5b750dab07bf6b222de86f6e270a6427e9a0ea6b194bb4bdc"
						);

	*/
	public static function sendreply($body){

		$query_string = "";
		
		foreach($body as $key => $frow)
		{
			$query_string .= '&'.$key.'='.$frow;
		}
		$query_string = substr($query_string, 1);
		//echo $query_string;

		$URL = "https://112.199.82.34/smsapi/request";
		$curl_handler = curl_init();
		curl_setopt($curl_handler, CURLOPT_URL, $URL);
		curl_setopt($curl_handler, CURLOPT_POST, count($body));
		curl_setopt($curl_handler, CURLOPT_POSTFIELDS, $query_string);
		curl_setopt($curl_handler, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($curl_handler, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl_handler, CURLOPT_SSL_VERIFYHOST, false);

		$response = curl_exec($curl_handler);
		curl_close($curl_handler);
		return $response;
	}

}