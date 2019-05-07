<!DOCTYPE html>
<html>
<head>

<!-- <script type="text/javascript">
	window.onload = function(){
		alert('Transaction Success!!!');
		
	}
</script> -->
</head>
<body>
	<?php
	ob_start();
	session_start();
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "http://node15791-env-9772882.cloudjiffy.net/Book/rest/services/mailthanhcong/");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded')); // In Java: @Consumes(MediaType.APPLICATION_FORM_URLENCODED)

	$data = array('accid' => $_SESSION["username"]);
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

	curl_exec($ch);
	$info = curl_getinfo($ch);
	curl_close($ch);
		echo "<script>
		alert('Successful Purchase!!!! ');

		window.location.href='http://localhost:8081/books/books.php';
		</script>";
	?>

</body>
</html>
