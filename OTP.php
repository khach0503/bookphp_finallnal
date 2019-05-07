<html>
<head>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">

	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

	<!-- Popper JS -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>

	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>

	<title>OTP confirmation</title>
	<style>
		body{
			font-family: calibri;
		}
		.tblLogin {
			border: #95bee6 1px solid;
			background: #d1e8ff;
			border-radius: 4px;
			max-width: 300px;
			padding:20px 30px 30px;
			text-align:center;
		}
		.tableheader { 
			font-size: 20px; 
			
		}
		.tablerow { padding:20px; }
		.error_message {
			color: #b12d2d;
			background: #ffb5b5;
			border: #c76969 1px solid;
		}
		.message {
			width: 100%;
			max-width: 300px;
			padding: 10px 30px;
			border-radius: 4px;
			margin-bottom: 5px;
		}
		.login-input {
			border: #CCC 1px solid;
			padding: 10px 20px;
			border-radius:4px;
		}
		.btnSubmit {
			padding: 10px 20px;
			background: #2c7ac5;
			border: #d1e8ff 1px solid;
			color: #FFF;
			border-radius:4px;
		}
	</style>
	
	<script type="text/javascript">
 
		function timedMsg()
		{
			var t=setTimeout("document.getElementById('myMsg').style.display='none';",4000);
		}
	</script>
</head>
<body>
<?php
	ob_start();
	session_start();
	if(!isset($_SESSION['username'])){
		header("Location: user_login.php");
	}
	$username           = $_SESSION["username"];
	//$receiver           = $_SESSION["receiver_name"];
	$result = "";
?>

<?php
	if(!empty($error_message)) {
		?>
		<div class="message error_message"><?php echo $error_message; ?></div>
		<?php
	}
?>

	<div class="form-group">
        <div class="col-sm-10 col-sm-offset-2">
            <?php echo $result; ?>
        </div>
    </div>

	<form name="frmUser" method="post" style="position:fixed;top:20%;left:35%;">
		<div class="tblLogin">
			<div class="tableheader">Checkout Verification</div>
			<p style="color:#31ab00; margin:auto">OTP Code is sent to Your Email</p>
			<div class="tablerow">
				<input type="text" name="otp" placeholder="One Time Password" class="login-input" required>
			</div>
			<input type="submit" name="submit_otp" value="Submit" class="btnSubmit">
			<div style="text-align: center"> <a href="OTPinput.php">Resend new OTP Code?</a></div>
			<div style="text-align: center"> <a href="books.php">You don't want to Continue?</a></div>
		</div>
	</form>

	<div id="alert" class="alert alert-success" style="display: none ; float: left" >
		<!-- <strong> Ma OTP nay khong co hieu luc </strong> -->
		<strong>This OTP code is not valid</strong>
	</div>
<?php


if(isset($_POST['otp'])) {

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "http://node15791-env-9772882.cloudjiffy.net/Book/rest/services/checkOTP");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded')); // In Java: @Consumes(MediaType.APPLICATION_FORM_URLENCODED)
	echo $_POST['otp'];
	$data = array('otp' => $_POST['otp'], 'macart' => $_SESSION["macart"]);
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

	$output = curl_exec($ch);
	$info = curl_getinfo($ch);
	curl_close($ch);
	echo $output;
	if ($output == "true") {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "http://node15791-env-9772882.cloudjiffy.net/Book/rest/services/bookreduce");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded')); // In Java: @Consumes(MediaType.APPLICATION_FORM_URLENCODED)

		$data = array('macart' => $_SESSION['macart']);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

		curl_exec($ch);
		$info = curl_getinfo($ch);
		curl_close($ch);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "http://node15791-env-9772882.cloudjiffy.net/Book/rest/services/balareduce");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded')); // In Java: @Consumes(MediaType.APPLICATION_FORM_URLENCODED)

		$data = array('accid' => $_SESSION['username'], 'sotien' => $_SESSION['total_price'],'macart' => $_SESSION['macart']);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

		curl_exec($ch);
		$info = curl_getinfo($ch);
		curl_close($ch);

		header("Location: SuccessTransaction.php");
	}
	else{
		?>
		<script>
			document.getElementById('alert').style.display = 'block';
		</script>
	<?php	}
}
?>




</body>
</html>