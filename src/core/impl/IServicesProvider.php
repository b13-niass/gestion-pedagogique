<?php
namespace GPD\Core\Impl;

use GPD\Core\Container;

Interface IServicesProvider{
    public function register(Container $container, array $services);
}