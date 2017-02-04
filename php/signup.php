<?php
	//  HTTPヘッダーで文字コードを指定
	header("Content-Type:text/html; charset=UTF-8");
?>
<?php
// signup.php

	//エラーメッセージ初期値
	$error = '';

	//data-change.phpを呼出し、「PHPの定数」と，「HTMLのname属性」を対応付ける
	require_once 'data_change.php';

	// save.phpではsaveボタンが押された時にajaxで値が受け渡される(json形式)
	$json = file_get_contents('php://input');
	$json = mb_convert_encoding($json,'UTF-8','ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
	 // JSON形式データをPHPの配列型に変換
	$data = json_decode($json, true);
	printf($json);
	$username = isset($data[USERNAME]) ? htmlspecialchars($data[USERNAME]) : '';
	$email= isset($data[EMAIL]) ? htmlspecialchars($data[EMAIL]) : '';
	$password = isset($data[PASSWORD]) ? htmlspecialchars($data[PASSWORD]) : '';
	//新規に入力された場合入力データ受け取り

	// //リダイレクト用セッション変数
	$_SESSION[EMAIL] = $email;
	$_SESSION[PASSWORD] = '';
	$_SESSION[USERNAME] = $username;
	//
	// //password.phpと接続
	require_once 'password.php';
	// //パスワードハッシュ化
	$hashpass = password_hash($password, PASSWORD_DEFAULT);

	//データベース接続用php呼出し
	require_once 'mysql_connect.php';

	//データ検索重複チェック
	$sql = 'SELECT * FROM t_user WHERE user_id = ?';
	$stmt = $pdo->prepare($sql);
	$stmt->bindValue(1, $email, PDO::PARAM_STR);
	$sql_result = $stmt->execute();
	// if(!$sql_result) {
	// 	// データがなければエラー
	// 	$error = 'phpエラー : t_userに対してのsqlでエラー';
	// 	print($error);
	// 	exit();
	// }
	// foreach ($stmt as $rows) {
	// 	print 'tuuka';
	// 	$dbuser_id = isset($rows['user_id']) ? $rows['user_id'] : '';
	// 	$dbuser_name = isset($rows['user_name']) ? $rows['user_name'] : '';
	// 	//メールアドレス,パスワード二重チェック
	//  	if(isset($dbuser_id) === $email ) {
	// 		print 'tuuka2';
	// 		$error= '入力されたメールアドレスは既に存在しています';
	// 		print ($error);
	// 		exit();
	// 	}
	// }
	// unset($rows);
	//
	// print 'tuuka3;'
	// //データ登録
	// if(!$error) {
	// 	print 'tuuka4';
	// 	$sql = 'INSERT INTO t_user (user_id,user_pass,user_name) VALUES (?,?,?)';
	// 	$stmt->bindValue(1, $email, PDO::PARAM_STR);
	// 	$stmt->bindValue(2, $password, PDO::PARAM_STR);
	// 	$stmt->bindValue(3, $username, PDO::PARAM_STR);
	// 	$sql_result2 = $stmt->execute();
	// 	if(!$sql_result2) {
	// 		// データがなければエラー
	// 		$error = 'phpエラー : t_userに対してのsqlでエラー';
	// 		print($error);
	// 		exit();
	// 	}
	//
	// 	if(!$error) {
	// 		print '登録しました！'.$username.'さんようこそ！';
	// 	}
	// 	// セッションクリア
	// 	@session_destroy();
	//
	// }
	// //データ登録

?>
