<?php

class Contact extends Eloquent {
	protected $primaryKey = 'ID';
	protected $table = "contacts";

	public $timestamps = false;


	// Use fillable as a white list
    //protected $fillable = array('username', 'email', 'password');
 
 
    // OR set guarded to an empty array to allow mass assignment of every field
    protected $guarded = array();

    public static function validate($input){

        $rules = array(
                'MSISDN'     => 'Required|Unique:contacts,MSISDN,null,KNEEDID,' . Session::get('user')->ID,
                'FIRSTNAME'     => 'Required',
                'LASTNAME'     => 'Required',
        );

        return Validator::make($input, $rules);
    }
}