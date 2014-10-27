<?php

class MobileIds extends Eloquent {
	protected $primaryKey = 'ID';
	protected $table = "ids";

	public $timestamps = false;

	// Use fillable as a white list
    //protected $fillable = array('username', 'email', 'password');
 
 
    // OR set guarded to an empty array to allow mass assignment of every field
    protected $guarded = array();

    protected $hidden = array('AUTHCODE','PASSWORD');


    public function scopeCheck($query,$msisdn,$password){
    	return $query
    			->where("MSISDN", "=", $msisdn)
    			->where("PASSWORD","=",Crypt::encrypt($password))
    			->get();

    }

}