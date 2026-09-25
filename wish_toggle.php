<?
include "common.php";

$cookie_id = $_COOKIE["cookie_id"];
$id = $_REQUEST["id"];

if(!$cookie_id)
{
	echo "login";
	exit;
}

if(!$id)
{
	echo "error";
	exit;
}

// 이미 찜했는지 확인
$sql = "select * from wish where member_id='$cookie_id' and product_id=$id";
$result = mysqli_query($db, $sql);

if(mysqli_num_rows($result) > 0)
{
	// 이미 있으면 삭제
	$sql = "delete from wish where member_id='$cookie_id' and product_id=$id";
	mysqli_query($db, $sql);

	echo "remove";
}
else
{
	// 없으면 추가
	$sql = "insert into wish (member_id, product_id) values ('$cookie_id', $id)";
	mysqli_query($db, $sql);

	echo "add";
}
?>