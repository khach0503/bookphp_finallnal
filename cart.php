<?php
	// the shopping cart needs sessions, to start one
	/*
		Array of session(
			cart => array (
				book_isbn (get from $_POST['book_isbn']) => number of books
			),
			items => 0,
			total_price => '0.00'
		)
	*/
ob_start();
session_start();
if(!isset($_SESSION['username'])) {
	header("Location: user_login.php");
}

$manggia = array();


	// book_isbn got from form post method, change this place later.
	if(isset($_POST['bookisbn'])){
		$book_isbn = $_POST['bookisbn'];
	}



	$ch_Info = curl_init();
	curl_setopt($ch_Info, CURLOPT_URL, "http://node15791-env-9772882.cloudjiffy.net/Book/rest/services/Booklistformcart/");
	curl_setopt($ch_Info, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch_Info, CURLOPT_POST, 1);
	curl_setopt($ch_Info, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
	$data = array('username'=>$_SESSION['username']);
	curl_setopt($ch_Info, CURLOPT_POSTFIELDS, http_build_query($data));

	$output = curl_exec($ch_Info);
	$info = curl_getinfo($ch_Info);
	curl_close($ch_Info);
	$resultma = (array) json_decode($output);
	$_SESSION['total_items'] = 0;
	$_SESSION['total_price'] = '0.00';

	if(isset($book_isbn)){
		// new iem selected
		if(!isset($_SESSION['cart'])){
			// $_SESSION['cart'] is associative array that bookisbn => qty
			$_SESSION['cart'] = array();


		}
	}



$ch_Info = curl_init();
curl_setopt($ch_Info, CURLOPT_URL, "http://node15791-env-9772882.cloudjiffy.net/Book/rest/services/UserInfo/");
curl_setopt($ch_Info, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch_Info, CURLOPT_POST, 1);
curl_setopt($ch_Info, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded')); // In Java: @Consumes(MediaType.APPLICATION_FORM_URLENCODED)
$data = array('username'=>$_SESSION['username']);
curl_setopt($ch_Info, CURLOPT_POSTFIELDS, http_build_query($data));

$output = curl_exec($ch_Info);
$info = curl_getinfo($ch_Info);
curl_close($ch_Info);
$result = (array) json_decode($output);

// User information
$name              = $result['tenkh'];
$email             = $result['email'];
$balance = $result['sotien'];
$accid          = $_SESSION["username"];


// print out header here
	$title = "Your shopping cart";
	require "./template/header.php";


?>
<form method="post">
	   	<table class="table">
	   		<tr>
	   			<th>Item</th>
	   			<th>Price</th>
	  			<th>Quantity</th>
	   			<th>Total</th>
					<th>Remove</th>
	   		</tr>
	   		<?php
		    	for($i = 0; $i < count($resultma); $i++){

					$ch_Info = curl_init();
					curl_setopt($ch_Info, CURLOPT_URL, "http://node15791-env-9772882.cloudjiffy.net/Book/rest/services/BookInfo/");
					curl_setopt($ch_Info, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($ch_Info, CURLOPT_POST, 1);
					curl_setopt($ch_Info, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded')); // In Java: @Consumes(MediaType.APPLICATION_FORM_URLENCODED)
					$data = array('book'=>$resultma[$i]);
					curl_setopt($ch_Info, CURLOPT_POSTFIELDS, http_build_query($data));

					$output = curl_exec($ch_Info);
					$info = curl_getinfo($ch_Info);
					curl_close($ch_Info);
					$resultds = (array) json_decode($output);

					// User information
					$masach             = $resultds['masach'];
					$tensach       = $resultds['tensach'];
					$tacgia           = $resultds['tacgia'];
					$giatien = $resultds['giatien'];
					$soluong         = $resultds['soluong'];
					$theloai         = $resultds['theloai'];
					$mota         = $resultds['mota'];
					$image        = $resultds['img'];


					$ch_Info = curl_init();
					curl_setopt($ch_Info, CURLOPT_URL, "http://node15791-env-9772882.cloudjiffy.net/Book/rest/services/BookInfocart/");
					curl_setopt($ch_Info, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($ch_Info, CURLOPT_POST, 1);
					curl_setopt($ch_Info, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded')); // In Java: @Consumes(MediaType.APPLICATION_FORM_URLENCODED)
					$data = array('book'=>$resultma[$i], 'macart'=>$_SESSION['macart']);
					curl_setopt($ch_Info, CURLOPT_POSTFIELDS, http_build_query($data));

					$output = curl_exec($ch_Info);
					$info = curl_getinfo($ch_Info);
					curl_close($ch_Info);
					$qty = json_decode($output);
			?>
			<tr>
				<td><?php echo $tensach . " by " . $tacgia; ?></td>
				<td><?php echo "VND " . $giatien; ?></td>
				<td><input type="text" value="<?php
					if($qty < $soluong)
						echo $qty;
					else
					{
						$ch_Info = curl_init();
						curl_setopt($ch_Info, CURLOPT_URL, "http://node15791-env-9772882.cloudjiffy.net/Book/rest/services/Updatesl/");
						curl_setopt($ch_Info, CURLOPT_RETURNTRANSFER, true);
						curl_setopt($ch_Info, CURLOPT_POST, 1);
						curl_setopt($ch_Info, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded')); // In Java: @Consumes(MediaType.APPLICATION_FORM_URLENCODED)
						$data = array('book'=>$resultma[$i], 'macart'=>$_SESSION['macart'], 'soluong'=>$soluong);
						curl_setopt($ch_Info, CURLOPT_POSTFIELDS, http_build_query($data));

						curl_exec($ch_Info);
						$info = curl_getinfo($ch_Info);
						curl_close($ch_Info);
						$qty = $soluong;
						echo $qty;
					}?>" size="2" name="<?php echo $masach; ?>"></td>
				<td><?php echo "VND " . $qty * $giatien; ?></td>
				<form method="get" action="deletebook.php">
					<td><button type="submit" class="btn btn-primary" name="masach" value="<?php  echo $masach; ?>">X</button> </td>
				</form>
				<?php $_SESSION['total_items'] += $qty; $_SESSION['total_price'] += $qty * $giatien;?>
			</tr>
			<?php } ?>
		    <tr>
		    	<th>&nbsp;</th>
		    	<th>&nbsp;</th>
		    	<th><?php echo $_SESSION['total_items']; ?></th>
		    	<th><?php echo "VND " . $_SESSION['total_price']; ?></th>
		    </tr>
	   	</table>
	   	<input type="submit" class="btn btn-primary" name="save_change" value="Save Changes">
</form>
	<br/><br/>
<?php

	if($balance >= $_SESSION['total_price']) {
		?>
		<a href="OTPinput.php" class="btn btn-primary">Checkout</a>
		<?php
	}
	else
		echo "You don't have enough money.";
?>
	<a href="books.php" class="btn btn-primary">Continue Shopping</a>
<?php

// if save change button is clicked , change the qty of each bookisbn
if(isset($_POST['save_change'])){
	for($i = 0; $i < count($resultma); $i++)
	{

		$ch_Info = curl_init();
		curl_setopt($ch_Info, CURLOPT_URL, "http://node15791-env-9772882.cloudjiffy.net/Book/rest/services/Updatesl/");
		curl_setopt($ch_Info, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch_Info, CURLOPT_POST, 1);
		curl_setopt($ch_Info, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded')); // In Java: @Consumes(MediaType.APPLICATION_FORM_URLENCODED)
		$data = array('book'=>$resultma[$i], 'macart'=>$_SESSION['macart'], 'soluong'=>$_POST[$resultma[$i]]);
		curl_setopt($ch_Info, CURLOPT_POSTFIELDS, http_build_query($data));

		curl_exec($ch_Info);
		$info = curl_getinfo($ch_Info);
		curl_close($ch_Info);
		header("Location: cart.php");
	}
}
	require_once "./template/footer.php";
?>
