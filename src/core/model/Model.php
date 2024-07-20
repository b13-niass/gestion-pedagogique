<?php

namespace GPD\Core\Model;

use GPD\App\App;
use GPD\Core\Database\MysqlDatabase;
use GPD\Core\Entity\Entity;
use GPD\Core\Impl\IModel;

abstract class Model implements IModel
{

    protected ?string $table = null;
    protected static ?string $table_static = null;
    protected ?MysqlDatabase $database = null;
    protected ?Entity $entity = null;
    protected static ?MysqlDatabase $database_static = null;

    public function setTable()
    {
        $className = (new \ReflectionClass($this))->getShortName();
        if (substr($className, -5) === 'Model') {
            $className = substr($className, 0, -5);
        }
        $this->table = strtolower($className) . "s";
        static::$table_static = strtolower($className) . "s";
    }

    public function __get($methodName)
    {
        $reflectionClass = new \ReflectionClass($this);

        if ($reflectionClass->hasMethod($methodName)) {
            $method = $reflectionClass->getMethod($methodName);

            if ($method->isPublic()) {
                return $method->invoke($this);
            } else {
                throw new \Exception("Method {$methodName} is not public in class {$reflectionClass->getName()}");
            }
        } else {
            throw new \Exception("Method {$methodName} does not exist in class {$reflectionClass->getName()}");
        }
    }

    public function __set($name, $value)
    {
        $this->entity->{$name} = $value;
    }


    public static function getTable()
    {
        return self::$table_static;
    }

    public function setEntity()
    {
        $entityClass = $this->getEntityName();
        $this->entity = new $entityClass();
    }

    public function getEntity()
    {
        return $this->entity;
    }

    public function getEntityName()
    {
        $className = (new \ReflectionClass($this))->getShortName();
        if (substr($className, -5) === 'Model') {
            $className = substr($className, 0, -5);
        }
        $entityName = ucfirst($className) . "Entity";

        return "GPD\\App\\Entity\\{$entityName}";
    }

    public static function getEntityNameStatic()
    {
        $className = (new \ReflectionClass(static::class))->getShortName();
        if (substr($className, -5) === 'Model') {
            $className = substr($className, 0, -5);
        }
        $entityName = ucfirst($className) . "Entity";

        return "GPD\\App\\Entity\\{$entityName}";
    }

    private function getRootClassName($className)
    {
        $className = (new \ReflectionClass($className))->getShortName();
        if (substr($className, -5) === 'Model') {
            $className = substr($className, 0, -5);
        }
        if (substr($className, -6) === 'Entity') {
            $className = substr($className, 0, -6);
        }

        return strtolower($className);
    }

    public function all()
    {
        return $this->query("SELECT * FROM {$this->table}", $this->getEntityName());
    }

    public function find(array $data)
    {
        $key = array_keys($data)[0];

        return $this->query(
            "SELECT * FROM {$this->table} WHERE {$key} = :{$key}",
            $this->getEntityName(),
            $data,
            true
        );
    }

    public function query(string $sql, string $className, array $params = [], bool $single = false)
    {
        if (count($params) == 0) {
            $result = $this->database->query($sql, $className, $single);
        } else {
            // dd($sql);
            $result =  $this->database->prepare($sql, $params, $className, $single);
        }
        return $result;
    }

    public function save(array $params)
    {
        $stringInto = [];
        $stringValues = [];

        foreach ($params as $key => $value) {
            $stringInto[] = $key;
            $stringValues[] = ":{$key}";
        }

        $into = implode(', ', $stringInto);
        $values = implode(', ', $stringValues);

        $sql = "INSERT INTO {$this->table} ({$into}) VALUES ({$values})";
        // dd($sql);
        return $this->query($sql, $this->getEntityName(), $params);
    }

    public function delete(int $id)
    {
        return $this->query(
            "DELETE FROM $this->table WHERE id = :id",
            $this->getEntityName(),
            ['id' => $id]
        );
    }

    public static function update(array $data)
    {
        $setParts = [];
        $params = [];

        foreach ($data as $key => $value) {
            if ($key != 'id') {
                $setParts[] = "{$key} = :{$key}";
            }
            $params[$key] = $value;
        }

        $setString = implode(', ', $setParts);
        $sql = "UPDATE " . static::$table_static . " SET {$setString} WHERE id = :id";
//         dd($sql);
        return static::$database_static->prepare($sql, $params, static::getEntityNameStatic(), false);
    }

    public function setDatabase(MysqlDatabase $database)
    {
        $this->database = $database;
        static::$database_static = $database;
    }

    //organiser dossier view par controller

    public function hasMany($classMany, $tableMany=null,$foreignKeyInMany=null)
    {
        $entityNameOne = $this->getRootClassName($this->getEntityName());
        $rootNameMany = $this->getRootClassName("GPD\\App\\Entity\\" . $classMany);
        $entityNameMany = "GPD\\App\\Entity\\" . ucfirst($rootNameMany) . "Entity";
        $modelNameMany = "GPD\\App\\Model\\" . ucfirst($rootNameMany) . "Model";
        $foreignKey = $entityNameOne . "_id";
        $tableManyName = $rootNameMany . "s";

        if($tableMany !=null && $foreignKeyInMany != null && is_string($tableMany) && is_string($foreignKeyInMany)){
            $sql = "SELECT * FROM {$tableMany} WHERE {$foreignKeyInMany} = :foreignKey";
        }else{
            $sql = "SELECT * FROM {$tableManyName} WHERE {$foreignKey} = :foreignKey";
        }

        $arrayOfentity = $this->query($sql, $entityNameMany, ["foreignKey" => $this->entity->id], false);

        $arrayOfModel = array_map(function ($value) use ($rootNameMany) {

            $object = App::getInstance()->getModel(ucfirst($rootNameMany));
            $object->entity = $value;
            return $object;
        }, $arrayOfentity);

        return array_values($arrayOfModel);
    }


    public function belongsTo($classOne, $tableOne=null,$idInOne=null)
    {
        $entityNameMany = $this->getRootClassName($this->getEntityName());
        $rootNameOne = $this->getRootClassName("GPD\\App\\Entity\\" . $classOne);
        $entityNameOne = "GPD\\App\\Entity\\" . ucfirst($rootNameOne) . "Entity";
        $modelNameMany = "GPD\\App\\Model\\" . ucfirst($rootNameOne) . "Model";
        $foreignKey = $rootNameOne . "_id";
        $tableOneName = $rootNameOne . "s";

        if($tableOne !=null && $idInOne != null && is_string($tableOne) && is_string($idInOne)) {
            $sql = "SELECT * FROM {$tableOneName} WHERE {$idInOne} = :id";
        }else{
            $sql = "SELECT * FROM {$tableOneName} WHERE id = :id";
        }

        $entity = $this->query($sql, $entityNameOne, ["id" => $this->entity->{$foreignKey}], true);


        $object = App::getInstance()->getModel(ucfirst($rootNameOne));
        $object->entity = $entity;

        return $object;
    }

    public function belongsToMany($classPivot, $classTarget, $columns = [])
    {
        $rootNameFrom = $this->getRootClassName($this->getEntityName());
        $rootNameTarget = $this->getRootClassName("GPD\\App\\Entity\\" . $classTarget);
        $rootNamePivot = $this->getRootClassName("GPD\\App\\Entity\\" . $classPivot);
        $entityNameTarget = "GPD\\App\\Entity\\" . ucfirst($rootNameTarget) . "Entity";
        $entityNamePivot = "GPD\\App\\Entity\\" . ucfirst($rootNamePivot) . "Entity";
        $modelNameTarget = "GPD\\App\\Model\\" . ucfirst($rootNameTarget) . "Model";
        $foreignKeyFrom = $rootNameFrom . "_id";
        $foreignKeyTarget = $rootNameTarget . "_id";
        $targetTableName = $rootNameTarget . "s";
        $pivotTableName = $rootNamePivot . "s";
        $foreignKeyFrom = substr($this->table, 0, -1) . "_id";
        // if(count($columns)){
        $sql = "SELECT * FROM {$targetTableName}
                JOIN {$pivotTableName} ON {$targetTableName}.id = {$pivotTableName}.{$foreignKeyTarget} WHERE {$pivotTableName}.{$foreignKeyFrom} = :id";
        // }
        // dd($sql);
        $arrayOfentity = $this->query($sql, $entityNamePivot, ["id" => $this->entity->id], false);

        $arrayOfModel = array_map(function ($value) use ($rootNamePivot) {

            $object = App::getInstance()->getModel(ucfirst($rootNamePivot));
            $object->entity = $value;
            return $object;
        }, $arrayOfentity);

        return array_values($arrayOfModel);
    }

    //hasOne 
    //hasMany
    //belongsToMany
    //BelongsTo
    //HasOneOrMany
    //BelongsToMany
    // transaction

    public function transaction(callable $transactions)
    {
        try {
            $this->database->beginTransaction();
            $transactions();
            $this->database->commit();
        } catch (\Exception $e) {
            $this->database->rollback();
            throw new \Exception('Erreur lors de la transaction');
        }
    }
}
