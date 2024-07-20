<?php

namespace GPD\Core\Security;

use GPD\App\Entity\UtilisateurEntity;
use GPD\Core\Database\MysqlDatabase;
use GPD\Core\Impl\IDatabase;

class SecurityDatabase
{
    private $database;

    public function __construct(IDatabase $database)
    {
        $this->database = $database;
    }

    public function getUser($email, array $otherTables = [])
    {
        if (count($otherTables) == 0){
            $sql = "SELECT * FROM utilisateurs WHERE email = :email";
            return $this->database->prepare($sql, ["email" => $email], UtilisateurEntity::class, true);
        }

        $sql = "SELECT * FROM utilisateurs";
        foreach ($otherTables as $table){
            $column = substr($table, 0, -1);
            $sql.= " UNION SELECT *, '{$column}' as role FROM $table";
        }
        $sql = "SELECT * FROM (".$sql.") as user";
        $sql.= " WHERE email = :email";

        return $this->database->prepare($sql, ["email" => $email], UtilisateurEntity::class, true);

    }
}
