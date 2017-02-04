<?php
	// DB接続用PHP 	書式 : PDO
	//MySQLへの接続　接続を開くだけで閉じるときは呼び出された先で閉じる
	require "mysqlenv.php";

	//DB接続 lolipop用
	// $dsn = 'mysql:dbname=LAA0801060-codememo;host=mysql116.phy.lolipop.lan;charset=utf8';

	// DB接続 localhost用
	$dsn = 'mysql:dbname='.$DB.';host='.$HOST.';charset=utf8';
	try{
		$pdo = new PDO(
			$dsn,
			$USER,
			$PASS,
			[
				PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
				PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
			]
		);
		// $dbh->query($CODE);
	}catch (PDOException $e){
		print "エラー!: " . $e->getMessage() . "<br/>";
		die();
	}
?>
