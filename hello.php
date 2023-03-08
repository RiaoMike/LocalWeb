<?php
if(isset($_REQUEST['fname']) && isset($_REQUEST['age'])){
echo "hello".$_POST["fname"]."<br>";
echo "your age is: ".$_POST["age"];
}
echo md5("QNKCDZO");
phpinfo();