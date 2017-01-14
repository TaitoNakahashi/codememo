<?php
// signup.php
	// 登録フラグ
	$signok = 0;

	//エラーメッセージ初期値
	$errmsg = '';

	//data-change.phpを呼出し、「PHPの定数」と，「HTMLのname属性」を対応付ける
	require 'data_change.php';

	//新規に入力された場合入力データ受け取り
	if(isset($_POST[EMAIL])) $email = htmlspecialchars($_POST[EMAIL]);
	if(isset($_POST[PASSWORD])) $password = htmlspecialchars($_POST[PASSWORD]);
	if(isset($_POST[NAME])) $name = htmlspecialchars($_POST[NAME]);

	//リダイレクト用セッション変数
	$_SESSION[EMAIL] = $email;
	$_SESSION[PASSWORD] = '';
	$_SESSION[NAME] = $name;


	//password.phpと接続
	require 'password.php';
	//パスワードハッシュ化
	$hashpass = password_hash($password, PASSWORD_DEFAULT);

	//データベース接続用php呼出し
	require 'mysql_connect.php';

	//データ検索重複チェック
	$sql = 'select user_mail,user_pass from t_user where user_mail = ?';
	if ($stmt = mysqli_prepare($mysqli,$sql)) {
		/* マーカにパラメータをバインドします */
		mysqli_stmt_bind_param($stmt, 's', $email);
		/* クエリを実行します */
		mysqli_stmt_execute($stmt);
		//結果変数を複数バインド　
		mysqli_stmt_bind_result($stmt, $dbmail,$dbpass);
		/* クライアントのバッファに
		結果セットを保存 */
		mysqli_stmt_store_result($stmt);
		//複数行結果セット
		/* 値を取得 */
		while(mysqli_stmt_fetch($stmt)) {
			printf('取得した値='.'%s %s\n', $dbmail,$dbpass);
		}
		//メールアドレス,パスワード二重チェック
	 	if(isset($dbmail) == $email ) {
			$errmsg = '入力されたメールアドレスは既に存在しています';
		}
		/* ステートメントを閉じます */
		mysqli_stmt_close($stmt);
	}


	//データ登録
	if(!$errmsg) {

		$sql = 'insert into t_user (user_mail,user_pass,user_name) values (?,?,?)';
		if ($stmt = mysqli_prepare($mysqli,$sql)) {
			mysqli_stmt_bind_param($stmt, 'sss', $email,$hashpass,$name);
			/* クエリを実行します */
			mysqli_stmt_execute($stmt);
			/* ステートメントを閉じます */
			mysqli_stmt_close($stmt);
		}
		$signok = 1;
		// セッションクリア
		@session_destroy();

	}
	//データ登録

	//MySQLの接続クローズ
	if(!mysqli_close($mysqli)) {
		exit('MySQL切断エラー');
	}
?>
