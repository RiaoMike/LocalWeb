<?php

$host = 'localhost';
$user = 'root';
$pwd = 'xurui ';

$conn = mysqli_connect($host, $user, $pwd, 'user');

$query = "SELECT title,content FROM wp_news WHERE id=" . $_GET['id'];
$res = mysqli_query($conn, $query);

$arr = mysqli_fetch_array($res);

echo '<center>';
echo '<h1>'.$arr['title'].'</h1>';
echo '<br>';
echo '<h1>'.$arr['content'].'</h1>';
echo '</center>';
