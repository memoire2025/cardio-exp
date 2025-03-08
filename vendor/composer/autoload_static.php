<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit2d39a8fc25d44f72368a90c3a7291aba
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
            1 => __DIR__ . '/../..' . '/config',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit2d39a8fc25d44f72368a90c3a7291aba::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit2d39a8fc25d44f72368a90c3a7291aba::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit2d39a8fc25d44f72368a90c3a7291aba::$classMap;

        }, null, ClassLoader::class);
    }
}
