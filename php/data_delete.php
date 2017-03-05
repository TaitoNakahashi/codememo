<?php
//  HTTPヘッダーで文字コードを指定
header('Content-Type:text/html; charset=UTF-8');
?>
<?php
//data_delete.php

	// //data-change.phpを呼出し、「PHPの定数」と，「HTMLのname属性」を対応付ける
	require 'data_change.php';

	require 'mysql_connect.php';

	if(isset($_POST['deleteid'])) {
		//member_id(int型)で検索するためint以外を弾く
		// $get_id = (int)filter_input(INPUT_POST, 'deleteid');
		$get_id = $_POST['deleteid'];

		// tagmapのデータを削除
		$sql = 'DELETE m, tm
				FROM t_memo m
				LEFT JOIN t_tagmap tm ON m.memo_id = tm.memo_id
				WHERE m.memo_id = ?';
		$stmt = $pdo->prepare($sql);
		$stmt->bindValue(1, $get_id, PDO::PARAM_STR);
		$sql_result1 = $stmt->execute();
		if($sql_result1) {
			print 'データを削除しました。';
		} else {
			print 'phpエラー : t_memoおよびt_tagmapに対するsqlでエラー。'.$sql_result1;
			exit();
		}

		// t_memoのデータを検索し、削除
		// if(isset($flag) === 'ok') {
		// 	$sql = 'DELETE FROM t_memo WHERE memo_id = ?';
		// 	$stmt = $pdo->prepare($sql);
		// 	$stmt->bindValue(1, $get_id, PDO::PARAM_STR);
		// 	$sql_result2 = $stmt->execute();
		// 	if($sql_result2) {
		// 		print 'データを削除しました。';
		// 	} else {
		// 		print 'phpエラー : t_memoに対するsqlでエラー。'.$sql_result2;
		// 		exit();
		// 	}
		// }

	} else {
		$error = '削除するデータを検索できませんでした。';
		print($error);
		exit();
	}

?>
