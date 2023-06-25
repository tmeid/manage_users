<?php 
try{
	if(class_exists('PDO')){
		$options = [
			PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION  // đẩy lỗi và ngoại lệ khi truy vấn
		];
		$dsn = _DRIVER .':dbname=' ._DB .';host=' ._HOST;
		$connection = new PDO($dsn, _USER, __PASS, $options);
	}
}catch (Exception $e){
    require_once 'modules/errors/db_error.php';
	die();
}
