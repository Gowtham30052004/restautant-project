

 <?php
if (!isset($_SESSION["name"])) {
    echo '<script>
        alert("Session expired or not set. Redirecting to login page.");
    </script>';
    include("userlogin.php");
    exit();
}
?> 


 <html>
    <style>
        .img
        {
            display:none;
        }
        
       
    </style>

<?php
include("index.php");
include ("menufunction.php");
include("additem.php");
$search="";
$row1;
$s="submit";
$obj=new child();
$obj1=new additem();
[$arr1, $arr2]=$obj1->get_data();
$cuisinearr = json_decode($arr1, true);
$foodtypearr= json_decode($arr2, true);
if(isset($_POST['submit']))
{    
 
    $arr=[
            'veg_or_noveg'       => htmlspecialchars(trim($_POST['veg_or_noveg'])),
            'food_name'          => htmlspecialchars(trim($_POST['food_name'])),
            'cuisine_id'         => intval($_POST['cuisine_id']),
            'amount'             => floatval($_POST['amount']),
            'other_cuisine_name' => isset($_POST['other_cuisine_name']) ? htmlspecialchars(trim($_POST['other_cuisine_name'])) : null,
            'category_id'        => intval($_POST['category_id']),
            'other_category_name'=> isset($_POST['other_category_name']) ? htmlspecialchars(trim($_POST['other_category_name'])) : null,
        ];
    if(isset($_POST["food_id"]))
     {
        $arr ['food_id']= htmlspecialchars(trim($_POST['food_id']));
     }
   // print_r($arr);
    $obj1->datainsert($arr);
    
}
else if (isset($_POST['edit']))
{
    $food_id=$_POST['edit'];
    $arr=$obj->edit($food_id);
    $row1= json_decode($arr, true);
    echo '<input type="checkbox" id="form2" class="hidden"  value="1" checked>';
   
}

else if(isset($_POST['status1']))
{
   // $obj1=new MenuHandler();
    $obj->statusmodify($_POST['status'],$_POST['status2']);
}
else if(isset($_POST['delete1']))
{
    $obj->delete($_POST['delete']);
}

else if(isset($_POST['item1']))
{  
    $search=$_POST['item'];
}

    $arr=$obj->displayMenu($search);
    $row = json_decode($arr, true);
?>

    <div class="main1">
        <div class="searchform">
            <form action="" target="_self" method ="post" >
                <label for="foodname"> </label>
                <input type="text" id="foodname" name="item" placeholder="eg:Biriyani">
                <label for="src"></label>
                <input type="submit"  id="search" name ="item1" value="Search ->" >
                <!-- <input type="submit" id="search"   name="item2" value="<-back"> -->
            </form>
        </div> 
        <?php if(is_array($row))
            {
                foreach ($row as $key => $value) 
                {
                    echo "<link rel='stylesheet' type='text/css' href='foodcss.css'>"; ?>
                    <div class="airport-card">
                        <div class="card-top-row">
                            <div class="item"><h4> <?=ucwords($row[$key]["food_name"]) ?></h4></div>
                            <div class="item"> <?=$row[$key]["veg_or_noveg"]  ?></h6></div>
                            <?php if ($row [$key]['status'])
                            {
                                echo '<div class="item available">Available</div>';
                            } 
                            else 
                            {
                                echo '<div class="item unavailable">Unavailable</div>';
                            }
                            echo '<div class="item"><h4>₹' . $row[$key]["amount"] . '</h4></div>';
                        echo '</div>';
                    
                        echo '<div class="action-buttons">';
                            echo '<form action="" method="post">
                                    <input type="hidden" name="status" value="' . $row[$key]["food_id"] . '">
                                    <input type="hidden" name="status2" value="' . $row[$key]["status"] . '">
                                    <button type="submit" class="edit-btn" name="status1">Change Status</button>
                            </form>';
                            echo '<form action="" method="post">
                                    <input type="hidden" name="delete" value="' . $row[$key]["food_id"] . '">
                                    <button type="submit" class="delete-btn" name="delete1">Remove</button>
                            </form>';
                            echo '<form method="post">
                                    <input type="hidden" name="edit" value="' . $row[$key]["food_id"] . '">             
                                    <button type="submit" name="edit1" class="edit-btn">✏️ Edit</button>
                            </form>';
                        echo '</div>';
                    echo '</div>';
                }
            }

        else
            { ?>
                <div class="airport-card" style="border:1px solid red;" >
                    <p style="color:red"><?=$row?></p>;
                </div>
            <?php }
            ?>
    </div>
    <link rel="stylesheet" href="menu.css">
      
<input type="checkbox" id="form2" class="hidden">
<label for="form2" class="btn">+</label>
<div class="form1">
    <label for="form2" class="close">&times;</label>
        <h3>Add Menu Item</h3>
        <form action="" method="post">
            <label>Food Name:</label><br>
            <input type="text" name="food_name" value="<?= isset($row1['food_name']) ? htmlspecialchars($row1['food_name']) : '' ?>"><br><br>
            <?php if(isset($row1['food_id']))
            {  
                echo $food_id;?>
                <input type="hidden" name="food_id" value="<?= $row1['food_id']?>">
                <?php   $s="submit";
            }?>
            <label>Veg Type:</label><br>
            <select name="veg_or_noveg">
                <option value="veg" <?= (isset($row1['veg']) && $row1['veg'] == 'veg') ? 'selected' : '' ?>>Veg</option>
                <option value="nonveg" <?= (isset($row1['veg']) && $row1['veg'] == 'nonveg') ? 'selected' : '' ?>>Non-Veg</option>
                <option value="others" <?= (isset($row1['veg']) && $row1['veg'] == 'others') ? 'selected' : '' ?>>Others</option>
            </select><br><br>

        <label>cuisine_name:</label><br>
        <select name="cuisine_id">
             <option value="<?= "-1"  ?>"><?= "others" ?></option>
          <?php foreach ($cuisinearr as $item): ?>
            <option value="<?= $item['cuisine_id'] ?>" 
                <?= isset($row1['cuisine_id']) && $item['cuisine_id'] == $row1['cuisine_id'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($item['cuisine_name']) ?>
            </option>
          <?php endforeach; ?>
        </select>
        <br><br>
       <details>
       <summary>Can't find your category? Add one:</summary>
       <input type="text" name="other_cuisine_name" placeholder="Enter other category">
       </details>
       <br><br>
        <label>Category Name:</label><br>
        <select name="category_id">
                <option value="<?= "-1"  ?>"><?= "others" ?></option>
            <?php foreach ($foodtypearr as $item): ?>
                <option value="<?= $item['type_id'] ?>" 
                <?= isset($row1['category_id']) && $item['type_id'] == $row1['category_id'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($item['type_name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <br><br>
        <details>
            <summary>Can't find your category? Add one:</summary>
            <input type="text" name="other_category_name" placeholder="Enter other category">
       </details>
       <br><br>
        <label>Amount:</label><br>
        <input type="number" name="amount" value="<?= isset($row1['amount']) ? (int)$row1['amount'] : '' ?>"><br><br>
        
        <input type="submit" name="submit" value=<?=$s?>>
    </form>
</div>
            
  


              <!-- footer start -->
    <link rel="stylesheet" type="text/css" href="foodcss.css" >
    <div class="footer" style="width:100%">
    <div class="footer-content" style="width:100%">
        <p>@copy: 2025 King chef. All rights reserved.</p>
        <div class="footer-links">
            <a href="#">About Us</a>
            <a href="#">Terms of Service</a>
            <a href="#">Privacy Policy</a>
            <a href="#">Contact</a>
        </div>
    </div>
</div>

</div>
