<?php
//  HTTPヘッダーで文字コードを指定
header('Content-Type:text/html; charset=UTF-8');
?>
<?php
//save.php

	// //data-change.phpを呼出し、「PHPの定数」と，「HTMLのname属性」を対応付ける
	// require 'data_change.php';

	require 'mysql_connect.php';

	// if(!isset($_SESSION[USER_ID]) || !$_SESSION[USER_ID] === '') {
	// 	print 'ログインしていないため利用できません。';
	// 	$data_disp = '';
	// 	exit();
	// } else {
		// クエリの実行
		// $user_id = $_SESSION[USER_ID];
		$user_id = 'taito@taito.com';

		// t_tags取得
		$sql = 'SELECT * FROM t_tags WHERE user_mail = ?';
		$stmt = $pdo->prepare($sql);
		$stmt->bindValue(1, $user_id, PDO::PARAM_STR);
		$stmt->execute();
		$rows1 = $stmt->fetchAll();
		$rows1_length = count($rows1);
		$no = 0;    //カウント数
		$tags_disp = "";
		$tags_disp .= '<ul>';
		foreach($rows1 as $key => $value) {
			$tags_disp .= '<li class="tag-li" data-target="'.$rows1[$key]['tag_id'].'">'.$rows1[$key]['tag_name'].',</li>';
			$no++;
			if($no !== $rows1_length) {
				$tags_disp .= '<li class="tag-li" data-target="'.$rows1[$key]['tag_id'].'">'.$rows1[$key]['tag_name'].'</li><ul>';
			}
		}

		// t_memo取得
		// $sql = 'SELECT * FROM t_memo WHERE user_mail = ?';
		// $stmt = $pdo->prepare($sql);
		// $stmt->bindValue(1, $user_id, PDO::PARAM_STR);
		// $stmt->execute();
		// $rows2 = $stmt->fetchAll();
		// $rows2_length = count($rows2);
		// $no = 0;
		// $data_disp = "";
		// foreach($rows2 as $key => $value) {
		// 	$memo_id = $rows2[$key]['memo_id'];
		// 	$date_year = mb_substr($rows2[$key]['save_date'],0,4)."."; //年
		// 	$date_month = mb_substr($rows2[$key]['save_date'],4,2)."."; //月
		// 	$date_day = mb_substr($rows2[$key]['save_date'],6,2); //日
		// 	$date = $date_year.$date_month.$date_day;
		// 	$data_disp .= '<div class="data-box" id="'.$rows2[$key]['mode_name'].'" data-target="'.$rows2[$key]['memo_id'].'">';
		// 	$data_disp .= '<div class="data-icon"></div><div class="box-info">';
		// 	$data_disp .= '<p class="data-title">'.$rows2[$key]['memo_name'].'</p>';
		// 	$data_disp .= '<p class="data-date">'.$date.'</p>';
		// 	$data_disp .= '<p class="tag-name">';
		// 	$data_disp .= foreach($rows1 as $key => $value) { ;
		// 	$data_disp .= if($memo_id == $rows1[$key]['memo_id']) { .'<label class="tag-label">'. $rows1[$key]['tag_name'] . '</label>' . };
		// 	$data_disp .= };
		// 	$data_disp .='</p></div>';
		// 	$data_disp .= '<input type="hidden" name="data-memo" value="'.$rows2[$key]['memo_data'].'"></div>';
		// }

	// }


?>
