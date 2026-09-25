<?
error_reporting(E_ALL);
ini_set("display_errors", 1);

include "common.php";

$cart = isset($_COOKIE["cart"]) ? $_COOKIE["cart"] : array();
$n_cart = isset($_COOKIE["n_cart"]) ? intval($_COOKIE["n_cart"]) : 0;

$cookie_id = isset($_COOKIE["cookie_id"]) ? $_COOKIE["cookie_id"] : "";

/*
	로그인 회원이면 member 테이블에서 실제 회원 번호(id)를 찾아서
	jumun.member_id에 저장한다.
	비회원이면 0으로 저장한다.
*/
$member_id = 0;

if($cookie_id)
{
	$cookie_id_sql = mysqli_real_escape_string($db, $cookie_id);

	$sql_member = "
		select id
		from member
		where uid='$cookie_id_sql' or id='$cookie_id_sql'
		limit 1
	";

	$result_member = mysqli_query($db, $sql_member);

	if(!$result_member)
		exit("에러: $sql_member<br>" . mysqli_error($db));

	$row_member = mysqli_fetch_array($result_member);

	if($row_member)
		$member_id = intval($row_member["id"]);
}

$today = date("Y-m-d");
$today_id = date("ymd");

$max_id = "";

$sql = "select max(id) as max_id from jumun where id like '$today_id%'";
$result = mysqli_query($db, $sql);
if(!$result) exit("에러: $sql<br>" . mysqli_error($db));

$row = mysqli_fetch_array($result);
if($row["max_id"])
{
	$max_id = $row["max_id"];
}

$sql = "select max(jumun_id) as max_id from jumuns where jumun_id like '$today_id%'";
$result = mysqli_query($db, $sql);
if(!$result) exit("에러: $sql<br>" . mysqli_error($db));

$row = mysqli_fetch_array($result);
if($row["max_id"])
{
	if(!$max_id || $row["max_id"] > $max_id)
	{
		$max_id = $row["max_id"];
	}
}

if($max_id)
{
	$num = intval(substr($max_id, -4)) + 1;
	$jumun_id = $today_id . sprintf("%04d", $num);
}
else
{
	$jumun_id = $today_id . "0001";
}

$total = 0;
$product_nums = 0;
$product_names = "";

for($i=1; $i<=$n_cart; $i++)
{
	if(!isset($cart[$i]) || !$cart[$i]) continue;

	$tmp = explode("^", $cart[$i]);

	$product_id = isset($tmp[0]) ? intval($tmp[0]) : 0;
	$num = isset($tmp[1]) ? intval($tmp[1]) : 1;
	$opts_id1 = isset($tmp[2]) ? intval($tmp[2]) : 0;
	$opts_id2 = isset($tmp[3]) ? intval($tmp[3]) : 0;

	if($product_id <= 0) continue;
	if($num < 1) $num = 1;

	$sql = "select * from product where id='$product_id'";
	$result = mysqli_query($db, $sql);
	if(!$result) exit("에러: $sql<br>" . mysqli_error($db));

	$row = mysqli_fetch_array($result);
	if(!$row) continue;

	$name = stripslashes($row["name"]);
	$price = intval($row["price"]);
	$discount = intval($row["discount"]);

	if($row["icon_sale"] == 1)
		$price = round($price * (100 - $discount) / 100, -3);

	if($opts_id1 > 0)
	{
		$sql_opt = "select price from opts where id='$opts_id1'";
		$result_opt = mysqli_query($db, $sql_opt);

		if($result_opt)
		{
			$row_opt = mysqli_fetch_array($result_opt);

			if($row_opt)
				$price = $price + intval($row_opt["price"]);
		}
	}

	if($opts_id2 > 0)
	{
		$sql_opt = "select price from opts where id='$opts_id2'";
		$result_opt = mysqli_query($db, $sql_opt);

		if($result_opt)
		{
			$row_opt = mysqli_fetch_array($result_opt);

			if($row_opt)
				$price = $price + intval($row_opt["price"]);
		}
	}

	$prices = $price * $num;
	$total = $total + $prices;

	$product_nums++;

	if($product_nums == 1)
		$product_names = $name;

	$sql = "insert into jumuns
		(jumun_id, product_id, num, price, prices, discount, opts_id1, opts_id2)
		values
		('$jumun_id', '$product_id', '$num', '$price', '$prices', '$discount', '$opts_id1', '$opts_id2')";

	$result2 = mysqli_query($db, $sql);
	if(!$result2) exit("에러: $sql<br>" . mysqli_error($db));

	setcookie("cart[$i]", "");
}
if($product_nums < 1)
{
	echo("<script>
		alert('장바구니에 상품이 없습니다.');
		location.href='cart.php';
	</script>");
	exit;
}

if($product_nums > 1)
	$product_names = $product_names . " 외 " . ($product_nums - 1);

if($total >= $max_baesongbi)
	$baesong = 0;
else
	$baesong = $baesongbi;

if($baesong > 0)
{
	$sql = "insert into jumuns
		(jumun_id, product_id, num, price, prices, discount, opts_id1, opts_id2)
		values
		('$jumun_id', '0', '1', '$baesong', '$baesong', '0', '0', '0')";

	$result = mysqli_query($db, $sql);
	if(!$result) exit("에러: $sql<br>" . mysqli_error($db));
}

$totalprice = $total + $baesong;

$o_name = addslashes($_REQUEST["o_name"]);
$o_tel = addslashes($_REQUEST["o_tel"]);
$o_email = addslashes($_REQUEST["o_email"]);
$o_zip = addslashes($_REQUEST["o_zip"]);
$o_juso = addslashes($_REQUEST["o_juso"]);

$r_name = addslashes($_REQUEST["r_name"]);
$r_tel = addslashes($_REQUEST["r_tel"]);
$r_email = addslashes($_REQUEST["r_email"]);
$r_zip = addslashes($_REQUEST["r_zip"]);
$r_juso = addslashes($_REQUEST["r_juso"]);
$memo = addslashes($_REQUEST["memo"]);

$pay_kind = isset($_REQUEST["pay_kind"]) ? intval($_REQUEST["pay_kind"]) : 0;
$card_kind = isset($_REQUEST["card_kind"]) ? intval($_REQUEST["card_kind"]) : 0;
$card_halbu = isset($_REQUEST["card_halbu"]) ? intval($_REQUEST["card_halbu"]) : 0;
$bank_kind = isset($_REQUEST["bank_kind"]) ? intval($_REQUEST["bank_kind"]) : 0;
$bank_sender = isset($_REQUEST["bank_sender"]) ? addslashes($_REQUEST["bank_sender"]) : "";

$card_okno = "";

if($pay_kind == 0)
	$card_okno = $jumun_id;

$member_id = intval($member_id);

$sql = "insert into jumun
	(id, member_id, jumunday, product_names, product_nums,
	o_name, o_tel, o_email, o_zip, o_juso,
	r_name, r_tel, r_email, r_zip, r_juso, memo,
	pay_kind, card_okno, card_halbu, card_kind, bank_kind, bank_sender,
	totalprice, state)
	values
	('$jumun_id', '$member_id', '$today', '$product_names', '$product_nums',
	'$o_name', '$o_tel', '$o_email', '$o_zip', '$o_juso',
	'$r_name', '$r_tel', '$r_email', '$r_zip', '$r_juso', '$memo',
	'$pay_kind', '$card_okno', '$card_halbu', '$card_kind', '$bank_kind', '$bank_sender',
	'$totalprice', '1')";

$result = mysqli_query($db, $sql);
if(!$result) exit("에러: $sql<br>" . mysqli_error($db));

setcookie("n_cart", 0);

echo("<script>location.href='order_ok.php?id=$jumun_id'</script>");
?>