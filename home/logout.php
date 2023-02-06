<?php
include 'connectDB.php';
session_start();
session_destroy();
header('location:login.php');
?>