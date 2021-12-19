<?php

require_once "../client.php";

header('Content-type: application/json');

$client = new Client();
$data = $client->dbList();

echo json_encode($data);
