<?
include "../common.php";

$regday = date("Y-m-d");

$sql = "select * from opt order by id";
$result = mysqli_query($db, $sql);
if(!$result) exit("에러: $sql");
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

<form name="form1" method="post" action="product_insert.php" enctype="multipart/form-data">

<div class="row mx-1 justify-content-center">
<div class="col" align="center">

<h4 class="m-0 mb-3">제품</h4>

<table class="table table-sm table-bordered myfs12 m-0 p-0">
<tr>
	<td width="15%" class="bg-light">상품분류</td>
	<td align="left" class="ps-2">
		<div class="d-inline-flex">
			<select name="menu" class="form-select form-select-sm bg-light myfs12">
<?
for($i=0; $i<$n_menu; $i++)
{
	echo("<option value='$i'>$a_menu[$i]</option>");
}
?>
			</select>&nbsp;
		</div>
	</td>
</tr>

<tr>
	<td class="bg-light">상품코드</td>
	<td align="left" class="ps-2">
		<input type="text" name="code" class="form-control form-control-sm" style="width:150px">
	</td>
</tr>

<tr>
	<td class="bg-light">상품명</td>
	<td align="left" class="ps-2">
		<input type="text" name="name" class="form-control form-control-sm" style="width:350px">
	</td>
</tr>

<tr>
	<td class="bg-light">제조사</td>
	<td align="left" class="ps-2">
		<input type="text" name="coname" class="form-control form-control-sm" style="width:200px">
	</td>
</tr>

<tr>
	<td class="bg-light">판매가</td>
	<td align="left" class="ps-2">
		<input type="text" name="price" class="form-control form-control-sm" style="width:120px"> 원
	</td>
</tr>

<tr>
	<td class="bg-light">옵션</td>
	<td align="left" class="ps-2">

		<div class="d-inline-flex">

			<select name="opt1" class="form-select form-select-sm bg-light myfs12 me-2" style="width:100px">
				<option value="0">옵션 선택</option>

<?
mysqli_data_seek($result, 0);
while($row = mysqli_fetch_array($result))
{
	echo("<option value='{$row['id']}'>{$row['name']}</option>");
}
?>
			</select>

			<select name="opt2" class="form-select form-select-sm bg-light myfs12 me-2" style="width:100px">
				<option value="0">옵션 선택</option>

<?
mysqli_data_seek($result, 0);
while($row = mysqli_fetch_array($result))
{
	echo("<option value='{$row['id']}'>{$row['name']}</option>");
}
?>
			</select>

		</div>

	</td>
</tr>

<tr>
	<td class="bg-light">제품설명</td>
	<td align="left" class="ps-2">
		<textarea name="contents" rows="5" cols="80" class="form-control form-control-sm myfs12"></textarea>
	</td>
</tr>

<tr>
	<td class="bg-light">상품상태</td>
	<td align="left" class="ps-2">
		<input type="radio" name="status" value="1" checked> 판매중
		<input type="radio" name="status" value="2"> 판매중지
		<input type="radio" name="status" value="3"> 품절
	</td>
</tr>

<tr>
	<td class="bg-light">아이콘</td>
	<td align="left" class="ps-2">
		<input type="checkbox" value="1" name="icon_new" checked> New
		<input type="checkbox" value="1" name="icon_hit"> Hit
		<input type="checkbox" value="1" name="icon_sale"> Sale
		&nbsp; 할인율:
		<input type="text" name="discount" value="" class="form-control form-control-sm d-inline-flex" style="width:60px"> %
	</td>
</tr>

<tr>
	<td class="bg-light">등록일</td>
	<td align="left" class="ps-2">
		<input type="date" name="regday" value="<?=$regday;?>" class="form-control form-control-sm">
	</td>
</tr>

<tr>
	<td class="bg-light">이미지</td>
	<td align="left" class="ps-2">
		<b>이미지1 :</b> <input type="file" name="image1" class="form-control form-control-sm myfs12"><br>
		<b>이미지2 :</b> <input type="file" name="image2" class="form-control form-control-sm myfs12"><br>
		<b>이미지3 :</b> <input type="file" name="image3" class="form-control form-control-sm myfs12">
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