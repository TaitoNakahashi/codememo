<?php
//  HTTPヘッダーで文字コードを指定
header('Content-Type:text/html; charset=UTF-8');
?>
<?php
//mode_setting.php
	// mixltup.jsが動かなくなるためajaxは使用しない
	// if(isset($_POST['sendurl'])){

		//member_id(int型)で検索するためint以外を弾く
		// $get_url = (int)filter_input(INPUT_POST, 'sendurl');

		// //data-change.phpを呼出し、「PHPの定数」と，「HTMLのname属性」を対応付ける
		require 'mysql_connect.php';

		// 現在のURLを取得し、ページURLで処理を変更
		$get_url = $_SERVER["REQUEST_URI"];
		// $get_url = $_POST['sendurl'];

		// クエリの実行
		// t_mode取得
		$sql = 'SELECT * FROM t_mode GROUP BY mode_id ORDER BY mode_name ASC';
		$stmt = $pdo->prepare($sql);
		$sql_result = $stmt->execute();
		if(!$sql_result) {
			// データがなければエラー
			$error = 'phpエラー : t_modeに対してのsql(SELECT)でエラー';
			exit();
		}
		$rows = $stmt->fetchAll();
		$rows_length = count($rows);
		$no = 0;    //カウント数　表示個数
		$no2 = 0;	//カウント数　全体個数

		if(strstr($get_url,'/editor')) {
			// urlがeditorの場合
			$mode_disp = '<ul class="flex-container">';
			foreach($rows as $key => $value) {
				$mode_disp .= '<li class="mode-btn" id="'.$rows[$key]['mode_name'].'-button" data-target="'.$rows[$key]['mode_name'].'">'.$rows[$key]['label_mode_name'].'</li>';
				$no++;
				$no2++;
				if($no == 3) {
					$mode_disp .= '</ul><ul class="flex-container">';
					$no = 0;
				} else if($no2 == $rows_length) {
					$mode_disp .= '</ul>';
				}
			}
			// print $mode_disp;

		} else if(strstr($get_url,'/savedata')) {
			// urlがsavedataの場合
			$mode_disp = '<ul>';
			foreach($rows as $key => $value) {
				$mode_disp .= '<li class="mode-li filter" data-toggle=".'.$rows[$key]['mode_name'].'">'.$rows[$key]['mode_name'].'</li>';
				$no++;
				if($no == $rows_length) {
					$mode_disp .= '</ul>';
				}
			}
			// print $mode_disp;
		}

	// }
?>
