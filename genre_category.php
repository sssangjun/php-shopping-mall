<?
$type = isset($_REQUEST["type"]) ? $_REQUEST["type"] : "all";
$now_menu = isset($_REQUEST["menu"]) ? $_REQUEST["menu"] : "";

$genre_list = array(
	array("name"=>"RPG", "desc"=>"스토리와 성장 중심", "icon"=>"⚔"),
	array("name"=>"액션", "desc"=>"빠른 전투와 타격감", "icon"=>"🔥"),
	array("name"=>"어드벤처", "desc"=>"탐험과 몰입형 플레이", "icon"=>"🧭"),
	array("name"=>"슈팅", "desc"=>"정확한 조준과 전투", "icon"=>"🎯"),
	array("name"=>"시뮬레이션", "desc"=>"현실감 있는 플레이", "icon"=>"🕹"),
	array("name"=>"인디게임", "desc"=>"개성 있는 창작 게임", "icon"=>"✨")
);
?>

<div class="genre-category-section">

	<div class="genre-category-title">
		<div class="section-small">GAME CATEGORY</div>
	
	</div>

	<div class="genre-category-grid">

<?
foreach($genre_list as $genre)
{
	$genre_name = $genre["name"];
	$genre_desc = $genre["desc"];
	$genre_icon = $genre["icon"];

	$menu_id = "";

	if(isset($a_menu) && is_array($a_menu))
	{
		foreach($a_menu as $key => $value)
		{
			$menu_value = trim($value);
			$menu_value_clean = str_replace("게임", "", $menu_value);
			$genre_name_clean = str_replace("게임", "", $genre_name);

			if($menu_value == $genre_name || $menu_value_clean == $genre_name_clean)
			{
				$menu_id = $key;
				break;
			}
		}
	}

	$genre_href = "menu.php?type=" . urlencode($type);

	if($menu_id !== "")
	{
		$genre_href .= "&menu=" . urlencode($menu_id);
	}

	$genre_href .= "#gameList";

	$genre_count_text = "게임 보기";

	if($menu_id !== "")
	{
		$menu_id_sql = mysqli_real_escape_string($db, $menu_id);

		$sql_count = "select count(*) as cnt from product where status=1 and menu='$menu_id_sql'";
		$result_count = mysqli_query($db, $sql_count);

		if($result_count)
		{
			$row_count = mysqli_fetch_array($result_count);
			$genre_count = intval($row_count["cnt"]);

			if($genre_count > 0)
				$genre_count_text = number_format($genre_count) . "개";
		}
	}

	$active = "";
	if($now_menu !== "" && $menu_id !== "" && strval($now_menu) == strval($menu_id))
		$active = "active";
?>

		<a href="<?=$genre_href;?>" class="genre-category-card <?=$active;?>">
			<div class="genre-category-icon"><?=$genre_icon;?></div>

			<div class="genre-category-text">
				<strong><?=$genre_name;?></strong>
				<span><?=$genre_desc;?></span>
			</div>

			<div class="genre-category-count"><?=$genre_count_text;?></div>
		</a>

<?
}
?>

	</div>

</div>