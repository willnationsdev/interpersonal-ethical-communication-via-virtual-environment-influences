<?php

session_start();

header("Location:".$_SESSION['destination']);
//header("Location:test.php");
?>
