<?php

namespace Bukubuku\Core;

class Database
{

    public \PDO $pdo;

    public function __construct(string $dsn, string $username, string $password)
    {
        $this->pdo = new \PDO($dsn, $username, $password);


        //Throw exceptions in case of errors.
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        //Set the fetch mode to FETCH_ASSOC.
        $this->pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
    }

    public function prepare($query)
    {
        return $this->pdo->prepare($query);
    }

    public function beginTransaction()
    {
        return $this->pdo->beginTransaction();
    }

    public function commit()
    {
        return $this->pdo->commit();
    }

    public function rollback()
    {
        return $this->pdo->rollBack();
    }
}
