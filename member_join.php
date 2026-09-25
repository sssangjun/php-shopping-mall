<?
include_once "common.php";
?>

<!doctype html>
<html lang="kr">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>NEONIX 회원가입</title>

	<link rel="icon" href="images/favicon.png?v=1" type="image/png">
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/my.css?v=51" rel="stylesheet">

	<script src="js/jquery-3.7.1.min.js"></script>
	<script src="js/bootstrap.bundle.min.js"></script>

	<script>
	function FindZip(zip_kind) 
	{
		w = window.open("zipcode.php?zip_kind=" + zip_kind, "zip", 
			"width=440,height=320,scrollbars=no");
	}

	function check_id()	
	{
		if (!form2.uid.value) {
			alert("ID를 입력하십시요.");
			form2.uid.focus();
			return;
		}

		window.open("member_idcheck.php?uid=" + form2.uid.value, "",
			"width=300,height=200,scrollbar=no");
	}

	function reset_check_id()
	{
		form2.check_id.value = "";
	}

	function Check_Value() 
	{
		if (!form2.check_id.value) {
			alert("중복ID 조사를 먼저 하십시요.");
			form2.uid.focus();
			return;
		}

		if (!form2.uid.value) {
			alert("아이디가 잘못되었습니다.");
			form2.uid.focus();
			return;
		}

		if (!form2.pwd.value) {
			alert("암호가 잘못되었습니다.");
			form2.pwd.focus();
			return;
		}

		if (!form2.pwd1.value) {
			alert("암호가 잘못되었습니다.");
			form2.pwd1.focus();
			return;
		}

		if (form2.pwd.value != form2.pwd1.value) {
			alert("암호가 일치하지 않습니다.");
			form2.pwd.focus();
			return;
		}

		if (!form2.birthday1.value || !form2.birthday2.value || !form2.birthday3.value) {
			alert("생일이 잘못되었습니다.");
			form2.birthday1.focus();
			return;
		}

		if (!form2.tel1.value || !form2.tel2.value || !form2.tel3.value) {
			alert("핸드폰이 잘못되었습니다.");
			form2.tel1.focus();
			return;
		}

		if (!form2.zip.value) {
			alert("우편번호가 잘못되었습니다.");
			form2.zip.focus();
			return;
		}

		if (!form2.juso.value) {
			alert("주소가 잘못되었습니다.");
			form2.juso.focus();
			return;
		}

		if (!form2.email.value) {
			alert("이메일이 잘못되었습니다.");
			form2.email.focus();
			return;
		}

		form2.submit();
	}
	</script>
</head>

<body class="join-page">

<header class="join-header">
	<a href="main.php" class="join-logo">
		<img src="images/neonix_logo.png?v=110" alt="NEONIX">
	</a>

	<nav class="join-nav">
		<a href="main.php">HOME</a>
		<a href="member_login.php">로그인</a>
	</nav>
</header>

<section class="join-wrap">

	<div class="join-card">

		<div class="join-left">
			<div class="join-small">CREATE ACCOUNT</div>

			<h1>
				새로운 게임 여정을<br>
				<span>NEONIX</span>에서 시작하세요
			</h1>

			<p>
				회원가입 후 다양한 게임과 특가 상품,<br>
				장바구니와 주문 내역을 편하게 이용할 수 있습니다.
			</p>

			<div class="join-feature-box">
				<div>
					<b>다양한 게임</b>
					<span>장르별 게임을 한 곳에서</span>
				</div>

				<div>
					<b>회원 혜택</b>
					<span>특가와 추천 게임 확인</span>
				</div>

				<div>
					<b>빠른 주문</b>
					<span>간편한 장바구니 이용</span>
				</div>
			</div>
		</div>

		<div class="join-right">

			<div class="join-title">
				<h2>회원가입</h2>
				<p>정보를 입력하고 NEONIX 회원이 되어보세요.</p>
			</div>

			<form name="form2" method="post" action="member_insert.php">
				<input type="hidden" name="check_id" value="">

				<div class="join-row">
					<label>아이디 <span>*</span></label>
					<div class="join-id-line">
						<div class="join-input-box">
							<i>♙</i>
							<input type="text" name="uid" value="" onkeyup="reset_check_id();" placeholder="아이디를 입력해주세요.">
						</div>

						<a href="javascript:check_id();" class="join-check-btn">중복확인</a>
					</div>
				</div>

				<div class="join-row">
					<label>비밀번호 <span>*</span></label>
					<div class="join-input-box">
						<i>⌘</i>
						<input type="password" name="pwd" placeholder="비밀번호를 입력해주세요.">
					</div>
				</div>

				<div class="join-row">
					<label>비밀번호 확인 <span>*</span></label>
					<div class="join-input-box">
						<i>⌘</i>
						<input type="password" name="pwd1" placeholder="비밀번호를 다시 입력해주세요.">
					</div>
				</div>

				<div class="join-row">
					<label>이름 <span>*</span></label>
					<div class="join-input-box">
						<i>◎</i>
						<input type="text" name="name" value="" placeholder="이름을 입력해주세요.">
					</div>
				</div>

				<div class="join-row">
					<label>휴대폰 <span>*</span></label>
					<div class="join-tel-line">
						<input type="text" name="tel1" maxlength="3" value="010">
						<em>-</em>
						<input type="text" name="tel2" maxlength="4" value="">
						<em>-</em>
						<input type="text" name="tel3" maxlength="4" value="">
					</div>
				</div>

				<div class="join-row">
					<label>주소 <span>*</span></label>
					<div class="join-zip-line">
						<div class="join-input-box join-zip-box">
							<i>⌖</i>
							<input type="text" name="zip" id="zip11" maxlength="5" value="" placeholder="우편번호">
						</div>

						<a href="javascript:FindZip(0);" class="join-check-btn">우편번호 찾기</a>
					</div>

					<div class="join-input-box join-address-box">
						<i>⌂</i>
						<input type="text" name="juso" id="juso11" value="" placeholder="주소를 입력해주세요.">
					</div>
				</div>

				<div class="join-row">
					<label>E-Mail <span>*</span></label>
					<div class="join-input-box">
						<i>✉</i>
						<input type="text" name="email" value="" 
							pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$"
							placeholder="이메일을 입력해주세요.">
					</div>
				</div>

				<div class="join-row">
					<label>생일 <span>*</span></label>
					<div class="join-birth-line">
						<input type="text" name="birthday1" maxlength="4" value="" placeholder="YYYY">
						<em>-</em>
						<input type="text" name="birthday2" maxlength="2" value="" placeholder="MM">
						<em>-</em>
						<input type="text" name="birthday3" maxlength="2" value="" placeholder="DD">
					</div>
				</div>

				<button type="button" onclick="Check_Value()" class="join-submit-btn">
					회원가입
				</button>

				<div class="join-login-link">
					이미 회원이신가요?
					<a href="member_login.php">로그인</a>
				</div>

				<div class="join-back">
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
