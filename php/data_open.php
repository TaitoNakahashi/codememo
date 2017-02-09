<?php
//  HTTPヘッダーで文字コードを指定
header('Content-Type:text/html; charset=UTF-8');
?>
<?php
//data_open.php

	// //data-change.phpを呼出し、「PHPの定数」と，「HTMLのname属性」を対応付ける
	require_once 'data_change.php';

	require_once 'mysql_connect.php';

	// if(!isset($_SESSION[USER_ID]) || !$_SESSION[USER_ID] === '') {
	// 	print 'ログインしていないため利用できません。';
	// 	$data_disp = '';
	// 	exit();
	// } else {
		// クエリの実行
		// $user_id = $_SESSION[USER_ID];
		$user_id = 'taito@taito.com';

		// t_tags取得　タグフィルターの生成
		$sql = 'SELECT * FROM t_tags WHERE user_id = ? GROUP BY tag_id ORDER BY tag_name ASC';
		$stmt = $pdo->prepare($sql);
		$stmt->bindValue(1, $user_id, PDO::PARAM_STR);
		$sql_result = $stmt->execute();
		if(!$sql_result) {
			$error = 'phpエラー : t_tagsのsqlにエラーが発生しました。';
			exit();
		}
		$rows1 = $stmt->fetchAll();
		$rows1_length = count($rows1);
		$no = 0;    //カウント数
		$tags_disp = '<ul>';
		foreach($rows1 as $key => $value) {
			$tags_disp .= '<li class="tag-li filter" data-toggle=".'.$rows1[$key]['tag_name'].'">'.$rows1[$key]['tag_name'].'</li>';
			$no++;
			if($no === $rows1_length) {
				$tags_disp .= '</ul>';
			}
		}
		unset($key);

		// t_memoから当該ユーザのデータ取得　メモリストを生成
		$sql = 'SELECT * FROM t_memo WHERE user_id = ? GROUP BY memo_id ORDER BY save_date DESC';
		$stmt = $pdo->prepare($sql);
		$stmt->bindValue(1, $user_id, PDO::PARAM_STR);
		$sql_result2 = $stmt->execute();
		if(!$sql_result2) {
			$error = 'phpエラー : t_memoのsqlにエラーが発生しました。';
			exit();
		}
		$rows2 = $stmt->fetchAll();
		$rows2_length = count($rows2);
		$no = 0;
		$data_disp = '<ul class="data-disp flex-container">';
		foreach($rows2 as $key => $value) {
			$memo_id = $rows2[$key]['memo_id'];
			$filter_date = $rows2[$key]['save_date'];
			$date_year = mb_substr($rows2[$key]['save_date'],0,4)."-"; //年
			$date_month = mb_substr($rows2[$key]['save_date'],4,2)."-"; //月
			$date_day = mb_substr($rows2[$key]['save_date'],6,2); //日
			$date = $date_year.$date_month.$date_day;
			$data_disp .= '<li class="data-box mix '.$rows2[$key]['mode_name'];
				// t_tagmapから当該ユーザの当該memoに関連付けされているタグを取得 t_tags t_tagmap t_memo
				$sql = 'SELECT t.tag_name,tm.memo_id
					FROM t_tagmap tm
					INNER JOIN t_tags t ON t.tag_id = tm.tag_id
					AND t.user_id = ? AND tm.memo_id = ?
					ORDER BY t.tag_name ASC';
				$stmt = $pdo->prepare($sql);
				$stmt->bindValue(1, $user_id, PDO::PARAM_STR);
				$stmt->bindValue(2, $memo_id, PDO::PARAM_STR);
				$sql_result3 = $stmt->execute();
				if(!$sql_result3) {
					$error = 'phpエラー : t_memoのsqlにエラーが発生しました。';
					exit();
				}
				$rows3 = $stmt->fetchAll();
				$rows3_length = count($rows3);
				// $rows3が空かどうかの判定　0 --> タグがない　それ以外はタグあり
				if(empty($rows3)) {
					// 空なら要素を閉じる
					$data_disp .= '" id="'.$rows2[$key]['mode_name'].'" data-published-date="'.$filter_date.'" data-target="'.$rows2[$key]['memo_id'].'">';
				} else {
					// タグをクラス内に埋め込み
					$no2 = 0;
					foreach($rows3 as $key2 => $value) {
						if($memo_id === $rows3[$key2]['memo_id']) {
							$data_disp .= ' '.$rows3[$key2]['tag_name'].' ';
						}
						$no2++;
						if($no2 === $rows3_length) {
							$data_disp .= '" id="'.$rows2[$key]['mode_name'].'" data-published-date="'.$filter_date.'" data-target="'.$rows2[$key]['memo_id'].'">';
						}
					}
				}
				unset($key2);
				$data_disp .= '<div class="delete-button popup-delete-trigger" data-target="'.$rows2[$key]['memo_id'].'"><i class="fa fa-times" aria-hidden="true"></i></div>';
				$data_disp .= '<div class="data-icon"></div><div class="box-info">';
				$data_disp .= '<p class="data-title">'.$rows2[$key]['memo_name'].'</p>';
				$data_disp .= '<p class="data-date">'.$date.'</p>';
				$data_memo = $rows2[$key]['memo_data'];
				$data_disp .= '<p class="tag-name">';
				// $rows3が空かどうかの判定　0 --> タグがない　それ以外はタグあり
				if(empty($rows3)) {
					// 空なら要素を閉じる
					$data_disp .= '</p></div>';
				} else {
					// タグをタグ表示領域内に埋め込み
					$no2 = 0;
					foreach($rows3 as $key2 => $value) {
						if($memo_id === $rows3[$key2]['memo_id']) {
							$data_disp .= '<label class="tag-label">'.$rows3[$key2]['tag_name'].'</label>,';
						}
						$no2++;
						if($no2 === $rows3_length) {
							$data_disp .= '</p></div>';
						}
					}
				}
				unset($key2);
				$data_disp .= '<input type="hidden" name="data-memo" value="'.$rows2[$key]['memo_data'].'"></li>';
			$no++;
			if($no === $rows2_length) {
				$data_disp .= '</ul>';
			}
		}

?>
