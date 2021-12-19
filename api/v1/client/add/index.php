<?php

require_once "../client.php";

header('Content-type: application/json');

$ctx = file_get_contents('php://input');
$json = json_decode($ctx, true);

if (isset($json['firstName'], $json['lastName'], $json['mobilePhone'])) {
    $client = new Client(
        $json['firstName'],
        $json['lastName'],
        $json['mobilePhone'],
        $json['comment']
    );
    echo $client->dbInsert() ? '{"ok": true}' : $client->someError;
} else {
    exit('{"error": "not valid request"}');
}
