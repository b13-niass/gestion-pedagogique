<?php
namespace GPD\Core\Service;

use GPD\Core\Container;
use GPD\Core\Impl\IAuthorize;
use GPD\Core\Impl\IDatabase;
use GPD\Core\Impl\IFile;
use GPD\Core\Impl\IServicesProvider;
use GPD\Core\Impl\ISession;
use GPD\Core\Impl\IValidator;

class ServicesProvider implements IServicesProvider
{
    public function register(Container $container, array $services)
    {
//        dd($services);
        foreach ($services as $serviceName => $serviceClass) {
            try {
                $container->set($serviceName, function () use ($serviceClass, $serviceName,$container){
                    $reflectionClass = new \ReflectionClass($serviceClass);

                    if ($reflectionClass->isInstantiable()) {

                        if ($serviceName === 'GPD\Core\Impl\IDatabase') {
                            $params = [dbHost, dbName, dbUser, dbPassword];
                            $instance = $reflectionClass->newInstanceArgs($params);
                        } else {
                            $constructor = $reflectionClass->getConstructor();
                            if ($constructor === null) {
                                $instance = $reflectionClass->newInstance();
                            }else{
                                $params = $constructor->getParameters();
                                if (count($params) === 0) {
                                    $instance = $reflectionClass->newInstance();
                                } else {
                                    $dependencies = array_map(function ($param) use ($container) {
                                        $type = $param->getType();
                                        if ($type === null) {
                                            throw new \Exception("Cannot resolve class dependency {$param->name}");
                                        }
                                        return $container->get($type->getName());
                                    }, $params);
                                    $instance = $reflectionClass->newInstanceArgs($dependencies);
                                }
                            }
                        }
                        return $instance;
                    } else {
                        echo "La classe {$serviceClass} n'est pas instanciable pour le service {$serviceName}.<br>";
                    }
                });
            } catch (\ReflectionException $e) {
                echo "Erreur lors de la réflexion pour le service {$serviceName}: " . $e->getMessage() . "<br>";
            }
        }
    }

}
