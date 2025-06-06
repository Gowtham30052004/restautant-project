<?php
class MenuHandler {
    public $arr;
    public $pdo;
  

    public function __construct() {
        $database = "mysql";
        $host = "localhost";
        $dbname = "order_admin";
        $port = "3307"; // Change to 3306 if you're using default MySQL
        $user = "root";
        $pass = "";

        try {
            $dsn = "$database:host=$host;port=$port;dbname=$dbname";
            $this->pdo = new PDO($dsn, $user, $pass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // echo "Connection successful!";
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }


    public function displayMenu($foodname)
    {   
        $querys="SELECT * FROM menu_details ORDER BY status DESC";
        if(strlen($foodname))
        { 
             $querys="SELECT * FROM menu_details where food_name like '%$foodname%' ORDER BY status DESC";
        }

        $stmt = $this->pdo->query($querys);
         //echo($stmt->rowCount());
        if ( $stmt->rowCount() > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $foodarray[] = [
                    'food_id'      => $row['food_id'],
                    'food_name'    => $row['food_name'],
                    'veg_or_noveg' => $row['veg_or_noveg'],
                    'status'       => (int)$row['status'],
                    'amount'       => $row['amount']
                ];
            }
        }
        else
        {
            $foodarray="Food Not found";
        }
          $this->arr=json_encode($foodarray);
          return $this->arr;
     }
     public function edit($food_id)
     {    
          
        $result=$this->pdo->query("SELECT * FROM menu_details WHERE food_id = $food_id;");
        $result1=$this->pdo->query("SELECT * FROM main WHERE food_id1 = $food_id;");
        if ($row=$result->fetch(PDO::FETCH_ASSOC)) 
        {
          $food_name=$row["food_name"];
          $amount=$row['amount'];
          $veg=$row['veg_or_noveg'];
        }
        if ($row1=$result1->fetch(PDO::FETCH_ASSOC))
        {
            $cuisineid = $row1['cuisine_id1'];
            $categoryid=$row1['type_id'];
            $result1=$this->pdo->query ("SELECT * FROM cuisine_table WHERE cuisine_id = '$cuisineid';");
            $row1=$result1->fetch(PDO::FETCH_ASSOC);
            $cuisinename=$row1['cuisine_name'];
            $result2=$this->pdo->query("SELECT * FROM foodtype_table WHERE type_id = '$categoryid';");
            $row2=$result2->fetch(PDO::FETCH_ASSOC);
           $categoryname =$row2['type_name'];
        } 
       $data = [
                 'food_id' => $food_id,
                'food_name' => $food_name,
                'amount' => $amount,
                 'veg' => $veg,
                 'cuisine_id'=> $cuisineid,
                 'category_id'=>$categoryid,
                'cuisine_name' => $cuisinename,
                'category_name' => $categoryname
              ];
      return json_encode($data);

      
        
     }

}
class child extends MenuHandler
{
  public function statusmodify($foodid,$status1)
    {    
          if($status1)
          {
            $status1=0;
          }
          else
          {
            $status1=1;
          }
            $this->pdo->query("UPDATE menu_details SET status= $status1 WHERE food_id=$foodid");?>
        <script>
    alert("Successfully updated!");
     </script>
    <?php 
    }
    public function delete($foodid)
    {
             $this->pdo->query("DELETE t1, t2 FROM menu_details t1 JOIN main t2 on t1.food_id = t2.food_id1 where t1.food_id = $foodid");

    ?> <script>
    alert("Successfully deleted");
     </script>
     <?php
    }
    

}
?>
