<?
include "common.php";

$name = mysqli_real_escape_string($db, $_REQUEST["name"]);
$kor = (int)$_REQUEST["kor"];
$eng = (int)$_REQUEST["eng"];
$mat = (int)$_REQUEST["mat"];
$hap = (int)$_REQUEST["hap"];
$avg = (float)$_REQUEST["avg"];

$sql = "insert into sj(name,kor,eng,mat,hap,avg) 
        values('$name',$kor,$eng,$mat,$hap,$avg)";

$result = mysqli_query($db, $sql);
if(!$result) exit("에러: $sql");

echo("<script>location.href='sj_list.php'</script>");
?>