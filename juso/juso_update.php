
<?
include "common.php";

$id = $_POST["id"];
$name = $_POST["name"];
$sm = $_POST["sm"];
$juso = $_POST["juso"];

$tel = $_POST["tel1"] . $_POST["tel2"] . $_POST["tel3"];
$date = $_POST["birthday1"] . "-" . $_POST["birthday2"] . "-" . $_POST["birthday3"];

$sql = "update juso set 
name='$name',
tel='$tel',
sm='$sm',
`date`='$date',
juso='$juso'
where id='$id'";

$result = mysqli_query($db, $sql);
if(!$result) exit("에러: $sql<br>" . mysqli_error($db));

echo("<script>location.href='juso_list.php'</script>");
?>