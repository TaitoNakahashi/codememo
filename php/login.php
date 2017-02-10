<?php
	//  HTTPヘッダーで文字コードを指定
	header("Content-Type:text/html; charset=UTF-8");
?>
<?php
//login.PHP	書式 : PDO

	//data-change.phpを呼出し、「PHPの定数」と，「HTMLのname属性」を対応付ける
	require_once 'data_change.php';

	// ajaxで値が受け渡される(json形式)
	$json = file_get_contents('php://input');
	$json = mb_convert_encoding($json,'UTF-8','ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
	 // JSON形式データをPHPの配列型に変換
	$data = json_decode($json, true);
	//新規に入力された場合入力データ受け取り
	$user_id = isset($data[USER_ID]) ? htmlspecialchars($data[USER_ID]) : '';
	$password = isset($data[PASSWORD]) ? htmlspecialchars($data[PASSWORD]) : '';
	$user_id = trim($user_id);
	$password = trim($password);

	if(empty($user_id) || empty($password)) {
		$error = '必須項目に空欄があります　再入力してください';
		print($error);
		exit();
	}

	//mysql接続用phpを呼び出す データベースに接続を開くだけ
	require_once 'mysql_connect.php';
	//パスワードのハッシュ化用のpassword.phpを呼出し
	require_once 'password.php';

	$sql = 'SELECT * FROM t_user WHERE user_id = ?';
	$stmt = $pdo->prepare($sql);
	$stmt->bindValue(1, $user_id, PDO::PARAM_STR);
	$sql_result = $stmt->execute();
	if(!$sql_result) {
		// データがなければエラー
		$error = 'phpエラー : t_userに対してのsqlでエラー';
		print($error);
		exit();
	}
	if(empty($rows)) {
		// データが存在していない場合
		$error = 'ユーザIDあるいはパスワードに誤りがあります。';
		print($error);
		exit();
	}
	foreach ($stmt as $rows) {
		$dbuser_id = isset($rows['user_id']) ? $rows['user_id'] : '';
		$dbuser_name = isset($rows['user_name']) ? $rows['user_name'] : '';
		$dbhashed_pwd = isset($rows['user_pass']) ? $rows['user_pass'] : '';
	}
	unset($rows);


	// 画面から入力されたパスワードとデータベースから取得したパスワードのハッシュを比較します。
	//パスワード
	if (password_verify($password,$dbhashed_pwd)) {
		//セッション変数にPOSTで受け取ったデータを代入
		$_SESSION[USER_ID] = $dbuser_id;
		$_SESSION[USERNAME] = $dbuser_name;

		print('こんにちは！'.$_SESSION[USERNAME].'さん');
		//プログラム処理を終了
		exit();
	} else {
		// 認証失敗
		$error = 'ユーザIDあるいはパスワードに誤りがあります。';
		print($error);
		exit();
	}
?>
