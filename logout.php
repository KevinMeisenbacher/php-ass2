<?php
//If a session doesn't exist start one to avoid errors
if (session_status() == PHP_SESSION_NONE) {
session_start();
}
session_destroy(); // removes all session data
header("Location: ./login_form.php" );
?>