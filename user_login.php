
<?php
	$title = "User login";
	require_once "./template/header.php";

	ob_start();
	session_start();
	if(isset($_SESSION['username'])){
		header("Location: books.php");
}
?>

<div>
	<form class="form-horizontal" method="post">

        <div class="center">
    <img src="./bootstrap/img/reading-owl.png" alt="Avatar" width="200" height="200">
    </div>
		<div class="form-group">
			<label for="name" class="control-label col-md-4">Name</label>
			<div class="col-md-4">
				<input type="text" name="username" class="form-control">
			</div>
		</div>
		<div class="form-group">
			<label for="pass" class="control-label col-md-4">Password</label>
			<div class="col-md-4">
				<input type="password" name="password" class="form-control">
			</div>
		</div>
		<div class="center">
			<button type="submit" name="submit" class="btn btn-primary">Login</button>
		</div>

		<div id="alert" class="alert alert-danger" style="	display: none ; float: center; text-allign:center" >
			<strong> Wrong username or password!!!! Please retype information</strong>
		</div>
	</form>

	<?php
	if (isset($_POST['username']) && isset($_POST['password']))
	{
		// Send username/password to Tomcat server for authenticating
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "http://node15791-env-9772882.cloudjiffy.net/Book/rest/services/login/");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded')); // In Java: @Consumes(MediaType.APPLICATION_FORM_URLENCODED)

		$data = array('username'=>$_POST['username'],'password'=>$_POST['password']);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

		$output = curl_exec($ch);
		$info = curl_getinfo($ch);
		curl_close($ch);

		//If the server returns TRUE, then print something
		if($output == "true")
		{
			// Start session
			$username                      = $_POST['username'];
			$_SESSION["username"]          = $username;
			header("Location: books.php");
		}
		else
		{
			?>
			<script>
				document.getElementById('alert').style.display = 'block';
			</script>
		<?php }
	}
	?>
</div>
<?php
	require_once "./template/footer.php";
?>
<style>
	.center {
		margin: auto;
		width: 20%;
		padding: 10px;
		margin-left: auto;
		margin-right: auto;
	}
</style>
