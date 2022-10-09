<?php

require_once 'main.php';

$image = addslashes(file_get_contents($_FILES['image']['tmp_name']));
$name = $_POST['service-name'];
$url = $_POST['service-url'];

$insert = "INSERT INTO services (`image`, `name`, `url`) VALUES ('$image', '$name', '$url')";
mysqli_query($connect, $insert);

header("Location: ../create-post.php");