
<?php
class additem
{
    public $cuisinearr,$foodtypearr,$arr1,$arr2;
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
    public function get_data()
{
    $result = $this->pdo->query("SELECT * FROM cuisine_table");
    $this->cuisinearr= $result->fetchAll(PDO::FETCH_ASSOC);
    $result = $this->pdo->query("SELECT * FROM foodtype_table");
     $this->foodtypearr=$result->fetchAll(PDO::FETCH_ASSOC);
      $this->arr1=json_encode($this->cuisinearr);
       $this->arr2=json_encode($this->foodtypearr);
       
          return [$this->arr1,$this->arr2];


}

public function datainsert($data)
{  
        
    if (intval($data['cuisine_id']) == -1)
    {
        if (strlen(trim($data['other_cuisine_name'])) < 1) 
        {
            echo "<script>alert('Invalid cuisine name');</script>";
            exit();
        }
    }

    if (intval($data['category_id']) == -1)
    {
        if (strlen(trim($data['other_category_name'])) < 1)
        {
            echo "<script>alert('Invalid category name');</script>";
            exit();
        }
    }
        
        $food_name = $data['food_name'];   
        $query1="SELECT * FROM  menu_details WHERE food_name = '" .$food_name. "';";
        $result = $this->pdo->query($query1);
        $row=$result->rowCount();
        if ( isset($data["food_id"])||$row==0)
        {   $food_id="";
            $veg_or_noveg = $data['veg_or_noveg'];
            $amount = $data['amount'];
            $tax = 0;
            $cuisine_id=$data['cuisine_id'] ;
            $category_id=$data['category_id'] ;
            if(isset($data['food_id']))
            {
               $food_id=$data['food_id'];
               $result = $this->pdo->query
                    ("
                        UPDATE menu_details 
                        SET 
                            food_name = '$food_name', 
                            veg_or_noveg = '$veg_or_noveg', 
                            status = 1, 
                            amount = $amount, 
                            tax = $tax 
                        WHERE food_id = $food_id
                    ");


            }
            else{
            $result=$this->pdo->query ("INSERT INTO  menu_details
                               VALUES ('','$food_name', '$veg_or_noveg',1, $amount, $tax)");
            $result = $this->pdo->query("SELECT * FROM  menu_details WHERE food_name = '" . $food_name . "';");
            $row=$result->fetch(PDO::FETCH_ASSOC);
            $food_id=$row['food_id'];
            }
            if($cuisine_id==-1)
            {
                $cuisine_name = $_POST['other_cuisine_name'];
                $result=$this->pdo->query ("INSERT INTO  cuisine_table
                               VALUES ('','$cuisine_name');");
                $result=$this->pdo->query("SELECT * FROM cuisine_table WHERE cuisine_name = '$cuisine_name';");
                $row=$result->fetch(PDO::FETCH_ASSOC);
            if ($row) 
            {
                $cuisine_id = $row['cuisine_id'];
            } 
                
            }
            if($category_id==-1)
            {
                $category_name = $_POST['other_category_name'];

                $result=$this->pdo->query ( "INSERT INTO  foodtype_table
                              VALUES ('','$category_name');");
                $result=$this->pdo->query( "SELECT * FROM foodtype_table WHERE type_name = '$category_name';");
                $row=$result->fetch(PDO::FETCH_ASSOC);
                if ($row ) 
                {
                    $category_id= $row['type_id'];
                } 

            }
            if(isset($data['food_id']))
            {
                       $result = $this->pdo->query("
                            UPDATE main 
                            SET 
                                cuisine_id1 = $cuisine_id, 
                                type_id = $category_id 
                            WHERE food_id1 = $food_id
                        ");
                 if ($result) 
            {
                 echo "<script>alert('successfully updated');</script>";
            }  


            }
            else
            {
                 $result=$this->pdo->query("INSERT INTO main  VALUES ($food_id, $cuisine_id,$category_id)");
            if ($result) 
            {
                 echo "<script>alert('successfully added');</script>";
            }  

        }

        }
        else
        {
        echo "<script>alert('Already one item exists with the same name');</script>";
        }

    }

}
?>