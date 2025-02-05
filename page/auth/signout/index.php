<?php
include('../../../helpers.php');
session_start();
session_destroy();

header('Location: ' . url('auth/signin'));
exit;
?>