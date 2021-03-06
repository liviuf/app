<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit6f49cc4c697928e8f9f3771ac950bbca
{
    public static $prefixLengthsPsr4 = array (
        'M' => 
        array (
            'MiniBlog\\' => 9,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'MiniBlog\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit6f49cc4c697928e8f9f3771ac950bbca::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit6f49cc4c697928e8f9f3771ac950bbca::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
