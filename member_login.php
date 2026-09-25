<?
include_once "common.php";
?>

<!doctype html>
<html lang="kr">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>NEONIX Login</title>

	<link rel="icon" href="images/favicon.png?v=1" type="image/png">
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/my.css?v=110" rel="stylesheet">

	<script src="js/jquery-3.7.1.min.js"></script>
	<script src="js/bootstrap.bundle.min.js"></script>

	<script>
	function Check_Value() {
		if (!form2.uid.value) {
			alert("아이디를 입력하세요.");
			form2.uid.focus();
			return;
		}

		if (!form2.pwd.value) {
			alert("암호를 입력하세요.");
			form2.pwd.focus();
			return;
		}

		form2.submit();
	}
	</script>
</head>

<body class="login-page">

<header class="login-header">
	<a href="main.php" class="login-logo">
		<img src="images/neonix_logo.png?v=101" alt="NEONIX">
	</a>

	<nav class="login-nav">
		<a href="main.php">HOME</a>
		<a href="member_join.php">회원가입</a>
	</nav>
</header>

<section class="login-wrap">

	<div class="login-card">

		<div class="login-left">
			<div class="login-small">WELCOME BACK</div>

			<h1>
				다시 만난<br>
				<span>NEONIX</span>
			</h1>

			<p>
				로그인하고 관심 게임, 장바구니, 주문 내역을<br>
				한 곳에서 편하게 확인해보세요.
			</p>

			<div class="login-feature-box">
				<div>
					<b>빠른 구매</b>
					<span>간편한 주문 진행</span>
				</div>

				<div>
					<b>특가 확인</b>
					<span>할인 게임 바로 확인</span>
				</div>

				<div>
					<b>주문 관리</b>
					<span>구매 내역 확인</span>
				</div>
			</div>
		</div>

		<div class="login-right">

			<div class="login-title">
				<h2>로그인</h2>
				<p>게임을 시작하려면 로그인하세요.</p>
			</div>

			<form name="form2" method="post" action="member_check.php">

				<div class="login-input-row">
					<label>아이디</label>
					<div class="login-input-box">
						<span>♙</span>
						<input type="text" name="uid" tabindex="1" placeholder="아이디를 입력해주세요.">
					</div>
				</div>

				<div class="login-input-row">
					<label>비밀번호</label>
					<div class="login-input-box">
						<span>⌘</span>
						<input type="password" name="pwd" tabindex="2" placeholder="비밀번호를 입력해주세요.">
					</div>
				</div>

				<div class="login-option-row">
					<label>
						<input type="checkbox">
						아이디 저장
					</label>

					<a href="member_idpw.html">아이디 / 암호 찾기</a>
				</div>

				<a href="javascript:Check_Value();" tabindex="3" class="login-submit-btn">
					로그인
				</a>

				<div class="login-divider">
					<span>또는</span>
				</div>

				<a href="member_join.php" class="login-join-btn">
					아직 회원이 아니신가요? 회원가입
				</a>

				<div class="login-back">
					<a href="main.php">‹ 메인으로 돌아가기</a>
				</div>

			</form>

		</div>

	</div>

</section>
<?
include "main_bottom.php";
?>

</body>
</html>