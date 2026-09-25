<?
include_once "common.php";
include "main_top.php";

$id = isset($_REQUEST["id"]) ? $_REQUEST["id"] : "";

$totalprice = "";
$product_names = "";
$jumunday = "";
$o_name = "";

if($id)
{
	$sql = "select * from jumun where id='$id'";
	$result = mysqli_query($db, $sql);

	if($result)
	{
		$row = mysqli_fetch_array($result);

		if($row)
		{
			$totalprice = isset($row["totalprice"]) ? $row["totalprice"] : "";
			$product_names = isset($row["product_names"]) ? stripslashes($row["product_names"]) : "";
			$jumunday = isset($row["jumunday"]) ? $row["jumunday"] : "";
			$o_name = isset($row["o_name"]) ? $row["o_name"] : "";
		}
	}
}
?>

<section class="order-ok-wrap">

	<div class="order-ok-card">

		<div class="order-ok-icon">
			✓
		</div>

		<div class="order-ok-small">
			ORDER COMPLETE
		</div>

		<h2>주문이 완료되었습니다</h2>

		<p class="order-ok-desc">
			NEONIX를 이용해주셔서 감사합니다.<br>
			주문하신 상품은 빠르게 확인 후 처리됩니다.
		</p>

		<div class="order-ok-info">

			<?
			if($id)
			{
			?>
				<div class="order-ok-row">
					<span>주문번호</span>
					<strong><?=$id;?></strong>
				</div>
			<?
			}
			?>

			<?
			if($o_name)
			{
			?>
				<div class="order-ok-row">
					<span>주문자</span>
					<strong><?=$o_name;?></strong>
				</div>
			<?
			}
			?>

			<?
			if($product_names)
			{
			?>
				<div class="order-ok-row">
					<span>주문상품</span>
					<strong><?=$product_names;?></strong>
				</div>
			<?
			}
			?>

			<?
			if($jumunday)
			{
			?>
				<div class="order-ok-row">
					<span>주문일자</span>
					<strong><?=$jumunday;?></strong>
				</div>
			<?
			}
			?>

			<?
			if($totalprice !== "")
			{
			?>
				<div class="order-ok-row total">
					<span>총 결제금액</span>
					<strong><?=number_format($totalprice);?>원</strong>
				</div>
			<?
			}
			?>

			<?
			if(!$id)
			{
			?>
				<div class="order-ok-row">
					<span>주문정보</span>
					<strong>주문이 정상 처리되었습니다.</strong>
				</div>
			<?
			}
			?>

		</div>

		<div class="order-ok-message">
			<p>
				주문 내역은 주문조회 화면에서 다시 확인할 수 있습니다.<br>
				즐거운 게임 쇼핑이 되시길 바랍니다.
			</p>
		</div>

		<?
$cookie_id = isset($_COOKIE["cookie_id"]) ? $_COOKIE["cookie_id"] : "";

if($cookie_id)
	$order_link = "jumun.php";
else
	$order_link = "jumun_login.php";
?>

<div class="order-ok-buttons">
	<a href="main.php" class="order-ok-main-btn">
		스토어로 이동
	</a>

	<a href="<?=$order_link;?>" class="order-ok-sub-btn">
		주문조회
	</a>
</div>

	</div>

</section>

<?
include "main_bottom.php";
?>