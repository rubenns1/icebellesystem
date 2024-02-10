<?php
if(!$_SESSION["LOGIN"])
{
    header("location:./index.php");
    exit();
}
