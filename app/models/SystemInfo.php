<?php

class SystemInfo extends Eloquent {
	protected $primaryKey = 'ID';
	protected $table = "systeminfo";

	public $timestamps = false;


	// Use fillable as a white list
    //protected $fillable = array('username', 'email', 'password');
 
 
    // OR set guarded to an empty array to allow mass assignment of every field
    protected $guarded = array();

    public function scopeGetProperty($query,$name){
        try{
    	return $query
    			->where("KEY", "=", $name)
    			->get()[0]->VALUE;
        }catch(Exception $e){
            return "";
        }

    }

}