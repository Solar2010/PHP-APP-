<?php 
//定时任务生成缓存 */5 * * * * /usr/bin/php /data/wwwroot/app.api/cron.php
require_once 'db.php';
require_once 'file.php';

$sql = "SELECT * FROM `video` WHERE `status`=1 ORDER BY `id` DESC";
$rows = [];
try{
	$connect = Db::getInstance() -> connect();
} catch (Exception $e) {
	file_put_contents('./logs/'.date('Y-m-d').'.txt', $e -> getMessage());
	return;
}
$result = mysql_query($sql,$connect);

if($result) {
	while ($row = mysql_fetch_assoc($result)) {
		$rows[] = $row;
	}
}

$file = new File();
if($rows) {
	$file -> cacheData('list_cron_cache',$rows);
} else {
	file_put_contents('./logs/'.date('Y-m-d').'.txt', 'no data');	
}