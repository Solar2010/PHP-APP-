<?php 
class File 
{
	private $_dir;
	const EXT = '.txt';
	public function __construct()
	{
		$this -> _dir = dirname(__FILE__).'/files/';
	}
	public function cacheData($key,$value='',$expire_time=0,$path='')
	{
		$filename = $this -> _dir.$path.'/'.$key.self::EXT;
		if($value !== '') {
			if(is_null($value)) {
				return @unlink($filename);
			}
			$dir = dirname($filename);
			if(!is_dir($dir)) {
				mkdir($dir,0777);
			}
			$expire_time = sprintf('%011d',$expire_time);
			return file_put_contents($filename, $expire_time.json_encode($value));
		}
		if(!is_file($filename)) {
			return false;
		} else {
			$contents = file_get_contents($filename);
			$expire_time = (int)substr($contents, 0,11);
			$value = substr($contents, 11);
			if($expire_time != 0 && $expire_time + filemtime($filename) < time()) {
				@unlink($filename);
				return false;
			}
			return json_encode($value,true);
		}
	}
}