<?
include_once "common.php";
include "main_top.php";

$cart = isset($_COOKIE["cart"]) ? $_COOKIE["cart"] : array();
$n_cart = isset($_COOKIE["n_cart"]) ? intval($_COOKIE["n_cart"]) : 0;

$o_name = "";
$o_tel1 = "010";
$o_tel2 = "";
$o_tel3 = "";
$o_email = "";
$o_zip = "";
$o_juso = "";

$cookie_id = isset($_COOKIE["cookie_id"]) ? $_COOKIE["cookie_id"] : "";

if($cookie_id)
{
	$sql = "select * from member where id='$cookie_id'";
	$result = mysqli_query($db, $sql);

	if($result)
	{
		$row = mysqli_fetch_array($result);

		if($row)
		{
			$o_name = $row["name"];
			$o_email = $row["email"];
			$o_zip = $row["zip"];
			$o_juso = $row["juso"];

			if($row["tel"])
			{
				$tel = explode("-", $row["tel"]);

				$o_tel1 = isset($tel[0]) ? $tel[0] : "010";
				$o_tel2 = isset($tel[1]) ? $tel[1] : "";
				$o_tel3 = isset($tel[2]) ? $tel[2] : "";
			}
		}
	}
}

$total = 0;

function get_order_option_text($opts_id, &$option_price)
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
	if (!form2.o_name.value) {
		alert("주문자 이름이 잘못 되었습니다.");
		form2.o_name.focus();
		return;
	}

	if (!form2.o_tel1.value || !form2.o_tel2.value || !form2.o_tel3.value) {
		alert("핸드폰이 잘못 되었습니다.");
		form2.o_tel1.focus();
		return;
	}

	if (!form2.o_email.value) {
		alert("이메일이 잘못 되었습니다.");
		form2.o_email.focus();
		return;
	}

	if (!form2.o_zip.value) {
		alert("우편번호가 잘못 되었습니다.");
		form2.o_zip.focus();
		return;
	}

	if (!form2.o_juso.value) {
		alert("주소가 잘못 되었습니다.");
		form2.o_juso.focus();
		return;
	}

	if (!form2.r_name.value) {
		alert("받으실 분의 이름이 잘못 되었습니다.");
		form2.r_name.focus();
		return;
	}

	if (!form2.r_tel1.value || !form2.r_tel2.value || !form2.r_tel3.value) {
		alert("핸드폰이 잘못 되었습니다.");
		form2.r_tel1.focus();
		return;
	}

	if (!form2.r_email.value) {
		alert("이메일이 잘못 되었습니다.");
		form2.r_email.focus();
		return;
	}

	if (!form2.r_zip.value) {
		alert("우편번호가 잘못 되었습니다.");
		form2.r_zip.focus();
		return;
	}

	if (!form2.r_juso.value) {
		alert("주소가 잘못 되었습니다.");
		form2.r_juso.focus();
		return;
	}

	form2.submit();
}

function FindZip(zip_kind)
{
	window.open("zipcode.php?zip_kind="+zip_kind,"","scrollbars=no,width=490,height=320");
}

function SameCopy(str)
{
	if (str == "Y")
	{
		form2.r_name.value = form2.o_name.value;
		form2.r_zip.value = form2.o_zip.value;
		form2.r_juso.value = form2.o_juso.value;

		form2.r_tel1.value = form2.o_tel1.value;
		form2.r_tel2.value = form2.o_tel2.value;
		form2.r_tel3.value = form2.o_tel3.value;

		form2.r_email.value = form2.o_email.value;
	}
	else
	{
		form2.r_name.value = "";
		form2.r_zip.value = "";
		form2.r_juso.value = "";

		form2.r_tel1.value = "";
		form2.r_tel2.value = "";
		form2.r_tel3.value = "";

		form2.r_email.value = "";
	}
}
</script>

<section class="neo-order-wrap">

	<div class="neo-order-title">
		<div class="neo-order-small">ORDER INFORMATION</div>
		<h2>주문 정보 입력</h2>
		<p>주문 상품과 배송 정보를 확인한 뒤 결제 단계로 이동하세요.</p>
	</div>

	<form name="form2" method="post" action="order_pay.php" class="neo-order-form">

		<div class="neo-order-layout">

			<div class="neo-order-left">

				<div class="neo-order-card">
					<div class="neo-order-card-head">
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
					<div class="neo-order-empty">
						장바구니에 담긴 상품이 없습니다.
					</div>
<?
}
else
{
?>
					<div class="neo-order-product-table">

						<div class="neo-order-product-head">
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
			$base_price = round($base_price * (100-$discount)/100,-3);

		$option_price = 0;

		$opts_name1 = get_order_option_text($opts_id1, $option_price);
		$opts_name2 = get_order_option_text($opts_id2, $option_price);

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

						<div class="neo-order-product-row">

							<div class="neo-order-product-info">
								<a href="product.php?id=<?=$id;?>" class="neo-order-product-img">
									<img src="product/<?=$image1;?>" alt="<?=$name;?>">
								</a>

								<div>
									<a href="product.php?id=<?=$id;?>" class="neo-order-product-name">
										<?=$name;?>
									</a>

									<p>
										<span>옵션</span>
										<?=$option_text;?>
									</p>
								</div>
							</div>

							<div class="neo-order-price">
								<?=number_format($price);?>원
							</div>

							<div class="neo-order-num">
								<?=$num;?>
							</div>

							<div class="neo-order-total">
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

<?
if($n_cart > 0)
{
?>

				<div class="neo-order-card">
					<div class="neo-order-card-head">
						<div>
							<span>STEP 02</span>
							<h3>주문자 정보</h3>
						</div>
					</div>

					<div class="neo-order-field-grid">

						<div class="neo-order-field">
							<label>이름 <b>*</b></label>
							<input type="text" name="o_name" value="<?=$o_name;?>" class="form-control neo-order-input">
						</div>

						<div class="neo-order-field">
							<label>휴대폰 <b>*</b></label>

							<div class="neo-order-phone">
								<input type="text" name="o_tel1" maxlength="3" value="<?=$o_tel1;?>" class="form-control neo-order-input">
								<span>-</span>
								<input type="text" name="o_tel2" maxlength="4" value="<?=$o_tel2;?>" class="form-control neo-order-input">
								<span>-</span>
								<input type="text" name="o_tel3" maxlength="4" value="<?=$o_tel3;?>" class="form-control neo-order-input">
							</div>
						</div>

						<div class="neo-order-field full">
							<label>이메일 <b>*</b></label>
							<input type="text" name="o_email" value="<?=$o_email;?>" class="form-control neo-order-input">
						</div>

						<div class="neo-order-field full">
							<label>주소 <b>*</b></label>

							<div class="neo-order-zip">
								<input type="text" name="o_zip" maxlength="5" value="<?=$o_zip;?>" class="form-control neo-order-input">
								<a href="javascript:FindZip(1)">우편번호 찾기</a>
							</div>

							<input type="text" name="o_juso" value="<?=$o_juso;?>" class="form-control neo-order-input mt-2">
						</div>

					</div>
				</div>

				<div class="neo-order-card">
					<div class="neo-order-card-head">
						<div>
							<span>STEP 03</span>
							<h3>배송 정보</h3>
						</div>

						<div class="neo-order-copy">
							<label>
								<input type="radio" name="same" onclick="javascript:SameCopy('Y')">
								주문자와 동일
							</label>

							<label>
								<input type="radio" name="same" onclick="javascript:SameCopy('N')">
								직접 입력
							</label>
						</div>
					</div>

					<div class="neo-order-field-grid">

						<div class="neo-order-field">
							<label>받는 분 <b>*</b></label>
							<input type="text" name="r_name" class="form-control neo-order-input">
						</div>

						<div class="neo-order-field">
							<label>휴대폰 <b>*</b></label>

							<div class="neo-order-phone">
								<input type="text" name="r_tel1" maxlength="3" value="010" class="form-control neo-order-input">
								<span>-</span>
								<input type="text" name="r_tel2" maxlength="4" class="form-control neo-order-input">
								<span>-</span>
								<input type="text" name="r_tel3" maxlength="4" class="form-control neo-order-input">
							</div>
						</div>

						<div class="neo-order-field full">
							<label>이메일 <b>*</b></label>
							<input type="text" name="r_email" class="form-control neo-order-input">
						</div>

						<div class="neo-order-field full">
							<label>주소 <b>*</b></label>

							<div class="neo-order-zip">
								<input type="text" name="r_zip" maxlength="5" class="form-control neo-order-input">
								<a href="javascript:FindZip(2)">우편번호 찾기</a>
							</div>

							<input type="text" name="r_juso" class="form-control neo-order-input mt-2">
						</div>

						<div class="neo-order-field full">
							<label>요구사항</label>
							<textarea name="memo" rows="4" class="form-control neo-order-input neo-order-textarea"></textarea>
						</div>

					</div>
				</div>

<?
}
?>

			</div>

			<div class="neo-order-right">

				<div class="neo-order-summary">
					<h3>결제 요약</h3>

					<div class="neo-order-summary-row">
						<span>상품금액</span>
						<strong><?=number_format($total);?>원</strong>
					</div>

					<div class="neo-order-summary-row">
						<span>수수료</span>
						<strong><?=number_format($baesong);?>원</strong>
					</div>

					<div class="neo-order-summary-line"></div>

					<div class="neo-order-summary-row final">
						<span>총 결제금액</span>
						<strong><?=number_format($all_total);?>원</strong>
					</div>

					<div class="neo-order-benefit">
						🚚 <?=number_format($max_baesongbi);?>원 이상 구매 시 수수료 무료
					</div>

<?
if($n_cart > 0)
{
?>
					<button type="button" onclick="Check_Value()" class="neo-order-next-btn">
						결제 정보 입력
					</button>

					<a href="cart.php" class="neo-order-back-btn">
						장바구니로 돌아가기
					</a>
<?
}
else
{
?>
					<a href="main.php" class="neo-order-next-btn">
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