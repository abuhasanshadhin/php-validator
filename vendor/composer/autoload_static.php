<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit172cbcc30a6103605ba81b1198c7561e
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit172cbcc30a6103605ba81b1198c7561e::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit172cbcc30a6103605ba81b1198c7561e::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
