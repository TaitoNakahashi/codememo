<?php
//ログイン処理用PHP	書式 : PDO
	//エラーメッセージを配列化
	$error = array();

	// ログイン

	//ユーザIDとパスワードの入力チェック
	// foreach ([USER_ID, PASSWORD] as $v) {
	// 	$$v = (string)filter_input(INPUT_POST, $v);
	// 	print $$v;
	// }
	if (empty($_POST[USER_ID]) or empty($_POST[PASSWORD])) {
		$error = 'ユーザIDまたはパスワードが未入力です。';
		print ($error);
		exit();
	//エラーがない場合　ログイン処理を行う
	} else {
		//mysql接続用phpを呼び出す データベースに接続を開くだけ
		require_once 'mysql_connect.php';
		//パスワードのハッシュ化用のpassword.phpを呼出し
		require_once 'password.php';
		// 入力値のサニタイズ
		$user_id = $_POST[USER_ID];
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
			print $error;
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
		if (password_verify($_POST[PASSWORD],$dbhashed_pwd)) {
			//セッション変数にPOSTで受け取ったデータを代入
			$_SESSION[USER_ID] = $dbuser_id;
			$_SESSION[USER_NAME] = $dbuser_name;
			//強制にindex_user.phpに転送
			header('Location: editor.php');
			//プログラム処理を終了
			exit();
		} else {
			// 認証失敗
			$error = 'ユーザIDあるいはパスワードに誤りがあります。';
			print $error;
			exit();
		}
	}
?>
