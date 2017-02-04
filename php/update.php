<?php
	//  HTTPヘッダーで文字コードを指定
	header("Content-Type:text/html; charset=UTF-8");
?>
<?php
//save.php
	// バリデーション内容 saveBtnを押されてきているかの判断,直接アクセスの拒否、ログインしている場合のみアクセス

		//data-change.phpを呼出し、「PHPの定数」と，「HTMLのname属性」を対応付ける
		require 'data_change.php';

		// save.phpではsaveボタンが押された時にajaxで値が受け渡される(json形式)
		$json = file_get_contents('php://input');
		$json = mb_convert_encoding($json,'UTF-8','ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
		 // JSON形式データをPHPの配列型に変換
		$data = json_decode($json, true);
		$memo_id = isset($data['memo_id']) ? $data['memo_id'] : '';
		$memo_name = isset($data['memo_name']) ? htmlspecialchars($data['memo_name']) : '';
		$mode_name = isset($data['mode_name']) ? htmlspecialchars($data['mode_name']) : '';
		$memo_data = isset($data['memo_data']) ? htmlspecialchars($data['memo_data']) : '';
		// 保存した日付を取得
		$save_date = date('Ymd');
		$tag_name = isset($data['tag_name']) ? htmlspecialchars($data['tag_name']) : '';
		// user_mailはログインしたユーザ名を取得
		$user_mail = 'taito@taito.com';

		//データベース接続用php呼出し
		require 'mysql_connect.php';

		// t_modeから取得したmodeデータが正しいものか判断する
		$sql = 'SELECT mode_id,mode_name FROM t_mode WHERE mode_name = ?';
		$stmt = $pdo->prepare($sql);
		$stmt->bindValue(1, $mode_name,PDO::PARAM_STR);
		$sql_result1 = $stmt->execute();
		if(!$sql_result1) {
			// データがなければエラー
			$error = 'phpエラー : t_modeに対してのsqlでエラー';
			print($error);
			exit();
		}
		foreach ($stmt as $rows) {
			// printf('%s %s',$rows['mode_id'],$rows['mode_name']);
			$dbmode_id = isset($rows['mode_id']) ? $rows['mode_id'] : '';
			$dbmode_name = isset($rows['mode_name']) ? $rows['mode_name'] : '';
		}
		unset($rows);
		//　mode名がDBのmode名と一致したらIDを取得
		if($dbmode_name === $mode_name) {
			// 取り出した値を受け渡し変数へ格納
			$mode_id = $dbmode_id;
		} else {
			// 受け取ったモード名がDBに存在しない場合
			$error = 'phpエラー : modeデータに関する処理でエラー';
			print $error;
			exit();
		}

		// メモ内容変更時には、ページの読み込み時にmemoの個別IDがあるかどうか確認して、
		// insertかupdateを切り替える
		if(isset($memo_id) && !empty($memo_id)) {
			// $memo_idが存在または変数に値がある場合 --> update
			$sql = 'UPDATE t_memo SET memo_name=?,memo_data=?,mode_name=?,save_date=? WHERE memo_id=?';
			$stmt = $pdo->prepare($sql);
			$stmt->bindValue(1, $memo_name, PDO::PARAM_STR);
			$stmt->bindValue(2, $memo_data, PDO::PARAM_STR);
			$stmt->bindValue(3, $mode_name, PDO::PARAM_STR);
			$stmt->bindValue(4, $save_date, PDO::PARAM_STR);
			$stmt->bindValue(5, $memo_id, PDO::PARAM_STR);
			$sql_result2 = $stmt->execute();
			if($sql_result2) {
				$result = '更新しました。';
			} else {
				$error = 'phpエラー : 更新に失敗しました';
				print($error);
				exit();
			}
		} else if(empty($memo_id) || isset($new_save)) {
			// $memo_idが存在しない場合 --> insert

			// t_memoにはログイン中のユーザ情報とメモの名前、メモ本文、形式カテゴリをinsertで登録
			//uniqidでユニークIDを13文字生成 引数に乱数を指定してさらにユニーク化
			//uniqid = マイクロ秒単位の現在時刻にもとづいた、接頭辞つきの一意な ID を取得します。
			$memo_id = uniqid(rand()).getmypid();
			$sql = 'INSERT INTO t_memo (memo_id,memo_name,memo_data,mode_name,save_date,user_mail) VALUES (?,?,?,?,?,?)';
			$stmt = $pdo->prepare($sql);
			$stmt->bindValue(1, $memo_id, PDO::PARAM_STR);
			$stmt->bindValue(2, $memo_name, PDO::PARAM_STR);
			$stmt->bindValue(3, $memo_data, PDO::PARAM_STR);
			$stmt->bindValue(4, $mode_name, PDO::PARAM_STR);
			$stmt->bindValue(5, $save_date, PDO::PARAM_STR);
			$stmt->bindValue(6, $user_mail, PDO::PARAM_STR);
			$sql_result3 = $stmt->execute();
			// $pdo->commit();
			if($sql_result3) {
				$result = '保存しました。';
			} else {
				$error = 'phpエラー : 保存に失敗しました';
				print($error);
				exit();
			}
		}
		print $memo_id;
		// t_tagはupdateなし　タグの削除はおいおい考える
		// t_tagsにはtagが入力されている場合、タグ名を取得し、登録者のユーザ名、登録したメモ名もinsertで登録
		$sql = 'SELECT tag_name FROM t_tags WHERE tag_name = ? AND memo_id = ?';
		$stmt = $pdo->prepare($sql);
		$stmt->bindValue(1, $tag_name, PDO::PARAM_STR);
		$stmt->bindValue(2, $memo_id, PDO::PARAM_STR); //この$memo_idは最後に代入されたIDとなる
		$sql_result4 = $stmt->execute();
		if(!$sql_result4) {
			// データがなければエラー
			$error = 'phpエラー : t_tagに対してのsql(SELECT)でエラー';
			print($error);
			exit();
		}
		foreach ($stmt as $rows) {
			$dbtag_name = isset($rows['tag_name']) ? $rows['tag_name'] : '';
		}
		unset($rows);
		//　tag名がDB内に存在している場合エラー文
		if($dbtag_name === $tag_name) {
			$tag_message = '入力されたタグは登録済みでした';
			// t_memoにだけ登録する
		} else if(isset($tag_name) && !empty($tag_name)) {
			$sql = 'INSERT INTO t_tags (tag_name,memo_id,user_mail) VALUES (?,?,?)';
			$stmt = $pdo->prepare($sql);
			$stmt->bindValue(1, $tag_name, PDO::PARAM_STR);
			$stmt->bindValue(2, $memo_id, PDO::PARAM_STR);
			$stmt->bindValue(3, $user_mail, PDO::PARAM_STR);
			$sql_result6 = $stmt->execute();
			// $pdo->commit();
			if(!$sql_result6) {
				// データがなければエラー
				$error = 'phpエラー : t_tagに対してのsql(INSERT)でエラー';
				print($error);
				exit();
			}
		} else {
			// 空白の場合はなにもしない
		}

		// errorがなければ保存が完了の変数を返す
		if(!isset($error)){
			if(isset($tag_message)) {
				// タグが存在している場合は同じようにリザルトで返す
				$result .= $tag_message;
			}
			print($result);
		}


?>
