<?php
// ログイン呼出し・セッション確認用PHP
	//セッション
	session_start();

	//data_change.phpを呼出し、「PHPの定数」と，「HTMLのname属性」を対応付ける
	require_once 'data_change.php';

	// 新規登録のセッションに入力データがある場合
	// メンバー登録php変数初期値
	$email = '';
	$password = '';
	$username = '';
	//既に入力済みの場合セッションから値を取得
	// if(isset($_SESSION[EMAIL])) $email = $_SESSION[EMAIL];
	// if(isset($_SESSION[PASSWORD])) $password = $_SESSION[PASSWORD];
	// if(isset($_SESSION[USERNAME])) $username = $_SESSION[USERNAME];
?>
