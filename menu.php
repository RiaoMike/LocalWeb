<?php

if(!isset($_GET['id'])) {
    show_source(__FILE__);
    die;
}

$a = 'aejfi';
$id = $_GET('id');
@parse_str($id);

if($a[0] != "QNKCDZO" && md5($a[0]) == md5("QNKCDZO")) {
    die('flag');
}
else {
    die('emmm');
}

