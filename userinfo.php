<!DOCTYPE html>

<html>

<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<style>
		body {
	font-family: Arial;
	font-size: 17px;
	padding: 8px;
	}

	* {
	box-sizing: border-box;
	}

	.roww {
	display: -ms-flexbox;
	/* IE10 */
	display: flex;
	-ms-flex-wrap: wrap;
	/* IE10 */
	flex-wrap: wrap;
	margin: 0 -16px;
	}

	.col-25 {
	-ms-flex: 25%;
	/* IE10 */
	flex: 25%;
	}

	.col-50 {
	-ms-flex: 50%;
	/* IE10 */
	flex: 50%;
	}

	.col-75 {
	-ms-flex: 75%;
	/* IE10 */
	flex: 75%;
	}

	.col-25,
	.col-50,
	.col-75 {
	padding: 0 16px;
	}

	.container {
	background-color: #f2f2f2;
	padding: 5px 20px 15px 20px;
	border: 1px solid lightgrey;
	border-radius: 3px;
	}

	input[type=text] {
	width: 100%;
	margin-bottom: 20px;
	padding: 12px;
	border: 1px solid #ccc;
	border-radius: 3px;
	}

	label {
	margin-bottom: 10px;
	display: block;
	}

	.icon-container {
	margin-bottom: 20px;
	padding: 7px 0;
	font-size: 24px;
	}

	.btn {
	background-color: #4CAF50;
	color: white;
	padding: 12px;
	margin: 10px 0;
	border: none;
	width: 100%;
	border-radius: 3px;
	cursor: pointer;
	font-size: 17px;
	}

	.btn:hover {
	background-color: #45a049;
	}

	a {
	color: #2196F3;
	}

	hr {
	border: 1px solid lightgrey;
	}

	span.price {
	float: right;
	color: grey;
	}

	@media (max-width: 800px) {
	.row {
	flex-direction: column-reverse;
	}

	.col-25 {
	margin-bottom: 20px;
	}
	}
	</style>
</head>

<body>

<?php
ob_start();
session_start();
if(!isset($_SESSION['username'])){
	header("Location: user_login.php");
}
$title = "User Info";
require "./template/header.php";

// Get user information
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
?>





				<div class="row">
					<div class="col-50">
						<h3>User Information</h3>
						<div class="wrap-input100 validate-input m-b-16">
							<label for="fname"><i class="fa fa-user"></i> Name</label>

							<?php
							if(isset($name)){
								echo '<input class="input100" disabled type="text" name="firstname" placeholder="User Name" value="'.$name.'">';
								echo '<span class="focus-input100"></span>';
							}
							?>
						</div>


						<label for="email"><i class="fa fa-envelope"></i> Email</label>

						<div class="wrap-input100 validate-input m-b-16" data-validate="User Email is required">
							<?php
							if(isset($email)){
								echo '<input class="input100" disabled type="text" name="user_email" placeholder="User Email" value="'.$email.'">';
								echo '<span class="focus-input100"></span>';
							}
							?>
						</div>


						<label>Account ID</label>

						<div class="wrap-input100 validate-input m-b-16" data-validate="Username is required">
							<?php
							if(isset($accid)){
								echo '<input class="input100" disabled type="text" name="user_email" placeholder="User Number" value="'.$accid.'">';
								echo '<span class="focus-input100"></span>';
							}
							?>
						</div>




						<label> Balance</label>

						<div class="wrap-input100 validate-input m-b-16" data-validate="User Email is required">
							<?php
							if(isset($balance)){
								echo '<input class="input100" disabled type="text" name="balance_Available" placeholder="User Email" value="'.$balance.'">';
								echo '<span class="focus-input100"></span>';
							}
							?>
						</div>

					</div>
				</div>














<script>
	function checknamee() {
		var recnum = document.getElementById('receiver_number').value + "";
		//recnum.toString;
		alert(recnum);
		document.cookie = "myJavascriptVar =" + recnum;
		var htmlString="<?php
			$recnum =  $_COOKIE['myJavascriptVar'];

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "http://localhost:8080/IBanking/rest/services/getIDReceiver/");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded')); // In Java: @Consumes(MediaType.APPLICATION_FORM_URLENCODED)

			$data = array('receiver_number'=>$recnum);
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
			$output = curl_exec($ch);
			$receiver_name = $output;
			curl_close($ch);
		?>";
		alert(htmlString);
	}
</script>

<!--===============================================================================================-->
<script src="formStyle/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
<script src="formStyle/vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
<script src="formStyle/vendor/bootstrap/js/popper.js"></script>
<script src="formStyle/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
<script src="formStyle/vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
<script src="formStyle/vendor/daterangepicker/moment.min.js"></script>
<script src="formStyle/vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
<script src="formStyle/vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
<script src="formStyle/js/main.js"></script>

</body>

</html>