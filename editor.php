<?php
<<<<<<< HEAD
	require_once 'php/login_check.php';

	require_once 'php/mode_setting.php';
=======
	require "php/login_check.php";
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
<script src="js/jquery-1.11.2.min.js"></script>
<script src="js/animsition.min.js"></script>
<script src="js/emmet.js"></script><!-- ace apiのemmet機能実装に必要 -->
<script src="ace_src/ace.js"></script><!-- ace api 本体 -->
<script src="ace_src/ext-language_tools.js"></script><!-- ace apiのsnippet機能 -->
<script src="ace_src/ext-emmet.js"></script><!-- ace apiのemmet機能 -->
<script src="js/jquery.mCustomScrollbar.concat.min.js"></script><!-- scrollbar.concat.min.js -->
=======
<script src="js/jquery-1.11.2.min.js"></script>
<script src="js/animsition.min.js"></script>
<!-- ACE API導入 -->
<script src="ace_src/ace.js"></script>
<script src="ace_src/ext-language_tools.js"></script>
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
						<div class="text-button popup-account-trigger" data-target="login-popup">
							Login
						</div>
					</li>
					<li>
						<div class="text-button popup-account-trigger" data-target="signup-popup">
							Sign up
						</div>
					</li>
				</ul>

				<?php if(!isset($_SESSION[USER_ID])) { ?><!-- ログイン判定 -->


				<?php } else { ?>
					<div class="header-button balloon-button" id="account-button">
						<div class="account-icon"><?php echo $_SESSION[USER_NAME]; ?></div>
						<i class="fa fa-chevron-down" aria-hidden="true"></i>
					</div>
					<div class="balloon-menu" id="account-menu">
						<ul>
							<li data-target="support"><span>Support</span></li>
							<li data-target="about"><span>About</span></li>
							<li data-target="tutorial"><span>Tutorial</span></li>
							<li data-target="contact"><span>Contact</span></li>
						</ul>
					</div>
				<?php } ?><!-- ログイン判定 -->

			</div>　<!-- /first-header -->

			<div class="second-header"><!-- second-header -->
					<ul class="tool-menu-ul flex-container">
						<li class="cell-container">
							<li>
								<div id="theme-change" class="button tool-button" data-target="theme-change">
									<i class="fa fa-file-text-o" aria-hidden="true"></i>
									Theme
								</div>
							</li>
						<li class="cell-container">
							<div id="font-plus" class="size-change cell-item button tool-button f-t-button" data-target="plus">
								<i class="fa fa-search-plus" aria-hidden="true"></i>
							</div>
							<div id="font-check" data-size="" class="cell-item">

							</div>
							<div id="font-minus" class="size-change cell-item button tool-button l-t-button" data-target="minus">
								<i class="fa fa-search-minus" aria-hidden="true"></i>
							</div>
						</li>
						<li>
							<div id="new-memo" class="button tool-button" data-target="new-memo">
								<i class="fa fa-file-text-o" aria-hidden="true"></i>
								New Memo
							</div>
						</li>

						<!-- <li><span class="border"></span></li> -->
					</ul>
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

			<div class="balloon-menu" id="theme-menu"><!-- more-menu -->
				<ul>
					<li data-target="support">Support</li>
					<li data-target="about">About</li>
					<li data-target="tutorial">Tutorial</li>
					<li data-target="contact">Contact</li>
				</ul>
			</div><!-- more-menu -->

		</section><!-- 吹き出しメニュー本体 -->


		<section id="section-popup"><!-- ポップアップメニュー本体 -->

			<div class="popup-menu" id="login-popup" role="alert"><!-- popup -->
				<div class="popup-container"> <!-- opup-container -->
					<h2>Login</h2>
					<form class="popup-form" id="login" name="login" action="" method="post">
						<div class="text-form">
							<label class="image-replace email" for="login-email">E-mail</label>
							<input type="email" class="full-width has-padding" name="email" placeholder="E-mail" value="">
							<span class="error-message">Error message here!</span>
						</div>
						<div class="text-form">
							<label class="image-replace password" for="login-password">Password</label>
							<input type="password" class="full-width has-padding" name="password" placeholder="Password" value="">
							<span class="error-message">Error message here!</span>
						</div>
						<div class="remember-form">
							<input type="checkbox" id="remember-me" checked>
							<label for="remember-me">Remember me</label>
						</div>
						<button type="button" id="login-button" class="full-width submit-button button"><i class="fa fa-sign-in" aria-hidden="true"></i><span>Login</span></button>
					</form>
					<p class="form-bottom-message"><a href="#0">Forgot your password?</a></p>
					<a href="#0" class="popup-close img-replace"></a>
				</div> <!-- popup-container -->
			</div> <!-- popup -->

			<div class="popup-menu" id="signup-popup" role="alert"><!-- popup -->
				<div class="popup-container"> <!-- popup-container -->
					<h2>Sign Up</h2>
					<form class="popup-form" id="signup" name="signup" action="" method="post">
						<div class="text-form">
							<label class="image-replace username" for="signup-name">Username</label>
							<input type="text" class="full-width has-padding" name="username" placeholder="Username" value="ago">
							<span class="error-message">Error message here!</span>
						</div>
						<div class="text-form">
							<label class="image-replace email" for="signup-email">E-mail</label>
							<input type="email" class="full-width has-padding" name="email" placeholder="E-mail" value="ago@ago.jp">
							<span class="error-message">Error message here!</span>
						</div>
						<div class="text-form">
							<label class="image-replace password" for="signup-password">Password</label>
							<input type="password" class="full-width has-padding" name="password" placeholder="Password" value="ago">
							<span class="error-message">Error message here!</span>
						</div>
						<div class="agree-check">
							<input type="checkbox" id="accept-terms">
							<label for="accept-terms">I agree to the <a href="#0">Terms</a></label>
						</div>
						<button type="button" id="signup-button" class="full-width submit-button button"><i class="fa fa-sign-in" aria-hidden="true"></i><span>Sign Up</span></button>
					</form>
					<a href="#0" class="popup-close img-replace"></a>
				</div> <!-- popup-container -->
			</div> <!-- popup -->

		</section><!-- ポップアップメニュー本体 -->


		<main id="disp" class="flex-container"><!-- main //editor.php -->

			<div class="side-area"><!-- side-area -->

				<div class="side-menu" id="editor-menu">
					<h2>Menu</h2>
					<input type="hidden" id="memo-id" name="memo-id" value="">
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
						<div class="header-button balloon-button" id="account-button">
							<div class="account-icon"><?php echo $_SESSION[USER_ID]; ?></div>
							<i class="fa fa-chevron-down" aria-hidden="true"></i>
						</div>
						<div class="balloon-menu" id="account-menu">
							<ul>
								<li data-target="support"><span>Account</span></li>
								<li data-target="about"><span>Logout</span></li>
							</ul>
						</div>
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

					<h2>Menu</h2>

>>>>>>> origin/master
					<div class="name-form">
						<h3>Name</h3>
						<div class="text-form">
							<input type="text" id="memo-name" name="memo-name" />
						</div>
					</div>
<<<<<<< HEAD
					<div class="mode-form">
						<h3>Mode Select</h3>
						<div id="mode-disp">
							<?php echo $mode_disp; ?>
						</div>
=======
					<div class="category-form">
						<h3>Category</h3>
						<ul class="flex-container">
							<li class="cate-btn" id="html-button" data-target="html"><span>HTML</span></li>
							<li class="cate-btn" id="css-button" data-target="css"><span>CSS</span></li>
							<li class="cate-btn" id="js-button" data-target="javascript"><span>JS</span></li>
						</ul>
						<ul class="flex-container">
							<li class="cate-btn" id="php-button" data-target="php"><span>PHP</span></li>
							<li class="cate-btn" id="xml-button" data-target="xml"><span>XML</span></li>
							<li class="cate-btn" id="sql-button" data-target="sql"><span>SQL</span></li>
						</ul>
>>>>>>> origin/master
					</div>
					<div class="tag-form">
						<h3>Tag</h3>
						<div class="text-form">
							<input type="text" id="memo-tag" name="memo-tag" />
						</div>
						<div id="tags-disp">

						</div>
					</div>
<<<<<<< HEAD
					<div class="save-form">
						<button type="button" class="save-button button" id="save"><i class="fa fa-check-square-o" aria-hidden="true"></i><span>Save</span></button>
						<button type="button" class="save-button button" id="update"><i class="fa fa-check-square-o" aria-hidden="true"></i><span>Update</span></button>
					</div>
				</div>

			</div><!-- side-area -->

			<div class="main-area"><!-- main-area -->

				<!-- ace apiを利用 -->
				<div class="editor-disp" id="editor"></div><!-- editor表示 -->

			</div><!-- main-area -->

		</main>


		<footer>
			<div class="copyright">

			</div>
=======
					<div class="form-save">
						<button class="save-button button" id="save"><span>Save</span></button>
					</div>
				</div>

			</div>
			<div class="main-area">

				<form action="" method="post"><!-- エディタ部分 -->
					<!-- ace apiを利用 -->
					<div class="editor-disp" id="editor"></div>

				</form><!-- エディタ部分 -->

			</div>

		</main>

		<footer>

>>>>>>> origin/master
		</footer>

	</div>

	<!-- ブラウザのjavascript設定がオフになっていた場合 #wrapを非表示 -->
	<script>  document.getElementById("wrap").style.display = "block";</script>

</body>
</html>
