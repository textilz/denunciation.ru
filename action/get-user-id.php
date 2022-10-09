<?php

require_once 'main.php';
$user_id = $_SESSION['id_user'];

echo json_encode($user_id);