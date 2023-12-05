<?php
session_start();
session_destroy();
header("Location: ../Vistas/index.php");
exit();
?>
