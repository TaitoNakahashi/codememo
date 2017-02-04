<?php
// ログイン呼出し・セッション確認用PHP
	//セッション
	session_start();

	//data_change.phpを呼出し、「PHPの定数」と，「HTMLのname属性」を対応付ける
<<<<<<< HEAD
	require_once 'data_change.php';
=======
	require 'data_change.php';

	if(isset($_SESSION[USER_ID]) || isset($_SESSION[USER_NAME])) {
		// ログイン状態の確認
		header('Location: index_user.php');
		exit('ログインしています。--> ログイン者名 : '.$_SESSION[USER_NAME]);//以降の処理を停止
	}

	if(isset($_POST[LOGIN])) {
		// login_checkを通過したことを証明するsession変数を渡す
		$check = 'check';
		//ログイン処理呼出し
		require 'login_connect.php';
		exit('ログイン処理を開始します。 --> login_connectへ');//以降の処理を停止
	}
>>>>>>> origin/master

	// 新規登録のセッションに入力データがある場合
	// メンバー登録php変数初期値
	$email = '';
	$password = '';
<<<<<<< HEAD
	$username = '';
	//既に入力済みの場合セッションから値を取得
	// if(isset($_SESSION[EMAIL])) $email = $_SESSION[EMAIL];
	// if(isset($_SESSION[PASSWORD])) $password = $_SESSION[PASSWORD];
	// if(isset($_SESSION[USERNAME])) $username = $_SESSION[USERNAME];
=======
	$name = '';
	//既に入力済みの場合セッションから値を取得
	if(isset($_SESSION[EMAIL])) $email = $_SESSION[EMAIL];
	if(isset($_SESSION[PASSWORD])) $password = $_SESSION[PASSWORD];
	if(isset($_SESSION[NAME])) $name = $_SESSION[NAME];
>>>>>>> origin/master
?>
