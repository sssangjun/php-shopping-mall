<?
include_once "common.php";
include "main_top.php";

$cart = isset($_COOKIE["cart"]) ? $_COOKIE["cart"] : array();
$n_cart = isset($_COOKIE["n_cart"]) ? intval($_COOKIE["n_cart"]) : 0;

$o_name = isset($_REQUEST["o_name"]) ? $_REQUEST["o_name"] : "";
$o_tel = 
	(isset($_REQUEST["o_tel1"]) ? $_REQUEST["o_tel1"] : "") . "-" .
	(isset($_REQUEST["o_tel2"]) ? $_REQUEST["o_tel2"] : "") . "-" .
	(isset($_REQUEST["o_tel3"]) ? $_REQUEST["o_tel3"] : "");

$o_email = isset($_REQUEST["o_email"]) ? $_REQUEST["o_email"] : "";
$o_zip = isset($_REQUEST["o_zip"]) ? $_REQUEST["o_zip"] : "";
$o_juso = isset($_REQUEST["o_juso"]) ? $_REQUEST["o_juso"] : "";

$r_name = isset($_REQUEST["r_name"]) ? $_REQUEST["r_name"] : "";
$r_tel = 
	(isset($_REQUEST["r_tel1"]) ? $_REQUEST["r_tel1"] : "") . "-" .
	(isset($_REQUEST["r_tel2"]) ? $_REQUEST["r_tel2"] : "") . "-" .
	(isset($_REQUEST["r_tel3"]) ? $_REQUEST["r_tel3"] : "");

$r_email = isset($_REQUEST["r_email"]) ? $_REQUEST["r_email"] : "";
$r_zip = isset($_REQUEST["r_zip"]) ? $_REQUEST["r_zip"] : "";
$r_juso = isset($_REQUEST["r_juso"]) ? $_REQUEST["r_juso"] : "";

$memo = isset($_REQUEST["memo"]) ? $_REQUEST["memo"] : "";

$total = 0;

function get_pay_option_text($opts_id, &$option_price)
{
	global $db;

	$opts_id = intval($opts_id);

	if(!$opts_id) return "";

	$sql = "select * from opts where id=$opts_id";
	$result = mysqli_query($db, $sql);

	if(!$result) return "";

	$row = mysqli_fetch_array($result);

	if(!$row) return "";

	$name = $row["name"];
	$price = intval($row["price"]);

	$option_price += $price;

	if($price > 0)
		$name .= " (+" . number_format($price) . "원)";

	return $name;
}
?>

<script>
function Check_Value() 
{
	if (form2.pay_kind[0].checked)
	{
		if (form2.card_kind.value==0) {
			alert("카드종류를 선택하세요."); form2.card_kind.focus(); return;
		}
		if (!form2.card_no1.value || !form2.card_no2.value || !form2.card_no3.value || !form2.card_no4.value) {
			alert("카드번호를 입력하세요."); form2.card_no1.focus(); return;
		}
		if (!form2.card_month.value) {
			alert("카드기간 월을 입력하세요."); form2.card_month.focus(); return;
		}
		if (!form2.card_year.value) {
			alert("카드기간 년도를 입력하세요."); form2.card_year.focus(); return;
		}
		if (!form2.card_pw.value) {
			alert("카드 비밀번호 뒤의 2자리를 입력하세요."); form2.card_pw.focus(); return;
		}
	}
	else
	{
		if (form2.bank_kind.value==0) {
			alert("입금할 은행을 선택하세요."); form2.bank_kind.focus(); return;
		}
		if (!form2.bank_sender.value) {
			alert("입금자 이름을 입력하세요."); form2.bank_sender.focus(); return;
		}
	}

	form2.card_kind.disabled = false;
	form2.card_no1.disabled = false;
	form2.card_no2.disabled = false;
	form2.card_no3.disabled = false;
	form2.card_no4.disabled = false;
	form2.card_year.disabled = false;
	form2.card_month.disabled = false;
	form2.card_pw.disabled = false;
	form2.card_halbu.disabled = false;
	form2.bank_kind.disabled = false;
	form2.bank_sender.disabled = false;

	form2.submit();
}

function PaySel(n) 
{
	var cardBox = document.getElementById("neoCardBox");
	var bankBox = document.getElementById("neoBankBox");

	if (n == 0) {
		form2.card_kind.disabled = false;
		form2.card_no1.disabled = false;
		form2.card_no2.disabled = false;
		form2.card_no3.disabled = false;
		form2.card_no4.disabled = false;
		form2.card_year.disabled = false;
		form2.card_month.disabled = false;
		form2.card_halbu.disabled = false;
		form2.card_pw.disabled = false;

		form2.bank_kind.disabled = true;
		form2.bank_sender.disabled = true;

		if(cardBox) cardBox.classList.add("active");
		if(bankBox) bankBox.classList.remove("active");
	}
	else {
		form2.card_kind.disabled = true;
		form2.card_no1.disabled = true;
		form2.card_no2.disabled = true;
		form2.card_no3.disabled = true;
		form2.card_no4.disabled = true;
		form2.card_year.disabled = true;
		form2.card_month.disabled = true;
		form2.card_halbu.disabled = true;
		form2.card_pw.disabled = true;

		form2.bank_kind.disabled = false;
		form2.bank_sender.disabled = false;

		if(cardBox) cardBox.classList.remove("active");
		if(bankBox) bankBox.classList.add("active");
	}
}
</script>

<section class="neo-pay-wrap">

	<div class="neo-pay-title">
		<div class="neo-pay-small">PAYMENT INFORMATION</div>
		<h2>주문 / 결제정보</h2>
		<p>결제 방법을 선택하고 주문 내용을 최종 확인하세요.</p>
	</div>

	<form name="form2" method="post" action="order_insert.php" class="neo-pay-form">

		<input type="hidden" name="o_name" value="<?=$o_name;?>">
		<input type="hidden" name="o_tel" value="<?=$o_tel;?>">
		<input type="hidden" name="o_email" value="<?=$o_email;?>">
		<input type="hidden" name="o_zip" value="<?=$o_zip;?>">
		<input type="hidden" name="o_juso" value="<?=$o_juso;?>">

		<input type="hidden" name="r_name" value="<?=$r_name;?>">
		<input type="hidden" name="r_tel" value="<?=$r_tel;?>">
		<input type="hidden" name="r_email" value="<?=$r_email;?>">
		<input type="hidden" name="r_zip" value="<?=$r_zip;?>">
		<input type="hidden" name="r_juso" value="<?=$r_juso;?>">
		<input type="hidden" name="memo" value="<?=$memo;?>">

		<div class="neo-pay-layout">

			<div class="neo-pay-left">

				<div class="neo-pay-card">
					<div class="neo-pay-card-head">
						<div>
							<span>STEP 01</span>
							<h3>주문 상품 확인</h3>
						</div>
						<a href="cart.php">장바구니 수정</a>
					</div>

<?
if($n_cart < 1)
{
?>
					<div class="neo-pay-empty">
						장바구니에 담긴 상품이 없습니다.
					</div>
<?
}
else
{
?>
					<div class="neo-pay-product-table">

						<div class="neo-pay-product-head">
							<div>상품정보</div>
							<div>판매가</div>
							<div>수량</div>
							<div>금액</div>
						</div>

<?
	for($i=1; $i<=$n_cart; $i++)
	{
		if(!isset($cart[$i]) || !$cart[$i]) continue;

		$tmp = explode("^", $cart[$i]);

		$id = isset($tmp[0]) ? intval($tmp[0]) : 0;
		$num = isset($tmp[1]) ? intval($tmp[1]) : 1;
		$opts_id1 = isset($tmp[2]) ? intval($tmp[2]) : 0;
		$opts_id2 = isset($tmp[3]) ? intval($tmp[3]) : 0;

		if($num < 1) $num = 1;

		$sql = "select * from product where id='$id'";
		$result = mysqli_query($db, $sql);

		if(!$result) continue;

		$row = mysqli_fetch_array($result);

		if(!$row) continue;

		$name = stripslashes($row["name"]);
		$image1 = $row["image1"];

		if(!$image1) $image1 = "nopic.png";

		$base_price = intval($row["price"]);
		$discount = intval($row["discount"]);

		if($row["icon_sale"] == 1 && $discount > 0)
			$base_price = round($base_price * (100-$discount)/100, -3);

		$option_price = 0;

		$opts_name1 = get_pay_option_text($opts_id1, $option_price);
		$opts_name2 = get_pay_option_text($opts_id2, $option_price);

		$price = $base_price + $option_price;
		$prices = $price * $num;

		$total += $prices;

		$option_text = "";

		if($opts_name1) $option_text .= $opts_name1;
		if($opts_name2)
		{
			if($option_text) $option_text .= " / ";
			$option_text .= $opts_name2;
		}

		if(!$option_text) $option_text = "선택 옵션 없음";
?>

						<div class="neo-pay-product-row">

							<div class="neo-pay-product-info">
								<a href="product.php?id=<?=$id;?>" class="neo-pay-product-img">
									<img src="product/<?=$image1;?>" alt="<?=$name;?>">
								</a>

								<div>
									<a href="product.php?id=<?=$id;?>" class="neo-pay-product-name">
										<?=$name;?>
									</a>

									<p>
										<span>옵션</span>
										<?=$option_text;?>
									</p>
								</div>
							</div>

							<div class="neo-pay-price">
								<?=number_format($price);?>원
							</div>

							<div class="neo-pay-num">
								<?=$num;?>
							</div>

							<div class="neo-pay-total">
								<?=number_format($prices);?>원
							</div>

						</div>

<?
	}
?>

					</div>
<?
}

if($total >= $max_baesongbi)
	$baesong = 0;
else
	$baesong = $baesongbi;

$all_total = $total + $baesong;
?>

				</div>

				<div class="neo-pay-card">
					<div class="neo-pay-card-head">
						<div>
							<span>STEP 02</span>
							<h3>주문 정보 확인</h3>
						</div>
						<a href="javascript:history.back()">정보 수정</a>
					</div>

					<div class="neo-pay-info-grid">

						<div class="neo-pay-info-box">
							<h4>주문자 정보</h4>

							<div class="neo-pay-info-row">
								<span>이름</span>
								<strong><?=$o_name;?></strong>
							</div>

							<div class="neo-pay-info-row">
								<span>휴대폰</span>
								<strong><?=$o_tel;?></strong>
							</div>

							<div class="neo-pay-info-row">
								<span>이메일</span>
								<strong><?=$o_email;?></strong>
							</div>

							<div class="neo-pay-info-row address">
								<span>주소</span>
								<strong>[<?=$o_zip;?>] <?=$o_juso;?></strong>
							</div>
						</div>

						<div class="neo-pay-info-box">
							<h4>받는 사람 정보</h4>

							<div class="neo-pay-info-row">
								<span>이름</span>
								<strong><?=$r_name;?></strong>
							</div>

							<div class="neo-pay-info-row">
								<span>휴대폰</span>
								<strong><?=$r_tel;?></strong>
							</div>

							<div class="neo-pay-info-row">
								<span>이메일</span>
								<strong><?=$r_email;?></strong>
							</div>

							<div class="neo-pay-info-row address">
								<span>주소</span>
								<strong>[<?=$r_zip;?>] <?=$r_juso;?></strong>
							</div>
						</div>

					</div>

<?
if($memo)
{
?>
					<div class="neo-pay-memo">
						<span>요구사항</span>
						<p><?=$memo;?></p>
					</div>
<?
}
?>

				</div>

				<div class="neo-pay-card">
					<div class="neo-pay-card-head">
						<div>
							<span>STEP 03</span>
							<h3>결제 방법 선택</h3>
						</div>
					</div>

					<div class="neo-pay-method-select">

						<label class="neo-pay-method active" id="neoCardBox">
							<input type="radio" name="pay_kind" value="0" onclick="javascript:PaySel(0);" checked>
							<div>
								<strong>카드 결제</strong>
								<p>신용카드 정보를 입력하여 결제합니다.</p>
							</div>
						</label>

						<label class="neo-pay-method" id="neoBankBox">
							<input type="radio" name="pay_kind" value="1" onclick="javascript:PaySel(1);">
							<div>
								<strong>무통장 입금</strong>
								<p>선택한 계좌로 입금 후 주문을 진행합니다.</p>
							</div>
						</label>

					</div>

					<div class="neo-pay-section">
						<div class="neo-pay-section-title">
							카드 정보
						</div>

						<div class="neo-pay-field-grid">

							<div class="neo-pay-field full">
								<label>카드종류</label>
								<select name="card_kind" class="form-select neo-pay-input">
									<option value="0" selected>카드종류를 선택하세요.</option>
									<option value="1">국민카드</option>
									<option value="2">신한카드</option>
									<option value="3">우리카드</option>
									<option value="4">하나카드</option>
								</select>
							</div>

							<div class="neo-pay-field full">
								<label>카드번호</label>

								<div class="neo-pay-card-number">
									<input type="text" name="card_no1" maxlength="4" class="form-control neo-pay-input">
									<input type="text" name="card_no2" maxlength="4" class="form-control neo-pay-input">
									<input type="text" name="card_no3" maxlength="4" class="form-control neo-pay-input">
									<input type="text" name="card_no4" maxlength="4" class="form-control neo-pay-input">
								</div>
							</div>

							<div class="neo-pay-field">
								<label>카드기간</label>

								<div class="neo-pay-expire">
									<input type="text" name="card_month" maxlength="2" class="form-control neo-pay-input" placeholder="MM">
									<span>월</span>
									<input type="text" name="card_year" maxlength="2" class="form-control neo-pay-input" placeholder="YY">
									<span>년</span>
								</div>
							</div>

							<div class="neo-pay-field">
								<label>카드 비밀번호</label>

								<div class="neo-pay-password">
									<span>**</span>
									<input type="password" name="card_pw" maxlength="2" class="form-control neo-pay-input" placeholder="뒤 2자리">
								</div>
							</div>

							<div class="neo-pay-field full">
								<label>할부</label>
								<select name="card_halbu" class="form-select neo-pay-input">
									<option value="0" selected>일시불</option>
									<option value="3">3 개월</option>
									<option value="6">6 개월</option>
									<option value="9">9 개월</option>
									<option value="12">12 개월</option>
								</select>
							</div>

						</div>
					</div>

					<div class="neo-pay-section">
						<div class="neo-pay-section-title">
							무통장 입금 정보
						</div>

						<div class="neo-pay-field-grid">

							<div class="neo-pay-field full">
								<label>입금은행</label>
								<select name="bank_kind" class="form-select neo-pay-input" disabled>
									<option value="0" selected>입금할 은행을 선택하세요.</option>
									<option value="1">국민은행 111-00000-0000</option>
									<option value="2">신한은행 222-00000-0000</option>
								</select>
							</div>

							<div class="neo-pay-field full">
								<label>입금자 이름</label>
								<input type="text" name="bank_sender" class="form-control neo-pay-input" disabled>
							</div>

						</div>
					</div>

				</div>

			</div>

			<div class="neo-pay-right">

				<div class="neo-pay-summary">
					<h3>최종 결제금액</h3>

					<div class="neo-pay-summary-row">
						<span>상품금액</span>
						<strong><?=number_format($total);?>원</strong>
					</div>

					<div class="neo-pay-summary-row">
						<span>수수료</span>
						<strong><?=number_format($baesong);?>원</strong>
					</div>

					<div class="neo-pay-summary-line"></div>

					<div class="neo-pay-summary-row final">
						<span>총 결제금액</span>
						<strong><?=number_format($all_total);?>원</strong>
					</div>

					<div class="neo-pay-benefit">
						안전한 결제를 위해 입력 정보를 다시 한 번 확인해주세요.
					</div>

<?
if($n_cart > 0)
{
?>
					<button type="button" onclick="Check_Value()" class="neo-pay-next-btn">
						결제하기
					</button>

					<a href="order.php" class="neo-pay-back-btn">
						주문정보로 돌아가기
					</a>
<?
}
else
{
?>
					<a href="main.php" class="neo-pay-next-btn">
						스토어로 이동
					</a>
<?
}
?>

				</div>

			</div>

		</div>

	</form>

</section>

<?
include "main_bottom.php";
?>