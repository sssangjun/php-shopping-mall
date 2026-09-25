<?
include "../common.php";

$id = isset($_REQUEST["id"]) ? $_REQUEST["id"] : "";

$page = isset($_REQUEST["page"]) ? $_REQUEST["page"] : 1;
$sel1 = isset($_REQUEST["sel1"]) ? $_REQUEST["sel1"] : 0;
$sel2 = isset($_REQUEST["sel2"]) ? $_REQUEST["sel2"] : 1;
$text1 = isset($_REQUEST["text1"]) ? $_REQUEST["text1"] : "";
$day1 = isset($_REQUEST["day1"]) ? $_REQUEST["day1"] : "";
$day2 = isset($_REQUEST["day2"]) ? $_REQUEST["day2"] : "";

$id_sql = mysqli_real_escape_string($db, $id);

$sql = "delete from jumuns where jumun_id='$id_sql'";
$result = mysqli_query($db, $sql);
if(!$result) exit("에러: $sql<br>" . mysqli_error($db));

$sql = "delete from jumun where id='$id_sql'";
$result = mysqli_query($db, $sql);
if(!$result) exit("에러: $sql<br>" . mysqli_error($db));

$args = "page=$page&sel1=$sel1&sel2=$sel2&text1=" . urlencode($text1) . "&day1=$day1&day2=$day2";

echo("<script>location.href='jumun.php?$args';</script>");
?>