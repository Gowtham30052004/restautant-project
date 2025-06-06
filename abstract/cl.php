<?php
abstract class a
{  
     public function __construct()
     {
       echo "construct";    
       $this->h();
     }
      
   abstract public function b();
    public function b1(){
        echo "normal function ";
    }
    private function b2 ()
    {
         echo "normal function1 ";
    }
    public static function h()
     {
       echo "construct1";    
     }
}
//traits


?>