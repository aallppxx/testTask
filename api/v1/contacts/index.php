<?php

require_once "./model.php";

header('Content-type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $ctx = file_get_contents('php://input');
    $json = json_decode($ctx, true);

// Add contacts to base
    if (isset($json['sourceID'], $json['items']) && count($json['items'])) {
        $contactsCtr = 0;
        foreach ($json['items'] as $key => $item) {
            $phone = (string)$item['phone'];

            $contact = new Contact(
                $json['sourceID'],
                $item['name'],
                $item['phone'],
                $item['email']
            );
            if ($contact->dbInsert())
                $contactsCtr++;
            else
                exit($contact->someError);
        }

        echo '{"addedContacts": ' . $contactsCtr . '}';

    } else {
        exit('{"error": "not valid request"}');
    }

} else

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_REQUEST['phone'])) {
        $contact = new Contact();
        $contacts = $contact->findPhone($_REQUEST['phone']);
        echo json_encode($contacts);
    }
}
