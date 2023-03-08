<?php

$host = 'localhost';
$user = 'root';
$pwd = 'xurui ';

$conn = mysqli_connect($host, $user, $pwd);
if (!$conn) {
    die('error to connect' . mysqli_connect_error());
}
@mysqli_query($conn, 'set names utf8');
mysqli_select_db($conn, 'user');

$selectall = 'SELECT * FROM `SCORE`';
$insert = 'INSERT INTO `SCORE`(`SUBJECT`, `SCORE`, `CREDIT`, `AUX`) VALUES (?, ?, ?, ?)';

//select all from score
$selectRes = mysqli_query($conn, $selectall);
while($rows = mysqli_fetch_row($selectRes)) {
    echo implode(' ', $rows)."<br>";
}


// insert
if (isset($_POST['credit']) && isset($_POST['subject']) &&
    isset($_POST['aux']) && isset($_POST['score'])) {

    $subject = $_POST['subject'];
    $score = (float)$_POST['score'];
    $credit = (int)$_POST['credit'];
    $aux = (int)$_POST['aux'];

    $stmt = mysqli_prepare($conn, $insert);
    mysqli_stmt_bind_param($stmt, 'sdii', $subject, $score, $credit, $aux);
    $result = mysqli_stmt_execute($stmt);

    if (!$result) {
        die('Error sql query' . mysqli_error($conn));
    } else {
        echo 'Insert successful!!!';
    }
}



mysqli_close($conn);

