<?
$current_page = basename($_SERVER["PHP_SELF"]);

$game_pages = array(
	"main.php",
	"menu.php",
	"product.php",
	"product_search.php",
	"cart.php",
	"order.php",
	"order_pay.php",
	"order_ok.php",
	"orders.php",
	"member_edit.php",
	"member_login.php",
	"member_join.php",
	"member_joinend.php",
	"jumun_login.php",
	"jumun.php",
	"jumun_info.php"
);

$is_game_page = in_array($current_page, $game_pages);
?>

<? if($is_game_page) { ?>

<footer class="neo-footer">

	<div class="neo-footer-line">
		<span></span>
	</div>

	<div class="neo-footer-inner">

		<div class="neo-footer-logo-box">
			<a href="main.php" class="neo-footer-logo">
	<img src="images/neonix_logo.png?v=101" alt="NEONIX">
</a>
		</div>

		<div class="neo-footer-info">
			<h3>NEONIX</h3>

			<p>
				상호: 네오닉스 <span>|</span>
				대표: 유상준 <span>|</span>
				사업자 등록번호: 123-12-123345
			</p>

			<p>
				주소: 21424 서울 노원구 초안산로 인덕대학교 <span>|</span>
				전화: 010-1111-2222 <span>|</span>
				Fax: 02-3333-4444
			</p>

			<p>
				개인정보관리책임자: 홍길동 <span>|</span>
				이메일: honggd@induk.ac.kr
			</p>

			<p class="neo-footer-copy">
				Copyright © 2024 www.induk.ac.kr &nbsp; All Rights Reserved.
			</p>
		</div>

		<div class="neo-footer-right">

			<div class="neo-footer-links">
				<a href="company.html">회사소개</a>
				<a href="useinfo.html">이용안내</a>
				<a href="policy.html">개인정보정책</a>
				<a href="admin/index.html" class="admin-link">Admin</a>
			</div>

			<div class="neo-footer-cert">
				<a href="http://www.ftc.go.kr/" target="_blank">
					<img src="images/footer_pic1.gif" alt="공정거래위원회 표준약관">
				</a>

				<a href="http://www.sgic.co.kr/" target="_blank">
					<img src="images/footer_pic2.gif" alt="한국소비자보호원 소비자">
				</a>
			</div>

		</div>

	</div>

</footer>

</div>

</body>
</html>

<? } else { ?>

<hr class="m-0">

<div class="row bg-light py-3 m-0 mb-5">
	<div class="col-2" align="center">
		<a href="index.html">
			<img src="images/footer_logo.png" width="120" class="img-fluid">
		</a>
	</div>

	<div class="col-7" align="left" style="line-height:15px;">
		<h6><b>INDUK Mall</b></h6>
		<font style="font-size:12px;">
			상호: 인덕주식회사 | 대표 : 홍길동 | 사업자 등록번호 : 123-12-123345<br>
			주소 : 21424 서울 노원구 초안산로 인덕대학교 | 전화 : 010-1111-2222 | Fax : 02-3333-4444<br>
			개인정보관리책임자 : 홍길동 | 이메일 : honggd@induk.ac.kr<br>
			<br>
			Copyright © 2024 www.induk.ac.kr &nbsp; All Rights Reserved.
		</font>
	</div>

	<div class="col-3" align="center" style="font-size:12px;">
		<a href="company.html">회사소개</a>&nbsp; |&nbsp;
		<a href="useinfo.html">이용안내</a>&nbsp; |&nbsp;
		<a href="policy.html">개인정보정책</a>&nbsp; |&nbsp;
		<a href="admin/index.html"><b>Admin</b></a>
		<br><br>

		<a href="http://www.ftc.go.kr/">
			<img src="images/footer_pic1.gif" border="0" class="img-fluid mb-2">
		</a>

		<a href="http://www.sgic.co.kr/">
			<img src="images/footer_pic2.gif" border="0" class="img-fluid mb-2">
		</a>
	</div>
</div>

<br>

</div>

</body>
</html>

<? } ?>