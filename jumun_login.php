<?
include_once "common.php";
include "main_top.php";


$cookie_id = isset($_COOKIE["cookie_id"]) ? $_COOKIE["cookie_id"] : "";

if($cookie_id)
{
	echo("<script>location.href='jumun.php';</script>");
	exit;
}
?>

<script>
function Check_Value()
{
	if(!form2.o_name.value)
	{
		alert("주문자 이름을 입력하세요.");
		form2.o_name.focus();
		return;
	}

	if(!form2.o_email.value)
	{
		alert("주문자 이메일을 입력하세요.");
		form2.o_email.focus();
		return;
	}

	form2.submit();
}
</script>

<section class="jumun-login-wrap">

	<div class="jumun-login-card">

		<div class="jumun-login-logo">
			<img src="images/neonix_logo.png?v=101" alt="NEONIX">
		</div>

		<div class="jumun-login-small">ORDER SEARCH</div>

		<h2>비회원 주문조회</h2>

		<p>
			비회원 주문 시 입력한 이름과 이메일로<br>
			주문 내역을 확인할 수 있습니다.
		</p>

		<form name="form2" method="post" action="jumun.php">

			<div class="jumun-login-field">
				<label>이름</label>
				<input type="text" name="o_name" class="jumun-login-input">
			</div>

			<div class="jumun-login-field">
				<label>E-Mail</label>
				<input type="text" name="o_email" class="jumun-login-input">
			</div>

			<a href="javascript:Check_Value();" class="jumun-login-btn">
				주문조회
			</a>

		</form>

		<div class="jumun-login-guide">
			회원은 로그인 후 주문조회 메뉴를 이용해주세요.
		</div>

	</div>

</section>

<?
include "main_bottom.php";
?>