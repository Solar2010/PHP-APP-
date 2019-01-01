<?php 
class File 
{
	private $_dir;
	public function __construct()
	{
		$this -> _dir = dirname(__FILE__).'/files/';
	}
	public function cacheData($key,$value='',$path)
	{

	}
}