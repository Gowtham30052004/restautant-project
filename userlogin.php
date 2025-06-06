<?php
session_start();
?>

<!DOCTYPE html>
<html>
    <head>
      <link rel="stylesheet" href="logincss.css">
    </head>
    <body>
    <div class="login-container">
    <h2>Login</h2>
    <form method="post" target="_self" action="">
      <div class="radio-group">
        <input type="radio" id="admin" name="login" value="admin" checked>
        <label for="admin">Admin</label>

        <input type="radio" id="user" name="login" value="user">
        <label for="user">User</label>
      </div>

      <div class="form-group">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" placeholder="Enter username" required>
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Enter password" required>
      </div>
      <?php
          if (isset($_SESSION['error'])) {
              echo '<p style="color: red;">' . $_SESSION['error'] . '</p>';
              unset($_SESSION['error']);
          }
      ?>
      <input type="submit" class="login-btn" name="adminlogin" value="login">
    </form>
  </div>
          
    </body>

</html>
<?php


if(isset($_POST['adminlogin']))
{
    $my=mysqli_connect('localhost','root','','order_admin','3307');
  $a=$_POST['username'];
  $p=$_POST['password'];
  $user=$_POST['login'];
 $stmt = $my->prepare("SELECT * FROM $user WHERE user_name = ? AND password = ?");
$stmt->bind_param("ss", $a, $p);
$stmt->execute();
$result = $stmt->get_result();
if($row = $result->fetch_assoc()) {
  
    print_r($row);  
 
   $_SESSION["name"]=$a;
   $_SESSION['usertype']=$user;
   $_SESSION['id']=$row['userid'];
 
  header("location:index.php");
 }

 else{
  $_SESSION['error']='username password incorrect';
    header('location:userlogin.php');
 }

}
if(isset($_POST['logout']))
{
    session_destroy();

}

?>
