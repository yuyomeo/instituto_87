<?php
    session_start();
    session_destroy();
    $url="http://".$_SERVER["HTTP_HOST"]."/instituto_87/index.php";
    header("Location:".$url);
?>