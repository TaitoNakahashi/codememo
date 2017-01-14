<?php
//ログイン処理用PHP	書式 : PDO
	//エラーメッセージを配列化
	$error = array();

	// ログイン
	if (!isset($_POST[LOGIN] || !isset($check))) {
		$error = '通信エラーです。';
		exit();
	} else {
		//ユーザIDとパスワードの入力チェック
		// foreach ([USER_ID, PASSWORD] as $v) {
		// 	$$v = (string)filter_input(INPUT_POST, $v);
		// 	print $$v;
		// }
		if (empty($_POST[USER_ID]) or empty($_POST[PASSWORD])) {
			$error = 'ユーザIDまたはパスワードが未入力です。';
			exit();
		//エラーがない場合　ログイン処理を行う
		} else {
			//mysql接続用phpを呼び出す データベースに接続を開くだけ
			require 'mysql_connect.php';
			//パスワードのハッシュ化用のpassword.phpを呼出し
			require_once 'password.php';
			// 入力値のサニタイズ
			// $user_id = (string)filter_input(INPUT_POST,$_POST[USER_ID]);
			$user_id = $_POST[USER_ID];
			$stmt = $pdo->prepare('SELECT * FROM t_user WHERE user_mail = ?');
			$stmt->bindValue(1, $user_id, PDO::PARAM_STR);
			$stmt->execute();
			// $sql = 'SELECT * FROM t_user WHERE user_mail = '' .$user_id. ''';
			while ($rows = $stmt->fetch()) {
			// パスワード(暗号化済み）の取り出し
				$dbuser_id = $row['user_mail'];
				$dbuser_name = $row['user_name'];
				$dbhashed_pwd = $row['user_pass'];
			}
			//クエリが実行できたかどうか
			if (!$rows) {
				print('クエリーが失敗しました。' . $stmt->error);
				//接続を閉じる
				$stmt->close();
				exit();
			}
			// データベースの切断
			$stmt->close();
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
				exit();
			}
		}
	}
?>
