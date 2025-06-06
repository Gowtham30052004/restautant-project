<?php
//include("formfunction.php");

function form1($fooditems)
{
    ?>
    <link rel='stylesheet' type='text/css' href='index.css'>
    <div class="foodorder">
        <div class="form1">
            <form method="post">
                <h4>Select Food Items:</h4>
                <input id="add" class="close" type="submit" name="submit" value="Close" style="display:none;">
                <label for="add" class="close">&times;</label>
                <div class="search">
                    <input type="search" id="foodname" name="item" placeholder="eg:Biriyani">
                    <input type="submit" class="search-button" name="submit" value="Search">
                    <h5>Customer Name:</h5>
                    <input type="text" id="foodname" name="table_id" placeholder="eg:t1" value="<?= isset($_SESSION['table_id']) ? $_SESSION['table_id'] : "" ?>">
                    <h5>Table Name:</h5>
                     <input type="text" id="foodname" name="order_name" placeholder="eg:ram" value="<?= isset($_SESSION['order_name']) ? $_SESSION['order_name'] : "" ?>">
                </div>
                <div class="heading">
                    <div class="t1">Food Name</div>
                    <div class="t2">Qty</div>
                    <div class="t3">Amount</div>
                </div>
                <?php foreach ($fooditems as $i => $item) { ?>
                    <div class="city-button">
                        <input type="checkbox" id="city<?= $i ?>" name="selectedfood[<?= $item['food_id'] ?>]" value="<?= $item['food_id'] ?>"
                            <?= ($item['quantity'] > 0) ? 'checked' : '' ?>>
                        <label for="city<?= $i ?>" class="food1"><?= $item['food_name'] ?></label>
                        <input type="number" name="count[<?= $item['food_id'] ?>]" min="1" max="10"
                               value="<?= ($item['quantity'] > 0) ? $item['quantity'] : 1 ?>">
                        <div class="amount">
                            <?= ($item['quantity'] > 0) ? ($item['amount'] * $item['quantity']) : $item['amount'] ?>
                        </div>
                    </div>
                <?php } ?>
                <input class="orderconform" type="submit" name="submit" value="Conform">
            </form>
        </div>
    </div>
    <?php
}

// <?php
// session_start();
include_once("formfunction.php"); 
if(isset($_POST['edit']))
{
    $obj3=new order_details();
   $arr= $obj3->data($_POST["order_id"]);
    $fooditems = json_decode($arr, true);
    form1($fooditems);
    return;
}

$obj2 = new MenuHandler2();

if (!isset($_SESSION['food'])) 
{
    $arr = $obj2->displayMenu("");
    $fooditems = json_decode($arr, true);
} 
else 
{
    $fooditems = $_SESSION['food'];
}
if(isset($_POST["order"]))
form1($fooditems);

if (isset($_POST['submit']))
 {
    $_SESSION['table_id'] = $_POST['table_id'] ?? '';
    $_SESSION['order_name'] = $_POST['order_name'] ?? '';

    if ($_POST["submit"] == "Close") 
    {
        unset($_SESSION["food"], $_SESSION["table_id"], $_SESSION["order_name"]);
        echo "<script>alert('Order Canceled');</script>";
        return;
    }

    $selectedfood = $_POST['selectedfood'] ?? [];
    $count = $_POST['count'] ?? [];
    $commonkeys = array_intersect_key($count, $selectedfood);

    foreach ($commonkeys as $i => $value)
     {
        if (isset($fooditems[$i])) 
        {
            $fooditems[$i]["quantity"] = (int)$value;
        }
    }
   

    $_SESSION['food'] = $fooditems;

    if ($_POST["submit"] == "Search") 
    {
        if (!empty($_POST['item'])) 
        {
            $filterKeys = json_decode($obj2->displayMenu($_POST['item']), true);

            if (is_array($filterKeys))
             {
                $filteredfoods = array_intersect_key($fooditems, $filterKeys);
                form1($filteredfoods);
            }
             else 
            {
                echo "<script>alert('Food not found');</script>";
                form1($fooditems);
            }
        } else {
            form1($fooditems);
        }
        return;
    }
     if(!count($commonkeys))
    {
         echo "<script>alert('Please enter fooditems');</script>";
             form1($fooditems);
             return;
    }
    if ($_POST["submit"] == "Conform") {
        if(strlen($_SESSION["table_id"]&& strlen($_SESSION["order_name"])&& count($_SESSION["food"])))
        {
        $obj2->insertdata($_SESSION["food"], $_SESSION["table_id"]);
        unset($_SESSION["food"], $_SESSION["table_id"], $_SESSION["order_name"]);
        echo "<script>alert('Order Confirmed');</script>";
        }
        else
        {
             echo "<script>alert('Please enter user name or table name');</script>";
             form1($fooditems);

        }
        return;
    }

 }


?>
