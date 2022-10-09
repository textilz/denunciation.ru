<?php

require_once 'main.php';

$text = $_POST['textService'];
$select = "SELECT `id_services`, `name`, `url` FROM services WHERE `name` LIKE '%$text%' OR `url` LIKE '%$text%' LIMIT 10";
$data = mysqli_fetch_all(mysqli_query($connect, $select), MYSQLI_ASSOC);

echo json_encode($data);