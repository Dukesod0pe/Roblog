<?php
session_start();
session_unset();
session_destroy();
header("Location: mainPage(Before).php");

exit();
?>