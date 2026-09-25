<?
include_once "common.php";
include "main_top.php";

$cart = $_COOKIE["cart"];
$n_cart = $_COOKIE["n_cart"];

if(!$n_cart) $n_cart = 0;

$total = 0;

/* 옵션 이름 + 추가금액 가져오기 */
function get_cart_option_text($opts_id, &$option_price)
{
	global $db;

	$opts_id = intval($opts_id);

	if(!$opts_id) return "";

	$sql = "select name, price from opts where id=$opts_id";
	$result = mysqli_query($db, $sql);

	if(!$result) return "";

	$row = mysqli_fetch_array($result);

	if(!$row) return "";

	$name = $row["name"];
	$price = intval($row["price"]);

	$option_price += $price;

	if($price > 0)
	{
		$name .= " (+" . number_format($price) . "원)";
	}

	return $name;
}
?>

<script>
	function cart_edit(kind,pos) 
	{
		if (kind=="deleteall") 
		{
			if(confirm("장바구니를 모두 비우시겠습니까?"))
				location.href = "cart_edit.php?kind=deleteall";
		}
		else if (kind=="delete")
		{
			if(confirm("이 상품을 삭제하시겠습니까?"))
				location.href = "cart_edit.php?kind=delete&pos="+pos;
		}
		else if (kind=="update")	
		{
			var num = eval("form2.num"+pos).value;

			if(!num || num < 1)
			{
				alert("수량을 확인해주세요.");
				return;
			}

			location.href = "cart_edit.php?kind=update&pos="+pos+"&num="+num;
		}
	}
</script>

<form name="form2" method="post" action="">

<section class="cart-page-wrap">

	<div class="cart-title-box">
		<div class="cart-small-title">SHOPPING CART</div>
		<h2>장바구니</h2>
		<p>선택한 게임과 옵션을 확인한 뒤 주문을 진행하세요.</p>
	</div>

	<div class="cart-layout">

		<div class="cart-list-box">

			<div class="cart-free-banner">
				<span>🚚</span>
				<b><?=number_format($max_baesongbi);?>원 이상 구매 시 수수료 무료</b>
			</div>

			<table class="neo-cart-table">
				<tr>
					<th width="42%">상품정보</th>
					<th width="16%">판매가</th>
					<th width="18%">수량</th>
					<th width="16%">금액</th>
					<th width="8%">삭제</th>
				</tr>

<?
$cart_count = 0;

for($i=1; $i<=$n_cart; $i++)
{
	if(!$cart[$i]) continue;

	$tmp = explode("^", $cart[$i]);

	$id = intval($tmp[0]);
	$num = intval($tmp[1]);
	$opts_id1 = intval($tmp[2]);
	$opts_id2 = intval($tmp[3]);

	if($num < 1) $num = 1;

	$sql = "select * from product where id='$id'";
	$result = mysqli_query($db, $sql);
	if(!$result) exit("에러: $sql");

	$row = mysqli_fetch_array($result);

	if(!$row) continue;

	$cart_count++;

	$name = stripslashes($row["name"]);
	$image1 = $row["image1"];
	if(!$image1) $image1 = "nopic.png";

	$base_price = intval($row["price"]);
	$discount = intval($row["discount"]);

	if($row["icon_sale"] == 1 && $discount > 0)
	{
		$base_price = round($base_price * (100 - $discount) / 100, -3);
	}

	$option_price = 0;

	$opts_name1 = get_cart_option_text($opts_id1, $option_price);
	$opts_name2 = get_cart_option_text($opts_id2, $option_price);

	$price = $base_price + $option_price;
	$prices = $price * $num;

	$total += $prices;
?>

				<tr>
					<td>
						<div class="cart-product-info">
							<a href="product.php?id=<?=$id;?>" class="cart-product-img">
								<img src="product/<?=$image1;?>">
							</a>

							<div class="cart-product-text">
								<a href="product.php?id=<?=$id;?>" class="cart-product-name">
									<?=$name;?>
								</a>

								<div class="cart-option-text">
									<?
									if($opts_name1 || $opts_name2)
									{
										echo("<span>옵션</span> ");
										if($opts_name1) echo($opts_name1);
										if($opts_name2) echo(" / " . $opts_name2);
									}
									else
									{
										echo("<span>옵션 없음</span>");
									}
									?>
								</div>
							</div>
						</div>
					</td>

					<td>
						<div class="cart-price">
							<?=number_format($price);?>원
						</div>

						<?
						if($option_price > 0)
						{
						?>
							<div class="cart-option-price">
								옵션 +<?=number_format($option_price);?>원
							</div>
						<?
						}
						?>
					</td>

					<td>
						<div class="cart-qty-box">
							<input type="text" name="num<?=$i;?>" value="<?=$num;?>">
							<a href="javascript:cart_edit('update','<?=$i;?>')">수정</a>
						</div>
					</td>

					<td>
						<div class="cart-total-price">
							<?=number_format($prices);?>원
						</div>
					</td>

					<td>
						<a href="javascript:cart_edit('delete','<?=$i;?>')" class="cart-delete-btn">
							×
						</a>
					</td>
				</tr>

<?
}
?>

<?
if($cart_count == 0)
{
?>
				<tr>
					<td colspan="5">
						<div class="cart-empty">
							장바구니에 담긴 상품이 없습니다.
						</div>
					</td>
				</tr>
<?
}
?>

			</table>

			<div class="cart-bottom-buttons">
				<a href="main.php" class="cart-sub-btn">쇼핑 계속하기</a>
				<a href="javascript:cart_edit('deleteall',0)" class="cart-sub-btn">장바구니 비우기</a>
			</div>

		</div>

<?
if($total >= $max_baesongbi)
	$baesong = 0;
else
	$baesong = $baesongbi;

$all_total = $total + $baesong;
?>

		<div class="cart-summary-box">
			<h3>주문 요약</h3>

			<div class="summary-row">
				<span>상품금액</span>
				<b><?=number_format($total);?>원</b>
			</div>

			<div class="summary-row">
				<span>수수료</span>
				<b><?=number_format($baesong);?>원</b>
			</div>

			<div class="summary-line"></div>

			<div class="summary-total">
				<span>총 결제금액</span>
				<strong><?=number_format($all_total);?>원</strong>
			</div>

			<?
			if($cart_count > 0)
			{
			?>
				<a href="order.php" class="cart-order-btn">주문하기</a>
			<?
			}
			else
			{
			?>
				<a href="main.php" class="cart-order-btn">상품 보러가기</a>
			<?
			}
			?>

			<a href="main.php" class="cart-continue-btn">‹ 쇼핑 계속하기</a>
		</div>

	</div>

	<div class="cart-benefit">
		<div>
			<b>빠른 처리</b>
			<span>신속하고 안전한 주문 처리</span>
		</div>

		<div>
			<b>안전한 결제</b>
			<span>다양한 결제수단 지원</span>
		</div>

		<div>
			<b>고객지원</b>
			<span>문의와 주문 확인 가능</span>
		</div>

		<div>
			<b>정품 보장</b>
			<span>NEONIX 공식 판매 상품</span>
		</div>
	</div>

</section>

</form>

<?
include "main_bottom.php";
?>