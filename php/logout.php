<?php
	//セッション
	session_start();
	//data-change.phpを呼出し、「PHPの定数」と，「HTMLのname属性」を対応付ける
	require "data-change.php";

	if(isset($_SESSION[USER_ID])) {
	  $errorMessage = "ログアウトしました。";
	} else {
	  $errorMessage = "セッションがタイムアウトしました。";
	}
	// セッション変数のクリア
	$_SESSION = array();

	// セッションクリア
	@session_destroy();

	header("Location: ../index.php");
	exit;
?>
