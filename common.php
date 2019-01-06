<?php 
//处理接口公共业务
require_once 'response.php';
require_once 'db.php';
class Common 
{
	public $params;
	public $app;

	/**
	 * 检测APP信息
	 * @return [type] [description]
	 */
	public function check()
	{
		$this -> params['app_id'] = $appId = isset($_POST['app_id']) ? $_POST['app_id'] : '';
		$this -> params['version_id'] = $version_id = isset($_POST['version_id']) ? $_POST['version_id'] : '';
		$this -> params['version_mini'] = $version_mini = isset($_POST['version_mini']) ? $_POST['version_mini'] : '';
		$this -> params['did'] = $did = isset($_POST['did']) ? $_POST['did'] : '';
		$this -> params['encrypt_id'] = $encrypt_id = isset($_POST['encrypt_id']) ? $_POST['encrypt_id'] : '';
		if(!is_numeric($appId) || !is_numeric($version_id)) {
			Response::show(401,'参数不合法');
		}
		$this -> app = $this -> getApp($appId);
		if(!$this -> app) {
			return Response::show(402,'app_id不存在');
		}

		if($this -> app['is_encryption'] && $encryptDid != md5($did).$this -> app['key']) {
			return Response::show(403,'没有权限');
		}

	}

	/**
	 * 获取APP信息
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function getApp($id)
	{
		$sql = "SELECT * FROM `app` WHERE `id` = ".$id." AND `status` = 1 LIMIT 1";
		$connect = Db::getInstance() -> connect();
		return $result = mysql_query($sql);
	}

	/**
	 * 获取APP版本升级信息
	 * @param  [type] $appId [description]
	 * @return [type]        [description]
	 */
	public function getVersionUpgrade($appId) {
		$sql = "SELECT * FROM `version_upgrade` WHERE `app_id` = ".$appId." AND `status` = 1 LIMIT 1";
		$connect = Db::getInstance() -> connect();
		return $result = mysql_query($sql); 
	}
}