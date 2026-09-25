<?
	include "common.php";

	$text1 = $_REQUEST["text1"] ? $_REQUEST["text1"] : "";

	// 주소록 테이블 검색: 이름 또는 주소에서 검색
	$sql = "select * from juso 
			where name like '%$text1%' or juso like '%$text1%' 
			order by id desc";
	
	$args = "text1=$text1";

	$result = mypagination($sql, $args, $count, $pagebar);
?>

<!doctype html>
<html lang="kr">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>주소 목록</title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/my.css" rel="stylesheet">
	<script src="js/jquery-3.7.1.min.js"></script>
	<script src="js/bootstrap.bundle.min.js"></script>
</head>
<body>

<div class="container">
<br>

<form name="form1" method="post" action="juso_list.php">
<div class="row mb-2">
	<div class="col-4" align="left">
		<div class="input-group input-group-sm">
			<span class="input-group-text">검색</span>
			<input type="text" name="text1" value="<?=$text1?>" class="form-control" placeholder="이름 또는 주소"> 
			<button class="btn mycolor1" type="button" onclick="form1.submit();">검색</button>
		</div>
	</div>

	<div class="col-8" align="right">
		<a href="juso_new.html" class="btn btn-sm mycolor1">주소 추가</a>
	</div>
</div>
</form>

<table class="table table-sm table-bordered table-hover mymargin5">
	<tr class="mycolor2">
		<td width="8%">ID</td>
		<td width="15%">이름</td>
		<td width="15%">전화번호</td>
		<td width="10%">구분</td>
		<td width="15%">날짜</td>
		<td>주소</td>
		<td width="15%">수정 / 삭제</td>
	</tr>

<?
	foreach($result as $row)
	{
		$id = $row["id"];

		$sm_text = "";
		if($row["sm"] == 0) $sm_text = "양력";
		else if($row["sm"] == 1) $sm_text = "음력";
		else $sm_text = $row["sm"];
?>

	<tr>
		<td><?=$id?></td>
		<td><?=$row["name"]?></td>
		<td><?=$row["tel"]?></td>
		<td><?=$sm_text?></td>
		<td><?=$row["date"]?></td>
		<td align="left"><?=$row["juso"]?></td>
		<td>
			<a href="juso_edit.php?id=<?=$id;?>" 
				class="btn btn-sm btn-outline-primary py-0 my-0">수정</a>
			<a href="juso_delete.php?id=<?=$id;?>" 
				class="btn btn-sm btn-outline-danger py-0 my-0"
				onClick="return confirm('삭제할까요 ?');">삭제</a>
		</td>
	</tr>

<?
	}
?>
</table>

<?
	echo $pagebar;
?>

</div>

</body>
</html>