<?php

class AuthCodes extends Eloquent {
	protected $primaryKey = 'ID';
	protected $table = "authcodes";

    public $timestamps = false;

	// Use fillable as a white list
    //protected $fillable = array('username', 'email', 'password');
 
 
    // OR set guarded to an empty array to allow mass assignment of every field
    protected $guarded = array();



    public function scopeCheck($query,$msisdn,$authcode){
    	return $query
    			->where("KNEEDID", "=", $msisdn)
    			->where("AUTHCODE","=",$authcode)
                ->where("ISUSED","=",0)
    			->get();

    }
}