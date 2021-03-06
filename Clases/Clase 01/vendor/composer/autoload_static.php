<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit21c7f756f7dd63ebdeb5f62be8cf611f
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'Psr\\Log\\' => 8,
        ),
        'M' => 
        array (
            'Monolog\\' => 8,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Psr\\Log\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/log/Psr/Log',
        ),
        'Monolog\\' => 
        array (
            0 => __DIR__ . '/..' . '/monolog/monolog/src/Monolog',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit21c7f756f7dd63ebdeb5f62be8cf611f::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit21c7f756f7dd63ebdeb5f62be8cf611f::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
