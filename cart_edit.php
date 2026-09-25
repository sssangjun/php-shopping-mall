<?
	include "common.php";

	$cart = $_COOKIE["cart"];
	$n_cart = $_COOKIE["n_cart"];

	$kind = $_REQUEST["kind"];
	$pos = $_REQUEST["pos"];

	if(!$n_cart) $n_cart = 0;

	switch($kind)
	{
		case "insert":
		case "order":

			$id = $_REQUEST["id"];
			$num = $_REQUEST["num"];

			$opts_id1 = $_REQUEST["opts1"];
			$opts_id2 = $_REQUEST["opts2"];

			$n_cart++;

			$cart[$n_cart] =
				implode("^", array($id, $num, $opts_id1, $opts_id2));

			setcookie("cart[$n_cart]", $cart[$n_cart]);
			setcookie("n_cart", $n_cart);

			break;

		case "delete":

			setcookie("cart[$pos]", "");

			break;

		case "update":

			$num = $_REQUEST["num"];

			list($id, $old_num, $opts_id1, $opts_id2) =
				explode("^", $cart[$pos]);

			$cart[$pos] =
				implode("^", array($id, $num, $opts_id1, $opts_id2));

			setcookie("cart[$pos]", $cart[$pos]);

			break;

		case "deleteall":

			for($i=1; $i<=$n_cart; $i++)
			{
				if($cart[$i])
					setcookie("cart[$i]", "");
			}

			$n_cart = 0;
			setcookie("n_cart", $n_cart);

			break;
	}

	if($kind=="order")
		echo("<script>location.href='order.php'</script>");
	else
		echo("<script>location.href='cart.php'</script>");
?>