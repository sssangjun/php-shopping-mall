<?
include "../common.php";

if(!isset($a_state))
{
	$a_state = array("전체", "주문신청", "주문확인", "입금확인", "배송중", "주문완료", "주문취소");
	$n_state = count($a_state);
}

$page = isset($_REQUEST["page"]) ? intval($_REQUEST["page"]) : 1;
if($page < 1) $page = 1;

$day1 = isset($_REQUEST["day1"]) ? $_REQUEST["day1"] : date("Y-m-d", strtotime("-1 month"));
$day2 = isset($_REQUEST["day2"]) ? $_REQUEST["day2"] : date("Y-m-d");

$sel1 = isset($_REQUEST["sel1"]) ? intval($_REQUEST["sel1"]) : 0;
$sel2 = isset($_REQUEST["sel2"]) ? intval($_REQUEST["sel2"]) : 1;
$text1 = isset($_REQUEST["text1"]) ? $_REQUEST["text1"] : "";

$text1_sql = mysqli_real_escape_string($db, $text1);

$where = " where jumunday between '$day1' and '$day2' ";

if($sel1 > 0)
{
	$where .= " and state=$sel1 ";
}

if($text1_sql)
{
	if($sel2 == 1)
		$where .= " and id like '%$text1_sql%' ";
	else if($sel2 == 2)
		$where .= " and o_name like '%$text1_sql%' ";
	else if($sel2 == 3)
		$where .= " and product_names like '%$text1_sql%' ";
}

$sql = "select count(*) as cnt from jumun $where";
$result = mysqli_query($db, $sql);
if(!$result) exit("에러: $sql<br>" . mysqli_error($db));

$row = mysqli_fetch_array($result);
$count = intval($row["cnt"]);

$page_line = 5;
$page_block = 5;

$pages = ceil($count / $page_line);
if($pages < 1) $pages = 1;
if($page > $pages) $page = $pages;

$first = ($page - 1) * $page_line;

$args = "day1=$day1&day2=$day2&sel1=$sel1&sel2=$sel2&text1=" . urlencode($text1);

$sql = "
	select j.*,
		(
			select ifnull(sum(num), 0)
			from jumuns
			where jumun_id = j.id and product_id <> 0
		) as product_count
	from jumun j
	$where
	order by id desc
	limit $first, $page_line
";

$result = mysqli_query($db, $sql);
if(!$result) exit("에러: $sql<br>" . mysqli_error($db));
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
</head>

<body>

<div class="container">

<script>
	document.write(admin_menu());
</script>

<script>
function go_update(id, pos)
{
	state = form1.state[pos].value;

	location.href = "jumun_update.php?id=" + id +
		"&state=" + state +
		"&page=" + form1.page.value +
		"&sel1=" + form1.sel1.value +
		"&sel2=" + form1.sel2.value +
		"&text1=" + form1.text1.value +
		"&day1=" + form1.day1.value +
		"&day2=" + form1.day2.value;
}
</script>

<div class="row mx-1 justify-content-center">
	<div class="col" align="center">

		<h4 class="m-0 mb-3">주문 관리</h4>

		<form name="form1" method="post" action="jumun.php">

		<input type="hidden" name="page" value="<?=$page;?>">

		<table class="table table-sm table-borderless m-0 p-0">
			<tr>
				<td width="20%" align="left" style="padding-top:8px">
					주문수 : <font color="red"><?=$count;?></font>
				</td>

				<td align="right">

					기간:
					<div class="d-inline-flex">
						<input type="date" name="day1" value="<?=$day1;?>"
							class="form-control form-control-sm" style="width:120px">~
						<input type="date" name="day2" value="<?=$day2;?>"
							class="form-control form-control-sm" style="width:120px">
					</div>

					<div class="d-inline-flex">
						<select name="sel1" class="form-select form-select-sm bg-light myfs12" style="width:100px">
<?
for($i=0; $i<$n_state; $i++)
{
	$selected = ($i == $sel1) ? "selected" : "";
?>
							<option value="<?=$i;?>" <?=$selected;?>><?=$a_state[$i];?></option>
<?
}
?>
						</select>&nbsp;

						<select name="sel2" class="form-select bg-light myfs12" style="width:105px">
							<option value="1" <?=$sel2==1 ? "selected" : "";?>>주문번호</option>
							<option value="2" <?=$sel2==2 ? "selected" : "";?>>고객명</option>
							<option value="3" <?=$sel2==3 ? "selected" : "";?>>상품명</option>
						</select>
					</div>

					<div class="d-inline-flex">
						<div class="input-group input-group-sm">
							<input type="text" name="text1" value="<?=$text1;?>"
								class="form-control myfs12" style="width:100px"
								onkeydown="if(event.keyCode == 13) { form1.submit(); }">

							<button class="btn mycolor1 myfs12" type="button"
								onclick="form1.page.value=1; form1.submit();">
								검색
							</button>
						</div>
					</div>

				</td>
			</tr>
		</table>

		<table class="table table-sm table-bordered table-hover my-1">
			<tr class="bg-light">
				<td>주문번호</td>
				<td>주문일</td>
				<td width="30%">제품명</td>
				<td width="5%">제품수</td>
				<td>금액</td>
				<td>주문자</td>
				<td width="5%">결제</td>
				<td width="20%">주문상태</td>
				<td width="5%">삭제</td>
			</tr>

<?
$pos = 0;

while($row = mysqli_fetch_array($result))
{
	$id = $row["id"];
	$jumunday = $row["jumunday"];
	$product_names = stripslashes($row["product_names"]);
	$product_count = intval($row["product_count"]);
	$totalprice = intval($row["totalprice"]);
	$o_name = $row["o_name"];

	$pay_kind = isset($row["pay_kind"]) ? intval($row["pay_kind"]) : 0;
	$pay_text = ($pay_kind == 0) ? "카드" : "무통장";

	$state = isset($row["state"]) ? intval($row["state"]) : 1;

	$color = "black";
	if($state == 5) $color = "blue";
	if($state == 6) $color = "red";
?>

			<tr>
				<td class="mywordwrap">
					<a href="jumun_info.php?id=<?=$id;?>&<?=$args;?>&page=<?=$page;?>" style="color:#0085dd">
						<?=$id;?>
					</a>
				</td>

				<td><?=$jumunday;?></td>

				<td align="left" class="mywordwrap">
					<?=$product_names;?>
				</td>

				<td><?=$product_count;?></td>

				<td align="right" class="mywordwrap">
					<?=number_format($totalprice);?>
				</td>

				<td><?=$o_name;?></td>

				<td><?=$pay_text;?></td>

				<td>
					<div class="d-sm-inline-flex">

						<select name="state" class="form-select form-select-sm myfs12 me-1" style="color:<?=$color;?>">
<?
	for($i=1; $i<$n_state; $i++)
	{
		$selected = ($i == $state) ? "selected" : "";
?>
							<option value="<?=$i;?>" <?=$selected;?>><?=$a_state[$i];?></option>
<?
	}
?>
						</select>

						<a href="javascript:go_update('<?=$id;?>', <?=$pos;?>);"
							class="btn btn-sm mybutton-blue" style="width:50px;">
							수정
						</a>

					</div>
				</td>

				<td>
					<a href="jumun_delete.php?id=<?=$id;?>&<?=$args;?>&page=<?=$page;?>"
						class="btn btn-sm mybutton-red"
						onclick="return confirm('삭제할까요 ?');">
						삭제
					</a>
				</td>
			</tr>

<?
	$pos++;
}

if($count == 0)
{
?>
			<tr>
				<td colspan="9" height="80" align="center">
					검색된 주문이 없습니다.
				</td>
			</tr>
<?
}
?>

		</table>

		<input type="hidden" name="state">

		</form>

		<nav>
			<ul class="pagination pagination-sm justify-content-center my-3">

<?
$start_page = floor(($page - 1) / $page_block) * $page_block + 1;
$end_page = $start_page + $page_block - 1;
if($end_page > $pages) $end_page = $pages;

if($start_page > 1)
{
	$prev_page = $start_page - 1;
?>
				<li class="page-item">
					<a class="page-link" href="jumun.php?page=<?=$prev_page;?>&<?=$args;?>">◁</a>
				</li>
<?
}

for($i=$start_page; $i<=$end_page; $i++)
{
	if($i == $page)
	{
?>
				<li class="page-item active">
					<span class="page-link mycolor1"><?=$i;?></span>
				</li>
<?
	}
	else
	{
?>
				<li class="page-item">
					<a class="page-link" href="jumun.php?page=<?=$i;?>&<?=$args;?>"><?=$i;?></a>
				</li>
<?
	}
}

if($end_page < $pages)
{
	$next_page = $end_page + 1;
?>
				<li class="page-item">
					<a class="page-link" href="jumun.php?page=<?=$next_page;?>&<?=$args;?>">▷</a>
				</li>
<?
}
?>

			</ul>
		</nav>

	</div>
</div>

</div>

</body>
</html>