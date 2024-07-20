<?php
namespace GPD\App;

use GPD\Core\Container;
use GPD\Core\Impl\IDatabase;
use GPD\Core\Security\SecurityDatabase;
use GPD\Core\Service\ServicesProvider;

class App
{
    private static ?App $instance = null;
    private ?Container $container = null;
    private static ?SecurityDatabase $securityDatabase = null;

    private function __construct()
    {
    }

    public static function getInstance(): App
    {
        if (self::$instance === null) {
            self::$instance = new App();
        }
        return self::$instance;
    }

    public function getContainer(): Container
    {
        if ( $this->container  === null) {
            $this->container = new Container();
        }
        return $this->container;
    }

    public static function getSecurityDB(): SecurityDatabase
    {
        if (self::$securityDatabase === null) {
            self::$securityDatabase = new SecurityDatabase(self::getInstance()->getContainer()->get(IDatabase::class));
        }
        return self::$securityDatabase;
    }

    public function getModel(string $modelName)
    {
        $modelName .= 'Model';
        $class = "GPD\\App\\Model\\{$modelName}";
        $reflectionClass = new \ReflectionClass($class);
        $object = $reflectionClass->newInstance();

        $setTableMethod = $reflectionClass->getMethod('setTable');
        $setTableMethod->invoke($object);

        $setDatabaseMethod = $reflectionClass->getMethod('setDatabase');
        $setDatabaseMethod->invoke($object, $this->container->get(IDatabase::class));

        $setTableMethod = $reflectionClass->getMethod('setEntity');
        $setTableMethod->invoke($object);

        return $object;
    }
}

