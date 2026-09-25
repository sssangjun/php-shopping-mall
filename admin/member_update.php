<?
include "../common.php";

$id = $_REQUEST["id"];
$uid = $_REQUEST["uid"];
$pwd = $_REQUEST["pwd"];
 
$name = $_REQUEST["name"];



$tel1 = $_REQUEST["tel1"];
$tel2 = $_REQUEST["tel2"];
$tel3 = $_REQUEST["tel3"];
$tel = $tel1 . $tel2 . $tel3;

$zip = trim($_REQUEST["zip"]);
$zip = str_replace(">", "", $zip);

$juso = $_REQUEST["juso"];
$email = $_REQUEST["email"];
$gubun = $_REQUEST["gubun"] ? $_REQUEST["gubun"] : 0;

$birthday1 = $_REQUEST["birthday1"];
$birthday2 = $_REQUEST["birthday2"];
$birthday3 = $_REQUEST["birthday3"];
$birthday = $birthday1 . "-" . $birthday2 . "-" . $birthday3;

$sql = "update member set 
uid='$uid',
pwd='$pwd',
name='$name',
tel='$tel',
zip='$zip',
juso='$juso',
email='$email',
birthday='$birthday',
gubun=$gubun
where id='$id'";

$result = mysqli_query($db, $sql);
if(!$result) exit("에러: $sql<br>" . mysqli_error($db));

echo("<script>location.href='member.php';</script>");
?>