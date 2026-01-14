<?php
session_destroy();
header('Location: http://localhost/uas_web/auth/login');
exit;
?>