<?php

require_once 'main.php';

$service = $_POST['service'];

$id_service = mysqli_fetch_all(mysqli_query($connect, "SELECT id_services FROM services INNER JOIN posts ON services.id_services = posts.id_service WHERE services.name = '$service';"), MYSQLI_ASSOC);

echo $id_service[0];

if ($id_service[0] != null) {
    header("Location: ../all-reviews.php?service=".$id_service[0]['id_services']);
} else {
    header("Location: ../index.php");
}
