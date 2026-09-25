<?
include_once "common.php";
include "main_top.php";

if(!isset($a_state))
{
	$a_state = array("전체", "주문신청", "주문확인", "입금확인", "배송중", "주문완료", "주문취소");
	$n_state = count($a_state);
}

if(!function_exists("h"))
{
	function h($str)
	{
		return htmlspecialchars($str ?? "", ENT_QUOTES);
	}
}

$id = isset($_REQUEST["id"]) ? $_REQUEST["id"] : "";
$page = isset($_REQUEST["page"]) ? intval($_REQUEST["page"]) : 1;

$req_o_name = isset($_REQUEST["o_name"]) ? $_REQUEST["o_name"] : "";
$req_o_email = isset($_REQUEST["o_email"]) ? $_REQUEST["o_email"] : "";

$cookie_id = isset($_COOKIE["cookie_id"]) ? $_COOKIE["cookie_id"] : "";

$id_sql = mysqli_real_escape_string($db, $id);
$req_o_name_sql = mysqli_real_escape_string($db, $req_o_name);
$req_o_email_sql = mysqli_real_escape_string($db, $req_o_email);
$cookie_id_sql = mysqli_real_escape_string($db, $cookie_id);

if(!$id)
{
	echo("<script>
		alert('주문번호가 없습니다.');
		location.href='jumun.php';
	</script>");
	exit;
}

/*
	로그인 회원:
		member 테이블의 숫자 id와 jumun.member_id가 같아야 조회 가능

	비회원:
		member_id가 0/빈값이고, 주문자 이름 + 이메일이 맞아야 조회 가능
*/

$where_auth = "";

if($cookie_id)
{
	$member_id = 0;

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

	if($member_id <= 0)
	{
		echo("<script>
			alert('회원 정보를 확인할 수 없습니다.');
			location.href='jumun.php';
		</script>");
		exit;
	}

	$where_auth = " and member_id='$member_id' ";
}
else
{
	if(!$req_o_name || !$req_o_email)
	{
		echo("<script>
			alert('비회원 주문조회는 이름과 이메일 확인이 필요합니다.');
			location.href='jumun_login.php';
		</script>");
		exit;
	}

	$where_auth = "
		and (member_id='0' or member_id='' or member_id is null)
		and o_name='$req_o_name_sql'
		and o_email='$req_o_email_sql'
	";
}

$sql = "
	select *
	from jumun
	where id='$id_sql'
	$where_auth
";

$result = mysqli_query($db, $sql);

if(!$result)
	exit("에러: $sql<br>" . mysqli_error($db));

$row = mysqli_fetch_array($result);

if(!$row)
{
	echo("<script>
		alert('조회할 수 없는 주문입니다.');
		location.href='jumun.php';
	</script>");
	exit;
}

$jumun_id = $row["id"];
$jumunday = $row["jumunday"];

$product_names = isset($row["product_names"]) ? stripslashes($row["product_names"]) : "";
$product_nums = isset($row["product_nums"]) ? intval($row["product_nums"]) : 0;
$totalprice = isset($row["totalprice"]) ? intval($row["totalprice"]) : 0;

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
$card_okno = isset($row["card_okno"]) ? $row["card_okno"] : "";
$card_halbu = isset($row["card_halbu"]) ? intval($row["card_halbu"]) : 0;
$card_kind = isset($row["card_kind"]) ? intval($row["card_kind"]) : 0;
$bank_kind = isset($row["bank_kind"]) ? intval($row["bank_kind"]) : 0;
$bank_sender = isset($row["bank_sender"]) ? $row["bank_sender"] : "";

$card_name = "";
if($card_kind == 1) $card_name = "국민카드";
else if($card_kind == 2) $card_name = "신한카드";
else if($card_kind == 3) $card_name = "우리카드";
else if($card_kind == 4) $card_name = "하나카드";
else $card_name = "카드";

$bank_name = "";
if($bank_kind == 1) $bank_name = "국민은행";
else if($bank_kind == 2) $bank_name = "신한은행";
else $bank_name = "무통장입금";

$list_args = "page=$page";

if(!$cookie_id)
{
	$list_args .= "&o_name=" . urlencode($req_o_name) . "&o_email=" . urlencode($req_o_email);
}
?>

<section class="jumun-info-wrap">

	<div class="jumun-info-title">
		<div class="jumun-info-small">ORDER DETAIL</div>
		<h2>주문 상세내역</h2>
		<p>주문하신 상품과 결제 정보를 확인할 수 있습니다.</p>
	</div>

	<div class="jumun-info-card">

		<div class="jumun-info-section">
			<h3>주문 정보</h3>

			<div class="jumun-info-grid">

				<div class="jumun-info-row">
					<span>주문번호</span>
					<strong><?=h($jumun_id);?></strong>
				</div>

				<div class="jumun-info-row">
					<span>주문상태</span>
					<strong><?=h($state_text);?></strong>
				</div>

				<div class="jumun-info-row">
					<span>주문일자</span>
					<strong><?=h($jumunday);?></strong>
				</div>

				<div class="jumun-info-row">
					<span>주문상품</span>
					<strong><?=h($product_names);?></strong>
				</div>

			</div>
		</div>

		<div class="jumun-info-section">
			<h3>주문상품내역</h3>

			<table class="jumun-product-table">
				<tr>
					<th>상품정보</th>
					<th width="12%">판매가</th>
					<th width="10%">수량</th>
					<th width="14%">금액</th>
					<th width="18%">옵션</th>
				</tr>

<?
$sql2 = "
	select 
		js.*,
		p.name as pname,
		op1.name as opt_name1,
		op2.name as opt_name2
	from jumuns js
		left join product p on p.id = js.product_id
		left join opts op1 on op1.id = js.opts_id1
		left join opts op2 on op2.id = js.opts_id2
	where js.jumun_id = '$id_sql'
	order by js.id
";

$result2 = mysqli_query($db, $sql2);

if(!$result2)
	exit("에러: $sql2<br>" . mysqli_error($db));

while($row2 = mysqli_fetch_array($result2))
{
	$product_id = isset($row2["product_id"]) ? intval($row2["product_id"]) : 0;

	$num = isset($row2["num"]) ? intval($row2["num"]) : 1;
	$price = isset($row2["price"]) ? intval($row2["price"]) : 0;
	$prices = isset($row2["prices"]) ? intval($row2["prices"]) : $price * $num;

	if($product_id == 0)
	{
		$pname = "수수료";
	}
	else
	{
		$pname = isset($row2["pname"]) ? stripslashes($row2["pname"]) : "상품정보 없음";
	}

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
		$option_text = "-";
?>

				<tr>
					<td class="jumun-product-info">
						<strong><?=h($pname);?></strong>
						<span>NEONIX GAME MALL</span>
					</td>

					<td><?=number_format($price);?>원</td>
					<td><?=number_format($num);?></td>
					<td><?=number_format($prices);?>원</td>
					<td><?=h($option_text);?></td>
				</tr>

<?
}
?>

			</table>

			<div class="jumun-info-total">
				<span>총 결제금액</span>
				<strong><?=number_format($totalprice);?>원</strong>
			</div>
		</div>

		<div class="jumun-info-section">
			<h3>결제내역</h3>

			<div class="jumun-info-grid">

				<div class="jumun-info-row">
					<span>결제방식</span>
					<strong><?=$pay_kind == 0 ? "카드" : "무통장";?></strong>
				</div>

				<div class="jumun-info-row">
					<span>결제금액</span>
					<strong><?=number_format($totalprice);?>원</strong>
				</div>

<?
if($pay_kind == 0)
{
?>
				<div class="jumun-info-row">
					<span>카드종류</span>
					<strong><?=h($card_name);?></strong>
				</div>

				<div class="jumun-info-row">
					<span>승인번호</span>
					<strong><?=h($card_okno);?></strong>
				</div>

				<div class="jumun-info-row">
					<span>할부</span>
					<strong><?=$card_halbu ? h($card_halbu) . "개월" : "일시불";?></strong>
				</div>
<?
}
else
{
?>
				<div class="jumun-info-row">
					<span>은행</span>
					<strong><?=h($bank_name);?></strong>
				</div>

				<div class="jumun-info-row">
					<span>입금자</span>
					<strong><?=h($bank_sender);?></strong>
				</div>
<?
}
?>

			</div>
		</div>

		<div class="jumun-info-section">
			<h3>주문자</h3>

			<div class="jumun-info-grid">

				<div class="jumun-info-row">
					<span>주문자</span>
					<strong><?=h($o_name);?></strong>
				</div>

				<div class="jumun-info-row">
					<span>핸드폰</span>
					<strong><?=h($o_tel);?></strong>
				</div>

				<div class="jumun-info-row">
					<span>이메일</span>
					<strong><?=h($o_email);?></strong>
				</div>

				<div class="jumun-info-row full">
					<span>주소</span>
					<strong>(<?=h($o_zip);?>) <?=h($o_juso);?></strong>
				</div>

			</div>
		</div>

		<div class="jumun-info-section">
			<h3>주문 처리 정보</h3>

			<div class="jumun-info-grid">

				<div class="jumun-info-row">
					<span>수취인</span>
					<strong><?=h($r_name);?></strong>
				</div>

				<div class="jumun-info-row">
					<span>핸드폰</span>
					<strong><?=h($r_tel);?></strong>
				</div>

				<div class="jumun-info-row full">
					<span>주소</span>
					<strong>(<?=h($r_zip);?>) <?=h($r_juso);?></strong>
				</div>

				<div class="jumun-info-row full">
					<span>메모</span>
					<strong><?=nl2br(h($memo));?></strong>
				</div>

			</div>
		</div>

	</div>

	<div class="jumun-info-buttons">
		<a href="jumun.php?<?=$list_args;?>" class="jumun-info-btn">
			목록으로
		</a>

		<a href="main.php" class="jumun-info-btn main">
			스토어로 이동
		</a>
	</div>

</section>

<?
include "main_bottom.php";
?>