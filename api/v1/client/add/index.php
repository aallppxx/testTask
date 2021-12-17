<?php

require_once "../client.php";


if (isset($_REQUEST['firstName'], $_REQUEST['lastName'], $_REQUEST['mobilePhone'])) {
    $client = new Client(
        $_REQUEST['firstName'],
        $_REQUEST['lastName'],
        $_REQUEST['mobilePhone'],
        $_REQUEST['desc']
    );
    $client->dbInsert();
}
