<?php

require_once "../../pdo.php";

$statement = $pdo->prepare(
    'SELECT id,firstName,lastNmae,mobilePhone,desc '.
            'FROM client WHERE SORT BY firstName,lastName '
);
$statement->execute();

$data = $statement->fetchAll();

echo json_encode($data);
