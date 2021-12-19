<?php

//require_once dirname(__FILE__).'/../pdo.php';

class Client
{
    public        $pdo;
    public int    $id;
    public string $firstName;
    public string $lastName;
    public string $mobilePhone;
    public string $comment;
    public string $someError;

    public function __construct(
        string $firstName = '',
        string $lastName = '',
        string $mobilePhone = '',
        string $comment = ''
    )
    {
        $this->pdo = new PDO('mysql:host=127.0.0.1;dbname=testTask', 'root', 'toor');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if (!empty($firstName))
            $this->setItem($firstName, $lastName, $mobilePhone, $comment);
    }

    public function setItem(
        string $firstName,
        string $lastName,
        string $mobilePhone,
        string $comment = ''
    ): bool {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->mobilePhone = $mobilePhone;
        $this->comment = $comment;

        $this->someError = self::validateProperties();
        return empty($this->someError) ? true : false;
    }

    private function returnJsonError($msg): string {
        return '{"error": "'.$msg.'"}';
    }

    public function validateProperties(): string {
        if (!preg_match('/^[\w-]{2,150}$/', $this->firstName))
            return self::returnJsonError('not valid firstName');
        if (!preg_match('/^[\w-]{2,150}$/', $this->lastName))
            return self::returnJsonError('not valid lastName');
        if (!preg_match('/^[\d]{10,}$/', $this->mobilePhone))
            return self::returnJsonError('not valid mobilePhone');
        return '';
    }

    public function dbInsert(): bool {
        if (empty($this->someError))
        try {
            $statement = $this->pdo->prepare(
                'INSERT INTO client(firstName, lastName, mobilePhone, comment) '.
                'VALUES (:firstName, :lastName, :mobilePhone, :comment) '
            );
            $statement->execute(
                array(
                    'firstName' => $this->firstName,
                    'lastName' => $this->lastName,
                    'mobilePhone' => $this->mobilePhone,
                    'comment' => $this->comment
                )
            );
            return true;
        } catch (Exception $e) {
            $this->someError = 'db error during insert new record: '.$e->getMessage();
        }
        return false;
    }

    public function dbModify($id): int {
        return false;
    }

    public function dbList(int $limit = 100, int $offset = 0): array {
        $statement = $this->pdo->prepare(
            'SELECT id,firstName,lastName,mobilePhone,comment '.
            'FROM client ORDER BY firstName,lastName LIMIT '.$offset.','.$limit
        );
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_CLASS);
    }
}
