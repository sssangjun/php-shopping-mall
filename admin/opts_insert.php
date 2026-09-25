<?
include "../common.php";

$opt_id = $_REQUEST["opt_id"];
$name = $_REQUEST["name"];

$sql = "insert into opts(opt_id, name)
        values('$opt_id', '$name')";

$result = mysqli_query($db, $sql);
if(!$result) exit("에러: $sql");

echo("<script>location.href='opts.php?id=$opt_id'</script>");
?>