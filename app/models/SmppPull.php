<?php

class SmppPull extends Eloquent {
	protected $primaryKey = 'ID';
	protected $table = "smpppull";

	public $timestamps = false;


	// Use fillable as a white list
    //protected $fillable = array('username', 'email', 'password');
 
 
    // OR set guarded to an empty array to allow mass assignment of every field
    protected $guarded = array();


}