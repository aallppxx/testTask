<?php

require_once "../pdo.php";

class Client
{
    public int    $id;
    public string $firstName;
    public string $lastName;
    public string $mobilePhone;
    public string $desc;

    public function __construct(
        string $firstName,
        string $lastName,
        string $mobilePhone,
        string $desc = null
    )
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->mobilePhone = $mobilePhone;
        $this->desc = $desc;

        $this->validateProperties();
    }

    private function returnJsonError($msg) {
        exit ('{error: '.$msg.'}');
    }

    public function validateProperties(): int {
        if (!preg_match('/^[\w-]{2,150}$/', $this->firstName))
            self::returnJsonError('not valid firstName');
        if (!preg_match('/^[\w-]{2,150}$/', $this->lastName))
            self::returnJsonError('not valid lastName');
        if (!preg_match('/^[\d]{10,}$/', $this->mobilePhone))
            self::returnJsonError('not valid mobilePhone');
    }

    public function dbInsert(): void {
        try {
            $statement = $pdo->prepare(
                'INSERT INTO client(firstName, lastName, mobilePhone, desc) '.
                'VALUES (:firstName, :lastName, :mobilePhone, :desc) '
            );
            $statement->execute(
                array(
                    'firstName' => $this->firstName,
                    'lastName' => $this->lastName,
                    'mobilePhone' => $this->mobilePhone,
                    'desc' => $this->desc
                )
            );
        } catch (Exception $e) {
            error_log('db error during insert new record: '.$e->getMessage());
        }
    }

    public function dbModify($id): int {
        return false;
    }
}
