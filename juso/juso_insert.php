<?
include "common.php";

$name = mysqli_real_escape_string($db, $_REQUEST["name"]);

$tel1 = $_REQUEST["tel1"];
$tel2 = $_REQUEST["tel2"];
$tel3 = $_REQUEST["tel3"];

// 전화번호 합치기
$tel = $tel1 . $tel2 . $tel3;

$sm = $_REQUEST["sm"];

$date1 = $_REQUEST["date1"];
$date2 = $_REQUEST["date2"];
$date3 = $_REQUEST["date3"];

// 날짜 만들기
$date = sprintf("%04d-%02d-%02d", $date1, $date2, $date3);

$juso = mysqli_real_escape_string($db, $_REQUEST["juso"]);

$sql = "insert into juso(name, tel, sm, date, juso)
		values('$name', '$tel', $sm, '$date', '$juso')";

$result = mysqli_query($db, $sql);

if(!$result) exit("에러: $sql <br>" . mysqli_error($db));

echo("<script>location.href='juso_list.php'</script>");
?>