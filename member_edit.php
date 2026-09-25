<?
include_once "common.php";
include "main_top.php";

$uid = isset($_COOKIE["cookie_id"]) ? $_COOKIE["cookie_id"] : "";

if(!$uid)
{
	echo("<script>
		alert('로그인 후 이용해주세요.');
		location.href='member_login.php';
	</script>");
	exit;
}

$uid_sql = mysqli_real_escape_string($db, $uid);

$sql = "select * from member where uid='$uid_sql'";
$result = mysqli_query($db, $sql);

if(!$result)
{
	$sql = "select * from member where id='$uid_sql'";
	$result = mysqli_query($db, $sql);
}

if(!$result) exit("에러: $sql");

$row = mysqli_fetch_array($result);

if(!$row)
{
	echo("<script>
		alert('회원 정보를 찾을 수 없습니다.');
		location.href='main.php';
	</script>");
	exit;
}

$name = $row["name"];
$tel = isset($row["tel"]) ? $row["tel"] : "";

$tel_clean = str_replace("-", "", $tel);

$tel1 = substr($tel_clean, 0, 3);
$tel2 = substr($tel_clean, 3, 4);
$tel3 = substr($tel_clean, 7, 4);

if(!$tel1) $tel1 = "010";

$zip = $row["zip"];
$juso = $row["juso"];
$email = $row["email"];

$birthday = isset($row["birthday"]) ? $row["birthday"] : "";

$birthday1 = substr($birthday, 0, 4);
$birthday2 = substr($birthday, 5, 2);
$birthday3 = substr($birthday, 8, 2);

function h($str)
{
	return htmlspecialchars($str ?? "", ENT_QUOTES);
}
?>

<script>
function FindZip(zip_kind) 
{
	window.open("zipcode.php?zip_kind="+zip_kind, "", "scrollbars=no,width=490,height=320");
}

function Check_Value() {
	if (form2.pwd.value != form2.pwd1.value) {
		alert("암호가 일치하지 않습니다.");	
		form2.pwd.focus();
		return;
	}

	if (!form2.name.value) {
		alert("이름이 잘못되었습니다.");
		form2.name.focus();
		return;
	}

	if (!form2.birthday1.value || !form2.birthday2.value || !form2.birthday3.value) {
		alert("생일이 잘못되었습니다.");
		form2.birthday1.focus();
		return;
	}

	if (!form2.tel1.value || !form2.tel2.value || !form2.tel3.value) {
		alert("핸드폰이 잘못되었습니다.");
		form2.tel1.focus();
		return;
	}

	if (!form2.zip.value) {
		alert("우편번호가 잘못되었습니다.");
		form2.zip.focus();
		return;
	}

	if (!form2.juso.value) {
		alert("주소가 잘못되었습니다.");
		form2.juso.focus();
		return;
	}

	if (!form2.email.value) {
		alert("이메일이 잘못되었습니다.");
		form2.email.focus();
		return;
	}

	form2.submit();
}
</script>

<section class="member-edit-wrap">

	<div class="member-edit-title">
		<div class="member-edit-small">MEMBER PROFILE</div>
		<h2>회원 정보 수정</h2>
		<p>NEONIX 계정 정보를 확인하고 필요한 내용을 수정하세요.</p>
	</div>

	<div class="member-edit-layout">

		<div class="member-edit-side">

			<div class="member-edit-profile-card">
				<div class="member-edit-avatar">
					<?=strtoupper(substr($uid, 0, 1));?>
				</div>

				<h3><?=h($uid);?></h3>
				<p>NEONIX MEMBER</p>

				<div class="member-edit-profile-info">
					<div>
						<span>이름</span>
						<strong><?=h($name);?></strong>
					</div>

					<div>
						<span>이메일</span>
						<strong><?=h($email);?></strong>
					</div>
				</div>
			</div>

			<div class="member-edit-guide">
				<h4>안내</h4>
				<p>
					비밀번호를 변경하지 않으려면<br>
					새 비밀번호 입력칸을 비워두면 됩니다.
				</p>
			</div>

		</div>

		<div class="member-edit-card">

			<form name="form2" method="post" action="member_update.php">

				<input type="hidden" name="uid" value="<?=h($uid);?>">

				<div class="member-edit-section-head">
					<span>ACCOUNT</span>
					<h3>기본 정보</h3>
				</div>

				<div class="member-edit-grid">

					<div class="member-edit-field full">
						<label>아이디 <b>*</b></label>
						<div class="member-edit-id-box">
							<?=h($uid);?>
						</div>
					</div>

					<div class="member-edit-field">
						<label>새 비밀번호</label>
						<input type="password" name="pwd" class="form-control member-edit-input" placeholder="변경할 때만 입력">
					</div>

					<div class="member-edit-field">
						<label>새 비밀번호 확인</label>
						<input type="password" name="pwd1" class="form-control member-edit-input" placeholder="비밀번호 확인">
					</div>

					<div class="member-edit-field">
						<label>이름 <b>*</b></label>
						<input type="text" name="name" value="<?=h($name);?>" class="form-control member-edit-input">
					</div>

					<div class="member-edit-field">
						<label>생일 <b>*</b></label>
						<div class="member-edit-birth">
							<input type="text" name="birthday1" maxlength="4" value="<?=h($birthday1);?>" class="form-control member-edit-input" placeholder="YYYY">
							<span>-</span>
							<input type="text" name="birthday2" maxlength="2" value="<?=h($birthday2);?>" class="form-control member-edit-input" placeholder="MM">
							<span>-</span>
							<input type="text" name="birthday3" maxlength="2" value="<?=h($birthday3);?>" class="form-control member-edit-input" placeholder="DD">
						</div>
					</div>

					<div class="member-edit-field full">
						<label>휴대폰 <b>*</b></label>
						<div class="member-edit-phone">
							<input type="text" name="tel1" maxlength="3" value="<?=h($tel1);?>" class="form-control member-edit-input">
							<span>-</span>
							<input type="text" name="tel2" maxlength="4" value="<?=h($tel2);?>" class="form-control member-edit-input">
							<span>-</span>
							<input type="text" name="tel3" maxlength="4" value="<?=h($tel3);?>" class="form-control member-edit-input">
						</div>
					</div>

					<div class="member-edit-field full">
						<label>주소 <b>*</b></label>

						<div class="member-edit-zip">
							<input type="text" name="zip" maxlength="5" value="<?=h($zip);?>" class="form-control member-edit-input">
							<a href="javascript:FindZip(0);">우편번호 찾기</a>
						</div>

						<input type="text" name="juso" value="<?=h($juso);?>" class="form-control member-edit-input mt-2">
					</div>

					<div class="member-edit-field full">
						<label>E-Mail <b>*</b></label>
						<input type="text" name="email" value="<?=h($email);?>" class="form-control member-edit-input">
					</div>

				</div>

				<div class="member-edit-buttons">
					<a href="javascript:Check_Value();" class="member-edit-submit">
						회원정보 수정
					</a>

					<a href="main.php" class="member-edit-cancel">
						취소
					</a>
				</div>

			</form>

		</div>

	</div>

</section>

<?
include "main_bottom.php";
?>