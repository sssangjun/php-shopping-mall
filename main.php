<?
include "common.php";
include "main_top.php";

$sql = "select * from product where status=1 order by rand() limit 8";
$result = mysqli_query($db, $sql);
if(!$result) exit("에러: $sql");

$products = array();

while($row = mysqli_fetch_array($result))
{
	$products[] = $row;
}
?>

<section class="game-section">

<?
/* 상단 추천 프로모션용 상품 5개 */
$promo_products = array_slice($products, 0, 5);
?>

<? if(count($promo_products) > 0) { ?>

	<div class="promo-rotator">

		<?
		$first = $promo_products[0];

		$first_id = $first["id"];
		$first_name = stripslashes($first["name"]);
		$first_price = $first["price"];
		$first_discount = $first["discount"];

		$first_image1 = $first["image1"];
		if(!$first_image1) $first_image1 = "nopic.png";

		$first_image2 = $first["image2"];
		if(!$first_image2) $first_image2 = $first_image1;

		if(intval($first_price) <= 0)
		{
			$first_price_html = "무료 플레이";
		}
		elseif($first["icon_sale"] == 1 && $first_discount > 0)
		{
			$first_sale_price = round($first_price * (100 - $first_discount) / 100, -3);
			$first_price_html = number_format($first_sale_price) . "원";
		}
		else
		{
			$first_price_html = number_format($first_price) . "원";
		}
		?>

		<div class="promo-main-box" id="promoMainBox">
			<a href="product.php?id=<?=$first_id;?>" id="promoMainLink">
				<img src="product/<?=$first_image2;?>" id="promoMainImg" class="promo-main-img">
			</a>

			<div class="promo-main-overlay"></div>

			<div class="promo-main-text">
				<div class="promo-small">오늘의 추천 게임</div>

				<h3 id="promoMainTitle">
					<?=$first_name;?>
				</h3>

				<p>지금 주목할 만한 게임을 확인해보세요.</p>

				<div class="promo-price" id="promoMainPrice">
					<?=$first_price_html;?>
				</div>

				<a href="product.php?id=<?=$first_id;?>" id="promoBuyLink" class="promo-detail-btn">
					상세보기
				</a>
			</div>
		</div>

		<div class="promo-side-list">

<?
$i = 0;

foreach($promo_products as $row)
{
	$id = $row["id"];
	$name = stripslashes($row["name"]);
	$price = $row["price"];
	$discount = $row["discount"];

	$image1 = $row["image1"];
	if(!$image1) $image1 = "nopic.png";

	$image2 = $row["image2"];
	if(!$image2) $image2 = $image1;

	if(intval($price) <= 0)
	{
		$price_text = "무료 플레이";
	}
	elseif($row["icon_sale"] == 1 && $discount > 0)
	{
		$sale_price = round($price * (100 - $discount) / 100, -3);
		$price_text = number_format($sale_price) . "원";
	}
	else
	{
		$price_text = number_format($price) . "원";
	}

	$active = "";
	if($i == 0) $active = "active";
?>

			<div class="promo-side-item <?=$active;?>"
				data-id="<?=$id;?>"
				data-name="<?=htmlspecialchars($name, ENT_QUOTES);?>"
				data-main-image="product/<?=$image2;?>"
				data-price="<?=htmlspecialchars($price_text, ENT_QUOTES);?>">

				<img src="product/<?=$image1;?>" class="promo-side-img">

				<div class="promo-side-info">
					<b><?=$name;?></b>
					<span><?=$price_text;?></span>
				</div>

				<div class="promo-progress"></div>
			</div>

<?
	$i++;
}
?>

		</div>
	</div>

<? } ?>

<?
include "genre_category.php";
?>

	<div class="game-section-title">
		<div class="section-small">FEATURED GAMES</div>
		<h2>오늘의 추천 게임</h2>
		<p>지금 가장 인기 있는 게임들을 만나보세요.</p>
	</div>

	<div class="game-grid">

<?
foreach($products as $row)
{
	$id = $row["id"];
	$name = stripslashes($row["name"]);
	$price = $row["price"];
	$discount = $row["discount"];

	$image1 = $row["image1"];
	if(!$image1) $image1 = "nopic.png";

	$menu_name = "";
	if(isset($a_menu[$row["menu"]])) $menu_name = $a_menu[$row["menu"]];

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
?>

		<div class="game-card">

			<a href="product.php?id=<?=$id;?>" class="game-cover-box">
				<? if($row["icon_sale"] == 1 && $discount > 0) { ?>
					<span class="sale-badge">-<?=$discount?>%</span>
				<? } ?>

				<img src="product/<?=$image1;?>" class="game-cover">
			</a>

			<div class="game-info">
				<a href="product.php?id=<?=$id;?>" class="game-name">
					<?=$name;?>
				</a>

				<div class="game-tags">
	<? if($menu_name) echo("<span class='tag-genre'>$menu_name</span>"); ?>
	<? if($row["icon_hit"] == 1) echo("<span class='tag-hit'>인기</span>"); ?>
	<? if($row["icon_new"] == 1) echo("<span class='tag-new'>신작</span>"); ?>
	<? if($row["icon_sale"] == 1) echo("<span class='tag-sale'>할인</span>"); ?>
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

	<div class="neo-benefit">
		<div>⇩ <b>즉시 다운로드</b><br><span>구매 즉시 플레이</span></div>
		<div>▣ <b>안전한 결제</b><br><span>다양한 결제 수단 지원</span></div>
		<div>◎ <b>환불 보장</b><br><span>14일 이내 환불 가능</span></div>
		<div>♧ <b>24/7 고객지원</b><br><span>언제든지 문의하세요</span></div>
	</div>

</section>

<script>
document.addEventListener("DOMContentLoaded", function() {
	const promoItems = document.querySelectorAll(".promo-side-item");
	const promoMainBox = document.getElementById("promoMainBox");
	const promoMainImg = document.getElementById("promoMainImg");
	const promoMainLink = document.getElementById("promoMainLink");
	const promoBuyLink = document.getElementById("promoBuyLink");
	const promoMainTitle = document.getElementById("promoMainTitle");
	const promoMainPrice = document.getElementById("promoMainPrice");

	if(!promoItems.length) return;

	let promoIndex = 0;
	let promoTimer;

	function changePromo(index) {
		if(!promoItems[index]) return;

		promoIndex = index;

		const item = promoItems[index];
		const id = item.dataset.id;
		const name = item.dataset.name;
		const mainImage = item.dataset.mainImage;
		const price = item.dataset.price;

		promoItems.forEach(function(el) {
			el.classList.remove("active");
			el.style.animation = "none";
		});

		item.classList.add("active");

		void item.offsetWidth;

		promoMainBox.classList.add("changing");

		setTimeout(function() {
			promoMainImg.src = mainImage;
			promoMainLink.href = "product.php?id=" + id;
			promoBuyLink.href = "product.php?id=" + id;
			promoMainTitle.innerHTML = name;
			promoMainPrice.innerHTML = price;

			promoMainBox.classList.remove("changing");
		}, 220);
	}

	function nextPromo() {
		let next = promoIndex + 1;

		if(next >= promoItems.length) {
			next = 0;
		}

		changePromo(next);
	}

	promoItems.forEach(function(item, index) {
		item.addEventListener("mouseenter", function() {
			changePromo(index);
			clearInterval(promoTimer);
		});

		item.addEventListener("mouseleave", function() {
			startPromoAuto();
		});

		item.addEventListener("click", function() {
			const id = item.dataset.id;
			location.href = "product.php?id=" + id;
		});
	});

	function startPromoAuto() {
		clearInterval(promoTimer);

		promoTimer = setInterval(function() {
			nextPromo();
		}, 3500);
	}

	startPromoAuto();
});
</script>

<?
include "main_bottom.php";
?>