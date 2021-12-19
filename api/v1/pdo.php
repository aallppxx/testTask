<?php

//require_once 'settings.php';

header('Content-type: application/json');

$pdo = new PDO('mysql:host=127.0.0.1;dbname=testTask', 'root', 'toor');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
