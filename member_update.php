<?
	include "common.php";
	
	$uid = $_REQUEST["uid"];
$pwd = $_REQUEST["pwd"];
$name = $_REQUEST["name"];

$tel1 = $_REQUEST["tel1"];
$tel2 = $_REQUEST["tel2"];
$tel3 = $_REQUEST["tel3"];
$tel = $tel1.$tel2.$tel3;

$zip = $_REQUEST["zip"];
$juso = $_REQUEST["juso"];
$email = $_REQUEST["email"];

$birthday1 = $_REQUEST["birthday1"];
$birthday2 = $_REQUEST["birthday2"];
$birthday3 = $_REQUEST["birthday3"];
$birthday = $birthday1."-".$birthday2."-".$birthday3;
	
	$cookie_id = $_COOKIE["cookie_id"];   // ⭐ 이거 추가
	
	if(!$pwd)
	{
		$sql="update member set uid='$uid', name='$name',
		tel='$tel', zip='$zip', juso='$juso', email='$email', birthday='$birthday'
		where uid='$cookie_id'";   // ⭐ id → uid
	}
	else
	{
		$sql="update member set uid='$uid', pwd='$pwd', name='$name',
		tel='$tel', zip='$zip', juso='$juso', email='$email', birthday='$birthday'
		where uid='$cookie_id'";   // ⭐ id → uid
	}
	
	$result = mysqli_query($db, $sql);
	if(!$result) exit("에러: $sql");

	echo("<script>location.href='index.html'</script>");
?>