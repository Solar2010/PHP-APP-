<?php 
require_once 'common.php';
class Init extends Common 
{
	public function index(){

		$this -> check();

		$versionUpgrade = $this -> getVersionUpgrade($this -> app['id']);
		if($versionUpgrade) {
			if($versionUpgrade['type'] && $this -> params['version_id'] < $versionUpgrade['version_id']) {
				$versionUpgrade['is_upload'] = $versionUpgrade['type'];
			} else {
				$versionUpgrade['is_upload'] = 0;
			}
			return Response::show(200,'版本升级信息获取成功',$versionUpgrade);
		} else {
			return Response::show(400,'版本升级信息获取失败');
		}
	}
}