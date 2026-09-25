<?
include_once "common.php";

$current_page = basename($_SERVER["PHP_SELF"]);

$game_pages = array(
	"main.php",
	"menu.php",
	"product.php",
	"product_search.php",
	"cart.php",
	"order.php",
	"order_pay.php",
	"order_ok.php",
	"orders.php",
	"member_edit.php",
	"member_joinend.php",
	"jumun_login.php",
	"jumun.php",
	"jumun_info.php"
	
	
);

$is_game_page = in_array($current_page, $game_pages);
$show_hero = ($current_page == "main.php" || $current_page == "menu.php");

$cookie_id = isset($_COOKIE["cookie_id"]) ? $_COOKIE["cookie_id"] : "";
$top_type = isset($_REQUEST["type"]) ? $_REQUEST["type"] : "";

/* 상단 장바구니 개수 */
$top_cart_count = 0;
$top_cart = isset($_COOKIE["cart"]) ? $_COOKIE["cart"] : array();
$top_n_cart = isset($_COOKIE["n_cart"]) ? intval($_COOKIE["n_cart"]) : 0;

if($top_n_cart > 0 && is_array($top_cart))
{
	for($i=1; $i<=$top_n_cart; $i++)
	{
		if(!isset($top_cart[$i]) || !$top_cart[$i]) continue;

		$tmp = explode("^", $top_cart[$i]);
		$tmp_num = isset($tmp[1]) ? intval($tmp[1]) : 1;

		if($tmp_num < 1) $tmp_num = 1;

		$top_cart_count += $tmp_num;
	}
}
?>

<!doctype html>
<html lang="kr">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>NEONIX</title>

	<link rel="icon" href="images/favicon.png?v=1" type="image/png">
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/my.css?v=94" rel="stylesheet">

	<script src="js/jquery-3.7.1.min.js"></script>
	<script src="js/bootstrap.bundle.min.js"></script>

	<script>
	function check_findproduct(form_obj) {
		if (!form_obj.find_text.value) {
			alert('검색어를 입력하세요');
			form_obj.find_text.focus();
			return;
		}
		form_obj.submit();
	}
	</script>

	<script>
	/* =========================
	   브라우저 축소 방지
	   100% 이하로 축소되는 것 방지
	   Ctrl + 마우스휠 아래 / Ctrl + - 차단
	========================= */

	(function () {
		const baseZoom = 1;

		function currentZoom() {
			return window.devicePixelRatio || 1;
		}

		function isAtOrBelow100() {
			return currentZoom() <= baseZoom + 0.01;
		}

		document.addEventListener("keydown", function (e) {
			if (!(e.ctrlKey || e.metaKey)) return;

			if (e.key === "-" || e.key === "_") {
				if (isAtOrBelow100()) {
					e.preventDefault();
				}
			}
		});

		document.addEventListener("wheel", function (e) {
			if (!(e.ctrlKey || e.metaKey)) return;

			if (e.deltaY > 0 && isAtOrBelow100()) {
				e.preventDefault();
			}
		}, { passive:false });
	})();
	</script>
</head>

<body class="<?=$is_game_page ? 'main-page' : 'sub-page';?>">

<?
if($is_game_page)
{
?>

<div class="game-wrap">

	<header class="neo-top">

		<div class="neo-logo">
			<a href="main.php">
				<img src="images/neonix_logo.png?v=101" alt="NEONIX">
			</a>
		</div>

		<nav class="neo-main-nav">
			<a href="main.php" class="<?=$current_page == 'main.php' ? 'active' : '';?>">스토어</a>
			<a href="qa.html">라운지</a>
			<a href="menu.php?type=sale#gameList">이벤트</a>
			<a href="faq.html">고객센터</a>
		</nav>

		<div class="neo-user">

			<form name="search_form_top" method="post" action="product_search.php" class="neo-header-search" id="neoHeaderSearch">
				<input type="text" name="find_text" placeholder="게임 검색">
				<button type="button" onclick="check_findproduct(document.search_form_top)">⌕</button>
			</form>

			<a href="cart.php" class="neo-header-cart">
				<span class="nav-icon icon-cart"></span>
				<span>장바구니</span>

				<? if($top_cart_count > 0) { ?>
					<em><?=$top_cart_count;?></em>
				<? } ?>
			</a>

			<?
			if($cookie_id)
				$order_link = "jumun.php";
			else
				$order_link = "jumun_login.php";
			?>

			<a href="<?=$order_link;?>" class="neo-header-order">주문조회</a>

			<?
			if(!$cookie_id)
			{
				echo("<a href='member_join.php'>회원가입</a>");
				echo("<a href='member_login.php' class='neo-login'>로그인</a>");
			}
			else
			{
				echo("<a href='member_edit.php'>회원정보</a>");
				echo("<a href='member_logout.php' class='neo-login'>로그아웃</a>");
			}
			?>

		</div>
	</header>

	<div class="neo-category-wrap" id="neoCategoryWrap">
		<div class="neo-category">

			<a href="main.php" class="<?=$current_page == 'main.php' ? 'active' : '';?>">
				<span class="nav-icon icon-recommend"></span>추천
			</a>

			<a href="menu.php?type=sale#gameList" class="<?=$current_page == 'menu.php' && $top_type == 'sale' ? 'active' : '';?>">
				<span class="nav-icon icon-sale"></span>특가게임
			</a>

			<a href="menu.php?type=hit#gameList" class="<?=$current_page == 'menu.php' && $top_type == 'hit' ? 'active' : '';?>">
				<span class="nav-icon icon-hit"></span>인기게임
			</a>

			<a href="menu.php?type=new#gameList" class="<?=$current_page == 'menu.php' && $top_type == 'new' ? 'active' : '';?>">
				<span class="nav-icon icon-new"></span>신작게임
			</a>

			<a href="menu.php?type=free#gameList" class="<?=$current_page == 'menu.php' && $top_type == 'free' ? 'active' : '';?>">
				<span class="nav-icon icon-free"></span>무료게임
			</a>

			<a href="menu.php?type=all#gameList" class="<?=$current_page == 'menu.php' && ($top_type == 'all' || $top_type == '') ? 'active' : '';?>">
				<span class="nav-icon icon-all"></span>전체게임
			</a>

			<span class="neo-line"></span>

			<form name="search_form_category" method="post" action="product_search.php" class="neo-search">
				<input type="text" name="find_text" placeholder="게임 검색">
				<button type="button" onclick="check_findproduct(document.search_form_category)">⌕</button>
			</form>

		</div>
	</div>
<? if($current_page != "member_joinend.php") { ?>
	<div class="neo-floating-category" id="neoFloatingCategory">

		<a href="main.php" class="<?=$current_page == 'main.php' ? 'active' : '';?>">
			<span class="nav-icon icon-recommend"></span>
			<em>추천</em>
		</a>

		<a href="menu.php?type=sale#gameList" class="<?=$current_page == 'menu.php' && $top_type == 'sale' ? 'active' : '';?>">
			<span class="nav-icon icon-sale"></span>
			<em>특가</em>
		</a>

		<a href="menu.php?type=hit#gameList" class="<?=$current_page == 'menu.php' && $top_type == 'hit' ? 'active' : '';?>">
			<span class="nav-icon icon-hit"></span>
			<em>인기</em>
		</a>

		<a href="menu.php?type=new#gameList" class="<?=$current_page == 'menu.php' && $top_type == 'new' ? 'active' : '';?>">
			<span class="nav-icon icon-new"></span>
			<em>신작</em>
		</a>

		<a href="menu.php?type=free#gameList" class="<?=$current_page == 'menu.php' && $top_type == 'free' ? 'active' : '';?>">
			<span class="nav-icon icon-free"></span>
			<em>무료</em>
		</a>

		<a href="menu.php?type=all#gameList" class="<?=$current_page == 'menu.php' && ($top_type == 'all' || $top_type == '') ? 'active' : '';?>">
			<span class="nav-icon icon-all"></span>
			<em>전체</em>
		</a>

	</div>
<? } ?>
	<script>
	document.addEventListener("DOMContentLoaded", function() {
		const category = document.getElementById("neoCategoryWrap");
		const floating = document.getElementById("neoFloatingCategory");
		const headerSearch = document.getElementById("neoHeaderSearch");

		if(!category) return;

		function checkFloatingCategory() {
			const rect = category.getBoundingClientRect();

			if(rect.bottom < 0) {
				if(floating) floating.classList.add("show");
				if(headerSearch) headerSearch.classList.add("show");
			}
			else {
				if(floating) floating.classList.remove("show");
				if(headerSearch) headerSearch.classList.remove("show");
			}
		}

		window.addEventListener("scroll", checkFloatingCategory, { passive:true });
		window.addEventListener("resize", checkFloatingCategory);

		checkFloatingCategory();
	});
	</script>

<?
if($show_hero)
{
?>

<section class="neo-hero">

	<div class="neo-slider-window">
		<div class="neo-slider-track" id="neo-slider-track">

			<div class="neo-slide btn-center" style="background-image:url('images/main1.jpg');">
				<div class="neo-slide-text">
					<div class="neo-small-title"></div>
					<a href="menu.php?type=new#gameList">신작게임 보기</a>
				</div>
			</div>

			<div class="neo-slide btn-center" style="background-image:url('images/main2.jpg');">
				<div class="neo-slide-text">
					<div class="neo-small-title"></div>
					<a href="menu.php?type=free#gameList">무료게임 보기</a>
				</div>
			</div>

			<div class="neo-slide btn-left" style="background-image:url('images/main3.jpg');">
				<div class="neo-slide-text">
					<div class="neo-small-title"></div>
					<a href="menu.php?type=sale#gameList">특가게임 보기</a>
				</div>
			</div>

			<div class="neo-slide btn-center" style="background-image:url('images/main4.jpg');">
				<div class="neo-slide-text">
					<div class="neo-small-title"></div>
					<a href="menu.php?type=hit#gameList">인기게임 보기</a>
				</div>
			</div>

		</div>
	</div>

	<button type="button" class="neo-arrow neo-prev" onclick="moveSlide(-1)">‹</button>
	<button type="button" class="neo-arrow neo-next" onclick="moveSlide(1)">›</button>

	<div class="neo-count">
		<span id="slide-count">1 / 4</span>
	</div>

</section>

<script>
const slideWidth = 920;
const slideGap = 28;
const moveSize = slideWidth + slideGap;

const track = document.getElementById("neo-slider-track");
const countText = document.getElementById("slide-count");

let isSliding = false;
let autoTimer = null;

Array.from(track.children).forEach(function(slide, index) {
	slide.dataset.realIndex = index + 1;
});

track.insertBefore(track.lastElementChild, track.firstElementChild);

function basePosition(animate) {
	if(animate) {
		track.style.transition = "transform .75s cubic-bezier(.22,.75,.25,1)";
	} else {
		track.style.transition = "none";
	}

	track.style.transform =
		"translateX(calc(50% - " + (slideWidth / 2) + "px - " + moveSize + "px))";
}

function updateSlideClass() {
	const slides = Array.from(track.children);

	slides.forEach(function(slide) {
		slide.classList.remove("active", "near");
	});

	if(slides[0]) slides[0].classList.add("near");
	if(slides[1]) slides[1].classList.add("active");
	if(slides[2]) slides[2].classList.add("near");

	if(slides[1]) {
		countText.innerHTML = slides[1].dataset.realIndex + " / 4";
	}
}

function restartProgress() {
	const countBox = document.querySelector(".neo-count");

	if(!countBox) return;

	countBox.classList.remove("progressing");
	void countBox.offsetWidth;
	countBox.classList.add("progressing");
}

function moveSlide(direction) {
	if(isSliding) return;
	isSliding = true;

	restartProgress();

	if(direction > 0) {
		track.style.transition = "transform .75s cubic-bezier(.22,.75,.25,1)";
		track.style.transform =
			"translateX(calc(50% - " + (slideWidth / 2) + "px - " + (moveSize * 2) + "px))";

		setTimeout(function() {
			track.appendChild(track.firstElementChild);
			basePosition(false);
			updateSlideClass();

			setTimeout(function() {
				track.style.transition = "transform .75s cubic-bezier(.22,.75,.25,1)";
				isSliding = false;
			}, 30);
		}, 760);
	}
	else {
		track.insertBefore(track.lastElementChild, track.firstElementChild);

		track.style.transition = "none";
		track.style.transform =
			"translateX(calc(50% - " + (slideWidth / 2) + "px - " + (moveSize * 2) + "px))";

		setTimeout(function() {
			track.style.transition = "transform .75s cubic-bezier(.22,.75,.25,1)";
			basePosition(true);
			updateSlideClass();

			setTimeout(function() {
				isSliding = false;
			}, 760);
		}, 30);
	}
}

function startAutoSlide() {
	restartProgress();

	autoTimer = setInterval(function() {
		moveSlide(1);
	}, 5000);
}

basePosition(false);
updateSlideClass();

setTimeout(function() {
	track.style.transition = "transform .75s cubic-bezier(.22,.75,.25,1)";
}, 50);

startAutoSlide();
</script>

<?
}
?>

<?
}
else
{
?>

<div class="container">

	<div class="row">
		<div class="col fs-3" align="left">
			&nbsp;<a href="main.php"><font color="#777777">INDUK Mall</font></a>
		</div>

		<div class="col mt-3" align="right" style="font-size:12px;">
			<a href="main.php">Home</a>&nbsp;|&nbsp;

			<?
			if(!$cookie_id)
			{
				echo("<a href='member_login.php'>Login</a>&nbsp;|&nbsp;");
				echo("<a href='member_join.php'>회원가입</a>&nbsp;|&nbsp;");
			}
			else
			{
				echo("<a href='member_logout.php'>Logout</a>&nbsp;|&nbsp;");
				echo("<a href='member_edit.php'>회원정보수정</a>&nbsp;|&nbsp;");
			}
			?>

			<a href="cart.php">장바구니</a>&nbsp;|&nbsp;
			<a href="jumun_login.php">주문조회</a>&nbsp;|&nbsp;
			<a href="qa.html">Q & A</a>&nbsp;|&nbsp;
			<a href="faq.html">FAQ</a>&nbsp;&nbsp;
		</div>
	</div>

	<div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel" data-bs-interval="4000">
		<div class="carousel-indicators">
			<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"></button>
			<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"></button>
			<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"></button>
			<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="3"></button>
		</div>

		<div class="carousel-inner">
			<div class="carousel-item active">
				<img src="images/main1.jpg" class="d-block w-100" alt="...">
				<div class="carousel-caption d-none d-md-block">
					<h1>New Fashion 1</h1>
					<p><h6>당신을 위한 패션 제안 1</h6></p>
				</div>
			</div>

			<div class="carousel-item">
				<img src="images/main2.jpg" class="d-block w-100" alt="...">
				<div class="carousel-caption d-none d-md-block">
					<h1>New Fashion 2</h1>
					<p><h6>당신을 위한 패션 제안 2</h6></p>
				</div>
			</div>

			<div class="carousel-item">
				<img src="images/main3.jpg" class="d-block w-100" alt="...">
				<div class="carousel-caption d-none d-md-block">
					<h1>New Fashion 3</h1>
					<p><h6>당신을 위한 패션 제안 3</h6></p>
				</div>
			</div>

			<div class="carousel-item">
				<img src="images/main4.jpg" class="d-block w-100" alt="...">
				<div class="carousel-caption d-none d-md-block">
					<h1>New Fashion 4</h1>
					<p><h6>당신을 위한 패션 제안 4</h6></p>
				</div>
			</div>
		</div>

		<button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
			<span class="carousel-control-prev-icon"></span>
		</button>

		<button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
			<span class="carousel-control-next-icon"></span>
		</button>
	</div>

	<div class="row bg-light m-0 p-1 fs-6 border">
		<div class="col">
			<div class="d-flex">
				<ul class="nav me-auto">
					<?
					for($i=1; $i<$n_menu; $i++)
					{
						echo("<li class='nav-item zoom_a'><a class='nav-link' href='menu.php?menu=$i'>{$a_menu[$i]}</a></li>");
					}
					?>
				</ul>

				<script>
				function check_findproduct_old() {
					if (!form1.find_text.value) {
						alert('검색어를 입력하세요');
						return;
					}
					form1.submit();
				}
				</script>

				<form name="form1" method="post" action="product_search.php">
					<div class="input-group input-group-sm pt-1">
						<span class="input-group-text" style="font-size:13px;">상품검색</span>
						<input type="text" name="find_text" value="" size="10" class="form-control form-control-sm">
						<button type="button" class="btn btn-sm btn-outline-secondary" style="font-size:13px;"
							onClick="check_findproduct_old();">Search</button>
					</div>
				</form>
			</div>
		</div>
	</div>

<?
}
?>