<?php
	require_once "php/login_check.php";

	require_once 'php/mode_setting.php';

	require_once "php/data_open.php";
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
<link rel="stylesheet" href="css/jquery.mCustomScrollbar.css">
<!-- <script src="js/jquery-3.1.0.min.js"></script> -->
<script src="js/jquery-1.11.2.min.js"></script>
<script src="js/animsition.min.js"></script>
<script src="js/modernizr.js"></script>
<script src="js/mixitup.min.js"></script><!-- mixitup.min.js -->
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


		<footer>

		</footer>

	</div>
	<!-- ブラウザのjavascript設定がオフになっていた場合 #wrapを非表示 -->
	<script>  document.getElementById("wrap").style.display = "block";</script>

</body>
</html>
