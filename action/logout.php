<?php

require_once 'main.php';

$_SESSION['id_user'] = null;

header('Location: ../login.php');