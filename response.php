<?php 
	/**
	* json化输出数据
	* 
	*/
	class Response
	{
		const JSON = "json";
		/**
		 * 综合输出数据
		 * @param  [integer] $code    [状态码]
		 * @param  string $message [提示信息]
		 * @param  array  $data    [返回数据]
		 * @param  [string] $type    [数据类型]
		 * @return [type]          [description]
		 */
		public static function show($code,$message='',$data=array(),$type=self::JSON)
		{
			if(!is_numeric($code)) {
				return '';
			}
			$result = [
				'code' => $code,
				'message' => $message,
				'data' => $data
			];
			$type = isset($_GET['format'])?$_GET['format']:self::JSON;
			if($type == 'json') {
				self::json($code,$message,$data);
				exit;
			} elseif ($type == 'array') {
				var_dump($result);
			} elseif ($type == 'xml') {
				self::xml($code,$message,$data);
				exit;
			} else {
				//TODO其他数据类型
			}
		}
		/**
		 * 按json返回数据
		 * @param  integer $code 状态码
		 * @param  string $message 提示信息
		 * @param  array $data 具体数据
		 * @return string
		 */
		public static function json($code,$message = '',$data=array())
		{
			if(!is_numeric($code)) {
				return '';
			}
			$result = [
				'code' => $code,
				'message' => $message,
				'data' => $data
			];
			echo json_encode($result);
			exit;
		}
		/**
		 * 按xml返回数据
		 * @param  [integer] $code    [状态码]
		 * @param  [string] $message [提示信息]
		 * @param  [type] $data    [返回数据]
		 * @return [string]          [description]
		 */
		public static function xml($code,$message='',$data=array())
		{
			if(!is_numeric($code)) {
				return '';
			}
			$result = [
				'code' => $code,
				'message' => $message,
				'data' => $data
			];
			header("Content-type:text/xml");
			$xml = "<?xml version='1.0' encoding='UTF-8'?>\n";
			$xml .= "<root>\n";
			$xml .= self::xmlEncode($result);
			$xml .= "</root>\n";
			echo $xml;
		}
		/**
		 * 拼装xml数据
		 * @param  [array] $data [description]
		 * @return [string]       [description]
		 */
		public static function xmlEncode($data) 
		{
			$xml = "";
			$attr = "";
			foreach ($data as $key => $value) {
				if(is_numeric($key)) {
					$attr = "id='{$key}'";
					$key = "item";
				}
				$xml .= "<{$key} {$attr}>";
				if(is_array($value)) {
					$xml .= self::xmlEncode($value);
				} else {
					$xml .= $value;
				}
				$xml .= "</{$key}>\n";
			}
			return $xml;
		}
	}