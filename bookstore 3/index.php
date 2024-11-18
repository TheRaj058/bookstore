<?php
  session_start();
  $count = 0;
  
  $title = "Homepage";
  // connecto database
  require_once "./functions/database_functions.php";
  $conn = db_connect();

  $query = "SELECT book_isbn, book_image,book_title FROM books";
  $result = mysqli_query($conn, $query);
  if(!$result){
    echo "Can't retrieve data " . mysqli_error($conn);
    exit;
  }

  require_once "./template/header.php";
?>
      <!-- check if session is valid with admin-->
      <?php if(
        // check if the logged in user session role is admin
        isset($_SESSION['logged_in']) && $_SESSION['logged_in'] = true 
      ){ ?>
        <div class="row d-flex justify-content-between">
          <div class="col-md-10">
            <h3>Welcome 
                <!--show the username from -->
                <?php echo $_SESSION['username']; ?>
            !</h3>
          </div>
          <?php if( isset($_SESSION['role']) && $_SESSION['role'] == 'admin'){ ?>
          <div class="col-md-2">
            <a href="admin_book.php" class="btn btn-primary">
              <span>Stock levels</span> 
            </a>
          </div>
          <?php } ?>
        </div>
      <?php } ?>
    
    <?php for($i = 0; $i < mysqli_num_rows($result); $i++){ ?>
      <div class="row">
        
        <?php while($query_row = mysqli_fetch_assoc($result)){ ?>
          <div class="col-md-3">
            <a href="book.php?bookisbn=<?php echo $query_row['book_isbn']; ?>">
              <img class="img-responsive img-thumbnail" src="./bootstrap/img/<?php echo $query_row['book_image']; ?>">
              <h4><?php echo $query_row['book_title']; ?></h4>
            </a>
          </div>
        <?php
          $count++;
          if($count >= 4){
              $count = 0;
              break;
            }
          } ?> 
      </div>
<?php
      }
  if(isset($conn)) { mysqli_close($conn); }
  require_once "./template/footer.php";
?>