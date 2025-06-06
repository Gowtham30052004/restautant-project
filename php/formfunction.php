<?php

class MenuHandler2 {
    public $arr;
    public $pdo;
    public function __construct() 
    {
        $database = "mysql";
        $host = "localhost";
        $dbname = "order_admin";
        $port = "3307";
        $user = "root";
        $pass = "";
       $this-> pdo = new PDO("$database:host=$host;dbname=$dbname;port=$port", $user, $pass);
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
                $foodarray[$row['food_id'] ]= [
                    'quantity'     => 0,
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
    public function insertdata($foodarray, $table_id)
    {
        //print_r($foodarray);
       // return 0;
    
    $query = "INSERT INTO order_table (table_id, user_id, status, order_name) VALUES (?, ?, ?, ?)";
    $stmt = $this->pdo->prepare($query);
    $stmt->execute([
        $table_id,
        1,
        1,
        $_SESSION['order_name']
    ]);

    $order_id = $this->pdo->lastInsertId();
    $query = "INSERT INTO order_detail (order_id, food_id, count) VALUES (?, ?, ?)";
    $stmt = $this->pdo->prepare($query);

        foreach ($foodarray as $food) 
        {
            if ($food['quantity'] > 0) {
                $stmt->execute([
                    $order_id,
                    $food['food_id'],
                    $food['quantity']
                ]);
            }
        }
         return 0;
    }
}

 class order_details extends MenuHandler2
{
    public $orderarray;
   public function data($order_id)
{
    $orderarray = [];
    $foodnamearr = json_decode($this->displayMenu(""), true);
    if($order_id)
    {
        $query = "SELECT * FROM order_detail where order_id=$order_id";
    }
    else
    $query = "SELECT * FROM order_detail";
    $stmt = $this->pdo->query($query);

    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $orderId = $row['order_id'];
            $foodId = $row['food_id'];
            if (!isset($orderarray[$orderId])) {
                $orderarray[$orderId] = [
                    'foods' => []
                ];
            }

            $orderarray[$orderId]['foods'][$foodId] = [
                "food_name" => $foodnamearr[$foodId]['food_name'] ?? 'Unknown',
                'count'     => $row['count'],
                'amount'    => $foodnamearr[$foodId]['amount'] ?? 0
            ];
        }
    }
    $query = "SELECT * FROM order_table";
    $stmt = $this->pdo->query($query);

    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $orderId = $row['order_id'];

            if (!isset($orderarray[$orderId])) {
                $orderarray[$orderId] = [];
            }

            $orderarray[$orderId]['tablename'] = $row["table_id"];
            $orderarray[$orderId]['customer_name'] = $row["order_name"];
        }
    }



 return json_encode($orderarray);
}

}
// $obj=new order_details();
// $obj->data();
?>