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
		// t_memoのデータを検索し、削除
		$sql = 'DELETE FROM t_memo WHERE memo_id = ?';
		$stmt = $pdo->prepare($sql);
		$stmt->bindValue(1, $get_id, PDO::PARAM_STR);
		$sql_result = $stmt->execute();
		if($sql_result) {
			print 'データを削除しました。';
		} else {
			print 'phpエラー : t_memoに対するsqlでエラー。'.$sql_result;
			exit();
		}
	} else {
		$error = '削除するデータを検索できませんでした。';
		print($error);
		exit();
	}

?>
