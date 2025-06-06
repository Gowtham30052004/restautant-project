<?php
include("cl.php");
class b extends  a{
   public function b()
    {
        echo"abstract function";
    }
}
class d extends b{
   public function b()
    {
        echo"abstract function2";
    }
}
class c extends d{

     public function b()
    {
     echo"abstract function1";
      parent::b();
     }
    

}
 
new c;
a::h();
?>