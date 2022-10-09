<?php

require_once 'main.php';
$id_post = $_POST['post'];

$votes = mysqli_fetch_all(mysqli_query($connect, "SELECT SUM(`vote`) as 'votes_sum' FROM `votes` WHERE `id_post` = $id_post"), MYSQLI_ASSOC);
$votes = $votes[0];

echo json_encode($votes);