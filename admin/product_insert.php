<?
include "../common.php";

$menu = $_REQUEST["menu"];
$code = $_REQUEST["code"];
$name = addslashes($_REQUEST["name"]);
$coname = $_REQUEST["coname"];
$price = $_REQUEST["price"];
$opt1 = $_REQUEST["opt1"];
$opt2 = $_REQUEST["opt2"];
$contents = addslashes($_REQUEST["contents"]);
$status = $_REQUEST["status"];
$regday = $_REQUEST["regday"];

$icon_new = $_REQUEST["icon_new"] ? 1 : 0;
$icon_hit = $_REQUEST["icon_hit"] ? 1 : 0;
$icon_sale = $_REQUEST["icon_sale"] ? 1 : 0;

$discount = $_REQUEST["discount"] ? $_REQUEST["discount"] : 0;

$image1 = "";
$image2 = "";
$image3 = "";

if($_FILES["image1"]["error"] == 0)
{
	$image1 = $_FILES["image1"]["name"];
	move_uploaded_file($_FILES["image1"]["tmp_name"], "../product/$image1");
}

if($_FILES["image2"]["error"] == 0)
{
	$image2 = $_FILES["image2"]["name"];
	move_uploaded_file($_FILES["image2"]["tmp_name"], "../product/$image2");
}

if($_FILES["image3"]["error"] == 0)
{
	$image3 = $_FILES["image3"]["name"];
	move_uploaded_file($_FILES["image3"]["tmp_name"], "../product/$image3");
}

$sql = "insert into product
(menu, code, name, coname, price, opt1, opt2, contents, status, regday,
icon_new, icon_hit, icon_sale, discount, image1, image2, image3)
values
('$menu', '$code', '$name', '$coname', '$price', '$opt1', '$opt2', '$contents', '$status', '$regday',
'$icon_new', '$icon_hit', '$icon_sale', '$discount', '$image1', '$image2', '$image3')";

$result = mysqli_query($db, $sql);
if(!$result) exit("에러: $sql<br>" . mysqli_error($db));

echo("<script>location.href='product.php'</script>");
?>