<?php

session_start();

// Redirect ke halaman login ketika tidak ada sesi
if(!isset($_SESSION["user"])) header("Location: login.php");