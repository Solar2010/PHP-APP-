<?php 
require_once 'response.php';
require_once 'file.php';
$file = new File();
$data = $file -> cacheData('list_cron_cache');
$data = json_decode(json_decode($data),true);
if($data) {
	return Response::show(200,'success',$data);
} else {
	return Response::show(400,'not found',$data);
}
exit;


require_once 'db.php';
require_once 'file.php';

$page = isset($_GET['page'])?$_GET['page']:1;
$pageSize = isset($_GET['pagesize'])?$_GET['pagesize']:10;

if(!is_numeric($page) || !is_numeric($pageSize)) {
	return Response::show(401,'参数错误');
}

$offset = ($page - 1)*$pageSize;
$sql = "SELECT * FROM `video` WHERE `status`=1 ORDER BY `id` DESC LIMIT ".$offset.",".$pageSize."";

$cache = new File();
$rows = [];
if(!$rows = $cache -> cacheData('list_cache'.$page.'-'.$pageSize)) {
	try{
		$connect = Db::getInstance() -> connect();
	} catch(Exception $e) {
		return Response::show(403,'mysql_connect error');
	}
	$result = mysql_query($sql,$connect);

	if($result) {
		while ($row = mysql_fetch_assoc($result)) {
			$rows[] = $row;
		}
	}
	if($rows) {
		$cache -> cacheData('list_cache'.$page.'-'.$pageSize,$rows,1200);
	}
}


if($rows) {
	return Response::show(200,'success',$rows);
} else {
	return Response::show(400,'not found',$rows);
}
