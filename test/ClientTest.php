<?php


use PHPUnit\Framework\TestCase;

require_once dirname(__FILE__).'/../api/v1/client/client.php';

class ClientTest extends TestCase
{
    public function testDatabaseWork() {
        $client = new Client();

        $stage = 2;
        while ($stage) {
            $data = $client->dbList();
            if (!count($data)) {
                $this->AssertTrue($client->setItem(
                    'firstName1',
                    'lastName1',
                    '1234567890',
                    'some comment'
                ));
                $this->AssertTrue($client->dbInsert());
                $stage = 0;
            } else {
                $statement = $client->pdo->prepare('DROP TABLE client');
                $statement->execute();
                $statement = $client->pdo->prepare(
                    'CREATE TABLE client (
                        id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                        firstName   varchar(150) NOT NULL,
                        lastName    varchar(150) NOT NULL,
                        mobilePhone varchar(16) NOT NULL,
                        comment     TEXT DEFAULT NULL,
                        createTS    TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                    )'
                );
                $statement->execute();
                $stage--;
                sleep(1);
            }
        }
        $data = $client->dbList();
        $this->AssertTrue(count($data) > 0);
        $record = $data[0];
        $this->AssertTrue($record->id == 1);
        $this->AssertTrue($record->firstName == $client->firstName);
        $this->AssertTrue($record->lastName == $client->lastName);
        $this->AssertTrue($record->mobilePhone == $client->mobilePhone);
        $this->AssertTrue($record->comment == $client->comment);

        $client->setItem('firstName2', 'lastName2', '12345678901', 'comment2');
        $this->AssertTrue($client->dbInsert());
        $client->setItem('firstName3', 'lastName3', '123456789012', 'comment3');
        $this->AssertTrue($client->dbInsert());
    }

}
