<?php
<<<<<<< HEAD
	require_once "php/login_check.php";

	require_once 'php/mode_setting.php';

	require_once "php/data_open.php";
=======
	require "php/login_check.php";

	require "php/data_open.php";
>>>>>>> origin/master
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
<title>CodeMemo</title>
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/font-awesome.css">
<link rel="stylesheet" href="css/animsition.min.css">
<<<<<<< HEAD
<link rel="stylesheet" href="css/jquery.mCustomScrollbar.css">
<!-- <script src="js/jquery-3.1.0.min.js"></script> -->
<script src="js/jquery-1.11.2.min.js"></script>
<script src="js/animsition.min.js"></script>
<script src="js/modernizr.js"></script>
<script src="js/mixitup.min.js"></script><!-- mixitup.min.js -->
<script src="js/jquery.mCustomScrollbar.concat.min.js"></script><!-- scrollbar.concat.min.js -->
=======
<!-- <script src="js/jquery-3.1.0.min.js"></script> -->
<script src="js/jquery-1.11.2.min.js"></script>
<script src="js/animsition.min.js"></script>
>>>>>>> origin/master
<script src="js/main.js"></script>
</head>

<body>

	<!-- javascript有効確認 -->
	<div id="JSNG" style="width: 400px; text-align: left; border: 5px solid #ffaaaa; padding: 10px;">
		<p>JavaScript が無効化されています。
			<br>ご利用のブラウザ設定からJavaScriptを有効にしてください。
		</p>
	</div>
	<script>document.getElementById("JSNG").style.display = "none";</script>
	<!--　javascript有効確認-->

	<div id="wrap" class="animsition" style="display:none;">

<<<<<<< HEAD

		<header>

			<div class="first-header flex-container">　<!-- first-header -->

				<div class="logo">
					<h1>CodeMemo</h1>
				</div>

				<ul class="groval-menu-ul flex-container">
					<li class="tab-li">
						<a class="tab-button button animsition-link" id="editor-link" href="editor.php">Editor</a>
					</li>
					<li>
						<a class="tab-button button animsition-link" id="savedata-link" href="savedata.php">SaveData</a>
					</li>
					<li class="border"><span class="border-white"></span></li>
					<li>
						<div class="text-button right-i balloon-button" data-target="more-menu">
							More
							<i class="fa fa-chevron-down" aria-hidden="true"></i>
						</div>
					</li>
					<li class="border"><span class="border-white"></span></li>
					<li>
						<div class="text-button modal-button" data-target="login-content">Login</div>
					</li>
					<li>
						<div class="text-button modal-button" data-target="signup-content">Sign up</div>
					</li>
				</ul>

				<?php if(!isset($_SESSION[USER_ID])) { ?><!-- ログイン判定 -->


				<?php } else { ?>
					<!-- <div class="header-button balloon-button" id="account-button">
						<div class="account-icon"><?php echo $_SESSION[USER_ID]; ?></div>
						<i class="fa fa-chevron-down" aria-hidden="true"></i>
					</div>
					<div class="balloon-menu" id="account-menu">
						<ul>
							<li data-target="support"><span>Support</span></li>
							<li data-target="about"><span>About</span></li>
							<li data-target="tutorial"><span>Tutorial</span></li>
							<li data-target="contact"><span>Contact</span></li>
						</ul>
					</div> -->
				<?php } ?><!-- ログイン判定 -->

			</div>　<!-- /first-header -->

			<div class="second-header"><!-- second-header -->
				<form id="save-filters">
					<ul class="tool-menu-ul flex-container">
						<li class="filter-keyword-li">
							<fieldset>
								<div class="text-form">
									<input type="text" placeholder="Enter Name" name="filter-keyword" id="filter--text" data-filiter=""><i class="fa fa-search" aria-hidden="true"></i>
								</div>
							</fieldset>
						</li>
						<li class="border"><span class="border-white"></span></li>
						<li>
							<fieldset>
								<div class="button tool-button filter" data-filter="all">All</div>
							</fieldset>
						</li>
						<li class="cell-container">
							<fieldset>
								<div id="filter-desc" class="cell-item button tool-button f-t-button filter" data-sort="published-date:desc name:asc">
									<i class="fa fa-sort-amount-desc" aria-hidden="true"></i>
								</div>
								<div id="filter-asc" class="cell-item button tool-button l-t-button filter" data-sort="published-date:asc name:asc">
									<i class="fa fa-sort-amount-asc" aria-hidden="true"></i>
								</div>
							</fieldset>
						</li>
						<li>
							<fieldset>
								<div class="button tool-button balloon-button" data-target="mode-menu">
									Mode
									<i class="fa fa-chevron-down" aria-hidden="true"></i>
								</div>
							</fieldset>
						</li>
						<li>
							<fieldset>
								<div class="button tool-button balloon-button" data-target="tags-menu">
									Tags
									<i class="fa fa-chevron-down" aria-hidden="true"></i>
								</div>
							</fieldset>
						</li>
						<!-- <li class="filter-reset-li">
							<div class="button tool-button" id="filter-reset">Clear Filters</div>
						</li> -->
					</ul>
				</form>
			</div><!-- /second-header -->

		</header>


		<section id="section-balloon"><!-- 吹き出しメニュー本体 -->

			<div class="balloon-menu" id="more-menu"><!-- more-menu -->
				<ul>
					<li data-target="support">Support</li>
					<li data-target="about">About</li>
					<li data-target="tutorial">Tutorial</li>
					<li data-target="contact">Contact</li>
				</ul>
			</div><!-- more-menu -->

			<div class="balloon-menu" id="mode-menu"><!-- mode-menu -->
				<?php echo $mode_disp; ?>
			</div><!-- mode-menu -->

			<div class="balloon-menu" id="tags-menu"><!-- tags-menu -->
				<?php echo $tags_disp; ?>
			</div><!-- tags-menu -->

		</section><!-- 吹き出しメニュー本体 -->


		<section id="section-popup"><!-- ポップアップメニュー本体 -->

			<div class="popup-menu" role="alert"><!-- cd-popup -->
				<div class="popup-container"> <!-- cd-popup-container -->
					<p>このメモデータを消去しますがよろしいですか？</p>
					<ul class="popup-buttons">
						<li><a href="#1">Yes</a></li>
						<li><a href="#2">No</a></li>
					</ul>
					<a href="#0" class="popup-close img-replace"></a>
				</div> <!-- cd-popup-container -->
			</div> <!-- cd-popup -->

		</section><!-- ポップアップメニュー本体 -->


		<main id="disp" class="flex-container"><!-- main //savedata -->

			<div class="main-area">

				<div class="savedata-disp" id="savedata"><!-- savedata表示 -->
					<?php echo $data_disp; ?>
				</div><!-- savedata表示 -->

			</div>

		</main><!-- main //savedata -->

=======
		<header>

			<div class="first-header flex-container">　<!-- headerの上段 -->

				<div class="logo flex-item">
					<h1>CodeMemo</h1>
				</div>

				<div class="header-menu flex-item">
					<ul>
						<li>
							<a class="tab-button button animsition-link" href="editor.php"><span>Editor</span></a>
						</li>
						<li>
							<a class="tab-button button animsition-link" href="savedata.php"><span>SaveData</span></a>
						</li>
						<li><span class="border"></span></li>
						<li class="more">
							<div class="text-button balloon-button" data-target="more-menu">
								<span>More</span>
								<i class="fa fa-chevron-down" aria-hidden="true"></i>
							</div>
							<div class="balloon-menu" id="more-menu">
								<ul>
									<li data-target="support"><span>Support</span></li>
									<li data-target="about"><span>About</span></li>
									<li data-target="tutorial"><span>Tutorial</span></li>
									<li data-target="contact"><span>Contact</span></li>
								</ul>
							</div>
						</li>
						<li><span class="border"></span></li>
						<li>
							<div class="text-button modal-button" data-target="login-content">
								<span>Login</span>
							</div>
						</li>
						<li>
							<div class="text-button modal-button" data-target="signup-content">
								<span>Sign up</span>
							</div>
						</li>
					</ul>

					<?php if(!isset($_SESSION[USER_ID])) { ?><!-- ログイン判定 -->


					<?php } else { ?>
						<!-- <div class="header-button balloon-button" id="account-button">
							<div class="account-icon"><?php echo $_SESSION[USER_ID]; ?></div>
							<i class="fa fa-chevron-down" aria-hidden="true"></i>
						</div>
						<div class="balloon-menu" id="account-menu">
							<ul>
								<li data-target="support"><span>Support</span></li>
								<li data-target="about"><span>About</span></li>
								<li data-target="tutorial"><span>Tutorial</span></li>
								<li data-target="contact"><span>Contact</span></li>
							</ul>
						</div> -->
					<?php } ?><!-- ログイン判定 -->

				</div>

			</div>　<!-- /headerの上段 -->

			<div class="second-header"><!-- headerの下段 -->
				<form>
				<div class="option-menu">
					<ul>
						<li class="search">
							<div class="text-form">
								<input type="text" name="search-keyword" id="search-keyword"><i class="fa fa-search" aria-hidden="true"></i>
							</div>
						</li>
						<li>
							<div class="text-button sort-button" data-target="best">
								<span>Best</span>
							</div>
						</li>
						<li>
							<div class="text-button sort-button" data-target="new">
								<span>New</span>
							</div>
						</li>
						<li>
							<div class="text-button balloon-button" data-target="tags-menu">
								<span>Tags</span>
								<i class="fa fa-chevron-down" aria-hidden="true"></i>
							</div>
							<div class="balloon-menu" id="tags-menu">
								<?php echo $tags_disp; ?>
							</div>
						</li>
					</ul>
				</div>
				</form>
			</div><!-- /headerの下段 -->


		</header>

		<section id="modal">
			<div id="login-content" class="modal-content"><!-- フォーム部分 login-content -->
				<p><a id="modal-close" class="close-button"><i class="fa fa-times" aria-hidden="true"></i></a></p>

				<div class="content-head">
					<h2>login</h2>
					<p></p>
				</div>

				<!-- エラーメッセージ表示 -->
				<?php if(isset($error_message)) { ?>
					<div class="error_message"><?php echo $error_message; ?></div>
				<?php } ?>
				<!-- //エラーメッセージ表示 -->

				<form class="form-horizontal" name="login-form" action="" method="POST">

					<div class="form-area">

						<div class="form-group">
							<label class="control-label">メールアドレス <span class="label label-danger">必須</span></label>
							<div class="">
								<input type="email" name="user_id" autocomplete="email" class="form-control" placeholder="メールアドレス" required/>
							</div>
						 </div>
						<div class="form-group">
							<label class="control-label">パスワード <span class="label label-danger">必須</span></label>
							<div class="">
								<input type="password" name="password" autocomplete="password" class="form-control" placeholder="パスワード" required/>
							</div>
						 </div>
						<div class="form-group"><!-- ログインボタン -->
							<div class="login-button">
								<button type="submit" class="input-button" name="login">ログイン</button>
							</div>
						</div><!-- /ログインボタン-->

					</div>

				</form>

			</div><!-- フォーム部分 login-content -->


			<div id="signup-content" class="modal-content"><!-- フォーム部分 signup-content -->
				<p><a id="modal-close" class="close-button"><i class="fa fa-times" aria-hidden="true"></i></a></p>
				<div class="content-head">
					<h2>sign up</h2>
					<p></p>
				</div>

				<!-- 確認画面表示のためのjsのautoConfirmをclassに設定
					その前にvalidationEngineを起動するためonsubmitでvalidateファンクションを指定 -->
				<form class="form-horizontal autoConfirm" id="signup-form" name="signup-form" action="" method="POST">

					<!-- validationEngineを利用するためバリデーション内容を inputのclassに指定 -->
					<div class="err_msg err_empty"><!-- エラーメッセージ -->
						<p>入力されていない項目があります。入力し直してください。</p>
					</div>
					<div class="err_msg err_text">
						<p>入力内容が正しくない項目があります。入力し直してください。</p>
					</div><!-- /エラーメッセージ -->

					<div class="form-area"><!-- メール・パスワード -->

						<div class="form-group">
							<label class="control-label">メールアドレス <span class="label label-danger">必須</span></label>
							<div class=""><!-- 入力部分 -->
								<input type="email" name="email" value="<?php print $email; ?>" autocomplete="email" class="form-control validate[required,custom[email]]" placeholder="ログインIDとなります" />
							</div><!-- /入力部分 -->
					 	</div>
						<div class="form-group">
							<label class="control-label">パスワード <span class="label label-danger">必須</span></label>
							<div class="">
								<input type="password" name="password" value="<?php print $password; ?>" autocomplete="password" class="form-control validate[required,custom[onlyLetterNumber],minSize[8],maxSize[15]]" placeholder="半角英数 8文字以上" />
							</div>
					 	</div>
						<div class="form-group"><!-- 名前(漢字・ローマ字) -->
 							<label class="control-label"> <span class="label label-danger">必須</span></label>
 							<div class="">
 								<input type="text" value="<?php print $name; ?>" name="name" autocomplete="name" class="form-control validate[required,custom[japanese]]" placeholder="" />
 							</div>
 						</div><!-- /名前(漢字・ローマ字) -->
						<div class="signup-button"><!-- ボタン部分 -->
						<!-- ボタンの表示非表示はJavascriptで制御 -->
							<!-- 入力時は非表示 -->
							<button type="button" name="cancel" class="autoConfirmBack" style="display: none;">戻る</button>
							<!-- 入力時と確認時で切り替え -->
							<button type="submit" name="check" class="button-default check-button" onClick="return validate($('#signup-form'))" >確認する (送信は行いません)</button>
						</div><!-- /ボタン部分 -->

					</div><!-- /メール・パスワード -->

				</form>

			</div><!-- フォーム部分 signup-content -->
		</section>

		<main id="disp" class="flex-container">

			<div class="side-area">

				<div class="side-menu" id="editor-menu">

					<h2>Group</h2>

					<div class="name-form">
						<h3>New List +</h3>
						<div class="text-form">
							<input type="text" id="list-name" name="list-name" />
						</div>
					</div>
					<div class="list-form">
						<h3>List</h3>
						<hr />
						<ul>
							<li class="list-select clearfix"><span>Hew-Site</span><label class="delete"><i class="fa fa-times" aria-hidden="true"></i></label></li>
							<li class="list-select clearfix"><span>Hew-Site</span><label class="delete"><i class="fa fa-times" aria-hidden="true"></i></label></li>
							<li class="list-select clearfix"><span>Hew-Site</span><label class="delete"><i class="fa fa-times" aria-hidden="true"></i></label></li>
						</ul>
					</div>
					<div class="form-save">
						<button class="save-button button" id="save"><span>Show All</span></button>
					</div>
				</div>

			</div>
			<div class="main-area">

				<form action="" method="post"><!-- エディタ部分 -->
					<!-- ace apiを利用 -->
					<div class="savedata-disp" id="savedata">
						<div class="savedata-body flex-container">
							<?php echo $data_disp; ?>
						</div>
					</div>

				</form><!-- エディタ部分 -->


			</div>

		</main>
>>>>>>> origin/master

		<footer>

		</footer>

	</div>
	<!-- ブラウザのjavascript設定がオフになっていた場合 #wrapを非表示 -->
	<script>  document.getElementById("wrap").style.display = "block";</script>

</body>
</html>
