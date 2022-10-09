<?php

require_once 'main.php';

$id_service = $_POST['idService'];
$select = "SELECT `image` FROM services WHERE `id_services` = $id_service";
$query_image = mysqli_query($connect, $select);

while($row = mysqli_fetch_array($query_image, MYSQLI_ASSOC)) {

        $image = base64_encode($row['image']);
}

echo $image;