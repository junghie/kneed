<?php

class Subscription extends Eloquent {
	protected $primaryKey = 'ID';
	protected $table = "subscriptions";

	public $timestamps = false;


	// Use fillable as a white list
    //protected $fillable = array('username', 'email', 'password');
 
 
    // OR set guarded to an empty array to allow mass assignment of every field
    protected $guarded = array();

    public static function validate($input){

        $rules = array(
                'reportname'     => 'Unique:subscriptions,KEYWORDID,null'
        );

        return Validator::make($input, $rules);
    }

    public function scopeGetGroup($query, $msisdn)
    {
        $selectVals = $query
        				->join('keywords','subscriptions.KEYWORDID','=','keywords.ID')
        				->select('keywords.KEYWORD','subscriptions.MSISDN')
        				->where("MSISDN","=",$msisdn)
        				->where("keywords.KNEEDID","=",Session::get('user')->ID);
        return $selectVals->get();
    }
}