<?php
interface c1{
    public function __construct();
    public function a();
    public static function b();
}
 class aa implements c1{
public function __construct()
{
    echo "interface construct a ";
}
public function a()
{
    echo "implement function a ";
}
 public static function b()
    {
        echo "static function b ";
        new aa();
    }
 }
 ?>