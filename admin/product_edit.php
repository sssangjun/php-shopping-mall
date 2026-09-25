<?
include "../common.php";

$id = $_REQUEST["id"];

$sql = "select * from product where id='$id'";
$result = mysqli_query($db, $sql);
if(!$result) exit("에러: $sql");

$row = mysqli_fetch_array($result);

$name = stripslashes($row["name"]);
$contents = stripslashes($row["contents"]);

$sql1 = "select * from opt order by name";
$result1 = mysqli_query($db, $sql1);
if(!$result1) exit("에러: $sql1");
?>

<!doctype html>
<html lang="kr">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>INDUK Mall</title>
	<link href="../css/bootstrap.min.css" rel="stylesheet">
	<link href="../css/my.css" rel="stylesheet">
	<script src="../js/jquery-3.7.1.min.js"></script>
	<script src="../js/bootstrap.bundle.min.js"></script>
	<script src="../js/my.js"></script>
</head>
<body>

<div class="container">
<script> document.write(admin_menu());</script>

<form name="form1" method="post" action="product_update.php" enctype="multipart/form-data">
<input type="hidden" name="id" value="<?=$id;?>">

<div class="row mx-1 justify-content-center">
<div class="col" align="center">

<h4 class="m-0 mb-3">제품</h4>

<table class="table table-sm table-bordered myfs12 m-0 p-0">
<tr>
	<td width="15%" class="bg-light">상품분류</td>
	<td align="left" class="ps-2">
		<select name="menu" class="form-select form-select-sm bg-light myfs12" style="width:120px">
<?
for($i=0; $i<$n_menu; $i++)
{
	$tmp = ($i == $row["menu"]) ? "selected" : "";
	echo("<option value='$i' $tmp>$a_menu[$i]</option>");
}
?>
		</select>
	</td>
</tr>

<tr>
	<td class="bg-light">상품코드</td>
	<td align="left" class="ps-2">
		<input type="text" name="code" value="<?=$row["code"];?>" class="form-control form-control-sm" style="width:150px">
	</td>
</tr>

<tr>
	<td class="bg-light">상품명</td>
	<td align="left" class="ps-2">
		<input type="text" name="name" value="<?=$name;?>" class="form-control form-control-sm" style="width:350px">
	</td>
</tr>

<tr>
	<td class="bg-light">제조사</td>
	<td align="left" class="ps-2">
		<input type="text" name="coname" value="<?=$row["coname"];?>" class="form-control form-control-sm" style="width:200px">
	</td>
</tr>

<tr>
	<td class="bg-light">판매가</td>
	<td align="left" class="ps-2">
		<input type="text" name="price" value="<?=$row["price"];?>" class="form-control form-control-sm" style="width:120px"> 원
	</td>
</tr>

<tr>
	<td class="bg-light">옵션</td>
	<td align="left" class="ps-2">
		<div class="d-inline-flex">
			<select name="opt1" class="form-select form-select-sm bg-light myfs12 me-2" style="width:100px">
				<option value="0">옵션 선택</option>
<?
foreach($result1 as $row1)
{
	$tmp = ($row["opt1"] == $row1["id"]) ? "selected" : "";
	echo("<option value='{$row1['id']}' $tmp>{$row1['name']}</option>");
}
?>
			</select>

			<select name="opt2" class="form-select form-select-sm bg-light myfs12 me-2" style="width:100px">
				<option value="0">옵션 선택</option>
<?
mysqli_data_seek($result1, 0);
foreach($result1 as $row1)
{
	$tmp = ($row["opt2"] == $row1["id"]) ? "selected" : "";
	echo("<option value='{$row1['id']}' $tmp>{$row1['name']}</option>");
}
?>
			</select>
		</div>
	</td>
</tr>

<tr>
	<td class="bg-light">제품설명</td>
	<td align="left" class="ps-2">
		<textarea name="contents" rows="5" cols="80" class="form-control form-control-sm myfs12"><?=$contents;?></textarea>
	</td>
</tr>

<tr>
	<td class="bg-light">상품상태</td>
	<td align="left" class="ps-2">
		<input type="radio" name="status" value="1" <?=$row["status"]==1 ? "checked" : "";?>> 판매중
		<input type="radio" name="status" value="2" <?=$row["status"]==2 ? "checked" : "";?>> 판매중지
		<input type="radio" name="status" value="3" <?=$row["status"]==3 ? "checked" : "";?>> 품절
	</td>
</tr>

<tr>
	<td class="bg-light">아이콘</td>
	<td align="left" class="ps-2">
		<input type="checkbox" value="1" name="icon_new" <?=$row["icon_new"]==1 ? "checked" : "";?>> New
		<input type="checkbox" value="1" name="icon_hit" <?=$row["icon_hit"]==1 ? "checked" : "";?>> Hit
		<input type="checkbox" value="1" name="icon_sale" <?=$row["icon_sale"]==1 ? "checked" : "";?>> Sale
		&nbsp; 할인율:
		<input type="text" name="discount" value="<?=$row["discount"];?>" maxlength="3" class="form-control form-control-sm d-inline-flex" style="width:60px"> %
	</td>
</tr>

<tr>
	<td class="bg-light">등록일</td>
	<td align="left" class="ps-2">
		<input type="date" name="regday" value="<?=$row["regday"];?>" class="form-control form-control-sm">
	</td>
</tr>

<tr>
	<td class="bg-light">이미지<br>(삭제할 그림 체크)</td>
	<td align="left" class="ps-2">

<?
for($i=1; $i<=3; $i++)
{
	$img = $row["image".$i];
	$show_img = $img ? $img : "nopic.png";
?>
		<table class="my-1">
		<tr>
			<td>
				<img src="../product/<?=$show_img;?>" width="50" height="50" class="img-thumbnail">
			</td>
			<td align="left" class="ps-3">
				<input type="hidden" name="imagename<?=$i;?>" value="<?=$img;?>">
				<input type="checkbox" name="checkno<?=$i;?>" value="1">
				<b>이미지<?=$i;?> : </b>&nbsp;<?=$img;?><br>
				<input type="file" name="image<?=$i;?>" class="form-control form-control-sm myfs12">
			</td>
		</tr>
		</table>
<?
}
?>

	</td>
</tr>
</table>

<a href="javascript:form1.submit();" class="btn btn-sm btn-dark text-white my-2">&nbsp;저 장&nbsp;</a>&nbsp;
<a href="javascript:history.back();" class="btn btn-sm btn-outline-dark my-2">&nbsp;돌아가기&nbsp;</a>

</div>
</div>
<br>
</form>
</div>

</body>
</html>