<?
include "../common.php";

$id = $_REQUEST["id"];

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

// 기존 이미지 이름
$image1 = $_REQUEST["imagename1"];
$image2 = $_REQUEST["imagename2"];
$image3 = $_REQUEST["imagename3"];

// 이미지 삭제 체크
if($_REQUEST["checkno1"] == 1) $image1 = "";
if($_REQUEST["checkno2"] == 1) $image2 = "";
if($_REQUEST["checkno3"] == 1) $image3 = "";

// 새 이미지 업로드
if($_FILES["image1"]["error"] == 0)
{
	$image1 = $_FILES["image1"]["name"];
	if(!move_uploaded_file($_FILES["image1"]["tmp_name"], "../product/$image1"))
		exit("업로드 실패");
}

if($_FILES["image2"]["error"] == 0)
{
	$image2 = $_FILES["image2"]["name"];
	if(!move_uploaded_file($_FILES["image2"]["tmp_name"], "../product/$image2"))
		exit("업로드 실패");
}

if($_FILES["image3"]["error"] == 0)
{
	$image3 = $_FILES["image3"]["name"];
	if(!move_uploaded_file($_FILES["image3"]["tmp_name"], "../product/$image3"))
		exit("업로드 실패");
}

$sql = "update product set
	menu='$menu',
	code='$code',
	name='$name',
	coname='$coname',
	price='$price',
	opt1='$opt1',
	opt2='$opt2',
	contents='$contents',
	status='$status',
	regday='$regday',
	icon_new='$icon_new',
	icon_hit='$icon_hit',
	icon_sale='$icon_sale',
	discount='$discount',
	image1='$image1',
	image2='$image2',
	image3='$image3'
	where id='$id'";

$result = mysqli_query($db, $sql);
if(!$result) exit("에러: $sql<br>" . mysqli_error($db));

echo("<script>location.href='product.php'</script>");
?>