<?php

class DataController extends BaseController {

	/*
	 *http://localhost:8001/api/auth/signup/
	 *{"msisdn":"639224638559","secretid":"","clientid":""}
	 */
	public function details()
	{
		$request = json_decode($json);
		$ids = MobileIds::where("MSISDN", "=", $request->msisdn)->get()[0];
		$app = Apps::Check($request->secretid,$request->clientid)[0];
		if(!Common::validate($request)){
			return Response::json(array('flash' => Lang::get('notification.success'), 
			'data'=> $json),401);	
		}

		$data = History::where("KNEEDID", "=", $ids->ID)->get();
		return Response::json(array('flash' => Lang::get('notification.success'), 
			'data'=> $data->toJson(),200);	
	}

	/*
	 *http://localhost:8001/api/auth/signup/
	 *{"msisdn":"639224638559","secretid":"","clientid":"","log":"","message":""}
	 */
	public function history()
	{
		$request = json_decode($json);
		$ids = MobileIds::where("MSISDN", "=", $request->msisdn)->get()[0];
		$app = Apps::Check($request->secretid,$request->clientid)[0];
		if(!Common::validate($request)){
			return Response::json(array('flash' => Lang::get('notification.success'), 
			'data'=> $json),401);	
		}

		
		Common::logHistory(
				array(
					"KNEEDID" => $ids->ID,
					"APPID" => $app->ID,
					"LOG" => $request->log,
					"MESSAGE" => $request->message,
					)
			);

		return Response::json(array('flash' => Lang::get('notification.success'), 
			'data'=> $json ,200);	
	}

}
