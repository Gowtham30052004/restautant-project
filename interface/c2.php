<?php
include("c1.php");
class bb extends aa
{
    public function __construct()
    {
        echo "class bb construct ";
        parent::a();
        aa::a();
        parent::b();
       aa::__construct();
    }
}

// aa::b();
// $obj=new bb();
// $obj->a();
//bb::b();