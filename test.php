<?php 
require_once './response.php';
$arr = [
	'name' => 'Ian',
	'age' => 18,
	'sex' => 'men',
	'hobbit' => array(4,5,6)
];
//Response::json(200,'success',$arr);
// Response::xml(200,'success',$arr);
Response::show(200,'success',$arr);