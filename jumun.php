<?
include_once "common.php";
include "main_top.php";

if(!isset($a_state))
{
	$a_state = array("전체", "주문신청", "주문확인", "입금확인", "배송중", "주문완료", "주문취소");
	$n_state = count($a_state);
}

function h($str)
{
	return htmlspecialchars($str ?? "", ENT_QUOTES);
}

$cookie_id = isset($_COOKIE["cookie_id"]) ? $_COOKIE["cookie_id"] : "";

$o_name = isset($_REQUEST["o_name"]) ? $_REQUEST["o_name"] : "";
$o_email = isset($_REQUEST["o_email"]) ? $_REQUEST["o_email"] : "";

$page = isset($_REQUEST["page"]) ? intval($_REQUEST["page"]) : 1;
if($page < 1) $page = 1;

$page_line = 5;
$page_block = 5;

$o_name_sql = mysqli_real_escape_string($db, $o_name);
$o_email_sql = mysqli_real_escape_string($db, $o_email);
$cookie_id_sql = mysqli_real_escape_string($db, $cookie_id);

$where = "";
$args = "";

/*
	로그인 회원 주문조회 보안 처리

	프로젝트마다 jumun.member_id에
	회원번호(id)가 들어가기도 하고,
	회원아이디(uid)가 들어가기도 해서
	현재 로그인한 회원의 id / uid 둘 다 확인한다.
*/

if($cookie_id)
{
	$member_keys = array();

	// cookie_id 자체도 후보로 넣음
	$member_keys[] = $cookie_id;

	// member 테이블에서 현재 로그인 회원의 id, uid 확인
	$sql_member = "
		select id, uid
		from member
		where id='$cookie_id_sql' or uid='$cookie_id_sql'
		limit 1
	";

	$result_member = mysqli_query($db, $sql_member);

	if($result_member)
	{
		$row_member = mysqli_fetch_array($result_member);

		if($row_member)
		{
			if(isset($row_member["id"]) && $row_member["id"] !== "")
				$member_keys[] = $row_member["id"];

			if(isset($row_member["uid"]) && $row_member["uid"] !== "")
				$member_keys[] = $row_member["uid"];
		}
	}

	// 중복 제거 + 빈 값 제거
	$member_keys = array_unique($member_keys);

	$member_where = array();

	foreach($member_keys as $key)
	{
		if($key === "" || $key === null) continue;

		$key_sql = mysqli_real_escape_string($db, $key);
		$member_where[] = "member_id='$key_sql'";
	}

	if(count($member_where) == 0)
	{
		$where = " where 1=0 ";
	}
	else
	{
		$where = " where member_id<>'' and (" . implode(" or ", $member_where) . ") ";
	}

	$args = "";
}
else
{
	if(!$o_name || !$o_email)
	{
		echo("<script>
			alert('비회원 주문조회는 이름과 이메일을 입력해야 합니다.');
			location.href='jumun_login.php';
		</script>");
		exit;
	}

	/*
		비회원은 회원 주문이 섞여 나오면 안 되므로
		member_id가 비어있는 주문만 조회
	*/

	$where = "
		where 
			(member_id='' or member_id is null or member_id='0')
			and o_name='$o_name_sql'
			and o_email='$o_email_sql'
	";

	$args = "o_name=" . urlencode($o_name) . "&o_email=" . urlencode($o_email);
}

$sql = "select count(*) as cnt from jumun $where";
$result = mysqli_query($db, $sql);

if(!$result) exit("에러: $sql<br>" . mysqli_error($db));

$row = mysqli_fetch_array($result);
$count = intval($row["cnt"]);

$pages = ceil($count / $page_line);
if($pages < 1) $pages = 1;
if($page > $pages) $page = $pages;

$first = ($page - 1) * $page_line;

$sql = "
	select *
	from jumun
	$where
	order by id desc
	limit $first, $page_line
";

$result = mysqli_query($db, $sql);

if(!$result) exit("에러: $sql<br>" . mysqli_error($db));
?>

<section class="jumun-list-wrap">

	<div class="jumun-list-title">
		<div class="jumun-list-small">ORDER HISTORY</div>
		<h2>주문조회</h2>
		<p>주문한 게임과 결제 상태를 확인할 수 있습니다.</p>
	</div>

	<div class="jumun-list-card">

		<div class="jumun-list-head">
			<div>
				<strong>주문수</strong>
				<span><?=number_format($count);?>건</span>
			</div>

			<a href="main.php">스토어로 이동</a>
		</div>

		<div class="jumun-list-table">

			<div class="jumun-list-row jumun-list-row-head">
				<div>주문일</div>
				<div>주문번호</div>
				<div>제품정보</div>
				<div>결제금액</div>
				<div>주문상태</div>
			</div>

<?
while($row = mysqli_fetch_array($result))
{
	$id = $row["id"];
	$jumunday = $row["jumunday"];

	$product_names = isset($row["product_names"]) ? stripslashes($row["product_names"]) : "";
	$totalprice = isset($row["totalprice"]) ? intval($row["totalprice"]) : 0;

	$state = isset($row["state"]) ? intval($row["state"]) : 1;
	$state_text = isset($a_state[$state]) ? $a_state[$state] : "주문신청";

	$state_class = "normal";
	if($state == 5) $state_class = "complete";
	if($state == 6) $state_class = "cancel";

	$info_args = "id=$id&page=$page";
	if($args) $info_args .= "&" . $args;
?>

			<div class="jumun-list-row">

				<div>
					<?=h($jumunday);?>
				</div>

				<div>
					<a href="jumun_info.php?<?=$info_args;?>" class="jumun-list-id">
						<?=h($id);?>
					</a>
				</div>

				<div class="jumun-list-product">
					<?=h($product_names);?>
				</div>

				<div class="jumun-list-price">
					<?=number_format($totalprice);?>원
				</div>

				<div>
					<span class="jumun-state <?=$state_class;?>">
						<?=h($state_text);?>
					</span>
				</div>

			</div>

<?
}

if($count == 0)
{
?>
			<div class="jumun-list-empty">
				조회된 주문 내역이 없습니다.
			</div>
<?
}
?>

		</div>

	</div>

<?
$start_page = floor(($page - 1) / $page_block) * $page_block + 1;
$end_page = $start_page + $page_block - 1;

if($end_page > $pages)
	$end_page = $pages;
?>

	<div class="jumun-pagination">

<?
if($start_page > 1)
{
	$prev_page = $start_page - 1;
	$link_args = "page=$prev_page";

	if($args)
		$link_args .= "&" . $args;
?>
		<a href="jumun.php?<?=$link_args;?>">◀</a>
<?
}

for($i=$start_page; $i<=$end_page; $i++)
{
	$link_args = "page=$i";

	if($args)
		$link_args .= "&" . $args;

	if($i == $page)
	{
?>
		<span><?=$i;?></span>
<?
	}
	else
	{
?>
		<a href="jumun.php?<?=$link_args;?>"><?=$i;?></a>
<?
	}
}

if($end_page < $pages)
{
	$next_page = $end_page + 1;
	$link_args = "page=$next_page";

	if($args)
		$link_args .= "&" . $args;
?>
		<a href="jumun.php?<?=$link_args;?>">▶</a>
<?
}
?>

	</div>

</section>

<?
include "main_bottom.php";
?>