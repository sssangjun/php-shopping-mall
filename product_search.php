<?
include "common.php";
include "main_top.php";

$find_text = isset($_REQUEST["find_text"]) ? $_REQUEST["find_text"] : "";

$where = "status=1";

if($find_text)
{
	$where .= " and name like '%$find_text%'";
}

$sql = "select * from product where $where order by id desc";

$result = mysqli_query($db, $sql);
if(!$result) exit("에러: $sql");
?>

<section class="game-section menu-list-section">

	<div class="game-section-title">
		<div class="section-small">SEARCH RESULT</div>
		<h2>게임 검색</h2>
		<p>
			<?
			if($find_text)
				echo("'".$find_text."' 검색 결과입니다.");
			else
				echo("검색어를 입력해주세요.");
			?>
		</p>
	</div>

	<div class="menu-list-top">
		<div class="menu-total">
			Total <b><?=mysqli_num_rows($result);?></b> items
		</div>
	</div>

	<div class="game-grid">

<?
while($row = mysqli_fetch_array($result))
{
	$id = $row["id"];
	$name = stripslashes($row["name"]);
	$price = $row["price"];
	$discount = $row["discount"];

	$image1 = $row["image1"];
	if(!$image1) $image1 = "nopic.png";

	if(intval($price) <= 0)
	{
		$price_html = "<span class='free-game'>무료 플레이</span>";
	}
	elseif($row["icon_sale"] == 1 && $discount > 0)
	{
		$sale_price = round($price * (100 - $discount) / 100, -3);

		$price_html = "
			<span class='old-price'>" . number_format($price) . "원</span>
			<span class='sale-price'>" . number_format($sale_price) . "원</span>
		";
	}
	else
	{
		$price_html = "<span class='normal-price'>" . number_format($price) . "원</span>";
	}

	$menu_name = "";
	if(isset($a_menu[$row["menu"]])) $menu_name = $a_menu[$row["menu"]];
?>

		<div class="game-card">

			<a href="product.php?id=<?=$id;?>" class="game-cover-box">
				<? if($row["icon_sale"] == 1 && $discount > 0) { ?>
					<span class="sale-badge">-<?=$discount;?>%</span>
				<? } ?>

				<img src="product/<?=$image1;?>" class="game-cover">
			</a>

			<div class="game-info">
				<a href="product.php?id=<?=$id;?>" class="game-name">
					<?=$name;?>
				</a>

				<div class="game-tags">
					<? if($menu_name) echo("<span>$menu_name</span>"); ?>
					<? if($row["icon_hit"] == 1) echo("<span>인기</span>"); ?>
					<? if($row["icon_new"] == 1) echo("<span>신작</span>"); ?>
					<? if($row["icon_sale"] == 1) echo("<span>할인</span>"); ?>
				</div>

				<div class="game-price">
					<?=$price_html;?>
				</div>

				<a href="cart.php" class="wish-btn">♡</a>
			</div>

		</div>

<?
}
?>

	</div>

<?
if(mysqli_num_rows($result) == 0)
{
?>
	<div style="text-align:center; color:#cfd5dd; font-size:16px; font-weight:800; padding:60px 0;">
		검색 결과가 없습니다.
	</div>
<?
}
?>

</section>

<?
include "main_bottom.php";
?>