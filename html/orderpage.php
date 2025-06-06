<html>
  <style>
        .img
        {
            display:none;
        } 
  </style>
</html>
<?php
 include ('index.php');
  include("formfunction.php");
  include("orderform.php");
if (!isset($_SESSION["name"])) {
    echo '<script>
        alert("Session expired or not set. Redirecting to login page.");
    </script>';
    exit(); 
}

// if (isset($_POST['order'])||isset($_POST['submit']) )
// {
//   include("orderform.php");
// }

$obj3=new order_details();
$array=json_decode($obj3->data(0),1);
//print_r($array);

?>

<link rel="stylesheet" href="index.css">
  <?php foreach ($array as $orderId => $order): ?>
    <br>
  <div class="one">
    <div class="order-header">
      <div>Table: <?= htmlspecialchars($order['tablename']) ?></div>
      <div>User: <?= htmlspecialchars($order['customer_name']) ?></div>
      <div>
        Total: ₹
        <?= array_reduce($order['foods'], function($total, $item) {
              return $total + ($item['amount'] * $item['count']);
            }, 0);
        ?>
      </div>
    </div>

    <div class="toggle-section">
      <input type="checkbox" id="toggle-<?= $orderId ?>" class="toggle">
      <label for="toggle-<?= $orderId ?>" class="show-label">View Details</label>

      <div class="food-details">
        <?php foreach ($order['foods'] as $food): ?>
          <div class="item">
            <?= htmlspecialchars($food['food_name']) ?> -
            ₹<?= $food['amount'] ?> - x<?= $food['count'] ?>
          </div>
        <?php endforeach; ?>
        
        <form action="" method="post">
          <input type="hidden" name="order_id" value="<?= $orderId ?>">
          <input type="submit" name="edit" value="Edit">
          <input type="submit" class="edit-btn" name="Finish" value="Finish">
        </form>
      </div>
    </div>
  </div>
<?php endforeach; ?>

<form method="post" >
  <input type="submit" id="take"class="foodorder2" name="order" >
  <label for="take" class="foodorder1">+</label>
</form>
 
 







