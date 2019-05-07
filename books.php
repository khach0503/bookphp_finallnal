<?php
  ob_start();
  session_start();
  //if(!isset($_SESSION['username'])){
  //header("Location: user_login.php");}
  error_reporting(0);
  $count = 0;
  // connecto database




  $title = "Full Catalogs of Books";
  require_once "./template/header.php";
$ch_Info = curl_init();
curl_setopt($ch_Info, CURLOPT_URL, "http://node15791-env-9772882.cloudjiffy.net/Book/rest/services/checkuseravailable/");
curl_setopt($ch_Info, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch_Info, CURLOPT_POST, 1);
curl_setopt($ch_Info, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
$data = array('accid'=>$_SESSION['username']);
curl_setopt($ch_Info, CURLOPT_POSTFIELDS, http_build_query($data));

curl_exec($ch_Info);
$info = curl_getinfo($ch_Info);
curl_close($ch_Info);

  $ch_Info = curl_init();
  curl_setopt($ch_Info, CURLOPT_URL, "http://node15791-env-9772882.cloudjiffy.net/Book/rest/services/GetBook/");
  curl_setopt($ch_Info, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch_Info, CURLOPT_POST, 1);
  curl_setopt($ch_Info, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));

  $output = curl_exec($ch_Info);
  $info = curl_getinfo($ch_Info);
  curl_close($ch_Info);
  $resultma = (array) json_decode($output);

  //print_r($resultma);



  $ch_Info = curl_init();
  curl_setopt($ch_Info, CURLOPT_URL, "http://node15791-env-9772882.cloudjiffy.net/Book/rest/services/getcart/");
  curl_setopt($ch_Info, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch_Info, CURLOPT_POST, 1);
  curl_setopt($ch_Info, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded')); // In Java: @Consumes(MediaType.APPLICATION_FORM_URLENCODED)
  $data = array('username'=>$_SESSION['username']);
  curl_setopt($ch_Info, CURLOPT_POSTFIELDS, http_build_query($data));

  $output = curl_exec($ch_Info);
  $info = curl_getinfo($ch_Info);
  curl_close($ch_Info);
  $resultcart = json_decode($output);
  $_SESSION['macart'] = $resultcart;








?>
<html>
<body>
<div class="hero-image">
  <div class="hero-text">
    <h1 style="font-size:50px">Saleto & Luke</h1>
    <p>Number 1 online bookstore</p>

  </div>
</div>


  <p class="lead text-center text-muted">Full Catalogs of Books</p>
    <?php //echo $resultma;
    for($i = 0; $i < count($resultma); $i++){
      //if($i % 4 == 0){
    ?>

        <?php
          //echo $i;
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
        ?>

          <div class="col-xs-3">
            <a href="book.php?bookisbn=<?php echo $masach; ?>">
              <img class="img-responsive img-thumbnail" src="./bootstrap/img/<?php echo $image; ?>"> <br>
              <label for="book price"> <?php echo $giatien;  ?> VNĐ</label><br>
              <br>
            </a>

          </div>
        <?php
        } ?>

<?php

  require_once "./template/footer.php";
?>
</body>
</html>
<style>
label{
  vertical-align: middle;
  display: block;
  margin-left: auto;
  margin-right: auto;
}

img:hover {
  animation: shake 0.5s;
  animation-iteration-count: infinite;
}

@keyframes shake {
  0% { transform: translate(1px, 1px) rotate(0deg); }
  10% { transform: translate(-1px, -2px) rotate(-1deg); }
  20% { transform: translate(-3px, 0px) rotate(1deg); }
  30% { transform: translate(3px, 2px) rotate(0deg); }
  40% { transform: translate(1px, -1px) rotate(1deg); }
  50% { transform: translate(-1px, 2px) rotate(-1deg); }
  60% { transform: translate(-3px, 1px) rotate(0deg); }
  70% { transform: translate(3px, 1px) rotate(-1deg); }
  80% { transform: translate(-1px, -1px) rotate(1deg); }
  90% { transform: translate(1px, 2px) rotate(0deg); }
  100% { transform: translate(1px, -2px) rotate(-1deg); }
}

</style>