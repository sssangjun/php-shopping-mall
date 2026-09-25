<?
include "common.php";
include "main_top.php";

$type = isset($_REQUEST["type"]) ? $_REQUEST["type"] : "all";
$sort = isset($_REQUEST["sort"]) ? intval($_REQUEST["sort"]) : 1;
$menu = isset($_REQUEST["menu"]) ? $_REQUEST["menu"] : "";

if(!$sort) $sort = 1;

$where = "status=1";
$page_title = "전체게임";

/* 상단 메뉴별 조건 */
if($type == "sale")
{
	$where .= " and icon_sale=1";
	$page_title = "특가게임";
}
elseif($type == "hit")
{
	$where .= " and icon_hit=1";
	$page_title = "인기게임";
}
elseif($type == "new")
{
	$where .= " and icon_new=1";
	$page_title = "신작게임";
}
elseif($type == "free")
{
	$where .= " and price=0";
	$page_title = "무료게임";
}
else
{
	$type = "all";
	$page_title = "전체게임";
}

/* 장르 카테고리 조건 */
$menu_name_selected = "";

if($menu !== "" && isset($a_menu[$menu]))
{
	$menu_sql = mysqli_real_escape_string($db, $menu);
	$where .= " and menu='$menu_sql'";

	$menu_name_selected = $a_menu[$menu];

	if($type == "all")
		$page_title = $menu_name_selected;
	else
		$page_title = $page_title . " · " . $menu_name_selected;
}

/* 정렬 조건 */
if($sort == 1)
	$order = "order by id desc";
elseif($sort == 2)
	$order = "order by icon_hit desc, id desc";
elseif($sort == 3)
	$order = "order by name";
elseif($sort == 4)
	$order = "order by price";
else
	$order = "order by price desc";

$sql = "select * from product where $where $order";
$result = mysqli_query($db, $sql);
if(!$result) exit("에러: $sql");

$total_count = mysqli_num_rows($result);

/* 정렬 링크에 현재 menu 값 유지 */
$menu_url = "";

if($menu !== "" && isset($a_menu[$menu]))
{
	$menu_url = "&menu=" . urlencode($menu);
}
?>

<section class="game-section menu-list-section" id="gameList">

<?
include "genre_category.php";
?>

	<div class="game-section-title menu-page-title">
		<div class="section-small">GAME CATEGORY</div>
		<h2><?=$page_title;?></h2>
		<p>원하는 게임을 찾아보세요</p>
	</div>

	<div class="menu-list-top">
		<div class="menu-total">
			Total <b><?=$total_count;?></b> items
		</div>

		<div class="menu-sort">
<?
$a_sort = array("", "최신순", "인기순", "게임명", "저가순", "고가순");

for($i=1; $i<=5; $i++)
{
	if($i == $sort)
		echo("<a href='menu.php?type=$type$menu_url&sort=$i#gameList' class='active'>$a_sort[$i]</a>");
	else
		echo("<a href='menu.php?type=$type$menu_url&sort=$i#gameList'>$a_sort[$i]</a>");
}
?>
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
if($total_count == 0)
{
?>
	<div class="menu-empty-box">
		등록된 게임이 없습니다.
	</div>
<?
}
?>

</section>

<?
include "main_bottom.php";
?>