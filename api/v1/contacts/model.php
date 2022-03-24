<?php

//require_once dirname(__FILE__).'/../pdo.php';

class Contact
{
    public        $pdo;

    public int    $id;
    public int    $sourceID;
    public string $name;
    public string $phone;
    public string $email;
    public string $createDate;
    public string $someError;

    public function __construct(
        int    $sourceID = 0,
        string $name = '',
        string $phone = '',
        string $email = '',
        string $createDate = ''
    )
    {
        $this->pdo = new PDO('mysql:host=127.0.0.1;dbname=testTask', 'root', 'toor');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if (!empty($firstName))
            $this->setItem($sourceID, $name, $phone, $email, $createDate);
    }

    public function setItem(
        int    $sourceID,
        string $name,
        string $phone,
        string $email
    ): bool {
        $this->sourceID = $sourceID;
        $this->name = $name;
        $this->phone = $phone;
        $this->email = $email;

        $this->someError = self::validateProperties();
        return empty($this->someError) ? true : false;
    }

    private function returnJsonError($msg): string {
        return '{"error": "'.$msg.'"}';
    }

    public function validateProperties(): string {
        if (preg_match("/^\+?[7]?[0-9]{10}$/", $this->phone) === false)
            return self::returnJsonError('not valid phone format: ' . $this->phone);
        // TODO: may be name and email validation too
        //if (!preg_match('/^[\w-]{2,150}$/', $this->name))
        //    return self::returnJsonError('not valid name');
        return '';
    }

    public function dbInsert(): bool {
        $this->someError = '';
        try {
            $phone = (int) str_replace('+7', '', $this->phone);

            $statement = $this->pdo->prepare(
                'SELECT id FROM contact WHERE phone = :phone AND createTS > DATE_SUB(NOW(), INTERVAL 1 DAY)'
            );
            $result = $statement->execute(array('phone' => $phone));
            if ($result && $statement->rowCount())
                throw new Exception('new source allowed once per day for the phone number');

            $statement = $this->pdo->prepare(
                'INSERT INTO contact(sourceID, name, phone, email) VALUES (:sourceID, :name, :phone, :email) '
            );
            $statement->execute(
                array(
                    'sourceID' => $this->sourceID,
                    'phone' => $phone,
                    'name' => $this->name,
                    'email' => $this->email
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
            'SELECT id, sourceID, name, phone, email, createTS '.
            'FROM contact ORDER BY phone, createTS LIMIT '.$offset.','.$limit
        );
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_CLASS);
    }
}
