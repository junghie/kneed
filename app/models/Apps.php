<?php

class Apps extends Eloquent {
	protected $primaryKey = 'ID';
	protected $table = "apps";

	public $timestamps = false;

	// Use fillable as a white list
    //protected $fillable = array('username', 'email', 'password');
 
 
    // OR set guarded to an empty array to allow mass assignment of every field
    protected $guarded = array();


    public function scopeCheck($query,$secretid,$appid){
    	return $query
    			->where("SECRETID", "=", $secretid)
    			->where("APPID","=",$appid)
    			->get();

    }


}