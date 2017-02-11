<?php
	require_once 'php/login_check.php';

	require_once 'php/mode_setting.php';
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
<title>CoMeApp/Editor</title>
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/font-awesome.css">
<link rel="stylesheet" href="css/animsition.min.css">
<link rel="stylesheet" href="css/jquery.mCustomScrollbar.css">
<script src="js/jquery-1.11.2.min.js"></script>
<script src="js/animsition.min.js"></script>
<script src="js/emmet.js"></script><!-- ace apiのemmet機能実装に必要 -->
<script src="ace_src/ace.js"></script><!-- ace api 本体 -->
<script src="ace_src/ext-language_tools.js"></script><!-- ace apiのsnippet機能 -->
<script src="ace_src/ext-emmet.js"></script><!-- ace apiのemmet機能 -->
<script src="js/jquery.mCustomScrollbar.concat.min.js"></script><!-- scrollbar.concat.min.js -->
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

		<header>

			<div class="first-header flex-container">　<!-- first-header -->

				<div class="logo">
					<h1>CoMeApp</h1>
				</div>

				<ul class="groval-menu-ul flex-container">
					<li class="tab-li">
						<a class="tab-button button animsition-link" id="editor-link" href="editor.php">Editor</a>
					</li>
					<li>
						<a class="tab-button button animsition-link" id="savedata-link" href="savedata.php">SaveData</a>
					</li>
					<li class="border"><span class="border-white"></span></li>
				<?php if(!isset($_SESSION[USER_ID])) { ?><!-- ログイン判定 -->
					<li>
						<div class="text-button right-i balloon-button" id="more-menu-1" data-target="more-menu">
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
				<?php } else { ?>
					<li>
						<div class="text-button right-i balloon-button" id="more-menu-2" data-target="more-menu">
							More
							<i class="fa fa-chevron-down" aria-hidden="true"></i>
						</div>
					</li>
					<li>
						<div class="header-button balloon-button" id="account-button">
							<div class="account-icon"><?php echo $_SESSION[USER_NAME]; ?></div>
							<i class="fa fa-chevron-down" aria-hidden="true"></i>
						</div>
					</li>
				<?php } ?><!-- ログイン判定 -->
				</ul>

			</div>　<!-- /first-header -->

			<div class="second-header"><!-- second-header -->

					<ul class="tool-menu-ul flex-container">
						<!-- <li class="cell-container">
								<div id="theme-change" class="button tool-button" data-target="theme-change">
									<i class="fa fa-file-text-o" aria-hidden="true"></i>
									Theme
								</div>
						</li> -->
						<li class="cell-container">
							<div id="font-plus" class="size-change cell-item button tool-button f-t-button" data-target="plus">
								<i class="fa fa-search-plus" aria-hidden="true"></i>
							</div>
							<div id="font-check" data-size="" class="cell-item"></div>
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
					</ul>

			</div><!-- /second-header -->

		</header>


		<section id="section-balloon"><!-- 吹き出しメニュー本体 -->

			<div class="balloon-menu" id="more-menu-1"><!-- more-menu -->
				<ul>
					<li data-target="support">Support</li>
					<li data-target="about">About</li>
					<li data-target="tutorial">Tutorial</li>
					<li data-target="contact">Contact</li>
				</ul>
			</div><!-- more-menu -->

			<div class="balloon-menu" id="more-menu-2"><!-- more-menu -->
				<ul>
					<li data-target="support">Support</li>
					<li data-target="about">About</li>
					<li data-target="tutorial">Tutorial</li>
					<li data-target="contact">Contact</li>
				</ul>
			</div><!-- more-menu -->

			<div class="balloon-menu" id="account-menu">
				<ul>
					<li data-target="account"><span>Account</span></li>
					<li data-target="about"><span>About</span></li>
					<li class="popup-logout-trigger" data-target="logout"><span>Logout</span></li>
				</ul>
			</div>

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
							<input type="email" class="has-padding" name="user-id" placeholder="E-mail" value="">
							<span class="error-message">Error message here!</span>
						</div>
						<div class="text-form">
							<label class="image-replace password" for="login-password">Password</label>
							<input type="password" class="has-padding" name="password" placeholder="Password" value="">
							<span class="error-message">Error message here!</span>
						</div>
						<div class="remember-form">
							<input type="checkbox" id="remember-me" checked>
							<label for="remember-me">Remember me</label>
						</div>
						<button type="button" id="login-button" class="submit-button button"><i class="fa fa-sign-in" aria-hidden="true"></i><span>Login</span></button>
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
							<input type="text" class="has-padding" name="username" placeholder="Username" value="ago">
							<span class="error-message">Error message here!</span>
						</div>
						<div class="text-form">
							<label class="image-replace email" for="signup-email">E-mail</label>
							<input type="email" class="has-padding" name="email" placeholder="E-mail" value="ago@ago.jp">
							<span class="error-message">Error message here!</span>
						</div>
						<div class="text-form">
							<label class="image-replace password" for="signup-password">Password</label>
							<input type="password" class="has-padding" name="password" placeholder="Password" value="ago">
							<span class="error-message">Error message here!</span>
						</div>
						<div class="agree-check">
							<input type="checkbox" id="accept-terms">
							<label for="accept-terms">I agree to the <a href="#0">Terms</a></label>
						</div>
						<button type="button" id="signup-button" class="submit-button button"><i class="fa fa-sign-in" aria-hidden="true"></i><span>Sign Up</span></button>
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
					<div class="name-form">
						<h3>Name</h3>
						<div class="text-form memo-name">
							<input type="text" id="memo-name" name="memo-name" />
						</div>
					</div>
					<div class="mode-form">
						<h3>Mode Select</h3>
						<div id="mode-disp">
							<?php echo $mode_disp; ?>
						</div>
					</div>
					<div class="tag-form">
						<h3>Tag</h3>
						<div class="text-form">
							<input type="text" id="memo-tag" name="memo-tag" placeholder="現在壊れてます！" />
						</div>
						<div id="tags-disp">

						</div>
					</div>
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
		</footer>

	</div>

	<!-- ブラウザのjavascript設定がオフになっていた場合 #wrapを非表示 -->
	<script>document.getElementById("wrap").style.display = "block";</script>

</body>
</html>
