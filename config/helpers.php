<?php

/** Quelque fonction utilitaire **/


function dd($data)
{
    echo "<pre >";
    var_dump($data);
    echo "</pre>";
    die();
}

function removeTrailingSlash($string)
{
    return rtrim($string, '/');
}

function replaceMultipleSlashes($url)
{
    return removeTrailingSlash(preg_replace('#/+#', '/', $url));
}

function extractServiceClasses(array $config): array
{
    $serviceClasses = [];

    if (isset($config['services'])) {
        foreach ($config['services'] as $serviceKey => $serviceConfig) {
            if (isset($serviceConfig['class'])) {
                $serviceClasses[$serviceKey] = $serviceConfig['class'];
            }
        }
    }

    return $serviceClasses;
}