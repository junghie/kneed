<?php

class Keyword extends Eloquent {
	protected $primaryKey = 'ID';
	protected $table = "keywords";

	public $timestamps = false;


	// Use fillable as a white list
    //protected $fillable = array('username', 'email', 'password');
 
 
    // OR set guarded to an empty array to allow mass assignment of every field
    protected $guarded = array();

    public static function validate($input){

        $rules = array(
                'KEYWORD' => 'Required|Min:3|Max:80|Alpha|Unique:keywords',
        );

        return Validator::make($input, $rules);
    }

    
}