<?php
// this starts the session
session_start();

// echo variable from the session, we set this on our other page
echo "<br>Our color value is ".$_SESSION['color'];
echo "<br>Our size value is ".$_SESSION['size'];
echo "<br>Our shape value is ".$_SESSION['shape'];
?>