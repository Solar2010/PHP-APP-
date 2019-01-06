<?php
/**
 * 单例模式实例化数据库
 */
class Db{
	private static $_instance;
	private static $_connectSource;
	private $_dbConfig = array(
		'host' => '127.0.0.1',
		'db_user' => 'root',
		'db_password' => 'root',
		'db' => 'test'
	);
	private function __constract()
	{

	}

	public static function getInstance()
	{
		if(!self::$_instance instanceof self) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	public function connect()
	{
		if(!self::$_connectSource) {
			self::$_connectSource = mysql_connect($this -> _dbConfig['host'],$this -> _dbConfig['db_user'],$this -> _dbConfig['db_password']);
			if(!self::$_connectSource) {
				throw new Exception('mysql connect error'.mysql_error());
				//die('mysql connect error'.mysql_error());
			}
			mysql_select_db($this -> _dbConfig['db'],self::$_connectSource);
			mysql_set_charset('UTF8'); 
		}
		
		return self::$_connectSource;
	}
}