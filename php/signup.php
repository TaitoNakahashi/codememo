<?php
	//  HTTPヘッダーで文字コードを指定
	header("Content-Type:text/html; charset=UTF-8");
?>
<?php
//signup.PHP	書式 : PDO

	//data-change.phpを呼出し、「PHPの定数」と，「HTMLのname属性」を対応付ける
	require_once 'data_change.php';

	// ajaxで値が受け渡される(json形式)
	$json = file_get_contents('php://input');
	$json = mb_convert_encoding($json,'UTF-8','ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
	 // JSON形式データをPHPの配列型に変換
	$data = json_decode($json, true);
	//新規に入力された場合入力データ受け取り
	$username = isset($data[USERNAME]) ? htmlspecialchars($data[USERNAME]) : '';
	$email = isset($data[EMAIL]) ? htmlspecialchars($data[EMAIL]) : '';
	$password = isset($data[PASSWORD]) ? htmlspecialchars($data[PASSWORD]) : '';
	$username = trim($username);
	$email = trim($email);
	$password = trim($password);

	if(empty($username) || empty($email) || empty($password)) {
		$error = '必須項目に空欄があります　再入力してください';
		print($error);
		exit();
	}

	// //リダイレクト用セッション変数
	$_SESSION[EMAIL] = $email;
	$_SESSION[PASSWORD] = '';
	$_SESSION[USERNAME] = $username;

	// //password.phpと接続
	require_once 'password.php';
	// //パスワードハッシュ化
	$hashpass = password_hash($password, PASSWORD_DEFAULT);

	//データベース接続用php呼出し
	require_once 'mysql_connect.php';

	// データ検索重複チェック
	$sql = 'SELECT user_id FROM t_user WHERE user_id = ?';
	$stmt = $pdo->prepare($sql);
	$stmt->bindValue(1, $email, PDO::PARAM_STR);
	$sql_result = $stmt->execute();
	if(!$sql_result) {
		// データがなければエラー
		$error = 'phpエラー : t_userに対してのsqlでエラー';
		print($error);
		exit();
	}
	foreach ($stmt as $rows) {
		$dbuser_id = isset($rows['user_id']) ? $rows['user_id'] : '';
	}
	unset($rows);
	//メールアドレス,パスワード二重チェック
	if(isset($dbuser_id) === $email ) {
		$error= '入力されたメールアドレスは既に存在しています';
		print ($error);
		exit();
	} else {
		// insert($email,$hashpass,$username);
	}

	//データ登録
	// function insert($email,$hashpass,$username) {
		$sql = 'INSERT INTO t_user (user_id,user_pass,user_name) VALUES (?,?,?)';
		$stmt = $pdo->prepare($sql);
		$stmt->bindValue(1, $email, PDO::PARAM_STR);
		$stmt->bindValue(2, $hashpass, PDO::PARAM_STR);
		$stmt->bindValue(3, $username, PDO::PARAM_STR);
		$sql_result2 = $stmt->execute();
		if(!$sql_result2) {
			// データがなければエラー
			$error = 'phpエラー : t_userに対してのsqlでエラー';
			print($error);
			exit();
		}
		$sql = 'SELECT user_name FROM t_user';
		$stmt = $pdo->prepare($sql);
		// $stmt->bindValue(1, $email, PDO::PARAM_STR);
		$sql_result3 = $stmt->execute();
		if(!$sql_result3) {
			// データがなければエラー
			$error = 'phpエラー : t_userに対してのsqlでエラー';
			print($error);
			exit();
		}
		foreach ($stmt as $rows) {
			$dbuser_name = isset($rows['user_name']) ? $rows['user_name'] : '';
			if(isset($dbuser_name) === $username) {
					print('登録しました！'.$username.'さんようこそ！');
					// セッションクリア
					@session_destroy();
					exit();
			} else {
				print('登録に失敗しました！');
				// セッションクリア
				@session_destroy();
				exit();
			}
		}
		unset($rows);

	// }
	//データ登録

?>
