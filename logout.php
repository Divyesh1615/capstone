<?php
session_start();
session_destroy();
header("Location: /Capstones/admin/login.php");
exit();
?>
