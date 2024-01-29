<?php
session_start();
if(isset($_SESSION['admin'])) {
    echo "logged in";
} else {
    echo "not logged in";
}
?>  