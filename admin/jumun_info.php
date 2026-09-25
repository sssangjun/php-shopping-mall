<?
include "../common.php";

$id = isset($_REQUEST["id"]) ? $_REQUEST["id"] : "";

$page = isset($_REQUEST["page"]) ? $_REQUEST["page"] : 1;
$sel1 = isset($_REQUEST["sel1"]) ? $_REQUEST["sel1"] : 0;
$sel2 = isset($_REQUEST["sel2"]) ? $_REQUEST["sel2"] : 1;
$text1 = isset($_REQUEST["text1"]) ? $_REQUEST["text1"] : "";
$day1 = isset($_REQUEST["day1"]) ? $_REQUEST["day1"] : "";
$day2 = isset($_REQUEST["day2"]) ? $_REQUEST["day2"] : "";

$args = "page=$page&sel1=$sel1&sel2=$sel2&text1=" . urlencode($text1) . "&day1=$day1&day2=$day2";

if(!isset($a_state))
{
	$a_state = array("전체", "주문신청", "주문확인", "입금확인", "배송중", "주문완료", "주문취소");
	$n_state = count($a_state);
}

function h($str)
{
	return htmlspecialchars($str ?? "", ENT_QUOTES);
}

$id_sql = mysqli_real_escape_string($db, $id);

$sql = "select * from jumun where id='$id_sql'";
$result = mysqli_query($db, $sql);

if(!$result) exit("에러: $sql<br>" . mysqli_error($db));

$row = mysqli_fetch_array($result);

if(!$row)
{
	echo("<script>
		alert('주문 정보를 찾을 수 없습니다.');
		location.href='jumun.php?$args';
	</script>");
	exit;
}

$jumun_id = $row["id"];
$jumunday = $row["jumunday"];

$state = isset($row["state"]) ? intval($row["state"]) : 1;
$state_text = isset($a_state[$state]) ? $a_state[$state] : "주문신청";

$o_name = isset($row["o_name"]) ? $row["o_name"] : "";
$o_tel = isset($row["o_tel"]) ? $row["o_tel"] : "";
$o_email = isset($row["o_email"]) ? $row["o_email"] : "";
$o_zip = isset($row["o_zip"]) ? $row["o_zip"] : "";
$o_juso = isset($row["o_juso"]) ? $row["o_juso"] : "";

$r_name = isset($row["r_name"]) ? $row["r_name"] : "";
$r_tel = isset($row["r_tel"]) ? $row["r_tel"] : "";
$r_email = isset($row["r_email"]) ? $row["r_email"] : "";
$r_zip = isset($row["r_zip"]) ? $row["r_zip"] : "";
$r_juso = isset($row["r_juso"]) ? $row["r_juso"] : "";

$memo = isset($row["memo"]) ? $row["memo"] : "";

$pay_kind = isset($row["pay_kind"]) ? intval($row["pay_kind"]) : 0;

$card_kind = isset($row["card_kind"]) ? intval($row["card_kind"]) : 0;
$card_no = isset($row["card_no"]) ? $row["card_no"] : "";
$card_month = isset($row["card_month"]) ? $row["card_month"] : "";
$card_year = isset($row["card_year"]) ? $row["card_year"] : "";
$card_halbu = isset($row["card_halbu"]) ? $row["card_halbu"] : "";

$bank_kind = isset($row["bank_kind"]) ? intval($row["bank_kind"]) : 0;
$bank_sender = isset($row["bank_sender"]) ? $row["bank_sender"] : "";

$card_name = "";
if($card_kind == 1) $card_name = "국민카드";
else if($card_kind == 2) $card_name = "신한카드";
else if($card_kind == 3) $card_name = "우리카드";
else if($card_kind == 4) $card_name = "하나카드";

$bank_name = "";
if($bank_kind == 1) $bank_name = "국민은행 111-00000-0000";
else if($bank_kind == 2) $bank_name = "신한은행 222-00000-0000";

$member_kind = "비회원";
if(isset($row["member_id"]) && $row["member_id"])
{
	$member_kind = "회원";
}
?>

<!doctype html>
<html lang="kr">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>NEONIX Admin</title>

	<link href="../css/bootstrap.min.css" rel="stylesheet">
	<link href="../css/my.css" rel="stylesheet">

	<script src="../js/jquery-3.7.1.min.js"></script>
	<script src="../js/bootstrap.bundle.min.js"></script>
	<script src="../js/my.js"></script>

	<style>
		@media print {
			.no-print {
				display:none !important;
			}

			body {
				background:#ffffff !important;
			}

			.container {
				width:100% !important;
				max-width:100% !important;
			}

			table {
				font-size:12px !important;
			}
		}
	</style>
</head>

<body>

<div class="container">

<script>
	document.write(admin_menu());
</script>

<div class="row mx-1 justify-content-center">
	<div class="col-sm-10" align="center">

		<h4 class="m-0 mb-3">
			주문 ( <b><?=h($jumun_id);?></b> )
		</h4>

		<table class="table table-sm table-bordered mb-3">
			<tr>
				<td width="15%" class="bg-light">상태</td>
				<td width="35%"><?=h($state_text);?></td>
				<td width="15%" class="bg-light">주문일</td>
				<td width="35%"><?=h($jumunday);?></td>
			</tr>
		</table>

		<table class="table table-sm table-bordered mb-2">
			<tr>
				<td width="15%" class="bg-light"><b>주문자</b></td>
				<td width="35%"><?=h($o_name);?></td>
				<td width="15%" class="bg-light">구분</td>
				<td width="35%"><?=h($member_kind);?></td>
			</tr>

			<tr>
				<td class="bg-light">전화</td>
				<td><?=h($o_tel);?></td>
				<td class="bg-light">E-Mail</td>
				<td><?=h($o_email);?></td>
			</tr>

			<tr>
				<td class="bg-light">주소</td>
				<td align="left" colspan="3">
					&nbsp;(<?=h($o_zip);?>) <?=h($o_juso);?>
				</td>
			</tr>
		</table>

		<table class="table table-sm table-bordered mb-3">
			<tr>
				<td width="15%" class="bg-light"><b>수신자</b></td>
				<td width="35%"><?=h($r_name);?></td>
				<td width="15%" class="bg-light"></td>
				<td width="35%"></td>
			</tr>

			<tr>
				<td class="bg-light">전화</td>
				<td><?=h($r_tel);?></td>
				<td class="bg-light">E-Mail</td>
				<td><?=h($r_email);?></td>
			</tr>

			<tr>
				<td class="bg-light">주소</td>
				<td align="left" colspan="3">
					&nbsp;(<?=h($r_zip);?>) <?=h($r_juso);?>
				</td>
			</tr>

			<tr height="50">
				<td class="bg-light">메모</td>
				<td align="left" valign="top" colspan="3">
					&nbsp;<?=nl2br(h($memo));?>
				</td>
			</tr>
		</table>

		<table class="table table-sm table-bordered mb-3">
<?
if($pay_kind == 0)
{
?>
			<tr>
				<td width="15%" class="bg-light"><b>카드</b></td>
				<td width="35%"><?=h($card_name);?></td>
				<td width="15%" class="bg-light">승인</td>
				<td width="35%"><?=h($card_no);?></td>
			</tr>

			<tr>
				<td class="bg-light">할부</td>
				<td>
<?
	if($card_halbu == "" || $card_halbu == "0")
		echo("일시불");
	else
		echo(h($card_halbu) . "개월");
?>
				</td>

				<td class="bg-light">카드기간</td>
				<td><?=h($card_month);?>월 / <?=h($card_year);?>년</td>
			</tr>
<?
}
else
{
?>
			<tr>
				<td width="15%" class="bg-light"><b>무통장</b></td>
				<td width="35%"><?=h($bank_name);?></td>
				<td width="15%" class="bg-light">입금자</td>
				<td width="35%"><?=h($bank_sender);?></td>
			</tr>
<?
}
?>
		</table>

		<table class="table table-sm table-bordered mb-3">
			<tr class="bg-light">
				<td>제품명</td>
				<td width="10%">수량</td>
				<td width="10%">단가</td>
				<td width="10%">금액</td>
				<td width="10%">할인</td>
				<td width="20%">옵션</td>
			</tr>

<?
$sql = "
	select 
		js.*,
		p.name as product_name,
		p.discount as product_discount,
		op1.name as opt_name1,
		op2.name as opt_name2
	from jumuns js
		left join product p on js.product_id = p.id
		left join opts op1 on js.opts_id1 = op1.id
		left join opts op2 on js.opts_id2 = op2.id
	where js.jumun_id = '$id_sql'
	order by js.id
";

$result = mysqli_query($db, $sql);

if(!$result) exit("에러: $sql<br>" . mysqli_error($db));

$sum = 0;

while($row2 = mysqli_fetch_array($result))
{
	$product_id = isset($row2["product_id"]) ? intval($row2["product_id"]) : 0;

	$num = isset($row2["num"]) ? intval($row2["num"]) : 1;
	if($num < 1) $num = 1;

	$price = isset($row2["price"]) ? intval($row2["price"]) : 0;
	$prices = isset($row2["prices"]) ? intval($row2["prices"]) : $price * $num;

	if(!$prices)
		$prices = $price * $num;

	$sum += $prices;

	if($product_id == 0)
	{
		$product_name = "수수료";
	}
	else
	{
		$product_name = isset($row2["product_name"]) ? stripslashes($row2["product_name"]) : "상품정보 없음";
	}

	$discount = "";

	if(isset($row2["discount"]))
		$discount = $row2["discount"];
	else if(isset($row2["product_discount"]))
		$discount = $row2["product_discount"];

	$opt_name1 = isset($row2["opt_name1"]) ? $row2["opt_name1"] : "";
	$opt_name2 = isset($row2["opt_name2"]) ? $row2["opt_name2"] : "";

	$option_text = "";

	if($opt_name1) $option_text .= $opt_name1;

	if($opt_name2)
	{
		if($option_text) $option_text .= " / ";
		$option_text .= $opt_name2;
	}

	if(!$option_text)
		$option_text = "";
?>

			<tr>
				<td align="left"><?=h($product_name);?></td>
				<td><?=number_format($num);?></td>
				<td align="right"><?=number_format($price);?></td>
				<td align="right"><?=number_format($prices);?></td>
				<td>
<?
	if($discount !== "" && intval($discount) > 0)
		echo(h($discount) . "%");
?>
				</td>
				<td><?=h($option_text);?></td>
			</tr>

<?
}
?>

		</table>

		<table class="table table-sm table-bordered mb-3 p-2">
			<tr>
				<td width="15%" class="bg-light">총금액</td>
				<td width="85%" align="right" style="font-size:18px">
					<b><?=number_format($sum);?> 원</b>&nbsp;
				</td>
			</tr>
		</table>

		<div class="no-print">
			<a href="javascript:print();" class="btn btn-sm btn-dark text-white my-2">
				&nbsp;프린트&nbsp;
			</a>&nbsp;

			<a href="jumun.php?<?=$args;?>" class="btn btn-sm btn-outline-dark my-2">
				&nbsp;돌아가기&nbsp;
			</a>
		</div>

	</div>
</div>

</div>

</body>
</html>