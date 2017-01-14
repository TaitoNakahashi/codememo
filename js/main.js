// ===================================================================
// main.js
// ===================================================================
$(window).bind("load", function(){
	// URLにeditorが含まれていたら実行
	if(document.URL.match("/editor")) {
		aceEditor();
		// 不要メニューを隠す
		console.log('通過');
		$('.second-header').addClass('hide');
	}
	if(document.URL.match("/savedata")) {
		$('.second-header').removeClass('hide');
	}
});

$(document).ready(function() {

	$(".animsition").animsition({

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

});


/* ページトップボタン　イベント */
$(function() {
	// 画面ロード時の要素の高さを指定
	contentHeight();

	// Webstorageが有効かどうか
	if (typeof sessionStorage !== 'undefined') {
		// Web Storageに関する処理を記述

	} else {
		window.alert("本ブラウザではWeb Storageが使えません");
		return false;
	}


	//バルーンメニュー
	var clickCount = 0;
	$('.balloon-button').on('click',function(event) {
		clickCount ++;
		var target = $(this).attr('data-target');
		// $('#'+target).show();
		$('#'+target).addClass('visible');
		$(document).on('click touchend', function(event) {

			if(!$(event.target).closest('.balloon-button').length) {
				// $('#'+target).hide();
				$('#'+target).removeClass('visible');
				clickCount ++;
			} else if((clickCount%2)==0) {
				$('#'+target).removeClass('visible');
			}
		});
	});



	// モーダルメニュー
	$('.modal-button').on('click',function() {
		//キーボード操作などにより、オーバーレイが多重起動するのを防止する
		$(this).blur();
		//新しくモーダルウィンドウを起動しない [下とどちらか選択]
		if($('#modal-overlay')[0]) return false ;
		//オーバーレイ用のHTMLコードを、[body]内の最後に生成する
		$('body').append('<div id="modal-overlay"></div>');
		//[$modal-overlay]をフェードインさせる
		$('#modal-overlay').fadeIn('fast');
		// センタリングfunction
		centeringModalSyncer();
		var target = $(this).attr('data-target');
		$('#'+target).fadeIn('fast');
		$('#modal-overlay,#modal-close').unbind().on('click',function() {
			//[#modal-overlay]、または[#modal-close]をクリックしたら起こる処理
			//[#modal-overlay]と[#modal-close]をフェードアウトする
			$('#'+target+',#modal-overlay').fadeOut('fast',function()　{
				//フェードアウト後、[#modal-overlay]をHTML(DOM)上から削除
				$('#modal-overlay').remove();
			});
		});
	});


	//リサイズされたら、センタリングをする関数[centeringModalSyncer()]を実行する
	// モーダルメニュー
	$(window).resize(centeringModalSyncer);

	// 画面サイズが変わると実行
	$(window).resize(contentHeight);


	$('.data-box').on('click',function() {
		$(this).blur();
		// 選択された保存アイコンからデータを取得
		var saveid = $(this).attr('data-target');
		var savemode = $(this).attr('id');
		var savename = $(this).find('p.data-title').html();
		var savetag = $(this).find('p.tag-name').html();
		var savedata = $(this).find('input[name="data-memo"]').val();
		var savelist = {
			'save_id':saveid,
			'save_name':savename,
			'save_mode':savemode,
			'save_data':savedata,
			'save_tag':savetag
		};
		// Webstorageが使えるかどうか
		if(('localStorage' in window) && (window.localStorage !== null)) {
			// セッションストレージが使える
			localStorage.setItem('savelist', JSON.stringify(savelist));
			// window.localStorage.setItem('savelist', JSON.stringify(savelist));
		} else {
			window.alert('エラーが発生しました。--> データ呼出し');
		}
		window.location.href = 'http://localhost:1024/codememo/editor.php';
	});
});


function aceEditor() {

	/* エディターAPI ACEの埋め込み */
	// モード選択するたびにエディタを再生成する
	var editor = ace.edit('editor');
	// 初期のエディタ設定
	// 自動補完・スニペット・ライブ補完の有効化
	editor.$blockScrolling = Infinity;
	editor.setOptions({
		enableBasicAutocompletion: true,
		enableSnippets: true,
		enableLiveAutocompletion: true
	});
	// テーマ
	editor.setTheme('ace/theme/twilight');

	// localStorageにデータがあれば呼び出す
	getSavelist = JSON.parse(localStorage.getItem('savelist'));
	// 呼び出したデータを各項目に格納する
	if(getSavelist) {
		$('.name-form').append('<input type="hidden" name="memo-id" value="'+getSavelist.save_id+'">');
		$('input[name="memo-name"]').val(getSavelist.save_name);
		mode = getSavelist.save_mode;
		editor.getSession().setMode('ace/mode/'+mode);
		editor.setValue(getSavelist.save_data, -1);
	} else {
		//初期設定
		// モード 初期はhtml
		editor.getSession().setMode("ace/mode/html");
		// modeを変数に格納
		mode = $('#html-button').attr('data-target');
	}



	// モードクリックイベント editor modeを変更
	$('.cate-btn').on('click',function() {
		$(this).blur();
		mode = $(this).attr('data-target');
		editor.getSession().setMode('ace/mode/'+mode);
		// 変更したmodeを変数に格納
	});


	// editor内のテキストおよび設定情報を保存する
	$('#save').on('click',function() {
		$(this).blur();
		// memo-nameを取得
		var memoname = $('#memo-name').val();
		// editorからmode情報を取得 editorのmodeを格納する変数を取得
		var memomode = mode;//仮
		// tag-nameを取得
		var memotag = $('#memo-tag').val();
		var memodata = editor.getValue();
		var data = {
			"memo_name":memoname,
			"mode_name":memomode,
			"memo_data":memodata,
			"tag_name":memotag
		};

		$.ajax({
			// ロリポップサーバのphpファイルのパスを指定
			// 現在は仮でローカルサーバ
			url: "php/save.php",
			type: "post",
			data: JSON.stringify(data),
		}).done(function( response, textStatus, jqXHR){
			// 成功の場合処理
			alert('保存しました。');
		}).fail(function( jqXHR, textStatus, errorThrown){
			// エラーの場合処理
			alert('保存できませんでした。'+jqXHR.status);
		});
	});
}




//モーダルメニューの位置を調整する関数
function centeringModalSyncer() {
	//画面(ウィンドウ)の幅を取得し、変数[w]に格納
	var w = $(window).width();
	//画面(ウィンドウ)の高さを取得し、変数[h]に格納
	var h = $(window).height();
	//コンテンツ(#modal-content)の幅を取得し、変数[cw]に格納
	var cw = $('.modal-content').outerWidth({margin:true});
	//コンテンツ(#modal-content)の高さを取得し、変数[ch]に格納
	var ch = $('.modal-content').outerHeight({margin:true});
	//コンテンツ(#modal-content)を真ん中に配置するのに、左端から何ピクセル離せばいいか？を計算して、変数[pxleft]に格納
	var pxleft = ((w - cw)/2);
	//コンテンツ(#modal-content)を真ん中に配置するのに、上部から何ピクセル離せばいいか？を計算して、変数[pxtop]に格納
	var pxtop = ((h - ch)/2);
	//[#modal-content]のCSSに[left]の値(pxleft)を設定
	$('.modal-content').css({'left': pxleft + 'px'});
	//[#modal-content]のCSSに[top]の値(pxtop)を設定
	$('.modal-content').css({'top': pxtop + 'px'});
}
//モーダルメニューの位置を調整する関数



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
