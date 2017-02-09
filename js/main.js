// ===================================================================
// main.js
// ===================================================================
$(function() {
	// DOMツリーの構築が完了したら実行される。
	/*-----------------------------------------------------
	// 変数宣言
	-------------------------------------------------------*/
	var editorLink = $('#editor-link'); //タブボタン
	var savedateLink = $('#savedata-link'); //タブボタン
	// --------------- save-form関連の変数 -------------  //
	var save = $('#save'); //saveボタン
	var update = $('#update'); //updateボタン
	var saveForm = $('.save-form');
	// --------------- save-data関連の変数 -------------  //
	var	memoId = $('#memo-id');
	var memoName = $('#memo-name');
	var memoTag = $('#memo-tag');



	$(window).bind('load', function() {
		// 関連データ全ての読み込みが完了したら実行される。

		// mixltup.jsが動かなくなるためajaxは使用しない
		// mode_setting.phpの呼び出し
		// var data = {sendurl : location.pathname};
		// $.ajax({
		// 	url: 'php/mode_setting.php',
		// 	type: 'post',
		// 	data: data
		// }).done(function(response) {
		// 	// 接続成功
		// 	if(document.URL.match('/editor')) {
		// 		$('#mode-disp').html(response);
		// 	} else if(document.URL.match('/savedata')) {
		// 		$('#mode-menu').html(response);
		// 	}
		// }).fail(function(jqXHR, textStatus, errorThrown) {
		// 	alert('jqueryエラー : mode_setting.phpの接続に失敗');
		// });

		// URLにeditorが含まれていたら実行
		if(document.URL.match('/editor')) {
			aceFunc(); //aceApiの呼び出し
			// タブボタンの表示
			editorLink.addClass('active');
			savedateLink.removeClass('active');
		}
		if(document.URL.match('/savedata')) {
			mixltupFunc(); //mixltupの呼び出し
			// タブボタンの表示
			savedateLink.addClass('active');
			editorLink.removeClass('active');
		}
	});

	//スクロールバーデザインjs
	$('#mode-menu ,#tags-menu , #savedata').mCustomScrollbar({
		theme: 'dark'
	});

	// animsitionの呼び出し
	animsitionFunc();

	// Webstorageが有効かどうか
	if (typeof sessionStorage !== 'undefined') {
		// Web Storageに関する処理を記述
	} else {
		window.alert("当ブラウザでは【Web Storage】が使えません");
		return false;
	}

	//バルーンメニュー
	// var clickCount = 0;
	$('.balloon-button').on('click',function() {
		// clickCount ++;
		var target = $(this).attr('data-target');
		$('#'+target).fadeIn('fast');
		$('#'+target).addClass('visible');
		// 動的にバルーンメニューが生成されるので$(document)で指定
		$(document).on('click touchend', function(event) {
			if(!$(event.target).closest('.balloon-button').length) {
				$('#'+target).removeClass('visible');
				$('#'+target).hide();
			// 	clickCount ++;
			// } else if((clickCount%2)==0) {
			// 	$('#'+target).removeClass('visible');
			}
		});
	});

	//open popup　ポップアップ画面を表示
	// --------------- popuup関連の変数 -------------  //
	var popup = $('.popup-menu');
	var login = $('#login');
	var loginButton = $('#login-button');
	var signup = $('#signup');
	var signupButton = $('#signup-button');
	var errorMsg = $('.error-message');
	var email = $('input[name="email"]');
	var password = $('input[name="password"]');
	var username = $('input[name="username"]');
	var error = 0;
	//　ログインと新規登録のポップアップ
	$.when (
		$('.popup-account-trigger').on('click', function(event) {
			event.stopPropagation();
			event.preventDefault();
			var target = $('#'+$(this).attr('data-target'));
			target.addClass('is-visible');
		})
	).done(function() {
		loginButton.on('click', function(event) {
			Login();
		});
		signupButton.on('click', function(event) {
			Signup();
		});
	});

	function Login() {
		login.find('input').each(function() {
			if($(this).val() === '') {
				$(this).toggleClass('has-error').next('span').toggleClass('is-visible');
			} else {
				(this).removeClass('has-error').next('span').removeClass('is-visible');
			}
		});
		var data = {
			'email': email.val(),
			'password': password.val()
		};
		$.ajax({
			// ロリポップサーバのphpファイルのパスを指定
			// 現在は仮でローカルサーバ
			url: 'php/login_connect.php',
			type: 'post',
			data: JSON.stringify(data),
		}).done(function( response, textStatus, jqXHR) {
			// 成功の場合処理
			alert(response);
		}).fail(function( jqXHR, textStatus, errorThrown) {
			// エラーの場合処理
			alert('データの送信にエラーが発生しました。'+jqXHR.status+textStatus+errorThrown);
		});
	}

	function Signup() {
		signup.find('input').each(function() {
			if($(this).val() === '') {
				$(this).toggleClass('has-error').next('span').toggleClass('is-visible');
			} else {
				(this).removeClass('has-error').next('span').removeClass('is-visible');
			}
		});
		var data = {
			'username': username.val(),
			'email': email.val(),
			'password': password.val()
		};
		$.ajax({
			// ロリポップサーバのphpファイルのパスを指定
			// 現在は仮でローカルサーバ
			url: 'php/signup.php',
			type: 'post',
			data: JSON.stringify(data),
		}).done(function( response, textStatus, jqXHR) {
			// 成功の場合処理
			alert(response);
		}).fail(function( jqXHR, textStatus, errorThrown) {
			// エラーの場合処理
			alert('データの送信にエラーが発生しました。'+jqXHR.status+textStatus+errorThrown);
		});
	}

	// save-dataの削除確認ポップアップ
	$('.popup-delete-trigger').on('click', function(event) {
		event.stopPropagation(); //バブリング発生を防止
		event.preventDefault();
		popup.addClass('is-visible');
		var target = $(this).attr('data-target');
		$('.popup-buttons a').on('click', function() {
			var flag = $(this).attr('href');
			if(flag === '#1') {
				$.ajax({
					url: 'php/data_delete.php',
					type: 'post',
					data: {deleteid : target},
					timeout : 1500,
				}).done(function(response) {
					// 接続成功
					alert(response);
					// 接続が成功したらポップアップを閉じる
					popup.removeClass('is-visible');
					//変更を反映させるためページをリロード
					location.reload();
					// saveReload(data);
				}).fail(function(jqXHR, textStatus, errorThrown) {
					alert('jqueryエラー : data_delete.phpの接続に失敗');
				});
			} else {
				// キャンセルボタンを押されたら閉じる
				popup.removeClass('is-visible');
			}
		});
	});
	//close popup ポップアップ選択画面を閉じる
	popup.on('click', function(event) {
		if( $(event.target).is('.popup-close') || $(event.target).is(popup) ) {
			event.preventDefault();
			$(this).removeClass('is-visible');
		}
	});
	//close popup when clicking the esc keyboard button　ポップアップ画面をescでも閉じる
	$(document).keyup(function(event) {
		if(event.which=='27'){
			popup.removeClass('is-visible');
		}
	});


	function aceFunc() {
		/* エディターAPI ACEの埋め込み */
		// モード選択するたびにエディタを再生成する
		var editor = ace.edit('editor');
		// 初期のエディタ設定
		// 自動補完・スニペット・ライブ補完の有効化
		editor.$blockScrolling = Infinity;
		editor.setOptions({
			enableBasicAutocompletion: true,
			enableSnippets: true,
			enableLiveAutocompletion: true,
			enableEmmet: true
		});
		// テーマ 初期設定
		editor.setTheme('ace/theme/twilight');

		// 文字サイズを取得　表示する
		var size = $('#font-check').val();
		// size = size.replace(/px/g , '');
		if(size === '') {
			// sizeが初期状態の場合　１６pxとする
			size = 14;
		}
		editor.setFontSize(size);
		$('#font-check').val(size);
		$('#font-check').html(size+'px');

		// save-buttonをここで一度初期状態にする
		saveForm.find('.save-button').each(function() {
			$(this).removeClass('twobutton');
		});
		update.addClass('hide');

		// localStorageにデータがあれば呼び出す
		getSavelist = JSON.parse(localStorage.getItem('savelist'));
		//　呼び出したデータがあるかどうか
		if(getSavelist) {
			// localStorageにデータの存在が確認されたらsave-buttonを変更状態にする
			update.removeClass('hide');
			saveForm.find('.save-button').each(function() {
				$(this).addClass('twobutton');
			});

			// 呼び出したデータを各項目に格納する
			// idを格納
			memoId.val(getSavelist.save_id);
			// nameを格納
			memoName.val(getSavelist.save_name);
			// modeを変数に格納
			mode = getSavelist.save_mode;
			editor.getSession().setMode('ace/mode/'+mode);
			$('#'+mode+'-button').addClass('mode-active');
			// tagを格納
			var tagArray = getSavelist.save_tag;
			$.each(tagArray, function(i, element) {

			});
			// メモデータを格納
			editor.setValue(getSavelist.save_data, -1);
		} else {
			//初期設定
			// モード 初期はhtml
			editor.getSession().setMode('ace/mode/html');
			// modeを変数に格納
			mode = $('#html-button').attr('data-target');
			$('#'+mode+'-button').addClass('mode-active');
		}

		// エディタ内文字サイズ変更
		$(document).on('click', '.size-change',function() {
			// 現在の文字サイズを取得
			var size = $('#font-check').html();
			size = size.replace(/px/g , "");
			if($(this).attr('id').match('font-plus')) {
				size++;
				$('#font-check').val(size);
				$('#font-check').html(size+'px');
			} else if($(this).attr('id').match('font-minus')) {
				size--;
				$('#font-check').val(size);
				$('#font-check').html(size+'px');
			}
			editor.setFontSize(size);
		});

		// new-memoボタンが押された場合　各項目を削除して新規状態にする
		$('#new-memo').on('click',function() {
			// save-buttonの項目を初期状態に戻す
			saveForm.find('.save-button').each(function() {
				$(this).removeClass('twobutton');
			});
			update.addClass('hide');

			// mode-btnが洗濯済みなら解除
			$('#mode-disp').find('.mode-active').each(function() {
				$(this).removeClass('mode-active');
			});

			$.when(
				// 各項目を初期化
				memoId.val(''),
				memoName.val(''),
				editor.getSession().setMode('ace/mode/html'),
				mode = $('#html-button').attr('data-target'),
				memoTag.val(''),
				editor.setValue('', -1),
				// localStorageに保存されている、あるkeyの値を削除する
				window.localStorage.removeItem('savelist')
			).done(function() {
				window.alert('さあ新しい知識をメモしましょう！');
			});
		});

		// モードクリックイベント editor modeを変更
		$(document).on('click','.mode-btn',function() {
			$('#mode-disp').find('.mode-active').each(function() {
				$(this).removeClass('mode-active');
			});
			$(this).addClass('mode-active');
			mode = $(this).attr('data-target');
			editor.getSession().setMode('ace/mode/'+mode);
			// 変更したmodeを変数に格納
		});

		// editor内のテキストおよび設定情報を保存する #saveか#updateで処理を分ける
		// 新規保存
		save.on('click',function() {
			// 入力バリデーション



			// save-buttonを押されたらsave-buttonを変更状態にする
			// save-buttonがtwobuttonの状態になっているかどうか
			if(update.hasClass('hide')) {
				// #updateのremove処理とtwobuttonクラスの追加は同じタイミングで行うので
				// ifの条件は#updateの判定だけでよい
				update.removeClass('hide');
				saveForm.find('.save-button').each(function() {
					$(this).addClass('twobutton');
				});
			}

			// memo-idを取得
			var memoid = memoId.val();
			// memo-nameを取得
			var memoname = memoName.val();
			// editorからmode情報を取得 editorのmodeを格納する変数を取得
			var memomode = mode;//仮
			// tag-nameを取得
			var memotag = memoTag.val();
			// エディタからデータを取得
			var memodata = editor.getValue();

			var data = {
				'new_save': 1, // 新規保存のフラグ用変数を用意
				'memo_id': memoid,
				'memo_name': memoname,
				'mode_name': memomode,
				'memo_data': memodata,
				'tag_name': memotag
			};

			$.ajax({
				// ロリポップサーバのphpファイルのパスを指定
				// 現在は仮でローカルサーバ
				url: 'php/save.php',
				type: 'post',
				data: JSON.stringify(data),
			}).done(function( response, textStatus, jqXHR) {
				// 成功の場合処理
				alert(response);
			}).fail(function( jqXHR, textStatus, errorThrown) {
				// エラーの場合処理
				alert('保存できませんでした。'+jqXHR.status+textStatus+errorThrown);
			});
		});

		// editor内のテキストおよび設定情報を保存する
		// 更新保存
		update.on('click',function() {
			console.log('tuuka');
			// memo-idを取得
			var memoid = memoId.val();
			// memo-nameを取得
			var memoname = memoName.val();
			// editorからmode情報を取得 editorのmodeを格納する変数を取得
			var memomode = mode;//仮
			// tag-nameを取得
			var memotag = memoTag.val();
			// エディタからデータを取得
			var memodata = editor.getValue();

			var data = {
				'memo_id': memoid,
				'memo_name': memoname,
				'mode_name': memomode,
				'memo_data': memodata,
				'tag_name': memotag
			};

			$.ajax({
				// ロリポップサーバのphpファイルのパスを指定
				// 現在は仮でローカルサーバ
				url: 'php/save.php',
				type: 'post',
				data: JSON.stringify(data),
			}).done(function( response, textStatus, jqXHR) {
				// 成功の場合処理
				alert(response);
			}).fail(function( jqXHR, textStatus, errorThrown) {
				// エラーの場合処理
				alert('保存できませんでした。'+jqXHR.status+textStatus+errorThrown);
			});
		});
	}

	// データリストを選択したとき
	$('.data-box').on('click',function(event) {
		event.stopPropagation();　//バブリング発生を防止
		// 選択された保存アイコンからデータを取得
		var saveid = $(this).attr('data-target');
		var savemode = $(this).attr('id');
		var savename = $(this).find('p.data-title').html();
		var savetag = new Array();
		$(this).find('.tag-name .tag-label').each(function() {
			taghtml =  $(this).html();
			 savetag.push(taghtml);
		});
		var savedata = $(this).find('input[name="data-memo"]').val();
		var savelist = {
			'save_id': saveid,
			'save_name': savename,
			'save_mode': savemode,
			'save_data': savedata,
			'save_tag': savetag
		};
		// Webstorageが使えるかどうか
		if(('localStorage' in window) && (window.localStorage !== null)) {
			// セッションストレージが使える
			localStorage.setItem('savelist', JSON.stringify(savelist));
			// window.localStorage.setItem('savelist', JSON.stringify(savelist));
		} else {
			window.alert('エラーが発生しました。--> データ呼出し');
		}
		// localhost用　url
		var localUrl ='http://localhost:8888/codememoA/editor.php';
		// lolipop用 url
		var loliUrl = 'http://';
		window.location.href = localUrl;
	});


	// コンテンツの横幅と高さを動的に調整
	function contentHeight() {
		// headerの高さ(margin込み)を取得
		var header = $('header').outerHeight(true);
		console.log(header);
		// wrapの高さを取得(padding排除)
		var wrap = $('#wrap').height();
		console.log(wrap);
		var resizeHeight = wrap - header;
		console.log(resizeHeight);
		$('#editor-menu,#editor').css({'height' : resizeHeight+'px'});
	}

	/*-----------------------------------------------------
	// 追加js
	-------------------------------------------------------*/

	function animsitionFunc() {
		// ページローディングのアニメーション
		$('.animsition').animsition({
			inClass               :   'fade-in', // ロード時のエフェクト
			outClass              :   'fade-out', //離脱時のエフェクト
			inDuration            :   1000, //ロード時の演出時間
			outDuration           :    800, //離脱時の演出時間
			linkElement           :   '.animsition-link', //アニメーションを行う要素
			// e.g. linkElement   :   'a:not([target="_blank"]):not([href^=#])'
			loading               :    true, //ローディングの有効/無効
			loadingParentElement  :   'body', //ローディング要素のラッパー
			loadingClass          :   'animsition-loading', //ローディングのクラス
			unSupportCss          : [
										'animation-duration',
										'-webkit-animation-duration',
										'-o-animation-duration'
									],
			overlay               :   false, //オーバーレイの有効/無効
			overlayClass          :   'animsition-overlay-slide', //オーバーレイのクラス
			overlayParentElement  :   'body' //オーバーレイ要素のラッパー
		});
	}

	function mixltupFunc() {
		// mixitup
		// On document ready, initialise our code.
		// Initialize buttonFilter code
		// Instantiate MixItUp
		$('#wrap').mixItUp({
			controls: {
				enable: false // we won't be needing these
			},
			callbacks: {
				onMixFail: function(){
					console.log('no-results');
				}
			}
		});
	}

});


/* エラー文字列の生成 */
function errorHandler(args) {
	var error;
	// errorThrownはHTTP通信に成功したときだけ空文字列以外の値が定義される
	if (args[2]) {
		try {
			// JSONとしてパースが成功し、且つ {"error":"..."} という構造であったとき
			// (undefinedが代入されるのを防ぐためにtoStringメソッドを使用)
			error = $.parseJSON(args[0].responseText).error.toString();
		} catch (e) {
			// パースに失敗した、もしくは期待する構造でなかったとき
			// (PHP側にエラーがあったときにもデバッグしやすいようにレスポンスをテキストとして返す)
			error = 'parsererror(' + args[2] + '): ' + args[0].responseText;
		}
	} else {
		// 通信に失敗したとき
		error = args[1] + '(HTTP request failed)';
	}
	return error;
}
