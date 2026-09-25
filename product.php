<?
include "common.php";
include "main_top.php";

$id = isset($_REQUEST["id"]) ? $_REQUEST["id"] : "";

$id_sql = mysqli_real_escape_string($db, $id);

$sql = "select * from product where id='$id_sql'";
$result = mysqli_query($db, $sql);
if(!$result) exit("에러: $sql");

$row = mysqli_fetch_array($result);

if(!$row)
{
	echo("<script>
		alert('상품 정보가 없습니다.');
		location.href='main.php';
	</script>");
	exit;
}

$name = stripslashes($row["name"]);
$contents = stripslashes($row["contents"]);

if(!$contents)
{
	$contents = $name . "은 NEONIX에서 만나볼 수 있는 인기 게임입니다. 플랫폼과 언어를 선택한 뒤 바로 구매하거나 장바구니에 담아 이용할 수 있습니다.";
}

$image2 = $row["image2"] ? $row["image2"] : "nopic.png";
$image3 = $row["image3"];

$price = $row["price"];
$discount = $row["discount"];

if($row["icon_sale"] == 1 && $discount > 0)
{
	$sale_price = round($price * (100 - $discount) / 100, -3);
	$final_price = $sale_price;
}
else
{
	$final_price = $price;
}

$menu_name = "";
if(isset($a_menu[$row["menu"]])) $menu_name = $a_menu[$row["menu"]];

/* 옵션 이름과 안내문 */
$opt1_title = isset($a_opt_title[$row["opt1"]]) ? $a_opt_title[$row["opt1"]] : "옵션1";
$opt1_msg = isset($a_opt_msg[$row["opt1"]]) ? $a_opt_msg[$row["opt1"]] : "옵션을 선택하세요.";

$opt2_title = isset($a_opt_title[$row["opt2"]]) ? $a_opt_title[$row["opt2"]] : "옵션2";
$opt2_msg = isset($a_opt_msg[$row["opt2"]]) ? $a_opt_msg[$row["opt2"]] : "옵션을 선택하세요.";
?>

<script>
	let base_price = <?=$final_price;?>;

	function cal_price() 
	{
		let num = Number(form2.num.value);

		if(!num || num < 1)
		{
			num = 1;
			form2.num.value = 1;
		}

		let option_price = 0;

		let selects = document.querySelectorAll(".option-select");

		selects.forEach(function(sel) {
			if(sel.value != "0")
			{
				let selected = sel.options[sel.selectedIndex];
				let addPrice = Number(selected.getAttribute("data-price"));

				if(!isNaN(addPrice))
				{
					option_price += addPrice;
				}
			}
		});

		let unit_price = base_price + option_price;
		let total_price = unit_price * num;

		form2.price.value = unit_price;
		form2.prices.value = total_price.toLocaleString();
	}

	function check_form2(str) 
	{
		if (form2.opts1.value==0) {
			alert("<?=$opt1_msg;?>");
			form2.opts1.focus();
			return;
		}

<?
if($row["opt2"])
{
?>
		if (form2.opts2 && form2.opts2.value==0) {
			alert("<?=$opt2_msg;?>");
			form2.opts2.focus();
			return;
		}
<?
}
?>

		if (!form2.num.value) {
			alert("수량을 입력하십시요.");
			form2.num.focus();
			return;
		}

		cal_price();

		if (str == "D") {
			form2.action = "cart_edit.php";
			form2.kind.value = "order";
			form2.submit();
		}
		else {
			form2.action = "cart_edit.php";
			form2.kind.value = "insert";
			form2.submit();
		}
	}

	window.onload = function() {
		cal_price();
	}
</script>

<form name="form2" method="post" action="">
<input type="hidden" name="kind" value="insert">
<input type="hidden" name="id" value="<?=$id;?>">
<input type="hidden" name="price" value="<?=$final_price;?>">

<section class="product-detail-wrap">

	<div class="product-detail-inner">

		<div class="product-image-area">

			<div class="product-main-image" data-bs-toggle="modal" data-bs-target="#zoomModal">
				<img src="product/<?=$image2;?>" alt="<?=$name;?>">
				<div class="image-zoom-badge">이미지 확대</div>
			</div>

			<div class="product-game-intro">
				<h2>게임 소개</h2>

				<div class="product-game-intro-content">
					<?=$contents;?>
				</div>
			</div>

		</div>

		<div class="product-info-area">

			<div class="product-breadcrumb">
				<a href="main.php">홈</a>
				<span>›</span>
				<a href="menu.php?type=all"><?=$menu_name;?></a>
				<span>›</span>
				<strong><?=$name;?></strong>
			</div>

			<div class="product-badges">
				<? if($row["icon_hit"] == 1) { ?>
					<span class="badge-hit">HIT</span>
				<? } ?>

				<? if($row["icon_new"] == 1) { ?>
					<span class="badge-new">NEW</span>
				<? } ?>

				<? if($row["icon_sale"] == 1 && $discount > 0) { ?>
					<span class="badge-sale">-<?=$discount;?>%</span>
				<? } ?>
			</div>

			<h1 class="product-title"><?=$name;?></h1>

			<p class="product-subtitle">
				<?=$menu_name;?> 장르의 인기 게임을 지금 만나보세요.
			</p>

			<div class="product-price-box">
				<div class="price-label">판매가</div>

				<div class="price-value">
<?
if(intval($price) <= 0)
{
?>
					<span class="free-price">무료 플레이</span>
<?
}
elseif($row["icon_sale"] == 1 && $discount > 0)
{
?>
					<span class="old-detail-price"><?=number_format($price);?>원</span>
					<span class="sale-detail-price"><?=number_format($sale_price);?>원</span>
<?
}
else
{
?>
					<span class="normal-detail-price"><?=number_format($price);?>원</span>
<?
}
?>
				</div>
			</div>

			<div class="product-option-box">

				<div class="option-row">
					<label><?=$opt1_title;?></label>
					<select name="opts1" class="form-select product-select option-select" onchange="cal_price();">
						<option value="0" data-price="0" selected><?=$opt1_msg;?></option>
<?
$sql1 = "select * from opts where opt_id='{$row["opt1"]}' order by price, id";
$result1 = mysqli_query($db, $sql1);
if($result1)
{
	while($row1 = mysqli_fetch_array($result1))
	{
		$opt_price = isset($row1["price"]) ? $row1["price"] : 0;

		$opt_text = $row1["name"];
		if($opt_price > 0)
		{
			$opt_text .= " (+" . number_format($opt_price) . "원)";
		}

		echo("<option value='{$row1['id']}' data-price='{$opt_price}'>{$opt_text}</option>");
	}
}
?>
					</select>
				</div>

<?
if($row["opt2"])
{
?>
				<div class="option-row">
					<label><?=$opt2_title;?></label>
					<select name="opts2" class="form-select product-select option-select" onchange="cal_price();">
						<option value="0" data-price="0" selected><?=$opt2_msg;?></option>
<?
$sql2 = "select * from opts where opt_id='{$row["opt2"]}' order by price, id";
$result2 = mysqli_query($db, $sql2);
if($result2)
{
	while($row2 = mysqli_fetch_array($result2))
	{
		$opt_price = isset($row2["price"]) ? $row2["price"] : 0;

		$opt_text = $row2["name"];
		if($opt_price > 0)
		{
			$opt_text .= " (+" . number_format($opt_price) . "원)";
		}

		echo("<option value='{$row2['id']}' data-price='{$opt_price}'>{$opt_text}</option>");
	}
}
?>
					</select>
				</div>
<?
}
?>

				<div class="option-row option-row-small">
					<label>수량</label>
					<input type="text" name="num" value="1" class="form-control product-num" 
						onchange="cal_price();" onkeyup="cal_price();">
				</div>

				<div class="option-row option-row-small">
					<label>총 금액</label>
					<input type="text" name="prices" value="<?=number_format($final_price);?>" class="form-control product-total" readonly>
				</div>

			</div>

			<div class="product-button-area">
				<a href="javascript:check_form2('D')" class="buy-btn">바로 구매</a>
				<a href="javascript:check_form2('C')" class="cart-btn">장바구니 담기</a>
			</div>

		</div>

	</div>

</section>

</form>

<section class="product-meta-section">
	<div class="product-meta-inner">

		<div class="product-meta-card">
			<div class="meta-icon">🎮</div>
			<div>
				<strong>게임 장르</strong>
				<span><?=$menu_name;?></span>
			</div>
		</div>

		<div class="product-meta-card">
			<div class="meta-icon">⬇</div>
			<div>
				<strong>구매 형태</strong>
				<span>디지털 다운로드</span>
			</div>
		</div>

		<div class="product-meta-card">
			<div class="meta-icon">🌐</div>
			<div>
				<strong>언어 지원</strong>
				<span>한국어 / English / 日本語</span>
			</div>
		</div>

		<div class="product-meta-card">
			<div class="meta-icon">🛡</div>
			<div>
				<strong>이용 등급</strong>
				<span>전체 이용가</span>
			</div>
		</div>

	</div>
</section>

<?
if($image3)
{
?>
<section class="product-desc-section">
	<div class="product-desc-inner">
	

		<div class="product-extra-image">
			<img src="product/<?=$image3;?>" alt="<?=$name;?> 상세 이미지">
		</div>
	</div>
</section>
<?
}
?>

<!-- Zoom Modal -->
<div class="modal fade neon-zoom-modal" id="zoomModal" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-xl modal-dialog-centered">
		<div class="modal-content neon-zoom-content">

			<div class="neon-zoom-header">
				<div class="neon-zoom-title"><?=$name;?></div>

				<button type="button" class="neon-zoom-close" onclick="closeZoomModal();">
					×
				</button>
			</div>

			<div class="neon-zoom-body">
				<img src="product/<?=$image2;?>" class="neon-zoom-img" alt="<?=$name;?>">
			</div>

		</div>
	</div>
</div>

<script>
function closeZoomModal()
{
	const modalEl = document.getElementById("zoomModal");

	if(window.bootstrap)
	{
		const modalObj = bootstrap.Modal.getInstance(modalEl);

		if(modalObj)
		{
			modalObj.hide();
		}
	}

	modalEl.classList.remove("show");
	modalEl.style.display = "none";
	modalEl.setAttribute("aria-hidden", "true");
	modalEl.removeAttribute("aria-modal");
	modalEl.removeAttribute("role");

	document.body.classList.remove("modal-open");
	document.body.style.removeProperty("overflow");
	document.body.style.removeProperty("padding-right");

	const backdrops = document.querySelectorAll(".modal-backdrop");
	backdrops.forEach(function(backdrop) {
		backdrop.remove();
	});
}
</script>

<?
include "main_bottom.php";
?>