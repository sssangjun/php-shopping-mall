<?
	error_reporting(E_ALL  &  ~E_NOTICE  &  ~E_WARNING);
	ini_set("display_errors", 1);

	mysqli_report(MYSQLI_REPORT_OFF);

	$db = (function () {
    $config = require __DIR__ . '/config/bootstrap.php';
    $connection = $config['shop'];
    return mysqli_connect($connection['host'], $connection['user'], $connection['password'], $connection['database']);
})();
	if (!$db) exit("DB연결에러");
	
	$page_line = 5;
	$page_block = 5;
	
	$baesongbi = 2500;
	$max_baesongbi = 100000;
	
	$admin_id = (require __DIR__ . '/config/bootstrap.php')['admin']['id'];
	$admin_pw = (require __DIR__ . '/config/bootstrap.php')['admin']['password'];
	


	$a_menu = array("분류선택", "RPG", "액션", "어드벤처", "슈팅", "시뮬레이션", "인디게임");
	$n_menu = count($a_menu);
	

	$a_status = array("상품상태", "판매중", "판매중지", "품절");
	$n_status = count($a_status);
	


	$a_icon = array("아이콘 선택", "New", "Hit", "Sale");
	$n_icon = count($a_icon);


	$a_text1 = array("", "제품이름", "제품번호");
	$n_text1 = count($a_text1);


	$a_opt_title = array(
	"",
	"Option",
	"Platform",
	"Language",
	"Edition"
);

$a_opt_msg = array(
	"",
	"옵션을 선택하세요.",
	"플랫폼을 선택하세요.",
	"언어를 선택하세요.",
	"에디션을 선택하세요."
);

$n_opt_title = count($a_opt_title);
	
	
	function mypagination($query, $args, &$count, &$pagebar)
	{
		global $db, $page_line, $page_block;

		$page = $_REQUEST["page"] ? $_REQUEST["page"] : 1;
		
		$url = basename($_SERVER['PHP_SELF']) . "?" . $args;
		

		$sql = strtolower($query);
		$sql = "select count(*) " . substr($sql, strpos($sql, "from"));
		$result = mysqli_query($db, $sql);

		if (!$result) exit("에러: $sql <br>" . mysqli_error($db));

		$row = mysqli_fetch_array($result);
		$count = $row[0];

		
		$first = ($page - 1) * $page_line;
		
		$sql = str_replace(";", "", $query);
		$sql .= " limit $first, $page_line";

		$result = mysqli_query($db, $sql);

		if (!$result) exit("에러: $sql <br>" . mysqli_error($db));

		
		$pages = ceil($count / $page_line);
		$blocks = ceil($pages / $page_block);
		$block = ceil($page / $page_block);
		$page_s = $page_block * ($block - 1);
		$page_e = $page_block * $block;

		if ($blocks <= $block) $page_e = $pages;

		$pagebar = "<nav>
			<ul class='pagination pagination-sm justify-content-center py-1'>";

		if ($block > 1)
			$pagebar .= "<li class='page-item'>
					<a class='page-link' href='$url&page=$page_s'>◀</a>
				</li>";

		for($i = $page_s + 1; $i <= $page_e; $i++)
		{
			if ($page == $i)
				$pagebar .= "<li class='page-item active'>
						<span class='page-link mycolor1'>$i</span>
					</li>";
			else
				$pagebar .= "<li class='page-item'>
						<a class='page-link' href='$url&page=$i'>$i</a>
					</li>";
		}

		if ($block < $blocks)
			$pagebar .= "<li class='page-item'>
					<a class='page-link' href='$url&page=" . ($page_e + 1) . "'>▶</a>
				</li>";
				
		$pagebar .= "</ul>
			</nav>";
			
		return $result;
	}
?>
<?
$a_state = array("전체", "주문신청", "주문확인", "입금확인", "배송중", "주문완료", "주문취소");
$n_state = count($a_state);
?>