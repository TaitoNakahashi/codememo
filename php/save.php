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
	$memo_name = isset($data['memo_name']) ? $data['memo_name'] : '';
	$mode_name = isset($data['mode_name']) ? $data['mode_name'] : '';
	$memo_data = isset($data['memo_data']) ? $data['memo_data'] : '';
	// 保存した日付を取得
	$save_date = date('Ymd');
	$tag_name = isset($data['tag_name']) ? $data['tag_name'] : '';
	// user_mailはログインしたユーザ名を取得
	$user_mail = 'taito@taito.com';

	//データベース接続用php呼出し
	require 'mysql_connect.php';

	$sql = 'SELECT mode_id,mode_name FROM t_mode WHERE mode_name = ?';
	$stmt = $pdo->prepare($sql);
	$stmt->bindValue(1, $mode_name,PDO::PARAM_STR);
	$stmt->execute();
	foreach ($stmt as $rows) {
		printf('%s %s',$rows['mode_id'],$rows['mode_name']);
	}
	$dbmode_id = isset($rows['mode_id']) ? $rows['mode_id'] : '';
	$dbmode_name = isset($rows['mode_name']) ? $rows['mode_name'] : '';
	unset($rows);
	//　mode名がDBのmode名と一致したらIDを取得
	if($dbmode_name === $mode_name) {
		// 取り出した値を受け渡し変数へ格納
		$mode_id = $dbmode_id;
	} else {
		// 受け取ったモード名がDBに存在しない場合
		$error = 'modeデータに関する処理でエラー';
		exit($error);
	}

	// t_memoにはログイン中のユーザ情報とメモの名前、メモ本文、形式カテゴリをinsertで登録
	//uniqidでユニークIDを13文字生成 引数に乱数を指定してさらにユニーク化
	//uniqid = マイクロ秒単位の現在時刻にもとづいた、接頭辞つきの一意な ID を取得します。
	$memo_id = uniqid(rand()).getmypid();
	$sql = 'insert into t_memo (memo_id,memo_name,memo_data,mode_name,save_date,user_mail) values (?,?,?,?,?,?)';
	$stmt = $pdo->prepare($sql);
	$stmt->bindValue(1, $memo_id, PDO::PARAM_STR);
	$stmt->bindValue(2, $memo_name, PDO::PARAM_STR);
	$stmt->bindValue(3, $memo_data, PDO::PARAM_STR);
	$stmt->bindValue(4, $mode_name, PDO::PARAM_STR);
	$stmt->bindValue(5, $save_date, PDO::PARAM_STR);
	$stmt->bindValue(6, $user_mail, PDO::PARAM_STR);
	$stmt->execute();
	// $pdo->commit();

	// t_tagsにはtagが入力されている場合、タグ名を取得し、登録者のユーザ名、登録したメモ名もinsertで登録
	$sql = 'select tag_name from t_tags where tag_name = ? and user_mail = ?';
	$stmt = $pdo->prepare($sql);
	$stmt->bindValue(1, $tag_name, PDO::PARAM_STR);
	$stmt->bindValue(2, $user_mail, PDO::PARAM_STR);
	$stmt->execute();
	foreach ($stmt as $rows) {
		printf('%s',$rows['tag_name']);
	}
	$dbtag_name = isset($rows['tag_name']) ? $rows['tag_name'] : '';
	unset($rows);
	//　tag名がDB内に存在している場合エラー文
	if($dbtag_name === $tag_name) {
		$tag_error = '入力されたタグ名は登録済みでした。';
	} else {
		$sql = 'insert into t_tags (tag_name,memo_id,user_mail) values (?,?,?)';
		$stmt = $pdo->prepare($sql);
		$stmt->bindValue(1, $tag_name, PDO::PARAM_STR);
		$stmt->bindValue(2, $memo_id, PDO::PARAM_STR);
		$stmt->bindValue(3, $user_mail, PDO::PARAM_STR);
		$stmt->execute();
		// $pdo->commit();
	}

	if(!isset($error)){
		$result = '保存しました。';
		if(isset($tag_error)) {
			$result .= $tag_error;
		}
		//$json_result = json_encode($result);
		echo $result;
	}

// メモ内容変更時には、ページの読み込み時にデータベースから取り出したデータかどうかのフラグで判断し、
// insertかupdateを切り替える


// Ajax以外からのアクセスを遮断

?>
