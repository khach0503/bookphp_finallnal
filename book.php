<?php
  session_start();

  $book_isbn = $_GET['bookisbn'];
  // connecto database







  $ch_Info = curl_init();
  curl_setopt($ch_Info, CURLOPT_URL, "http://node15791-env-9772882.cloudjiffy.net/Book/rest/services/BookInfo/");
  curl_setopt($ch_Info, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch_Info, CURLOPT_POST, 1);
  curl_setopt($ch_Info, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded')); // In Java: @Consumes(MediaType.APPLICATION_FORM_URLENCODED)
  $data = array('book'=>$book_isbn);
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

  $title = $tensach;
  require "./template/header.php";
?>

      <!-- Example row of columns -->
      <p class="lead" style="margin: 25px 0"><a href="books.php">Books</a> > <?php echo $tensach; ?></p>
      <div class="row">
        <div class="col-md-3 text-center">
          <img class="img-responsive img-thumbnail" src="./bootstrap/img/<?php echo $image; ?>">
        </div>
        <div class="col-md-6">
          <h4>Book Description</h4>
          <p><?php echo $mota; ?></p>
          <h4>Book Code</h4>
          <p><?php echo $masach; ?></p>
          <h4>Author</h4>
          <p><?php echo $tacgia; ?></p>
          <h4>Price</h4>
          <p><?php echo $giatien; ?></p>
          <h4>Stock</h4>
          <p><?php
            if($soluong > 0)
              echo $soluong;
            else
              echo "Out of stock."?></p>
          <table class="table">


            <?php

              if(isset($conn)) {mysqli_close($conn); }
            ?>
          </table>
          <?php
          if($soluong > 0){
          ?>
          <form method="post" action="cartupdate.php">
            <input type="hidden" name="bookisbn" value="<?php echo $book_isbn;?>">
            <button type="submit" value="<?php echo $masach;?>" name="masach" class="btn btn-primary">Add to cart</button>
          </form>
          <?php
          }
          ?>
       	</div>
      </div>
<?php
  require "./template/footer.php";
?>
