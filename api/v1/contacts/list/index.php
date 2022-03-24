<?php

require_once "../model.php";

header('Content-type: application/json');

$contact = new Contact();
$data = $contact->dbList();

echo json_encode($data);
