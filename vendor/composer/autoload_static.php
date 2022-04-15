<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitb02e05d3a98a189d56959c2ad8a99d62
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

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitb02e05d3a98a189d56959c2ad8a99d62::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitb02e05d3a98a189d56959c2ad8a99d62::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitb02e05d3a98a189d56959c2ad8a99d62::$classMap;

        }, null, ClassLoader::class);
    }
}
