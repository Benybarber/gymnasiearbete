<?php
$hostname_forumtest = "localhost";
$database_forumtest = "klippotek";
$username_forumtest = "klippotek";
$password_forumtest = "klippotek";


$forum = new PDO(
    "mysql:host=$hostname_forumtest;dbname=$database_forumtest;charset=utf8mb4",
    $username_forumtest,
    $password_forumtest,
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
);