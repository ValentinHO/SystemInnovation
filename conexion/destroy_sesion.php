<?php

    unset($_SESSION['nombreUsuario']);
    unset($_SESSION['iduser']);
    session_destroy();
   	header('Location: ../index.php');     
    exit();
?>